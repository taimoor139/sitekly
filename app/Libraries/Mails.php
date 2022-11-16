<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;
class Mails {
    private $email;
    private $MasterConfig;
    private $AppConfig;
    private $mailConfig;
    
    public function __construct()
    {
    $this->MasterConfig = config('MasterConfig');
    $this->mailConfig = $this->MasterConfig->mail;
    $this->email = \Config\Services::email();
    $this->AppConfig = config('App'); 
    $this->email->initialize($this->mailConfig);
    
    //echo $this->email->printDebugger();
    }
    public function send($data,$locale = null){
       
    $this->email->setFrom($this->mailConfig['SMTPUser'],$this->mailConfig['display']);
    $this->email->setTo($data['sendTo']);
    $this->email->setSubject($data['subject']);
    
    if(isset($data['template'])){
        $data['content']['siteName'] = $this->MasterConfig->siteName;
        $data['content']['siteUrl'] = base_url();
        
        $session = \Config\Services::session();
        $locale = $locale ? $locale : $session->get('lang');
        
        $defaultLocale = $this->AppConfig->defaultLocale; 
        $message = getView('mail/parts/header', $data['content']);
        
        if(file_exists(APPPATH.'Views/mail/'.$locale.'/'.$data['template'].'.php')){
         $message .= getView('mail/'.$locale.'/'.$data['template']); 
        } else{
            $message .= getView('mail/'.$defaultLocale.'/'.$data['template']); 
        }
    
        $message .= getView('mail/parts/footer');
    } else {
      $message = $data['message'];  
    }

    $this->email->setMessage($message);
    
    
    $result = $this->email->send();
    if(!$result){
        dlog('mail send failed');
    }
    
        return $result; 
        
    }
    
    
}