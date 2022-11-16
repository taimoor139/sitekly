<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;
class AutoHost {

    protected $autoHosts;
    public $panel;
    public $user;
    
    public function __construct()
    {
        $this->autoHosts = config('MasterConfig')->resellers;
    }

    public function login($login,$password){
        
        
        foreach($this->autoHosts as $host=>$config){
            if(!isset($config['mode'])) continue;
            $config['login'] = $login;
            $config['password'] = $password;
            
            $result = $this->connect($config);
            
            if($result === true){
                return ['host'=>$host,'password'=>$this->encrypter($password,'encrypt',$config['secret'])];
            }

        }
    }
    
    public function connect($config){
        $this->panel = newLib('Panels/'.$config['type']);
        $this->panel->connect($config);
        return $this->panel->testUser();
    }
    
    public function listDomains($id){
        $config = $this->getConfig($id);
        $result = $this->connect($config);
        if($result === true){
        return $this->panel->listDomains();
        } else {
            return false;
        }
        
    }
    
    public function testFtp($id){
        $config = $this->getConfig($id);
        
        $ftp = new \App\ThirdParty\FtpClient\FtpClient;
        try {
            $ftp->connect($config['ip']);
            $ftp->login($config['login'], $config['password']);
        } catch (\Exception $e) {
            dlog($e);
            return false;
        }
        return true;
        

    }
    
    public function getConfig($id){
        $model = newModel('UserModel');
        $row = $model->where('id', $id)->first();
        if(!$row) return false;
        
        $user = explode('@',$row['username']);
        if(!isset($this->autoHosts[$user[1]])) return false;
        $config = $this->autoHosts[$user[1]];
        $config['login'] = $user[0];
        $this->user = ['login'=>$user[0],'hostId'=>$user[1]];
        $config['password'] = $this->encrypter($row['password'],'decrypt',$config['secret']);
        return $config;
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