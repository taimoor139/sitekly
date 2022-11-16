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

class Dashboard extends BaseController 
{
    public function index($id=null){
        
        $auth = newLib('Auth');
        if($id &&!$auth->isDesigner()) return namedRedirect('dashboard');
        
        if($id) return $this->loginAsUser($id);
        
        $data = $this->commonData();
        
		$model = newModel('SiteModel');
        $rows = $model->getMySites();
        $pricingModel = newModel('PricingModel');
        
        $data['pricing'] = $pricingModel->getAll();
        $data['rows'] = $model->SitesData($rows);
        
        if($this->session->get('demoUser') && !cache('demoCleanup')){ 
            if($this->demoCleanup()) return namedRedirect('dashboard');
        }
        
        $data['modals'][] = ['id'=>'delete','body'=>lang('app.sure-del-site')];
        $data['modals'][] = ['id'=>'cancel','body'=>lang('app.sure-cancel-subscription')];
           
        echo getView('dashboard/parts/header', $data);
		echo getView('dashboard/dashboard');
        echo getView('dashboard/parts/modalConfirm');
		echo getView('dashboard/parts/footer'); 
        
    }
    
    public function contact(){
       $data = $this->commonData();
        

        helper(['form']);
         $data['formid'] = 'domain_manage';
         $data['rules'] = [
                'message' => [
                'rules'=>'required|string',
                'label'=>lang('app.your-message'),
                'type'=>'textarea',
                'size'=>'12',
                ],

			];
            
        if($this->request->getPost('message')){
            if (! $this->validate($data['rules'])) {
				$rd['errors'] = $this->validator->listErrors();
			} else {
			 
                $config = config('MasterConfig');
        
                $message = '';
                
                $_POST['user'] = $this->session->get('user_username');
                $_POST['email'] = $this->session->get('user_email');
        
                foreach($_POST as $k=>$v){
                    $message .= '<p><b>'.htmlspecialchars($k, ENT_QUOTES).':</b> '.htmlspecialchars($v, ENT_QUOTES).'</p>';  
                }

                $mailData = [
                'sendTo' => $config->notify['contact_email'],
                'subject' => 'Help request',
                'message'=> $message
                ];
                
                $mails = newLib('Mails');
                
                if($mails->send($mailData)){
                      $this->session->setFlashdata('success', lang('app.mail-form-success'));   
                } else {
                      $this->session->setFlashdata('fail', lang('app.mail-form-fail'));   
                }
        
                return namedRedirect('dashboard');
            }
        }    
        
        $data['back'] = ['label'=>lang('app.back'), 'path'=>'/dashboard'];
        $data['title'] = lang('app.how-can-we-help'); 
        $data['button'] = lang('app.send'); 
        
        echo getView('dashboard/parts/header', $data);
		echo getView('dashboard/parts/saveform');
		echo getView('dashboard/parts/footer');  
 
    }
        public function users($id=null){
           
           if($id){
               return $this->index($id); 
            }
            
          if($this->session->get('designer_mode')){
    	   foreach($this->session->get('designer_mode') as $key=>$val){
    	     $this->session->set($key,$val);  
    	   }
           $this->session->remove('designer_mode');
           return namedRedirect('dashboard/users');
    	}  
            
            
          $auth = newLib('Auth');
          if(!$auth->isDesigner()){
             return namedRedirect('dashboard');
          }
      
        $this->session->set('designerHide',true);
        
        $data = $this->commonData();
        
        helper(['form']);
        
        $UserModel = newModel('UserModel');
        $UserModel->join('Sites', 'Sites.user = Users.id', 'LEFT');
        $UserModel->select('Users.*');
        $UserModel->selectCount('Sites.id','sitesCount')->groupBy('Users.id');
        
        if ($this->request->getMethod() == 'post') {
          $UserModel->like('username',$this->request->getPost('search'),'both')->orLike('email',$this->request->getPost('search'),'both');
        }
        $UserModel->where('rid',session()->get('user_id'));
        
        $data['rows'] = $UserModel->orderBy('Users.id','asc')->paginate(20);
        $data['pager'] = $UserModel->pager;
        
        $data['search'] = getView('dashboard/parts/search');
        $data['modal'] = ['id'=>'delete','body'=>lang('app.del-user-and-sites')];
      
        echo getView('dashboard/parts/header', $data);
		echo getView('dashboard/designer');
        echo getView('dashboard/parts/footer');
        
    }
    
