<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
  protected $table = 'Users';
  protected $allowedFields = ['rid','firstname','lastname','username', 'email', 'password','status','role','last_visit'];
  protected $beforeInsert = ['beforeInsert'];
  protected $beforeUpdate = ['beforeUpdate'];
  public function isMyClient($id){
    return $this->where(['rid'=>session()->get('user_id'),'id'=>$id])->first();
  }
  protected function beforeInsert(array $data){
   $data = $this->passwordHash($data);
   $data['data']['created_at'] = time();
    return $data;
  }

  protected function beforeUpdate(array $data){
    $data = $this->passwordHash($data);
    return $data;
  }

  protected function passwordHash(array $data){
    if(isset($data['data']['password']) && isset($data['data']['status']) && $data['data']['status'] != 'autoUser'){
    
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
    }

    return $data;
  }


}