<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Validation;

class AppRules
{

  public function siteTaken(string $str, string $fields, array $data, string &$error=null){
    $model = newModel('SiteModel');
    $domainList = config('MasterConfig')->domainList;
    $dir = (strtolower($data['domain']) == $domainList[0]) ? $data['name'] : $data['name'].'.'.$data['domain'];
    $site = $model->where('directory', strtolower($dir))
                  ->first();
    if($site){ 
        $error = lang('app.nametaken');
        return false;
    
    }
    return true;
  }

}
