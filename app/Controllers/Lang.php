<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Controllers;

class Lang extends BaseController
{

    public function index($lang,$back=false)
    { 
        
        $config = config('App');
        if(in_array($lang,array_keys($config->LocalesDetails))){
          $newLang = $lang;
          $hasHome = $config->LocalesDetails[$lang][1] ? true : null;
          
        } else{
            $newLang = $config->defaultLocale;
        }
        $this->session->set('lang',$newLang);
        
        
        $redirect = ($config->defaultLocale == $newLang || !isset($hasHome)) ? '/' : '/'.$newLang; 
        $this->session->set('lang_base',$redirect);
    
        
        if(!$back){
        return redirect()->to($redirect);   
        }
        return redirect()->back();  
    }
}