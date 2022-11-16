<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;
class siteStatus
{

    
    public function updateStatus($data,$fromnow = false,$setTime = false){
      $siteModel = newModel('SiteModel');
      $site = $siteModel->where('id',$data['site'])->first();
      if(!$site) return false;
      
      if(!$setTime){
        $baset = ($site['expire'] > time() && !$fromnow) ? $site['expire'] : time(); 
        $expire = strtotime("+".$data['time']." month", $baset);
      } else {
        $expire = $setTime;
      }
      
      $newData = [
      'id'=> $site['id'],
      'expire'=> $expire,
      'package' => $data['package']
      ];
      if(isset($data['subscription'])){
        $newData['subscription'] = json_encode($data['subscription']);
      }

      $siteModel->save($newData);
      
      if(!empty($site['panel_login'])){
      $RemoteFileManager = newLib('RemoteFileManager');
      $RemoteFileManager->init($site['id']);
      $RemoteFileManager->setStatus();
      }
      
      $manager = newLib('MediaManager');
      $manager->connect($site['media']);
      $manager->setStatus($site['directory'],$newData['expire'],$site['status']);
      
      return true;  
    }


	//--------------------------------------------------------------------

}
