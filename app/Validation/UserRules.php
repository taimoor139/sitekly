<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Validation;


class UserRules
{

  public function validateUser(string $str, string $fields, array $data, string &$error=null){
    $model = newModel('UserModel');
    $user = $model->where('username', $data['username'])
                  ->first();

    if(!$user)
      return false;

    
    return password_verify($data['password'], $user['password']);
  }
  public function userExist(string $str, string &$error=null){
    $model = newModel('UserModel');
    $user = $model->where('email', $str)
                  ->first();

    if(!$user)
      return false;

return true;
  }
}
