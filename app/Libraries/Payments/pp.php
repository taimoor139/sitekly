<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries\Payments;
class pp {
    
    public function initMethod(){
        return '';
    }
    
    public function generateForm($paymentConfig,$methodConfig,$data){
       $action = $paymentConfig['testMode'] ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';

       $fields = [
       'id' => $methodConfig['id'],
       'desc' => lang('app.payment-desc'),
       'url1' => namedRoute('dashboard/payment/return?status=OK'),
       'url0' => namedRoute('dashboard/payment/return?status=FAIL'),
       'urlc' => namedRoute('payconfirm'),
       ];
       
       return '
        <form action="'.$action.'" id="paypal" method="POST" style="display:none;">
        <input type="hidden" name="cmd" value="_xclick">
        <input type="hidden" name="business" value="'.$fields['id'].'">
        <input type="hidden" name="notify_url" value="'.$fields['urlc'].'">
        <input name="return" type="hidden" value="'.$fields['url1'].'" />
        <input name="cancel" type="hidden" value="'.$fields['url0'].'" />
        <input type="hidden" name="currency_code" value="'.strtoupper($data['currency']).'">
        <input type="hidden" name="item_name" value="'.$fields['desc'].'">
        <input type="hidden" name="amount" value="'.$data['amount'].'">
        <input type="hidden" name="custom" id="control" value="'.$data['control'].'">
        <input type="hidden" name="charset" value="utf-8">
        </form>
        <script> function checkout(){ $("#paypal").submit()}</script>
        ';  
    } 
    
    public function identifyRequest(){
        if (isset($_POST['receiver_email']) && isset($_POST['custom'])){
            return true;
        }
    }
    
    public function validateRequest($paymentConfig,$methodConfig){
           
            $paymentModel = newModel('PaymentModel');
            
            $ipn = new \App\ThirdParty\PaypalIPN();  
            if($paymentConfig['testMode']){  
             $ipn->useSandbox();
             }
           $verified = $ipn->verifyIPN();

            if ($verified) {
                $payment = $paymentModel->where(['control'=>$_POST['custom'],'updated_at'=>'0'])->first();   
                if(!$payment) return ['error'=>'Payment not found'];
                $amount = number_format((float)$payment['amount'], 2, '.', '');
                
                $rules = [
				'receiver_email' => $methodConfig['id'],
                'payment_status' => 'Completed',
                'mc_gross' =>   $amount,
                'mc_currency' => strtoupper($payment['currency'])
                ];
                
                foreach($rules as $name=>$value){
                    if(!isset($_POST[$name]) || $_POST[$name] != $value){
                        return ['error'=>'Field '.$name.' is incorrect ('.$_POST[$name].')'];
                    }
                }

                $paymentModel->save(['id'=> $payment['id'],'updated_at'=>time(),'transaction'=>$_POST['txn_id']]);
                 
                return ['returnText'=>'OK','update'=>$payment];  //required: site id (site), package id (package), time in month (int) 

            
            } else {
                return ['error'=>'paypal payment verification fail'];
            } 


    }


    

}