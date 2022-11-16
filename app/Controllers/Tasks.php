<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Controllers;

class Tasks extends BaseController
{

    protected function verify($key){
        $lib = newLib('Tasks');
        if(!$lib->verify($key)) return false;
        return true;
    }
    
    public function main_thumb($directory,$key){
        if(!$this->verify($key)) return false;
        
        $thumbGenerator = newLib('thumbGenerator');
        $thumbGenerator->generateMain($directory);
            if(ENVIRONMENT == 'development'){
            return $this->response->setJSON();
            }
        
    }
    
}