<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;
class Tasks {
    
    public function run(){
        $action = implode("/",func_get_args());

        if ( ! $key = cache('taskKey')){ 
            helper('text');
            $key = random_string('alnum', 20);
        } 
        
        cache()->save('taskKey', $key, 300);
     
        $url = base_url('tasks/'.$action.'/'.$key);
        exec("wget ".$url." >> /dev/null &");
    }
    
    public function verify($key){
        if($_SERVER['REMOTE_ADDR'] != $_SERVER['SERVER_ADDR']) return false;
        if ( ! $cache = cache('taskKey')) return false;
       if($cache != $key) return false;
        return true; 
    }

}