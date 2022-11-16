<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Models;

use CodeIgniter\Model;

class SiteModel extends Model{
  protected $table = 'Sites';
  protected $allowedFields = ['directory','domain','name','user','panel_reseller','panel_login','panel_password','theme','package','subscription','media','status','expire'];
  protected $beforeInsert = ['beforeInsert'];
  protected $previewDir = 'preview';




  protected function beforeInsert(array $data){
   $data['data']['created_at'] = time();
   if(session()->get('demoUser')){
      
        $sites = isset($_COOKIE["demo_sites"]) ? $_COOKIE["demo_sites"] : '{}';
        $sites = json_decode($sites,true);
              
        $sites[] = $data['data']['directory'];
        setcookie("demo_sites", json_encode($sites), time()+(86400 *5),'/');
         
    }
  

    return $data;
  }

    public function SitesData($sites){
        
        if(!$sites) return false;
        $manager = newLib('FileManager'); 
        
        $MediaManager = newLib('MediaManager');
                    
        $data = [];
        
            foreach($sites as $key => $row){

                $isDir = $manager->setPath('project',$row['directory']);
                if(!$isDir){
                 dlog('Missing '.$row['directory'].' directory');
                 continue;   
                } 
                $MediaManager->connect($row['media']);
                $space = $MediaManager->space($row);
                
                $row['thumb'] =  base_url().'/pthumbs/'.$row['directory'].'.jpg'; 
                $row['title'] = !empty($row['domain']) ? $row['domain'] : $row['name'];
                $row['previewLink'] = $manager->previewUrl;
                $row['titleLink'] = !empty($row['domain']) ? '//'.$row['domain'] : $row['previewLink'];
                
                $row['statusChange'] = ($row['status'] == 1) ? [0,'danger','disable','enabled'] : [1,'success','enable','disabled'];   
                $row['expireDate'] = date('Y-m-d H:i',$row['expire']); 
                $row['status'] = ($row['expire'] < time()) ? lang('app.expired') : lang('app.active');
                $row['statusType'] = ($row['expire'] < time()) ? 'danger' : 'success';
                //$row['space'] = $siteFiles->diskSpace($row['package']);
                $row['space'] = ['used%'=>$space['usedp']];
                $data[$key] = $row;
            }
        return $data;
    }
    
   public function getMySite($id){
        return $this->where(['user'=>session()->get('user_id'),'id'=>$id])->first();

   } 
   
   public function getMySites(){
    $sites = $this->where(['user'=>session()->get('user_id')])->findAll();
        if(session()->get('demoUser')){
           $mysites = isset($_COOKIE["demo_sites"]) ? $_COOKIE["demo_sites"] : '{}';

           $mysites = json_decode($mysites,true);
           foreach($sites as $key=>$data){
                if(!in_array($data['directory'],$mysites)){
                    unset($sites[$key]);
                }
           }
           
        }
       return $sites;

   }
    public function countByPackage($pid){
        return $this->where(['user'=>session()->get('user_id'),'package'=>$pid])->countAllResults();

   }
   
   public function encrypter($text,$action,$key){
        $config         = new \Config\Encryption();
       $config->key    = $key;
       $encrypter = \Config\Services::encrypter($config);  

        if($action == 'encrypt'){
          return base64_encode($encrypter->encrypt($text));  
        } else {
           return $encrypter->decrypt(base64_decode($text)); 
        }
        
    }

}
