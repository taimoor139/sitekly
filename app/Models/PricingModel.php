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

class PricingModel extends Model{
  protected $table = 'Packages';
  protected $primaryKey = 'id';
  protected $allowedFields = ['name','space','ads','subdomain','domain','emails','site_limit','custom','privileges','price','price_monthly_month','price_monthly_year'];
  
  public function getAll(){
    $packages = $this->findAll();
        $pricing = [];
        $this->paymentConfig = config('MasterConfig')->paymentConfig;
        

        foreach($packages as $package){
           
            $package['pricing'] = [];
            if($package['price_monthly_month'] != -1){
              $package['pricing'][1] = $this->formatPrice($package['price_monthly_month'],1);
            }
            if($package['price_monthly_year'] != -1){
              $package['pricing'][12] = $this->formatPrice($package['price_monthly_year'],12);
            }

           
           $pricing[$package['id']] = $package; 
        }

    return $pricing;
  }
  
  public function formatPrice($price,$period){
    $paymentConfig = $this->paymentConfig;
    $amount_format = $paymentConfig['amount_format'];
    
    $price = number_format($price, 2, '.', '');
    $total = number_format($price * $period, 2, '.', '');
    $month_formated = '<span>'.$amount_format['before'].'</span>'.number_format($price, $amount_format['decimal-points'], $amount_format['decimal-separator'], $amount_format['thousands-separator']).'<span>'.$amount_format['after'].'</span>';
    $total_formated = '<span>'.$amount_format['before'].'</span>'.number_format($total, $amount_format['decimal-points'], $amount_format['decimal-separator'], $amount_format['thousands-separator']).'<span>'.$amount_format['after'].'</span>';
    $total_formated_code = number_format($total, $amount_format['decimal-points'], $amount_format['decimal-separator'], $amount_format['thousands-separator']).' '.$paymentConfig['currency'];
    
    return ['month'=>$price,'total'=>$total,'month_formated'=>$month_formated,'total_formated'=>$total_formated,'total_formated_code'=>$total_formated_code];
    
    
  }
  
}
