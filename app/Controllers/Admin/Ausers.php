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

class Ausers extends BaseController 
{
    protected $returnPath = '/admin/users';
    
    public function index(){
        if(!$this->privileges->can('view','admin_users')) return $this->response(3);
        $data = $this->dataCommon();
        helper(['form']);
        
        $UserModel = newModel('UserModel');
        $UserModel->join('Sites', 'Sites.user = Users.id', 'LEFT');
        $UserModel->select('Users.*');
        $UserModel->selectCount('Sites.id','sitesCount')->groupBy('Users.id');
        
        if ($this->request->getMethod() == 'post') {
          $search = $this->request->getPost('search');
          $UserModel->like('username',$search,'both');
          $UserModel->orLike('email',$search,'both');
          $UserModel->orWhere('role',$search);
          $UserModel->orWhere('Users.status',$search);

        }
        
        $data['rows'] = $UserModel->orderBy('Users.id','asc')->paginate(20);
        $data['pager'] = $UserModel->pager;
        
        $data['designers'] = [];
        foreach($UserModel->where('status','designer')->findAll() as $row){
            $data['designers'][$row['id']] = $row['username'];
        }
        
        foreach($data['rows'] as &$row){
            if($row['rid'] != 0){
               $row['designer'] = isset($data['designers'][$row['rid']]) ? $data['designers'][$row['rid']] : '';
            } else {
                $row['designer'] = '-';
            }
        }
        
        $data['search'] = getView('dashboard/parts/search');
        $data['modal'] = ['id'=>'delete','body'=>lang('app.del-user-and-sites')];
        
  		echo getView('admin/parts/header', $data);
		echo getView('admin/users');
        echo getView('dashboard/parts/modalConfirm');
		echo getView('dashboard/parts/footer');  
        
    }
    
    public function login($id){
        if(!$this->privileges->can('login','admin_users')) return $this->response(3);
        
        $model = newModel('UserModel');
        $user = $model->where('id',$id)->first(); 
        if(!$user){
        $this->session->setFlashdata('fail', 'User not found');
		return namedRedirect('admin/users');
        }
        if($user['status'] == 'admin'){
        $this->session->setFlashdata('fail', "Can't login as admin");
		return namedRedirect('admin/users');
        }
        
        $params = ['user_id', 'user_username','user_status','user_role','user_email'];
        $uData = ['admin_mode'=>[]];
        
        foreach($params as $param){
            $uData[$param] = $user[str_replace("user_","",$param)];
            $uData['admin_mode'][$param] = $this->session->get($param);
        }
        $uData['user_role'] = $uData['admin_mode']['user_role'];
        
        $uData['user_display_name'] = $user['username'];

		$this->session->set($uData);
        return namedRedirect('dashboard');
    }
    
       public function assign($id){
        if(!$this->privileges->can('manage','admin_users')) return $this->response(3);
        
         helper(['form']);
         $data = $this->dataCommon();
         $model = newModel('UserModel');
         
        $data['row'] = $id ? $model->where(['id'=>$id])->first() : false; 
         
         if(!$data['row'] || !in_array($data['row']['status'], ['user','autoUser']) ){
            $this->session->setFlashdata('fail', 'Can\'t assign');
				return redirect()->back();
         }
         
         $designers = ['0'=> lang('app.none')]; 
         foreach($model->where('status','designer')->findAll() as $row){
            $designers[$row['id']] = $row['username'];
        }
         
         $data['rules'] = [
                'id' => [
                'rules'=>'permit_empty|is_not_unique[Users.id]',
                'type'=>'hidden'
                ],
                'rid' => [
                'rules'=>'required|max_length[20]',
                'label'=>lang('app.designer'),
                'type'=>'select',
                'options'=>$designers
                
                ],
			];
        
        if ($this->request->getMethod() == 'post') {
            if (! $this->validate($data['rules'])) {
				$data['validation'] = $this->validator;
			}else{
			 
             $newData = $this->request->getPost();
             //remove any additional fields
             foreach($newData as $name=>$value){
              if(!isset($data['rules'][$name])){
                unset($newData[$name]);
              }  
             }
             if(empty($newData['password']))
             unset($newData['password']);
             
			 $model->save($newData);
             $this->session->setFlashdata('success', 'Successfuly Updated');
				return namedRedirect('admin/users');
             }
        }
          
          
        $data['back'] = ['label'=>lang('app.back'), 'path'=>'/admin/users'];
        $data['title'] = lang('app.assign-designer');
        $data['row']['password'] = '';
        

  		echo getView('admin/parts/header', $data);
		echo getView('dashboard/parts/saveform');
		echo getView('dashboard/parts/footer');      
    }
    
