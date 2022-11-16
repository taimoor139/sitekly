<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Adashboard extends BaseController 
{
    protected $dates;
    public function index(){

if ( ! $adminStats = cache('adminStats'))
{
        $data = [];
        $today = strtotime('today midnight');
        $thisWeek = strtotime('last monday');
        $thisMonth = strtotime("first day of this month midnight");
        $thisYear = strtotime('first day of january this year');
        $days = [1,7,14,30];
        
        $this->dates['fromNow']['d0'] = time();
        foreach($days as $day){
          $this->dates['fullDays']['d'.$day] = strtotime('-'.$day.' day', $today); 
          $this->dates['fromNow']['d'.$day] = strtotime('-'.$day.' day', $this->dates['fromNow']['d0']);  
        }
        $this->currency = config('MasterConfig')->paymentConfig['currency'];

        $rangeNow = [
           '1' => ['label'=>'app.last-24-hours','start'=>$this->dates['fromNow']['d1'],'stop'=>$this->dates['fromNow']['d0']],
           '30' => ['label'=>'app.last-30-days','start'=>$this->dates['fromNow']['d30'],'stop'=>$this->dates['fromNow']['d0']],
           'total' => ['label'=>'app.total','start'=>0,'stop'=>$this->dates['fromNow']['d0']],
        ];
        
        $rangeDays = [
           '0' => ['label'=>'app.today','start'=>$today,'stop'=>$this->dates['fromNow']['d0']],
           'week' => ['label'=>'app.this-week','start'=>$thisWeek,'stop'=>$this->dates['fromNow']['d0']],
           'month' => ['label'=>'app.this-moth','start'=>$thisMonth,'stop'=>$this->dates['fromNow']['d0']],
           'year' => ['label'=>'app.this-year','start'=>$thisYear,'stop'=>$this->dates['fromNow']['d0']],
        ];

     $data['stats']['users'] = $this->getStats([
        'table'=>'Users',
        'date_column'=>'created_at',
        'ranges'=>[
            ['range'=>$rangeDays['0'],'type'=>'count','compare'=>true],
            ['range'=>$rangeDays['month'],'type'=>'count','compare'=>true],
            ['range'=>$rangeNow['total'],'type'=>'count','compare'=>false],
        ],
        'label'=>"new-users",
        'button'=>['link'=>'/admin/users','label'=>"app.users"]
     ]);  
     
          $data['stats']['sites'] = $this->getStats([
        'table'=>'Sites',
        'date_column'=>'created_at',
        'ranges'=>[
            ['range'=>$rangeDays['0'],'type'=>'count','compare'=>true],
            ['range'=>$rangeDays['month'],'type'=>'count','compare'=>true],
            ['range'=>$rangeNow['total'],'type'=>'count','compare'=>false],
        ],
        'label'=>"new-sites",
        'button'=>['link'=>'/admin/sites','label'=>"app.sites"]
     ]);  
     
            $data['stats']['payments'] = $this->getStats([
        'table'=>'Payments',
        'date_column'=>'updated_at',
        'sum_column'=>'amount',
        'conditions'=>['currency'=>$this->currency],
        'ranges'=>[
            ['range'=>$rangeDays['0'],'type'=>'sum','compare'=>true,'unit'=>$this->currency],
            ['range'=>$rangeDays['week'],'type'=>'sum','compare'=>true,'unit'=>$this->currency],
            ['range'=>$rangeDays['month'],'type'=>'sum','compare'=>true,'unit'=>$this->currency],
            ['range'=>$rangeDays['year'],'type'=>'sum','compare'=>true,'unit'=>$this->currency],
            ['range'=>$rangeNow['total'],'type'=>'sum','compare'=>false,'unit'=>$this->currency],
        ],
        'label'=>"income-statistics"
     ]);  


        
        $data['fullstats'] = $this->getFullStats([
        'table'=>'Payments',
        'date_column'=>'updated_at',
        'sum_column'=>'amount',
        'time_start'=>$this->dates['fullDays']['d30'],
        'steps_total'=>'30',
        'step_size'=>'1',
        'group_format'=>'%d.%m',
        'where' =>"currency='".$this->currency."'",
        'compare'=>true

        ]);
        $data['currency'] = $this->currency;
        $adminStats = $data;
        cache()->save('adminStats', $adminStats, 300);
 }
 
        $settings = newModel('SettingsModel');
        $adminStats['package'] = $settings->getOption('package',true);
        $adminStats['version'] = $settings->getOption('version');
        
        $siteModel = newModel('SiteModel');
        if($adminStats['package']){
        $adminStats['package']['used'] = $siteModel->where(['domain!='=>''])->countAllResults();
        }
        
        $license = $settings->getOption('license',true);
        if(is_array($license) && $license['status']== 'fail'){
         $this->session->setFlashdata('fail', $license['message']);   
        }

      if(null !== $this->request->getGet('clear')){
        $settings->removeOption('license');
        $settings->removeOption('notify');
        return namedRedirect('admin');
      }
        $adminStats['privileges'] = $this->privileges;
  		echo getView('admin/parts/header', $adminStats);
		echo getView('admin/dashboard');
    echo getView('dashboard/parts/footer'); 
        
    }

    protected function getStats($config){
        $data = [];   
        $db      = \Config\Database::connect();
        $builder = $db->table($config['table']);
        
        foreach($config['ranges'] as $range){
            $row = [];
            $config['conditions'] = !isset($config['conditions']) ? [] : $config['conditions'];
            $where = array_merge([$config['date_column'].'>='=>$range['range']['start'],$config['date_column'].'<='=>$range['range']['stop']],$config['conditions']);
            $row['label'] = $range['range']['label'];
            if($range['type'] == 'count'){
             $row['this'] = $builder->where($where)->countAllResults(); 
            } else {
             $row['this'] = $builder->selectSUM($config['sum_column'],'sum')->where($where)->get()->getResultArray()[0]['sum'];    
            }  
  
            if($range['compare']){
                $start = $range['range']['start'] - $range['range']['stop'] + $range['range']['start'];
       
                $where = array_merge([$config['date_column'].'>='=>$start,$config['date_column'].'<='=>$range['range']['start']],$config['conditions']);
                if(isset($config['condition'])) $where[] = $config['condition'];
                
                if($range['type'] == 'count'){
                $row['prev'] = $builder->where($where)->countAllResults();
                } else {
                  $row['prev'] = $builder->selectSUM($config['sum_column'],'sum')->where($where)->get()->getResultArray()[0]['sum'];  
                } 
                
                $row['change'] = $this->changes($row['this'],$row['prev']);
                
            } 
            $row['thisFormated'] = number_format($row['this'], 0, ',', ' ');
          $row['unit'] = isset($range['unit']) ? $range['unit'] : '';
          $data['stats'][] = $row;    
        }
        $data['label'] = $config['label'];
        $data['button'] = isset($config['button']) ? $config['button'] : false;
        return $data;
    }

    protected function changes($val,$prev){
            $data = [];
            if($prev > 0){
              $data['value'] = round(($val / $prev - 1) *100,1);
              if($data['value'] > 0){
                $data['value'] = '+'.$data['value'];
                $data['type'] = 'success';
              } else if($data['value'] < 0){
                $data['type'] = 'danger';
              } else {
                $data['type'] = 'light';
              } 
            } else{
                $data['value'] = '--';
               $data['type'] = 'light'; 
            }
          return $data;  
    }
    
    protected function getFullStats($config){
        $date_format  = str_replace("%", "", $config['group_format']);
        $timestamp = ($config['compare']) ? $config['time_start'] - $config['step_size'] * 86400 * $config['steps_total'] : $config['time_start'];
        $where = isset($config['where']) ? ' AND '.$config['where'] : '';
        $db = \Config\Database::connect();
        $query = $db->query("SELECT FROM_UNIXTIME(`".$config['date_column']."`, '".$config['group_format']."') as date, SUM(".$config['sum_column'].") as date_sum from ".$config['table']." WHERE `".$config['date_column']."` >= ".$timestamp.$where." group by date order by date desc");
        $result= $query->getResultArray();
        
        $stats = [];
        $data = [];
        foreach($result as $stat){
            $stats[$stat['date']] = $stat['date_sum'];  
        }
        $currentStamp = $config['time_start'];
        $timestep = $config['step_size'] * 86400;

        for($i=0;$i<$config['steps_total'];$i++){
          $currentStamp += $timestep;
          $current = date($date_format, $currentStamp);
          $data['this'][] = isset($stats[$current]) ? $stats[$current] : 0;
          $data['labels'][0][] = $current;
          
          if($config['compare']){
          $prevStamp = $currentStamp - $timestep * $config['steps_total']; 
          $prev = date($date_format, $prevStamp);  
          $data['prev'][] = isset($stats[$prev]) ? $stats[$prev] : 0;
          $data['labels'][1][] = $prev;
          }
          
          
        }
        
        return $data;
    }
    
    protected function setbase(){
      $helper = newLib('Install/Helpers');
      $oldBase = 'http://old-media-domain/';
      $newBase = 'http://new-media-domain/';
      $search = [$oldBase,str_replace('/','\/',$oldBase)];
      $replace = [$newBase,str_replace('/','\/',$newBase)];
      $helper->setBase(WRITEPATH.'templates/',$search,$replace);
    }

	//--------------------------------------------------------------------

}
