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

class Apricing extends BaseController 
{
    
    public function index(){
        if(!$this->privileges->can('admin_pricing_manage')) return redirect()->back();
        $data = $this->dataCommon();
        
        $model = newModel('PricingModel');
        $data['pricing'] = $model->findAll();
        $data['modal'] = ['id'=>'delete','body'=>lang('app.del-package')];


  		echo getView('admin/parts/header', $data);
		echo getView('admin/pricing');
        echo getView('dashboard/parts/modalConfirm');
		echo getView('dashboard/parts/footer');  
        
    }
    
    public function save($id=null){
       if(!$this->privileges->can('admin_pricing_manage')) return redirect()->back(); 
         helper(['form']);
         $data = $this->dataCommon();
         $data['rules'] = [
                'id' => [
                'rules'=>'permit_empty|is_not_unique[Packages.id]',
                'type'=>'hidden'
                ],
				'name' => [
                'rules'=>'required|min_length[3]|max_length[100]',
                'label'=>lang('app.name2')
                ],
                'space' => [
                'rules'=>'required|integer|max_length[11]',
                'label'=>lang('app.disk-space')
                ],
                'ads' => [
                'rules'=>'required|integer|max_length[1]',
                'label'=>lang('app.ads'),
                'type'=>'select'
                ],
                'subdomain' => [
                'rules'=>'required|integer|max_length[1]',
                'label'=>lang('app.subdomain'),
                'type'=>'select'
                ],
                'domain' => [
                'rules'=>'required|integer|max_length[1]',
                'label'=>lang('app.user-domain'),
                'type'=>'select'
                ],
                'emails' => [
                'rules'=>'required|integer|max_length[3]',
                'label'=>lang('app.email-accounts')
                ],
                'site_limit' => [
                'rules'=>'required|integer|max_length[3]',
                'label'=>lang('app.site-count-allowed')
                ],
                'custom' => [
                'rules'=>'permit_empty',
                'label'=>lang('app.custom-properties'),
                'type'=>'textarea'
                ],
                'price_monthly_month' => [
                'rules'=>'required',
                'label'=>lang('app.price-admin-mo-month').lang('app.m1-disable')
                ],
                'price_monthly_year' => [
                'rules'=>'required',
                'label'=>lang('app.price-admin-mo-year').lang('app.m1-disable')
                ]
			];
        $model = newModel('PricingModel');
     
         $data['row'] = $id ? $model->where('id',$id)->first() : false;   
  
        
        if ($this->request->getMethod() == 'post') {
            if (! $this->validate($data['rules'])) {
				$data['validation'] = $this->validator;
			}else{
			 $model->save($this->request->getPost());
             $this->session->setFlashdata('success', 'Successfuly Updated');
				return namedRedirect('admin/pricing');
             }
        }
          
          
       $data['back'] = ['label'=>lang('app.back'), 'path'=>'/admin/pricing'];
       $data['title'] = lang('app.package');

  		echo getView('admin/parts/header', $data);
		echo getView('dashboard/parts/saveform');
		echo getView('dashboard/parts/footer');     
    }
    
        public function delete(){
            if(!$this->privileges->can('admin_pricing_manage')) return redirect()->back();
            
            if ($this->request->getMethod() == 'post') {  
            $id = $this->request->getPost('id');   
            $model = newModel('PricingModel');
            $model->delete($id);
            }
    		return namedRedirect('admin/pricing');   
    }
    
    protected function dataCommon($data=[]){
       return array_merge(['privileges' => $this->privileges], $data);
    }


	//--------------------------------------------------------------------

}
