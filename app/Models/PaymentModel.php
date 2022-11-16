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

class PaymentModel extends Model{
  protected $table = 'Payments';
  protected $primaryKey = 'id';
  protected $allowedFields = ['site','amount','currency','control','package','time','method','transaction','created_at','updated_at'];

}
