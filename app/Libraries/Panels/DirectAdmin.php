<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries\Panels;
class DirectAdmin {
    protected $panel;
    protected $config;
    
    public function connect($config)
    {   $this->config = $config;
        $this->panel = new \App\ThirdParty\DirectadminClass;
        $this->panel->connect($config['panel_host'].':'.$config['port']);
        $this->panel->login($config['login'],$config['password']);
    }

    public function addUser($data){
          $args = [
          'action' => 'create',
          'add' => 'Submit',
          'username'=>$data['username'],
          'email' =>$data['email'],
          'passwd'=>$data['password'],
          'domain'=>$data['domain'],
          'package'=>$this->config['package'],
          'ip'=>$this->config['ip'],
          'notify'=>'no'
               
          ];
          
          return $this->query('CMD_API_ACCOUNT_USER',$args);   
    }
    
    public function deleteUser($data){
          $args = [
          'confirmed' => 'Confirm',
          'delete' => 'yes',
          'select0'=>$data['username']      
          ];
          
          return $this->query('CMD_API_SELECT_USERS',$args,'POST'); 
    }
    
    public function addDomain($domain){
          $args = [
          'action' => 'create',
          'domain' => $domain,
          'ubandwidth' => 'unlimited',
          'uquota' => 'unlimited',
          'ssl' => 'OFF',
          'cgi' => 'ON',
          'php' => 'ON'      
          ];
          return $this->query('CMD_API_DOMAIN',$args,'POST');  
    }
    
        public function changeDomain($old_domain,$new_domain){
          $args = [
          'old_domain' => $old_domain,
          'new_domain' => $new_domain     
          ];
          
          return $this->query('CMD_API_CHANGE_DOMAIN',$args,'POST'); 
    }
    
    
    public function deleteDomain($domain){
          $args = [
            'delete' => 'anything',
            'confirmed' => 'anything',
            'select0' => $domain    
          ];
          
          return $this->query('CMD_API_DOMAIN',$args);
    
    }
    public function addEmail($data){
          $args = [
            'action' => 'create',
            'domain' =>	$data['domain'],
            'user' =>	$data['name'],
            'passwd' => $data["pass"],
            'quota' => '0'  
          ];
          
          return $this->query('CMD_API_POP',$args);
          
    }
        public function changeEmail($data){
          $args = [

            'email' =>	    $data['name'].'@'.$data['domain'],
            'oldpassword' => $data['oldpassword'],
            'password1' =>	$data['newpassword'],
            'password2' =>	$data['newpassword'],
            'api' =>	    'yes',

          ];
          
          return $this->query('CMD_CHANGE_EMAIL_PASSWORD',$args);
            
    }
    
         public function deleteEmail($data){
          $args = [

            'user' =>	    $data['name'],
            'domain' =>     $data['domain'],
            'action' =>	    'delete',

          ];
          
          return $this->query('CMD_API_POP',$args);
           
    }
    
    public function testUser(){
        $result = $this->query('CMD_API_LOGIN_TEST',[]);
        
        return isset($result['text']) && $result['text'] == 'Login OK' ? true : false;
        
    }
    
     public function listDomains(){
        return $this->query('CMD_API_SHOW_DOMAINS',[]);
        
    }
    
    protected function query($url,$args,$method='GET'){
        
        $result = $this->panel->query($url,$args,$method);
      //  var_dump($result);
        
        if(!$result && !is_array($result)) return ['error'=>'Empty response']; 
        if(!is_array($result)){
        $result = $this->panel->parse($result,true);
        }

       if (isset($result['error']) && $result['error'] != "0"){
           
          if(!empty($result['details'])){
            $error = $result['details'];
          } else if(!empty($result['text'])){
            $error = $result['text'];
          }
          
          return ['error'=>$error];  
        
         } else{
            unset($result['error']);
        return $result;  
         }
    }
    
}
