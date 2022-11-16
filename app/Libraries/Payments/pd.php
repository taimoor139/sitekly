<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries\Payments;
class pd { 
    
    
    public function initMethod(){
        return '<script src="https://cdn.paddle.com/paddle/paddle.js"></script>';
    }
    
/**
 *$paymentConfig: MasterConfig->paymentConfig, 
 *$methodConfig: MasterConfig->paymentMethods['sample'] or paymentTestMethods['sample']
 *$data: ['site','amount','currency','control','package','time','method',created_at]
 */
    public function generateForm($paymentConfig,$methodConfig,$data){ 
       $sandbox = $paymentConfig['testMode'] ? 'Paddle.Environment.set("sandbox");' : '';
       $product = $methodConfig['packages'][$data['package']][$data['time']];
       $back = namedRoute('dashboard');
       return '
        <script type="text/javascript">
        '.$sandbox.'
        Paddle.Setup({ 
            vendor: '.$methodConfig['vendor'].',
            eventCallback: function(data) {
                 if (data.event === "Checkout.Close") {
                  window.location.replace("'.$back.'");
                }
            } 
            });
        function checkout() {
		Paddle.Checkout.open({ product: '.$product.', allowQuantity: false, passthrough: "'.$data["control"].'" });
        }
        </script>
        ';  
    }
    
    public function cancel($paymentConfig,$methodConfig,$data){
        if(!isset($methodConfig['apiKey']) || empty($methodConfig['apiKey'])){
            return ['success'=>false,'message'=>lang('app.contact-support-for-assistance')];
        }
        
        $url = $paymentConfig['testMode'] ? 'https://sandbox-vendors.paddle.com/api/' : 'https://vendors.paddle.com/api/';
        $client = \Config\Services::curlrequest();
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url."2.0/subscription/users_cancel",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "vendor_id=".$methodConfig['vendor']."&vendor_auth_code=".$methodConfig['apiKey']."&subscription_id=".$data['subscription']['subscription_id'],
          CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          dlog($err);
          return ['success'=>false,'message'=>lang('app.contact-support-for-assistance')];
        } else {
          $result = json_decode($response);
          if($result->success){
            return ['success'=>true,'message'=>lang('app.update-success')];
          } else {
            dlog($response);
            return ['success'=>false,'message'=>lang('app.update-fail')];
          }
        }
    } 
    
    public function identifyRequest(){
        if(isset($_POST['passthrough']) && isset($_POST['checkout_id'])){
            return true;
        }
    }
    
    public function validateRequest($paymentConfig,$methodConfig){

            if ($this->verify($paymentConfig,$methodConfig)) {
                $paymentModel = newModel('PaymentModel');

                if($_POST['alert_name'] == 'subscription_payment_succeeded'){
                     $payment = $paymentModel->where(['control'=>$_POST['passthrough'],'transaction!='=>$_POST['subscription_payment_id']])->first();
                     if(!$payment) return ['error'=>'Payment not found'];
                     $paymentModel->save(['id'=> $payment['id'],'transaction'=>$_POST['subscription_payment_id']]);  
                     
                     
                     $payment['control'] = $payment['id'];
                     $payment['updated_at'] = time();
                     unset($payment['id']);
                     $paymentModel->save($payment);   

                     $payment['subscription'] = ['method'=>'pd','subscription_id'=>$_POST['subscription_id']];
                } else if($_POST['alert_name'] == 'payment_succeeded'){
                    $payment = $paymentModel->where(['control'=>$_POST['passthrough'],'updated_at'=>'0'])->first();
                     if(!$payment) return ['error'=>'Payment not found'];
                     $paymentModel->save(['id'=> $payment['id'],'updated_at'=>time(),'transaction'=>$_POST['order_id']]);  
                } else{
                     return 'ignore';
                }

                 
                return ['returnText'=>'OK','update'=>$payment];
            
            } else {
                return ['error'=>'Paddle payment verification fail'];
            } 


    }
    
    protected function verify($paymentConfig,$methodConfig){

          $public_key = openssl_get_publickey($methodConfig['publicKey']);
          
          // Get the p_signature parameter & base64 decode it.
          $signature = base64_decode($_POST['p_signature']);
          
          // Get the fields sent in the request, and remove the p_signature parameter
          $fields = $_POST;
          unset($fields['p_signature']);
          
          // ksort() and serialize the fields
          ksort($fields);
          foreach($fields as $k => $v) {
        	  if(!in_array(gettype($v), array('object', 'array'))) {
        		  $fields[$k] = "$v";
        	  }
          }
          $data = serialize($fields);
          
          // Verify the signature
          $verification = openssl_verify($data, $signature, $public_key, OPENSSL_ALGO_SHA1);
          
          if($verification == 1) {
        	 return true;
          } 
    }


    

}