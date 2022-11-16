<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries\Payments;
class p24 { 
 
             public function initMethod(){
                return '';
            }   
/**
 *$paymentConfig: MasterConfig->paymentConfig, 
 *$methodConfig: MasterConfig->paymentMethods['p24'] or paymentTestMethods['p24']
 *$data: ['site','amount','currency','control','package','time','method',created_at]
 */
    public function generateForm($paymentConfig,$methodConfig,$data){ 
           $type = $paymentConfig['testMode'] ? 'sandbox' : 'secure';
    
           $fields = [
           'id' => $methodConfig['id'],
           'pos_id'=> $methodConfig['pos_id'],
           'crc' => $methodConfig['crc'],
           'amount'=> $data['amount'] * 100,
           'desc' => lang('app.payment-desc'),
           'url' => namedRoute('dashboard'),
           'urlc' => namedRoute('payconfirm')
           ];

            $headers[] = 'p24_merchant_id=' . $fields['id'];
            $headers[] = 'p24_pos_id=' . $fields['pos_id'];
            $headers[] = 'p24_crc=' . $fields['crc'];
            $headers[] = 'p24_session_id=' . $data['control'];
            $headers[] = 'p24_amount=' . $fields['amount'];
            $headers[] = 'p24_currency='.strtoupper($data['currency']);
            $headers[] = 'p24_description=' . $fields['desc'];
            $headers[] = 'p24_country=PL';
            $headers[] = 'p24_url_return=' . urlencode($fields['url']);
            $headers[] = 'p24_url_status=' . urlencode($fields['urlc']);
            $headers[] = 'p24_api_version=3.2';
            $headers[] = 'p24_sign=' . md5($data['control'] . '|' . $fields['id'] . '|' . $fields['amount'] . '|'.strtoupper($data['currency']).'|' . $fields['crc']);
            $headers[] = 'p24_email=' . 'mail@test.pl';

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
            curl_setopt($curl, CURLOPT_POSTFIELDS, implode('&', $headers));
            curl_setopt($curl, CURLOPT_URL, 'https://' . $type . '.przelewy24.pl/trnRegister');
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
            curl_close($curl);

            parse_str($response, $output);
            if(!isset($output['token'])) {
              return dlog('p24 fail '.json_encode($output));
                
            }
            $url = 'https://' . $type . '.przelewy24.pl/trnRequest/' . $output['token'];
            
            return '
            <script>
               function checkout(){
                window.location.href = "'.$url.'";
               }
               </script>
            ';
            
        } 
    
    public function identifyRequest(){
        if (isset($_POST['p24_merchant_id']) && isset($_POST['p24_sign'])) {
           return true;
            }
    }
    
    public function validateRequest($paymentConfig,$methodConfig){
            $paymentModel = newModel('PaymentModel');
            $payment = $paymentModel->where(['control'=>$_POST['p24_session_id'],'updated_at'=>'0'])->first();
            if(!$payment) return ['error'=>'Payment not found'];

            $amount = number_format((float)$payment['amount'], 2, '.', '');
                
                $rules = [
				'p24_merchant_id' => $methodConfig['id'],
                'p24_pos_id'=> $methodConfig['pos_id'],
                'p24_amount' =>   $amount*100,
                'p24_currency' => strtoupper($payment['currency'])
                ];
                
                foreach($rules as $name=>$value){
                    if(!isset($_POST[$name]) || $_POST[$name] != $value){
                        return ['error'=>'Field '.$name.' is incorrect'];
                    }
                }
                
                if(!$this->verify($paymentConfig,$methodConfig)){
                    return ['error'=>'p24 payment verification fail'];
                }

                $paymentModel->save(['id'=> $payment['id'],'updated_at'=>time(),'transaction'=>$_POST['p24_order_id']]);
                 
                return ['returnText'=>'OK','update'=>$payment];  //required content: site id (site), package id (package), time in month (int) 
       


    }
    
    protected function verify($paymentConfig,$methodConfig)
        {
            $type = $paymentConfig['testMode'] ? 'sandbox' : 'secure';
            
            $headers[] = 'p24_merchant_id=' . $_POST['p24_merchant_id'];
            $headers[] = 'p24_pos_id=' . $_POST['p24_pos_id'];
            $headers[] = 'p24_session_id=' . $_POST['p24_session_id'];
            $headers[] = 'p24_amount=' . $_POST['p24_amount'];
            $headers[] = 'p24_currency='.$_POST['p24_currency'];
            $headers[] = 'p24_order_id=' . $_POST['p24_order_id'];
            $headers[] = 'p24_sign=' . md5($_POST['p24_session_id'] . '|' . $_POST['p24_order_id'] . '|' . $_POST['p24_amount'] . '|'.$_POST['p24_currency'].'|' . $methodConfig['crc']);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');
            curl_setopt($curl, CURLOPT_POSTFIELDS, implode('&', $headers));
            curl_setopt($curl, CURLOPT_URL, 'https://' . $type . '.przelewy24.pl/trnVerify');
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($curl);
            curl_close($curl);

            parse_str($response, $output);
            if($output['error'] == '0'){
                return true;
            } else {
            dlog('p24 verify fail '.json_encode($output));
            return false;
            }
        }

}