        protected function loginAsUser($id){
        
        $model = newModel('UserModel');
        $user = $model->isMyClient($id); 
        if(!$user){
        $this->session->setFlashdata('fail', 'User not found');
		return namedRedirect('dashboard/users');
        }
        
        $params = ['user_id', 'user_username','user_status','user_role','user_email'];
        $uData = ['designer_mode'=>[]];
        
        foreach($params as $param){
            $uData[$param] = $user[str_replace("user_","",$param)];
            $uData['designer_mode'][$param] = $this->session->get($param);
        }
        $uData['user_role'] = $uData['designer_mode']['user_role'];
        $uData['designer_mode']['user_display_name'] = $this->session->get('user_display_name');
        $uData['user_display_name'] = $user['username'];
        

		$this->session->set($uData);
        $this->session->remove('designerHide');
        return namedRedirect('dashboard');
    }
    
    public function payment(){

        if($this->request->getGet('status')){
            if($this->request->getGet('status') == 'OK'){
              $this->session->setFlashdata('success', lang('app.update-success'));   
            } else {
              $this->session->setFlashdata('fail', lang('app.update-fail'));   
            }
            return namedRedirect('dashboard');     
            
        }
        
        $data = $this->commonData();
        
        $config = config('MasterConfig');
        $siteModel = newModel('SiteModel');
        $data['site'] = $siteModel->getMySite($this->request->getGetPost('site'));
        if(!$data['site']) return namedRedirect('dashboard');
        $sitePackage = $data['site']['package'];
        
        $this->privileges->extendByPackage($sitePackage);
        if(!$this->privileges->can('subscription_manage')) return namedRedirect('dashboard');
        
        $pricingModel = newModel('PricingModel');
        $data['pricing'] = $pricingModel->getAll();
        
        $hiddenPackages = isset($config->trialConfig['settings']['hiddenPackages']) ? $config->trialConfig['settings']['hiddenPackages'] : [1];
        foreach($hiddenPackages as $hidden){
          unset($data['pricing'][$hidden]);     
        }
            

        $paymentsLib = newLib('Payments');
        
        if($this->request->getPost('action') == 'cancel'){
            $result = $paymentsLib->cancelSub($data['site']);
            if($result['success']){
              $this->session->setFlashdata('success', $result['message']);
              $siteModel->save(['id'=>$data['site']['id'],'subscription'=>'']);   
            } else if($result['message']){
              $this->session->setFlashdata('fail', $result['message']);   
            } else {
               $this->session->setFlashdata('fail', lang('app.update-fail'));    
            }
            return namedRedirect('dashboard'); 
        }
        
        
        $data['paymentMethods'] = $paymentsLib->enabledMethods;
        $data['initMethods'] = $paymentsLib->initMethods();
        $data['currency'] = $paymentsLib->paymentConfig['currency'];
        
        if($sitePackage == 1 || $data['pricing'][$sitePackage]['price_monthly_month'] == 0 || $data['pricing'][$sitePackage]['price_monthly_year'] == 0){
          $data['showPackages'] = true;  
        } else{
          $data['showPackages'] = false;  
          $data['currentPackage'] = $data['pricing'][$data['site']['package']];
        }
        
        $data['rules'] = [
                'site' => [
                'rules'=>'required',
                ],
                'period' => [
                'rules'=>'required|in_list[1,12]',
                'label'=>lang('app.period'),
                ],
                'package' => [
                'rules'=>'required|in_list['.implode(',',array_keys($data['pricing'])).']',
                'label'=>lang('app.package'),
                ],
                'method' => [
                'rules'=>'required|in_list['.implode(',',array_keys($data['paymentMethods'])).']',
                'label'=>lang('app.active'),
                ]
			];
        
        if($this->request->getPost('step')){
            $rd = [];
            $package = $data['showPackages'] ? $this->request->getPost('package') : $sitePackage;
            
            if(!$data['showPackages'] && $this->request->getPost('package') != $sitePackage){
                if(!$this->privileges->can('package_change')) return false;
                return $this->changePackage($data);
            }
            
            
            $count = $siteModel->countByPackage($package);
            
            if (! $this->validate($data['rules'])) {
				$rd['errors'] = $this->validator->listErrors();
			} else if($data['pricing'][$package]['site_limit'] != '-1' && $count >= $data['pricing'][$package]['site_limit']){
			     $this->validator->setError('package',lang('app.site-count-limit',['limit'=>$data['pricing'][$package]['site_limit']]));  
                  $rd['errors'] = $this->validator->listErrors();
			}else{
            $formPeriod = $this->request->getPost('period');
            if(!isset( $data['pricing'][$package]['pricing'][$formPeriod] )){
                $formPeriod = array_key_first($data['pricing'][$package]['pricing']);
            }
            

            $rd['inp']['amount'] = $data['pricing'][$package]['pricing'][$formPeriod]['total'];
            $rd['inp']['currency'] = $data['currency']; 
            
            $rd['success'] = true;
                if($this->request->getPost('step') == '2'){
                    
                   helper('text');
                   $paymentModel = newModel('PaymentModel'); 
                   $control = random_string('alnum', 32);
                   $method = $this->request->getPost('method');
                  
                   $sdata = [
                   'site' => $data['site']['id'],
                   'amount' => $rd['inp']['amount'],
                   'currency'=> $data['currency'],
                   'control' => $control,
                   'package' => $package,
                   'time' => $formPeriod,
                   'method'=> $method,
                   'created_at'=>time()
                   ];
                   $paymentModel->save($sdata); 
                   
                   if($rd['inp']['amount'] == 0){
                    
                    $sdata = [
                    'site'=> $data['site']['id'],
                    'package'=>$package,
                    'time'=>$formPeriod 
                    ];

                    $status = newLib('siteStatus');
                    $status->updateStatus($sdata,true);

                    $rd = ['redirect'=>namedRoute('dashboard')];  
                    return $this->response->setJSON($rd);  
                   }
                   
                   $rd['form'] = $paymentsLib->generateForm($sdata);

                }
             } 
            $rd['token'] = ['name'=>csrf_token(),'value'=>csrf_hash()];
            
            return $this->response->setJSON($rd);
        } else {

        echo getView('dashboard/parts/header', $data);
		echo getView('dashboard/payment');
		echo getView('dashboard/parts/footer'); 
       } 
  
    }
      protected function changePackage($data){
      
      $notify = false; //send email notification
      $autoChange = true; //recalculating remaining time proportionally based on monthly pricing
      
      if($notify){
          $message = 'Current package: '.$data['site']['package'].'<br>'
          .'Requested package: '.$this->request->getPost('package')
          .'<br><a href ="'.namedRoute('admin/sites/edit/'.$data['site']['id']).'">Edit site</a>';
    
            $mails = newLib('Mails');
            $config = config('MasterConfig');
            $this->request->getPost();
            $mailData = [
            'sendTo' => $config->notify['email'],
            'subject' => lang('app.package-change-request'),
            'message'=>$message
            ];
            
            $mails->send($mailData);
        $this->session->setFlashdata('success', lang('app.request-process-soon'));
   }
   
   if($autoChange){ 
            $pricingModel = newModel('PricingModel');
            $pricing = $pricingModel->getAll();
            $currentPackage = $pricing[$data['site']['package']];
            $newPackage = $pricing[$this->request->getPost('package')];
            if($newPackage['price_monthly_month'] == 0 || $newPackage['price_monthly_year'] == 0){
                $this->session->setFlashdata('info', lang('app.change-package-after-expire'));
                $rd = ['redirect'=>namedRoute('dashboard')];  
                return $this->response->setJSON($rd);
            }
            
            $column = false;
            if($newPackage['price_monthly_month'] != -1 && $currentPackage['price_monthly_month'] != -1){
                $column = 'price_monthly_month';
            }
            if(!$column && $newPackage['price_monthly_year'] != -1 && $currentPackage['price_monthly_year'] != -1){
                $column = 'price_monthly_year';
            }
            
            if(!$column){
                $this->session->setFlashdata('info', lang('app.change-package-not-possible'));
                $rd = ['redirect'=>namedRoute('dashboard')];  
                return $this->response->setJSON($rd);  
            }
            
            $timeLeft = $data['site']['expire'] - time();
            $ratio = $currentPackage[$column] / $newPackage[$column];
            $newTime = $timeLeft * $ratio + time();
            
            $package = $newPackage['id'];
            
            if($timeLeft <= 0){
            $newTime = $data['site']['expire'];
            }
            
           $paymentModel = newModel('PaymentModel'); 
           $sdata = [
               'site' => $data['site']['id'],
               'transaction' => 'previous: '.$data['site']['package'].', ratio: '.$ratio,
               'control' => time().$data['site']['id'],
               'package' => $package,
               'method'=> 'change',
               'created_at'=>time()
           ];
           $paymentModel->save($sdata); 
            
            
            $sdata = [
            'site'=> $data['site']['id'],
            'package'=>$package,
            'time'=> $newTime
            ];
            
            $status = newLib('siteStatus');
            $status->updateStatus($sdata,false,$newTime);
            $this->session->setFlashdata('success', lang('app.package-changed'));
            $this->session->setFlashdata('info', 'Demo note: package change can be handled manually with email notification or recalculated automatically.');
    }  
      
    
       
       $rd = ['redirect'=>namedRoute('dashboard')];  
       return $this->response->setJSON($rd);    
       
    }
        public function delete($siteId=null){
            
        $siteId = $this->request->getPost('site') ? $this->request->getPost('site') : $siteId;
         
         $model = newModel('SiteModel');
         $site = $model->getMySite($siteId);
         if(!$site) return $this->session->setFlashdata('fail', lang('app.delete-fail')); 
         
         $this->privileges->extendByPackage($site['package']);
        if(!$this->privileges->can('site_delete')) return redirect()->back();

        $model->delete($site['id']);
        
        $MailboxModel = newModel('MailboxModel');
        $MailboxModel->where('site',$site['id'])->delete();
         
        $FileManager = newLib('FileManager');
        $FileManager->deleteDirectory($FileManager->projectsRoot.$site['directory']);
        $FileManager->deleteFile($FileManager->projectThumbsRoot.$site['directory'].'.jpg');
        
        $MediaManager = newLib('MediaManager');
        $MediaManager->connect($site['media']);
        $MediaManager->deleteDirectory($site['directory']);
        
        if(!empty($site['panel_password'])) {
        $controlPanel = newLib('Controlpanel');
        $controlPanel->connectReseller($site['panel_reseller']);
        $query = $controlPanel->query('deleteUser',['username'=>$site['panel_login']]);
        }
        
         $this->session->setFlashdata('success', lang('app.delete-success'));
        
		return namedRedirect('dashboard');      
    }
    
      
      public function export(){

         $siteId = $this->request->getGet('site');
         
         $model = newModel('SiteModel');
         $site = $model->getMySite($siteId);
         if(!$site) return $this->session->setFlashdata('fail', lang('app.delete-fail')); 
         
         $this->privileges->extendByPackage($site['package']);
         if(!$this->privileges->can('site_export')) return redirect()->back();
         
         $directories = [WRITEPATH.'projects/'.$site['directory'], WRITEPATH.'usersiteFiles'];
         
        $this->FileManager = newLib('FileManager');
        $this->FileManager->setPath('project',$site['directory']);
        $fonts = $this->FileManager->getFonts();
        
         $zip = new \ZipArchive;
         $zipFile = WRITEPATH.'exports/'.$site['id'].'.zip';
        if(!$zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)){
            $this->session->setFlashdata('fail', 'Export failed');
		      return namedRedirect('dashboard');  
        }
        
