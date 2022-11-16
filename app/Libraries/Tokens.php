<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;
class Tokens {
    private $db;
    private $table;
    
    public function __construct()
    {
    $this->db = \Config\Database::connect();
    $this->table = $this->db->table('Tokens');
    }
    
    public function add(int $uid, string $action, int $expire){
        
        helper('text');
        
       $data = [
       'uid' => $uid,
       'action' => $action,
       'token' => random_string('alnum', 16),
       'expire' => time()+ $expire
       ];
       
       $this->table->insert($data);
       return $data['token'];
    }
    
    public function check(string $token, string $action){
        $table = $this->table;
        $data = [];
       $row = $table->getWhere(['token' => $token,'action'=>$action])->getRow();
        if(!$row) return false;

       $table->delete(['id'=>$row->id]);

        if($row->expire < time()) return false;
        
        return $row;
       
    }
}