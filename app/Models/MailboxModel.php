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

class MailboxModel extends Model{
  protected $table = 'Emails';
  protected $primaryKey = 'id';
  protected $allowedFields = ['user','site','name'];
}
