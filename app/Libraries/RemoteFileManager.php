<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;

use App\ThirdParty\FtpClient\FtpClient;
class RemoteFileManager extends FtpClient {
    public $config;
    public $sitePath;
    protected $site;
    protected $FileManager;
        
    public function init($siteid)
    {   
        $siteModel = newModel('SiteModel');
        $site = $this->site = $siteModel->where(['id'=>$siteid])->first();
        if(!$site) return false;
        
        $this->config = config('MasterConfig')->resellers[$site['panel_reseller']];  
        if(isset($this->config['mode'])){
          $UserModel = newModel('UserModel');
          $user = $UserModel->where(['id'=>$site['user']])->first();
          $site['panel_password'] = $user['password'];  
        } 
        $password = $siteModel->encrypter($site['panel_password'],'decrypt',$this->config['secret']);
        $this->connect($this->config['ip']);
        $this->login($site['panel_login'], $password);
        $this->sitePath = $this->getSitePath($site); 
        if(!$this->sitePath) return false;
        
        $this->FileManager = newLib('FileManager');
        $this->FileManager->setPath('project',$site['directory']);
    }
    
    
    public function updateSite(){
      $fonts = $this->FileManager->getFonts();
      $this->putAll($this->FileManager->activePath,$this->sitePath); 
      $this->FileManager->activePath = WRITEPATH.'usersiteFiles/'; 
      $this->putAll($this->FileManager->activePath,$this->sitePath); 
      
      $layout = $this->FileManager->getFileContent('layout.php');
      $layout = str_replace('{fonts-replace}',$fonts,$layout);
      $layout = str_replace('{base-replace}',base_url(),$layout);
      $this->putFromString($this->sitePath.'/layout.php',$layout); 
    }
    
    public function setStatus(){
        $this->putFromString($this->sitePath.'/config/expire',$this->site['expire'].','.$this->site['status']);
    }
    

    public function getSitePath($site){
        if($this->config['type'] == 'Cpanel' && $this->config['mode'] == 'autoHost'){
            $ah = newLib('AutoHost');
            $config = $ah->getConfig($site['user']);
            $ah->connect($config);
            $result = $ah->panel->getdocroot($site['domain']);
            if(!isset($result['cpanelresult']['data'][0]['reldocroot'])) return false;
            return $result['cpanelresult']['data'][0]['reldocroot'];
        }
      $path = str_replace('{domain}',$site['domain'],$this->config['publicPath']); 
      return str_replace('{login}',$site['panel_login'],$path);  
    }
    
}