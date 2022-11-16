<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

//custom controller for front pages
namespace App\Controllers;

class Front extends BaseController
{

    public function home(){
        return $this->viewPage('home');  
    }
    
    public function viewPage($page,$subpage=null){

        $data = [];
        $data['locale'] = $this->session->get('lang');
        $data['lang_base'] = rtrim($this->session->get('lang_base') != null ? $this->session->get('lang_base') : '','/');
        
        //view 404 if view not existing
        $view = $subpage ? $page.'/'.$subpage : $page;
       if(!is_file(APPPATH.'Views/front/'.$view.'.php'))
       return $this->view404();
        
        //get templates for specific pages
        $templatePages = ['templates'];
        if(in_array($page,$templatePages)){
        $data['templates'] = $this->getTemplates();
        }
        
       //load templates using ids
       //   $data['templates'] = $this->getTemplates([2,3,4,5]); 
       
        //load all templates
        if($page == 'templates'){
          $data['templates'] = $this->getTemplates();  
        }
        
        //load pricing 
        //$data['pricing'] = $this->getPricing();
       
       echo getView('front/parts/header', $data);
       echo getView('front/'.$view);
       echo getView('front/parts/footer');
    }
    
  public function ajaxform($id)
	  { 
        $config = config('MasterConfig');
        
        $success = lang('app.mail-form-success');
        $fail = lang('app.mail-form-fail');
        $subject = 'your example form';

        $message = '';


        foreach($_POST as $k=>$v){
            $message .= '<p><b>'.htmlspecialchars($k, ENT_QUOTES).':</b> '.htmlspecialchars($v, ENT_QUOTES).'</p>';  
        }
        
        
        $mailData = [
        'sendTo' => $config->notify['contact_email'],
        'subject' => $subject,
        'message'=> $message
        ];
        
        $mails = newLib('Mails');
        if($mails->send($mailData)){
          $return = ['status'=>1,'message'=>$success];
        } else{
          $return = ['status'=>0,'message'=>$fail];  
        }
        
        return $this->response->setJSON($return);
	  
	}
    
    
    private function getTemplates($filter=null, $sort='DESC',$showBlank=true){
       $model = newModel('TemplateModel');
       
       if($filter){
        $templates = $model->whereIn('id', $filter)->orderBy('id', 'DESC')->findAll();
       } else {
        $templates = $model->where(['status'=>'1','type'=>'1'])->orderBy('id', $sort)->findAll();  
       }

       $bkey = array_search('f930533257d79378', array_column($templates, 'uid'));

       $blank = $templates[$bkey];
       unset($templates[$bkey]);
       if($showBlank){
       array_unshift($templates,$blank);
        }
       
	   return $model->TemplatesData($templates);  

    }
    
    private function getPricing($trialInclude=false){
       
       $model = newModel('PricingModel');
       if($trialInclude){
        $pricing = $model->findAll();
       } else{
        $pricing = $model->where('id!=','1')->findAll();
       }
       
       
       return $pricing;

    }
    
    private function view404(){
        $this->response->setStatusCode(404);
        echo getView('errors/html/error_404');
    }
    

	//--------------------------------------------------------------------

}
