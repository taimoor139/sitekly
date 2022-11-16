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

class SettingsModel extends Model{
  protected $table = 'Settings';
  protected $allowedFields = ['name','value'];
  protected $primaryKey = 'name';
  public function getOption($name,$json = false){
    $row = $this->where(['name'=>$name])->first();
    if(!$row) return;
    if($json)
    $row['value'] = json_decode($row['value'],true);
    return $row['value'];
    
  }
  public function setOption($name,$value){
    if(is_array($value))
    $value = json_encode($value);
    
    $method = $this->find($name) ? 'save' : 'insert';
    
   return $this->$method(['name'=>$name,'value'=>$value]);
  }
  
    public function removeOption($name){
    $this->delete($name);
   return $this->db->affectedRows();
  }


}