    public function save($id=null){
        if(!$this->privileges->can('manage','admin_users')) return $this->response(3);
        
         helper(['form']);
         $data = $this->dataCommon();
         $data['rules'] = [
                'id' => [
                'rules'=>'permit_empty|is_not_unique[Users.id]',
                'type'=>'hidden'
                ],
				'username' => [
                'rules'=>'required|min_length[3]|max_length[100]',
                'label'=>lang('app.username')
                ],
                'firstname' => [
                'rules'=>'permit_empty|min_length[3]|max_length[60]',
                'label'=>lang('app.firstname')
                ],
                'lastname' => [
                'rules'=>'permit_empty|min_length[3]|max_length[60]',
                'label'=>lang('app.lastname')
                ],
                'password' => [
                'rules'=>'permit_empty|min_length[6]|max_length[60]',
                'label'=>lang('app.password')
                ],
                'email' => [
                'rules'=>'required|valid_email|max_length[200]',
                'label'=>lang('app.email-addr')
                ],
                'status' => [
                'rules'=>'required|string|max_length[10]',
                'label'=>lang('app.status'),
                'type'=>'select',
                'options'=>['user'=>lang('app.user'),'designer'=>lang('app.designer'),'admin'=>lang('app.administrator'),'blocked'=>lang('app.blocked')]
                ],
                'role' => [
                'rules'=>'required|max_length[20]',
                'label'=>lang('app.privileges'),
                'type'=>'select',
                'options'=>array_combine($this->privileges->getRoleList(),$this->privileges->getRoleList())
                
                ],
			];
        $model = newModel('UserModel');
        
     
         $data['row'] = $id ? $model->where('id',$id)->first() : false; 
         
         if(!$data['row']){
            $data['rules']['password']['rules'] = 'required|min_length[6]|max_length[60]';
         }  
  
        if(!$this->privileges->can('manage_admins','admin_users')){
            if($data['row'] && $data['row']['status'] == 'admin') return $this->response(3); 
            unset($data['rules']['status']['options']['admin']);    
            
        }
        
        if ($this->request->getMethod() == 'post') {
            if (! $this->validate($data['rules'])) {
				$data['validation'] = $this->validator;
			}else{
			 
             $newData = $this->request->getPost();
             //remove any additional fields
             foreach($newData as $name=>$value){
              if(!isset($data['rules'][$name])){
                unset($newData[$name]);
              }  
             }
             if(empty($newData['password']))
             unset($newData['password']);
             
			 $model->save($newData);
             $this->session->setFlashdata('success', 'Successfuly Updated');
				return namedRedirect('admin/users');
             }
        }
          
          
        $data['back'] = ['label'=>lang('app.back'), 'path'=>'/admin/users'];
        $data['title'] = lang('app.user');
        $data['row']['password'] = '';
        

  		echo getView('admin/parts/header', $data);
		echo getView('dashboard/parts/saveform');
		echo getView('dashboard/parts/footer');      
    }
    
        public function delete(){
        if(!$this->privileges->can('manage','admin_users')) return $this->response(3);
        
        if ($this->request->getMethod() == 'post') {  
            $id = $this->request->getPost('id');
    
        $model = newModel('UserModel');
        $user = $model->where('id',$id)->first();
        if(!$user){ return $this->response(); }
        
        if($user['status'] == 'admin' && !$this->privileges->can('manage_admins','admin_users')){
            return $this->response(3);
        }
        
        $model->delete($id);
        $sitemodel = newModel('SiteModel');
        $sites = $sitemodel->where('user',$user['id'])->findAll();
        $sitemodel->where('user',$user['id'])->delete();
        
        $MailboxModel = newModel('MailboxModel');
        $MailboxModel->where('user',$id)->delete();
        
        $FileManager = newLib('FileManager');
        $MediaManager = newLib('MediaManager');
        $controlPanel = newLib('Controlpanel');
               
        foreach($sites as $site){          
            $FileManager->deleteDirectory($FileManager->projectsRoot.$site['directory']);
            unlink($FileManager->projectThumbsRoot.$site['directory'].'.jpg');
            
            $MediaManager->connect($site['media']);
            $MediaManager->deleteDirectory($site['directory']);
            
            if(!empty($site['panel_password'])) {
            $controlPanel->connectReseller($site['panel_reseller']);
            $query = $controlPanel->query('deleteUser',['username'=>$site['panel_login']]);
            }         
        
        }
    }
        
		return namedRedirect('admin/users');   
    }
    
    protected function response($type=null){
        if($type == '1'){
          $this->session->setFlashdata('success', lang('app.updatesuccess'));  
        } if($type == '0'){
          $this->session->setFlashdata('fail', lang('app.updatefail'));  
        } else if($type == 3){
          $this->session->setFlashdata('fail', 'Action not allowed');  
        }
         
		 return namedRedirect('admin/users');  
    }
protected function dataCommon($data=[]){
       return array_merge(['privileges' => $this->privileges], $data);
}

	//--------------------------------------------------------------------

}