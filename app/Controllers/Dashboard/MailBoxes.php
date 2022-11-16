<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Controllers\Dashboard;
use App\Controllers\BaseController;

class MailBoxes extends BaseController
{

    protected $package;
    protected $site;

    public function list($siteId){
        $this->siteId = $siteId;
        if(!$this->verify()) return namedRedirect($this->back);
        
        $this->privileges->extendBySite($siteId);
        if(!$this->privileges->can('mailbox_view')) return namedRedirect($this->back);

        $data = $this->commonData();
        $MailboxModel = newModel('MailboxModel');
        
        $data['rows'] = $MailboxModel->where('site',$this->site['id'])->findAll();
        $data['site'] = $this->site;
        $data['webmail'] = config('MasterConfig')->resellers[$this->site['panel_reseller']]['webmail'];
        $data['modal'] = ['id'=>'delete','body'=>lang('app.sure-del-mailbox')];
        
        
        
        echo getView('dashboard/parts/header', $data);
		echo getView('dashboard/mailboxes');
       echo getView('dashboard/parts/modalConfirm');
		echo getView('dashboard/parts/footer'); 

    }
    
    public function add($siteId){
        $this->siteId = $siteId;
        
        $this->privileges->extendBySite($siteId);
        if(!$this->privileges->can('mailbox_add')) return namedRedirect($this->back);
        
        if(!$this->verify()) return namedRedirect($this->back);
        
        $MailboxModel = newModel('MailboxModel');
        $emails = $MailboxModel->where('site',$this->site['id'])->countAllResults();
  
        if($this->package['emails'] <= $emails){
          $this->session->setFlashdata('fail', lang('app.package-limit'));  
          return namedRedirect($this->back); 
        }

        helper(['form']);
        
        $data = $this->commonData();
        
         $data['rules'] = [
                'add' => [
                'type'=>'hidden',
                'rules'=>'required'
                ],
                'name' => [
                'rules'=>'required|alpha_numeric|min_length[3]|max_length[100]',
                'label'=>lang('app.name'),
                'size'=>'6'
                ],
                'domain' => [
                'rules'=>'permit_empty',
                'label'=>lang('app.domain'),
                'type'=>'disabled',
                'size'=>'6'
                ],
                'password' => [
                'rules'=>'required|min_length[1]|max_length[60]',
                'label'=>lang('app.password'),
                'itype'=>'password'
                ],
			];
            
            if ($this->request->getPost('add')) {
                if (! $this->validate($data['rules'])) {
    				$data['validation'] = $this->validator;
    			}else{
    			 
                     $newData = $this->request->getPost();

                     foreach($newData as $name=>$value){
                      if(!isset($data['rules'][$name])){
                        unset($newData[$name]);
                      }  
                     }
                     $newData['site'] = $this->site['id'];
                     $newData['user'] = $this->session->get('user_id');
                     $exist = $MailboxModel->where(['name'=>$newData['name'],'user'=>$newData['user'],'site'=>$newData['site']])->first();
                     if($exist){
                            $this->validator->setError('custom',lang('app.already-exist'));
                            $data['validation'] = $this->validator;    
                     } else{
                        $controlPanel = newLib('Controlpanel');
                        $controlPanel->connectUser($this->site);
                        
                        $query = $controlPanel->query('addEmail',['name'=>$newData['name'],'domain'=>$this->site['domain'],'pass'=>$newData['password']]);
                        if(isset($query['error'])){
                             $this->session->setFlashdata('fail', $query['error']);      
                        } else {
                        $MailboxModel->save($newData);
                        $this->session->setFlashdata('success', lang('app.update-success'));
        				return namedRedirect($this->back);
                        }
                                
                                
        			 
                    }    
                 }
        }
        $data['row']['domain'] = $this->site['domain'];
        $data['row']['add'] = 'true';
        
        $data['back'] = ['label'=>lang('app.back'), 'path'=>$this->back];
        $data['title'] = lang('app.add-mailbox'); 
        
        echo getView('dashboard/parts/header', $data);
		echo getView('dashboard/parts/saveform');
		echo getView('dashboard/parts/footer');
    }
        
