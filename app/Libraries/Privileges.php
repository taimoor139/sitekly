<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;
class Privileges {
    
    function __construct(){
       $this->session = \Config\Services::session();
       $this->config = config('Privileges');
       $this->package = false;
       
    }
    
    public function extendByPackage($package){
        $this->package = 'package_'.$package;
    }
    
    public function extendBySite($siteid){
        $siteModel = newModel('SiteModel');
        $site = $siteModel->getMySite($siteid);
        $this->package = 'package_'.$site['package'];
    }
    
    public function getRoleList(){
        return array_keys($this->config->roles);
        
    }
    
    public function can($action,$group=null){
        if(!$roleConfig = $this->getRoleConfig()) return false;
        if($group){
          return isset($roleConfig[$group]) && in_array($action,$roleConfig[$group]) ? true : false;  
        }
        return in_array($action,$roleConfig) ? true : false;  
        
    }
    
    public function getGroup($group){
        if(!$roleConfig = $this->getRoleConfig()) return false;
        return isset($roleConfig[$group]) ? $roleConfig[$group] : [];  
    }
    
    public function getRoleConfig(){
        if(!$this->session->get('user_isLoggedIn')) return false;
        $this->role = $this->getRole();
        $config =  isset($this->config->roles[$this->role]) ? $this->config->roles[$this->role] : [];
        if($this->package){
        $extend =  isset($this->config->roles[$this->package]) ? $this->config->roles[$this->package] : [];
        $config = $this->mergePrivileges($config,$extend);
        }

        return empty($config) ? false : $config;
    }
    
    protected function mergePrivileges($config,$extend){
        foreach($extend as $k=>$data){
            if(is_array($data)){
               $config[$k] = array_merge($config[$k],$data); 
            } else if(!in_array($data,$config)) {
                $config[] = $data;
            }
        }
        return $config;
    }
    
    public function getRole(){
        return $this->session->get('user_role');
    }
    
    public function guestCan($action){
        $roleConfig = isset($this->config->roles['guest']) ? $this->config->roles['guest'] : false;
        if(!$roleConfig) return false;
        return in_array($action,$roleConfig) ? true : false; 
    }
 
    
}