<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;




class Controlpanel {
    protected $reseller;
    protected $resellerConfig;
    protected $siteModel;
    
    public function __construct(){
      $this->siteModel = newModel('SiteModel');    
    }
    
    public function init($id){
      $this->resellerConfig = config('MasterConfig')->resellers[$id];
      $this->resellerConfig['id'] = $id;
      $this->panel = newLib('Panels/'.$this->resellerConfig['type']);   
    }
    public function connectReseller($id){
          $this->init($id);
          $config = $this->resellerConfig;
          if(isset($config['mode'])){
            return;
          }
          $config['port'] = $this->resellerConfig['port_reseller'];
          
          $this->panel->connect($config);  
    }
    public function connectUser($data){
        
          $this->init($data['panel_reseller']);
          $config = $this->resellerConfig;
          $config['login'] = $data['panel_login'];
          $config['password'] = $this->siteModel->encrypter($data['panel_password'],'decrypt',$this->resellerConfig['secret']);
          $config['port'] = $this->resellerConfig['port_user'];

          $this->panel->connect($config);  
    }
    
    public function updateSite($siteid,$newdata,$rid){

       $site = $this->siteModel->where(['id'=>$siteid])->first();
       $RemoteFileManager = newLib('RemoteFileManager');
       
       if(isset($newdata['domain'])){
            $validate = $this->ValidateDomain($newdata['domain']);
            if(isset($validate['error'])) return false;
            $newdata['domain'] = $validate['domain'];
       }
       
       if($rid == 'local'){
            if(!isset($newdata['domain'])) return false;
            $this->siteModel->save(['id'=>$site['id'],'panel_reseller'=>'local','domain'=>$newdata['domain']]);
            return true;
        }

       if(empty($site['panel_reseller'])){
            if(!isset($newdata['domain'])) return false;
            $this->connectReseller($rid); 
            $user = $this->createUser($newdata['domain']);
            if(isset($user['query']['error'])) { 
                dlog($user['query']['error']); 
                return false; 
            }  
                
            $password = $this->siteModel->encrypter($user['password'],'encrypt',$this->resellerConfig['secret']);
            $newData = ['id'=>$site['id'],'panel_reseller'=>$this->resellerConfig['id'],'panel_login'=>$user['username'],'panel_password'=>$password,'domain'=>$newdata['domain']];
            $this->siteModel->save($newData);
            sleep(2);
            $RemoteFileManager->init($site['id']);
            $RemoteFileManager->updateSite();
            $RemoteFileManager->setStatus();
            return true;
       } else if(!empty($site['domain'])){
        
        if(config('MasterConfig')->resellers[$rid]['type'] == 'Cpanel'){
          $this->connectReseller($rid);   
        } else {
         $this->connectUser($site);    
        }
        
        $request = $this->panel->changeDomain($site['domain'],$newdata['domain'],$site['panel_login']);

            if(isset($request['error'])) { 
                dlog($request['error']); 
                return false; 
            }
            $this->siteModel->save(['id'=>$site['id'],'domain'=>$newdata['domain']]);
        return true;
       }
        
    }
    
    public function createUser($domain){
       helper('text');
       $data = [
        'username'=>strtolower(random_string('alpha', 1)).strtolower(random_string('alnum', 9)),
        'password'=>random_string('alnum', 15).random_string('numeric', 1),
        'email'=>'any@any.comfake',
        'domain' =>$domain
       ];
       
       $data['query'] = $this->panel->addUser($data);  
       return $data;
    }
    
    protected function ValidateDomain($domain){
      $taken = $this->siteModel->where('domain', $domain)->first(); 
  
      if($taken) return ['error'=>lang('app.domain-taken')];
      
      $re = '/(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]/';
      preg_match_all($re, $domain, $matches, PREG_SET_ORDER, 0);
      if(!isset($matches[0][0])) return ['error'=>lang('app.domain-wrong')];
       return ['domain'=>$matches[0][0]]; 

    //  if(!filter_var(gethostbyname($domain), FILTER_VALIDATE_IP)) return ['error'=>lang('app.custom-domain-wrong')];
  
    //  $ns = dns_get_record($domain, DNS_NS);
    //  if(!isset($ns[0]['target']) || !isset($ns[1]['target']) || $ns[0]['target'] != $config->domainNS[0] || $ns[1]['target'] != $config->domainNS[1])
    //  return ['error'=>lang('app.add-ns-first')];


    }


    public function query($action,$data){
        
        $config = $this->resellerConfig;
          if(isset($config['mode'])){
            return;
          }
       
       return $this->panel->$action($data);
    }
  
}
