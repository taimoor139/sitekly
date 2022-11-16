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

class TemplateModel extends Model{
  protected $table = 'Templates';
  protected $primaryKey = 'id';
  protected $allowedFields = ['uid','status','type'];
  protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];
  
  protected function beforeInsert(array $data){
   helper('text');
   $data['data']['created_at'] = time();
   
   $data['data']['uid'] = random_string('crypto', 16);
   cache()->delete('exports');
    return $data;
  }
    protected function beforeUpdate(array $data){
    cache()->delete('exports');
    return $data;
  }

    public function TemplatesData($templates,$checkSpace = false){
        $manager = newLib('FileManager'); 
        
        if($checkSpace){
        $MediaManager = newLib('MediaManager');
        $MediaManager->connect('default');
        }
        
        if(!$templates) return false;
        $data = [];

            foreach($templates as $key => $row){
           
                $isDir = $manager->setPath('template',$row['id']);
                if(!$isDir){
                 dlog('Missing '.$row['id'].' directory');
                 continue;   
                } 
                
                if($checkSpace){
                $row['package'] = 1;
                $row['directory'] = $row['id'];
                $row['space'] = $MediaManager->space($row);
                }

                $indexPage = $manager->getPage(null);
                $row['Thumb'] =  base_url('thumbs/'.$row['id'].'/ico.jpg');
                
                $row['FullThumb'] =  base_url('thumbs/'.$row['id'].'/pages/600/'.$indexPage[0].'.png');   
                $row['Link'] = base_url($manager->previewUrl);
                $row['Title'] = '';
                if($row['type'] == '1'){
                $row['statusChange'] = ($row['status'] == 1) ? [0,'primary','disable','enabled'] : [1,'danger','enable','disabled'];
                } else {
                   $row['statusChange'] = ($row['status'] == 1) ? [0,'primary',false,'enabled'] : [1,'danger','enable','disabled']; 
                }
                $data[] = $row;
            }
        return $data;
    }
}