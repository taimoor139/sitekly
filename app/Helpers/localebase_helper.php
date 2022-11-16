<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

if (! function_exists('localebase'))
{
    function localebase(){
        $session = \Config\Services::session();
        $lang = $session->get('lang_base') ? $session->get('lang_base') : "/";
        return $lang;
        
    }
}
if (! function_exists('langList'))
{
     function langList(){
       $config = config('App');
       $locales = $config->LocalesDetails; 
       $language = service('language');
       $current = $language->getLocale();
      return ['supported'=>$locales,'current'=>$locales[$current][0]];
    }
}
