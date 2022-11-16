<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Controllers;

class Payconfirm extends BaseController
{
    protected $paymentModel;
    protected $paymentLib;
    protected $config;
    protected $paymentMethods;

	public function index()
	{ 
	   $this->paymentModel = newModel('PaymentModel');
       $this->paymentLib = newLib('Payments');
       $result = $this->paymentLib->validateRequest();

       if($result == 'end') return dlog('payment - wrong host '.$_SERVER['REMOTE_ADDR']);
       if($result == 'ignore') return 'ignore';
       if(isset($result['error'])) return dlog('payment - '.$result['error']);
       
       if(isset($result['update']) && !empty($result['update']['site']) && !empty($result['update']['package']) && !empty($result['update']['time'])){
          if($this->updateSite($result['update'])){
		          return isset($result['returnText']) ? $result['returnText'] : 'OK';
             } 
          return dlog('payconfirm - site not found');
 
       } 
       
       return dlog('payment - update data missing');  
       

	}
    
    protected function updateSite($payment){
      $siteModel = newModel('SiteModel');
      $prevPacId = $siteModel->where(['id'=>$payment['site']])->first();
      $pricingModel = newModel('PricingModel');
      $prevPac = $pricingModel->where(['id'=>$prevPacId['package']])->first();
        
      $prevPac['price'] = explode(' ',explode(':',$prevPac['price'])[1])[0];
      $fromnow = ($prevPac['price_monthly_month'] == 0 || $prevPac['price_monthly_year'] == 0) ? true : false;   
        
      $status = newLib('siteStatus');
      return $status->updateStatus($payment,$fromnow);
    }
	//--------------------------------------------------------------------

}
