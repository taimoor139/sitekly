<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries\Payments;
class dp {
    
    public function generateForm($paymentConfig,$methodConfig,$data){
       $data['action'] = $paymentConfig['testMode'] ? 'https://ssl.dotpay.pl/test_payment/' : 'https://ssl.dotpay.pl';
       $data['typ'] = 3;
       $data['id'] = $methodConfig['id'];
       $data['desc'] = lang('app.payment-desc');
       $data['url'] = base_url('dashboard/payment/return');
       $data['urlc'] = base_url('payconfirm');
       $data['currency'] = $paymentConfig['currency'];
       $data['api_version'] = 'dev';
       
       return '
       <script>
       function checkout(){
        $("#dotpay").submit();
       }
       </script>
        <form action="'.$data['action'].'" id="dotpay" method="POST" style="display:none;">
        <input name="id" type="hidden" value="'.$data['id'].'" />
        <input name="opis" type="hidden" value="'.$data['desc'].'" />
        <input name="control" type="hidden" value="'.$data['control'].'" />
        <input name="amount" type="hidden" value="'.$data['amount'].'" />
        <input name="currency" type="hidden" value="'.$data['currency'].'" />
        <input name="typ" type="hidden" value="'.$data['typ'].'" />
        <input name="api_version" type="hidden" value="'.$data['api_version'].'" />
        <input name="URL" type="hidden" value="'.$data['url'].'" />
        <input name="URLC" type="hidden" value="'.$data['urlc'].'" />
        </form>
        ';  
    }    

    

}