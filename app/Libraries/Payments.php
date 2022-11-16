<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;
class Payments {
    
    public $master;
    public $enabledMethods;
    public $paymentConfig;
    protected $methodLib;
    
    
    public function __construct(){
        $this->master = config('MasterConfig');  
        $this->paymentConfig = $this->master->paymentConfig;
        $this->enabledMethods = $this->getEnabledMethods(); 
    }
    
    public function getEnabledMethods(){
        $methods = [];
        
        $paymentMethods = $this->paymentConfig['testMode'] ? $this->master->paymentTestMethods : $this->master->paymentMethods;

        foreach($paymentMethods as $id => $method){
            if($method['active']){
              $methods[$id] = $method['label']; 
            } 
        } 
        return $methods;
    }
    
    public function validateRequest(){
        foreach($this->enabledMethods as $id => $method){
            $this->loadMethod($id);
            if($this->methodLib->identifyRequest()){
                $methodConfig = $this->getMethodConfig($id);
                return $this->methodLib->validateRequest($this->paymentConfig,$methodConfig);
            }
        }
        return 'end';
    }
    
    public function cancelSub($data){
        if(empty($data['subscription'])) return false;
        $data['subscription'] = json_decode($data['subscription'],true);
        $this->loadMethod($data['subscription']['method']);
        $methodConfig = $this->getMethodConfig($data['subscription']['method']);
        return $this->methodLib->cancel($this->paymentConfig,$methodConfig,$data);

    }
    
    public function initMethods(){
        $return = '';
        foreach($this->enabledMethods as $id => $method){
            $this->loadMethod($id);
           $return .= $this->methodLib->initMethod();
        } 
        return $return;
    }
    public function generateForm($data){
        
        $methodConfig = $this->getMethodConfig($data['method']);
            
        if($methodConfig['active']){
            $this->loadMethod($data['method']);
            return $this->methodLib->generateForm($this->paymentConfig,$methodConfig,$data); 
        }
    }
    
    protected function loadMethod($method){
        $this->methodLib = newLib('Payments/'.$method);
    }
    
    protected function getMethodConfig($method){
       return $this->paymentConfig['testMode'] ? $this->master->paymentTestMethods[$method] : $this->master->paymentMethods[$method]; 
    }
}