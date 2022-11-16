<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Asites extends BaseController 
{
    
    public function index(){
        if(!$this->privileges->can('admin_sites_manage')) return redirect()->back();
        
        $data = $this->dataCommon();
        helper(['form']);
        
        $siteModel = newModel('SiteModel');
        $siteModel->join('Users', 'Users.id = Sites.user', 'LEFT')->select('Sites.*')->select('Users.username');
        
        if ($this->request->getMethod() == 'post') {
          $siteModel->like('directory',$this->request->getPost('search'),'both')->orLike('Users.username',$this->request->getPost('search'),'both');
        }
        
        $rows = $siteModel->orderBy('Sites.id','asc')->paginate(20);
        $data['pager'] = $siteModel->pager;
        
        $data['rows'] = $siteModel->SitesData($rows);
        $data['search'] = getView('dashboard/parts/search');
  		
        $data['pricing'] = $this->pricingList()['rows'];  
        $data['modal'] = ['id'=>'delete','body'=>lang('app.sure-del-site')];
        
          
        echo getView('admin/parts/header', $data);
		echo getView('admin/sites');
        echo getView('dashboard/parts/modalConfirm');
		echo getView('dashboard/parts/footer');  
        
    }
    
        public function delete(){
            if(!$this->privileges->can('admin_sites_manage')) return redirect()->back();
            
        if ($this->request->getMethod() == 'post') {  
            $id = $this->request->getPost('id');
            $siteModel = newModel('SiteModel');
            $site = $siteModel->where('id',$id)->first();
            $siteModel->delete($id);
            
            $MailboxModel = newModel('MailboxModel');
            $MailboxModel->where('site',$id)->delete();
    
            $FileManager = newLib('FileManager');
            $FileManager->deleteDirectory($FileManager->projectsRoot.$site['directory']);
            unlink($FileManager->projectThumbsRoot.$site['directory'].'.jpg');
            
            $MediaManager = newLib('MediaManager');
            $MediaManager->connect($site['media']);
            $MediaManager->deleteDirectory($site['directory']);
            
            if(!empty($site['panel_password'])) {
            $controlPanel = newLib('Controlpanel');
            $controlPanel->connectReseller($site['panel_reseller']);
            $query = $controlPanel->query('deleteUser',['username'=>$site['panel_login']]);
            }
           
        }
		return namedRedirect('admin/sites');   
    }
    
        public function edit($id=null){
            if(!$this->privileges->can('admin_sites_manage')) return redirect()->back();
            
         helper(['form']);
         $data = $this->dataCommon();
         $data['rules'] = [
                'id' => [
                'rules'=>'required|is_not_unique[Sites.id]',
                'type'=>'hidden'
                ],
                'package' => [
                'rules'=>'required|max_length[3]',
                'label'=>lang('app.package'),
                'type'=>'select',
                'options'=>$this->pricingList()['list']
                ],
                'status' => [
                'rules'=>'required|max_length[3]',
                'label'=>lang('app.active'),
                'type'=>'select'
                ],
                'expire' => [
                'rules'=>'required|min_length[8]|max_length[60]',
                'label'=>lang('app.expire'),
                'type'=>'tsDate'
                ]
			];
         $siteModel = newModel('SiteModel');
         $data['row'] = $id ? $siteModel->where('id',$id)->first() : false; 
         if($data['row']){

        if ($this->request->getMethod() == 'post') {
            if (! $this->validate($data['rules'])) {
				$data['validation'] = $this->validator;
			}else{
			 $newData = $this->request->getPost();
             

             foreach($newData as $name=>$value){
              if(!isset($data['rules'][$name])){
                unset($newData[$name]);
              }  
             }
             
             $time = date('H:i',$data['row']['expire']);
             $newData['expire'] = strtotime($newData['expire'].' '.$time);

             $siteModel->save($newData);
             
             if($data['row']['expire'] != $newData['expire'] || $data['row']['status'] != $newData['status']){
                if(!empty($data['row']['domain']) && !empty($data['row']['panel_password'])){
                  $RemoteFileManager = newLib('RemoteFileManager');
                  $RemoteFileManager->init($data['row']['id']);
                  $RemoteFileManager->setStatus();
                  }
              
                  $manager = newLib('MediaManager');
                  $manager->connect($data['row']['media']);
                  $manager->setStatus($data['row']['directory'],$newData['expire'],$newData['status']);       
             }
             
             $this->session->setFlashdata('success', 'Successfuly Updated');
   	         return namedRedirect('admin/sites');

             
             
             
             }
        }
        
        
         
        
            
        $data['back'] = ['label'=>lang('app.back'), 'path'=>'/admin/sites'];
        $data['title'] = lang('app.site');
        

  		echo getView('admin/parts/header', $data);
		echo getView('dashboard/parts/saveform');
		echo getView('dashboard/parts/footer');
        
        }      
    }
    protected function pricingList(){
        $model = newModel('PricingModel');
        $data = ['list'=>[],'rows'=>[]];
        $all = $model->findAll();
        
        foreach($all as $k=>$row){
           
          $data['list'][$row['id']] = $row['name']; 
          $data['rows'][$row['id']] = $row;  
        }
        return $data;
    }
    
    protected function dataCommon($data=[]){
       return array_merge(['privileges' => $this->privileges], $data);
    }


	//--------------------------------------------------------------------

}