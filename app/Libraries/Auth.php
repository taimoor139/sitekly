<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;
class Auth {
    
    function __construct(){
       $this->session = \Config\Services::session();
    }
    
    public function isAdmin(){
       if(!$this->isLogged() || $this->session->get('user_status') != 'admin')
         return false; 
       else
        return true; 
    }
    public function isUser(){
       if(!$this->isLogged() || $this->session->get('user_status') != 'user' && $this->session->get('user_status') != 'autoUser')
         return false; 
       else
        return true; 
    }
        public function isAutoUser(){
       if(!$this->isLogged() || $this->session->get('user_status') != 'autoUser')
         return false; 
       else
        return true; 
    }
    public function isDesigner(){
       if(!$this->isLogged() || $this->session->get('user_status') != 'designer')
         return false; 
       else
        return true; 
    }
    public function isLogged(){
       if(!$this->session->get('user_isLoggedIn'))
         return false; 
       else
        return true; 
    }
    public function isGuest(){
       if($this->isLogged())
         return false; 
       else
        return true; 
    }
    public function delayedRedirect(){
        $session = $this->session;
        
      if($session->get('loggedRedirect') && $this->isLogged()){
        $redirect = $session->get('loggedRedirect');
        $session->remove('loggedRedirect');
        return $redirect;
        }
      else  
        return false;
    }
    
    
}