        $skip = ['config/allmenus.html','config/fonts.json','config/globals.json','config/styles.json'];
        
        foreach($directories as $directory){
           $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($directory),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );

        foreach ($files as $name => $file)
            {
                // Skip directories (they would be added automatically)
                if (!$file->isDir())
                {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($directory) + 1);
                    
                    if(in_array($relativePath,$skip)) continue;
                    if($relativePath == 'layout.php'){
                        $content = file_get_contents($filePath);
                        $content = str_replace('{fonts-replace}',$fonts,$content);
                        $content = str_replace('{base-replace}',base_url(),$content);
                        $zip->addFromString($relativePath, $content);
                        
                    } else {
                       $zip->addFile($filePath, $relativePath); 
                    }
                      
         
                }
            }
        
        }
        $zip->addFromString('config/expire', $site['expire'].','.$site['status']);
        $zip->close();
        
        header('Content-disposition: attachment; filename='.$site['name'].'.zip');
        header('Content-type: application/zip');
        readfile($zipFile);     
    }
    
    public function domain(){

        $data = $this->commonData();
        
        $siteModel = newModel('SiteModel');
        $data['site'] = $siteModel->getMySite($this->request->getPost('site'));
        if(!$data['site']) return namedRedirect('dashboard');
        
        $this->privileges->extendByPackage($data['site']['package']);
         if(!$this->privileges->can('domain_manage')) return redirect()->back();
         
         $upgradeLink = ' <a href="'.namedRoute('dashboard/payment').'?site='.$data['site']['id'].'">'.lang('app.upgrade').'</a>';
        

        $auth = newLib('Auth');
        if($auth->isAutoUser()){
             return $this->autoDomain();
        }

        
        $config = config('MasterConfig');
        $resellers = $config->resellers;
        $resellers = array_filter($config->resellers, function($reseller) {
            return !isset($reseller['mode']);
        });
        
        $servers = array_filter(array_combine(array_keys($resellers), array_column($resellers, 'label')));

        

        
        
        if(!empty($data['site']['panel_reseller'])){
         $domainList = explode(',',$resellers[$data['site']['panel_reseller']]['domains']);
        } else {
           $domainList = []; 
           foreach($resellers as $reseller){
            if(empty($reseller['domains'])) continue;
            $domainList = array_merge($domainList,explode(',',$reseller['domains'])); 
           }
           $domainList = array_unique($domainList);
        }
        
        $pricingModel = newModel('PricingModel');
        $data['pricing'] = $pricingModel->where('id',$data['site']['package'])->first();

        if($data['pricing']['domain'] == 0 && $data['pricing']['subdomain'] == 0){
           $this->session->setFlashdata('fail', lang('app.package-not-allowed').$upgradeLink);  
           return redirect()->back(); 
        }
        
        
        $domainType = 'free';
        if($data['site']['domain']){
            foreach($domainList as $domainPossible){
                $len = strlen( $domainPossible )+ 1;
                if(substr( $data['site']['domain'], - $len ) === '.'.$domainPossible){
                   $data['row']['name'] = substr( $data['site']['domain'], 0,-$len );
                   $data['row']['domain'] = $domainPossible;
                   break;
                }  
            }
            if(!isset($data['row']['name'])){
                $data['row']['customdomain'] = $data['site']['domain'];
                $domainType = 'custom';
            }
            
            
        }
        
        helper(['form']);
         $data['formid'] = 'domain_manage';
         $data['rules'] = [
                'site' => [
                'rules'=>'required|integer',
                'type'=>'hidden'
                ],
                'type' => [
                'rules'=>'required|string',
                'label'=>lang('app.domain-type'),
                'type'=>'radio',
                'options'=>['free'=>lang('app.use-free-domain'),'custom'=>lang('app.use-custom-domain')],
                'checked'=>$domainType,
                'size'=>'12'
                ],
				'name' => [
                'rules'=>'required|alpha_numeric|min_length[3]|max_length[100]',
                'label'=>lang('app.name'),
                'size'=>'6'
                ],
                'domain' => [
                'rules'=>'required|string|max_length[100]|in_list['.implode(',',$domainList).']',
                'label'=>lang('app.domain'),
                'type'=>'select',
                'options'=>array_combine($domainList, $domainList),
                'size'=>'6'
                ],
                'customdomain' => [
                'rules'=>'required|string|min_length[3]|max_length[200]',
                'label'=>lang('app.custom-domain'),
                'size'=>'6'
                ],
                
                'server' => [
                'rules'=>'required|string|max_length[100]|in_list['.implode(',',array_keys($servers)).']',
                'label'=>lang('app.server'),
                'type'=>'select',
                'options'=>$servers,
                'size'=>'6'
                ],
			];
            
            
            $selectedType = $this->request->getPost('type');

            if( sizeof($domainList) == 0 ){
                $selectedType = 'custom';
                unset($data['rules']['type']);
            }    
            
            
            
            if(!empty($data['site']['panel_reseller'])){
             unset($data['rules']['server']); 
             $data['rules']['customdomain']['size'] = 12;  
            }

            if ($selectedType == 'custom' || $domainType == 'custom' && !$selectedType) {
                unset($data['rules']['name'],$data['rules']['domain']);  
              } else {
                unset($data['rules']['customdomain'],$data['rules']['server']); 
              }
        
        
             if($this->checkLimit($data,$siteModel)){
                $this->session->setFlashdata('fail', lang('app.verfail')); 
                return redirect()->back();
             }
        

        
         if($data['pricing']['domain'] == 0 && $selectedType == 'custom') {
                unset($data['rules']['customdomain'],$data['rules']['server']);
                $this->validate($data['rules']);
                $this->validator->setError('type',lang('app.package-not-allowed').$upgradeLink); 
                $this->validator->customView = 'list-raw'; 
                $data['validation'] = $this->validator; 
         }   

        else if (!empty($this->request->getPost('name')) || !empty($this->request->getPost('customdomain'))) { 
            if (! $this->validate($data['rules'])) {
				$data['validation'] = $this->validator;
			}else{
			 
                if(isset($data['rules']['customdomain'])){
                    $domain = strtolower($this->request->getPost('customdomain'));
                    
                } else{
                    $domain = strtolower($this->request->getPost('name').'.'.$this->request->getPost('domain'));
                    $available = [];
                    foreach($resellers as $key=>$reseller){
                        $domains = explode(',',$reseller['domains']);
                       if(in_array($this->request->getPost('domain'),$domains)){
                        $available[] = $key;
                       } 
                    }
                    
                    $randomserver = $available[array_rand($available,1)]; 
                }
                
                if((!empty($data['site']['panel_reseller']))){
                   $rid = $data['site']['panel_reseller'];   
                } else if(isset($randomserver)){
                    $rid = $randomserver;
                } else {
                   $rid = $this->request->getPost('server');
                }

             
                if($data['site']['domain'] == $domain) return namedRedirect('dashboard');  
                
 
                $controlPanel = newLib('Controlpanel');

                $update = $controlPanel->updateSite($data['site']['id'],['domain'=>$domain],$rid);
               
                if($update){
                  $this->session->setFlashdata('success', lang('app.update-success'));
                  if(isset($data['rules']['customdomain'])){
                  $this->session->setFlashdata('info', lang('app.use_this_nameservers').' '.$resellers[$rid]['nameServers']);
                  };

                  return namedRedirect('dashboard');  
                } else {
                  $this->validator->setError('customdomain',lang('app.domain-exist-or-wrong'));  
                  $data['validation'] = $this->validator; 
                }

                
             }

        }

        
        $data['back'] = ['label'=>lang('app.back'), 'path'=>'/dashboard'];
        $data['title'] = lang('app.domain-settings'); 
        
        echo getView('dashboard/parts/header', $data);
		echo getView('dashboard/parts/saveform');
		echo getView('dashboard/parts/footer');  
 
    }
    
    protected function autoDomain($uid=null){
        
        $data = $this->commonData();
        
        $siteModel = newModel('SiteModel');
        $uid = $uid ? $uid : $this->session->get('user_id');
         
        $data['row'] = $siteModel->getMySite($this->request->getPost('site'));
        if(!$data['row']) return namedRedirect('dashboard');
        
        
        $autoHost = newLib('AutoHost');
        $result = $autoHost->listDomains($uid);

        if(is_array($result) && empty($result)){
            $this->session->setFlashdata('fail', lang('app.add-domain-first')); 
            return namedRedirect('dashboard'); 
        }
        if(!$result){
            $this->session->setFlashdata('fail', lang('app.connection-failed')); 
            return namedRedirect('dashboard'); 
        }
        
        
        
        helper(['form']);
        $data['formid'] = 'domain_manage';
        
         $data['rules'] = [
                'site' => [
                'rules'=>'required|integer',
                'type'=>'hidden'
                ],
                'domain' => [
                'rules'=>'required|in_list['.implode(',',$result).']',
                'label'=>lang('app.domain'),
                'type'=>'select',
                'options'=>array_combine($result, $result),
                'size'=>'12'
                ]
			];
        
        
        if (!empty($this->request->getPost('domain'))) { 
            if (! $this->validate($data['rules'])) {
				$data['validation'] = $this->validator;
			}else{
			     if($data['row']['domain'] == $this->request->getPost('domain')){
			         return namedRedirect('dashboard'); 
			     }
                 
                 if($siteModel->where(['domain'=>$this->request->getPost('domain')])->first()){
                    $this->session->setFlashdata('fail', lang('app.domain-in-use'));
			         return namedRedirect('dashboard'); 
			     }
			    
               if(!$autoHost->testFtp($uid)){
                 $this->session->setFlashdata('fail', lang('app.ftp-connection-failed')); 
                 return namedRedirect('dashboard'); 
               }

               $newData = ['id'=>$data['row']['id'],'panel_reseller'=>$autoHost->user['hostId'],'panel_login'=>$autoHost->user['login'],'domain'=>$this->request->getPost('domain')];
               $siteModel->save($newData);
               $RemoteFileManager = newLib('RemoteFileManager');
               $RemoteFileManager->init($data['row']['id']);
               $RemoteFileManager->updateSite();
               $RemoteFileManager->setStatus();
               
               $this->session->setFlashdata('success', lang('app.update-success'));
               return namedRedirect('dashboard'); 
             
             }
        }
        
        
        
        $data['back'] = ['label'=>lang('app.back'), 'path'=>'/dashboard'];
        $data['title'] = lang('app.domain-settings'); 
        
        echo getView('dashboard/parts/header', $data);
		echo getView('dashboard/parts/saveform');
		echo getView('dashboard/parts/footer'); 
        
    }
    protected function demoCleanup(){
        $reload = false;
        $model = newModel('SiteModel');
        $config = config('MasterConfig');
        if(!isset($config->demoUser['deleteAfter']) || !$config->demoUser['deleteAfter']) return;
   
        $sites = $model->where('user',$this->session->get('user_id'))->findAll();
        foreach($sites as $site){
            if($site['created_at'] < time() - $config->demoUser['deleteAfter'] * 3600){
                
               $this->delete($site['id']);
                $reload = true;
            }
        }
        
       $this->session->setFlashdata('fail', false); 
       $this->session->setFlashdata('success', false);
       cache()->save('demoCleanup', true, 600);
       return $reload; 
     
    }
    
    protected function checkLimit($data,$siteModel){
           $limit = false;
           
           $used = $siteModel->where(['domain!='=>''])->countAllResults();
           $settingsModel = newModel('SettingsModel');
           $package = $settingsModel->getOption('package',true);
           if(!$package) return;
           $config = config('MasterConfig'); 
           
           if($package['limit'] == '-1'){
                return $limit;
            }
            
           if(empty($data['site']['domain']) && isset($package['limit']) && $used >= $package['limit']){

                $limit = true;
           }
        
        $left = $package['limit'] - $used;
        
        if(!isset($config->notify) || !isset($config->notify['email'])) return $limit;
        $notify = $config->notify;
            
            $left = $left > 0 ? $left : 0;
            if($notify['siteLimit'] && is_array($notify['siteLimit']) && in_array($left,$notify['siteLimit'])){
                $nlog = $settingsModel->getOption('notify',true);
                
                if(!$nlog || $nlog['code'] != 'sl'.$left || $nlog['time'] < time() - 86400){
                   $settingsModel->setOption('notify',['code'=>'sl'.$left,'time'=>time()]);
                   
                   $mlang = [
                      'en'=> ["Site limit notification","Sites possible to be published: "],
                      'pl'=>["Powiadomienie o limicie stron","Pozostała liczba stron do opublikowania: "] 
                   ];  
                   $slang = isset($package['lang']) && isset($mlang[$package['lang']]) ? $mlang[$package['lang']] : $mlang['en'];                 
                    
                   $sdata = [
                    'sendTo'=>$notify['email'],
                    'subject'=>$slang[0],
                    'message'=>$slang[1].$left
                    ];
                    $mailer = newLib('Mails');
                    $mailer->send($sdata);
                }
                
            }

      
        return $limit;    
            
    }
    
    



	//--------------------------------------------------------------------

}
