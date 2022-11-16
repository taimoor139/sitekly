<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries\Payments;
class sample {  //same name as id in MasterConfig
    
/**
 *$paymentConfig: MasterConfig->paymentConfig, 
 *$methodConfig: MasterConfig->paymentMethods['sample'] or paymentTestMethods['sample']
 *$data: ['site','amount','currency','control','package','time','method',created_at]
 */
    public function generateForm($paymentConfig,$methodConfig,$data){ 
       $action = $paymentConfig['testMode'] ? 'sandbox url' : 'production url';

       $fields = [
       'id' => $methodConfig['id'],
       'desc' => lang('app.payment-desc'),
       'url1' => namedRoute('dashboard/payment/return?status=OK'),
       'url0' => namedRoute('dashboard/payment/return?status=FAIL'),
       'urlc' => namedRoute('payconfirm'), // notification url
       ];
       
       return '
        <form action="'.$action.'" id="sample" method="POST" style="display:none;">
        <input name="id" value="'.$fields['id'].'">
         <input name="amount" value="'.$data['amount'].'">
        </form>
       <script>
       function checkout(){
        $("#sample").submit();
       }
       </script>
        ';  
    } 
    
    public function identifyRequest(){
        //check if request is from this method, return true if yes
    }
    
    public function validateRequest($paymentConfig,$methodConfig){
        
            //do some request verification i needed

            if ($verified) {
                $paymentModel = newModel('PaymentModel');
                
                $payment = $paymentModel->where(['control'=>$_POST['custom'],'updated_at'=>'0'])->first();  
                if(!$payment) return ['error'=>'Payment not found'];
                $amount = number_format((float)$payment['amount'], 2, '.', '');
                
                $rules = [
				'id' => $methodConfig['id'],
                'status' => 'Completed',
                'amount' =>   $amount,
                'currency' => strtoupper($payment['currency'])
                ];
                
                foreach($rules as $name=>$value){
                    if(!isset($_POST[$name]) || $_POST[$name] != $value){
                        return ['error'=>'Field '.$name.' is incorrect'];
                    }
                }

                $paymentModel->save(['id'=> $payment['id'],'updated_at'=>time(),'transaction'=>$_POST['tid']]);
                 
                return ['returnText'=>'OK','update'=>$payment];  //required content: site id (site), package id (package), time in month (int) 

            
            } else {
                return ['error'=>'sample payment verification fail'];
            } 


    }


    

}