        public function delete($siteId){
            $this->siteId = $siteId;
            
            $this->privileges->extendBySite($siteId);
            if(!$this->privileges->can('mailbox_delete')) return namedRedirect($this->back);
            
            if(!$this->verify()) return namedRedirect($this->back);
            $MailboxModel = newModel('MailboxModel');
            $email = $MailboxModel->where(['site'=>$this->site['id'],'id'=>$this->request->getPost('mailbox')])->first();
            if(!$email){ 
             $this->session->setFlashdata('fail', lang('app.update-fail'));  
             return namedRedirect($this->back);
            }; 
            
            $controlPanel = newLib('Controlpanel');
            $controlPanel->connectUser($this->site);
                         
            $query = $controlPanel->query('deleteEmail',['name'=>$email['name'],'domain'=>$this->site['domain']]);
            if(isset($query['error'])){
                $this->session->setFlashdata('fail', $query['error']);     
            } else {
            $MailboxModel->delete($email['id']);
           
            $this->session->setFlashdata('success', lang('app.update-success')); 
            }  
            return namedRedirect($this->back);
       
        
        }
    
        public function change($siteId){
        $this->siteId = $siteId;
        
        $this->privileges->extendBySite($siteId);
        if(!$this->privileges->can('mailbox_change')) return namedRedirect($this->back);
       
        if(!$this->verify()) return namedRedirect($this->back);
        
        $MailboxModel = newModel('MailboxModel');
        $email = $MailboxModel->where(['site'=>$this->site['id'],'id'=>$this->request->getGet('mailbox')])->first();
        if(!$email){ 
            $this->session->setFlashdata('fail', lang('app.update-fail'));  
            return namedRedirect($this->back);
        }; 

        helper(['form']);
        
        $data = $this->commonData();
        
         $data['rules'] = [
                'old_password' => [
                'rules'=>'required|min_length[6]|max_length[60]',
                'label'=>lang('app.old-password'),
                'itype'=>'password'
                ],
                'new_password' => [
                'rules'=>'required|min_length[6]|max_length[60]',
                'label'=>lang('app.new-password'),
                'itype'=>'password'
                ],
			];
            
            if ($this->request->getPost('old_password')) {
                if (! $this->validate($data['rules'])) {
    				$data['validation'] = $this->validator;
    			}else{
    			 
                     $newData = $this->request->getPost();

                     foreach($newData as $name=>$value){
                      if(!isset($data['rules'][$name])){
                        unset($newData[$name]);
                      }  
                     }
                     
                     $controlPanel = newLib('Controlpanel');
                     $controlPanel->connectUser($this->site);
                     
                      $query = $controlPanel->query('changeEmail',['name'=>$email['name'],'domain'=>$this->site['domain'],'oldpassword'=>$newData['old_password'],'newpassword'=>$newData['new_password']]);
                        if(isset($query['error'])){
                             $this->session->setFlashdata('fail', $query['error']);    
                        } else {
                          $this->session->setFlashdata('success', lang('app.update-success'));
    				return namedRedirect($this->back);   
                        }
                     
               
                        
                        
                 }
        }
        
        $data['back'] = ['label'=>lang('app.back'), 'path'=>$this->back];
        $data['title'] = lang('app.change-password'); 
        
        echo getView('dashboard/parts/header', $data);
		echo getView('dashboard/parts/saveform');
		echo getView('dashboard/parts/footer');
    }

    
    protected function verify(){
       $this->back = 'dashboard';
       $upgradeLink = ' <a href="'.namedRoute('dashboard/payment').'?site='.$this->site['id'].'">'.lang('app.upgrade').'</a>';
       
       if(!$this->isMySite() || !$this->isAllowed()) {
        $this->session->setFlashdata('fail', lang('app.package-not-allowed').$upgradeLink);  
        return false;
       }
        if(empty($this->site['domain'])) {
        $this->session->setFlashdata('info', lang('app.add-domain-first'));  
        return false;
        }
        
        $this->back = 'dashboard/mailbox/list/'.$this->site['id'];
        
        return true;
    }
    
    protected function isAllowed(){

      $pricingModel = newModel('PricingModel');
      $this->package = $pricingModel->where('id',$this->site['package'])->first();
      if($this->package['emails'] == 0){
        return false;
      } 
      return true; 
    }
    protected function isMySite(){
        $siteModel = newModel('SiteModel');
        $this->site = $siteModel->getMySite($this->siteId);
        if(!$this->site) return false;
        return true;
    }


	//--------------------------------------------------------------------

}
