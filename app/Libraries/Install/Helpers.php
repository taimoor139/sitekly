<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries\Install;

class Helpers {

    public function setBase($dir, $search=null, $replace=null){
 
        // If source is not a directory stop processing
        if(!is_dir($dir)) return false;
    
        // Open the source directory to read in files
        $i = new \DirectoryIterator($dir);
        foreach($i as $f) {
            if($f->isFile()) {
                if($search && in_array($f->getExtension(),['json','html','css'] )){
                    
                   $content = str_replace($search,$replace,file_get_contents($f->getRealPath()));
                   file_put_contents($f->getRealPath(),$content);

                }
  
            } else if(!$f->isDot() && $f->isDir()) {
                 
                $this->setBase($f->getRealPath(), $search, $replace);
            }
        }
        return true;
    }
    
    protected function deleteDirectory($path) {
        if (!file_exists($path)) {
            return true;
        }
    
        if (!is_dir($path)) {
            return unlink($path);
        }
    
        foreach (scandir($path) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!$this->deleteDirectory($path . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
    
        }

          return rmdir($path);  
    }
    
    public function siteURL($subdomain = null)
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'];
        if($subdomain) 
            return $protocol.$subdomain.'.'.$domainName;
        return $protocol.$domainName.'/';
    }
    
    public function check($post){
    $email = !empty($post['newsletter']) ? $post['newsletter'] : '';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"https://sitekly.com/icheck");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 
              http_build_query(array('l' => $post['license'],'e'=>$email,'d'=>$_SERVER['HTTP_HOST'])));
    curl_setopt($ch, CURLOPT_VERBOSE, true);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $server_output = curl_exec($ch);
    curl_close ($ch);
    
    $r = json_decode($server_output,true);

    return $r;
    }
    
    public function db($post){
      $custom = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => '',
        'password' => '',
        'database' => '',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
      ];
     $post['password'] = $post['dbpassword'];
      
      $custom = array_merge($custom,$post);
      $db = \Config\Database::connect($custom);
      try{
      $db->initialize();
      } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e)
      {
         return($e->getMessage());
      }

      $sql = $this->getFile('app/Libraries/Install/templates/base.sql');
      $sql = explode(';',$sql);
      $sql = array_filter($sql);
      
             foreach($sql as $query){
                 try
                {
                    $db->query($query);
                }
                catch (\Exception $e)
                {
                    return $e->getMessage();
                }
           }   
       return true; 
    }

    
    public function panel($config){
        helper('text');
        $panel = newLib('Panels/'.$config['type']);  
        $config['port'] = $config['port_reseller'];
        $panel->connect($config); 
        $domain = 'test'.random_string('numeric', 5).'.'.trim(explode(',',$config['domains'])[0]);

       $data = [
        'username'=>'try'.random_string('numeric', 5),
        'password'=>random_string('alnum', 14).'11',
        'email'=>'any@any.comfake',
        'domain' =>$domain
       ];
       
              $data['query'] = $panel->addUser($data); 

       if(isset($data['query']['error']) && $data['query']['error'] == 1 || !isset($data['query']['text']) && $config['type'] == 'DirectAdmin'){
        return $data;
       }

       $data['query'] = $panel->deleteUser($data);
       if(isset($data['query']['error']) && $data['query']['error'] == 1 || !isset($data['query']['text']) && $config['type'] == 'DirectAdmin'){
        return $data;
       } 
 
       return true;
        
    }
    
    public function media($config){ 
        $this->client = \Config\Services::curlrequest();
            $data = [
                'secret'=>'{media-secret}',
                'action'=>'install',
                'replace'=>$config
            ];
        
            try
            {
                 $request = $this->client->request('POST', $config['base'].'/manager.php',['form_params' => $data,'http_errors' => false]);
            }
            catch (\Exception $e)
            {
                return ['error'=>$e->getMessage()];
            } 

            return json_decode($request->getBody(),true);  
    }
    
    public function setConfig($session){
       $config = $this->getFile('app/Libraries/Install/templates/config');
       if(!$config) return false;

       $data = [];
       
        for($i=1;$i<9;$i++){
                $ts = $session->get('s'.$i);
                $data[$i] = $ts;
                foreach($ts as $k=>$step){
                    $data['all'][$k] = $step;
                }
        }
        $props = ['siteName','license','base','media-secret','previewDomain','fontsKey','currency','techulusKey','techulusSecret','screenly','providerTemplate','providerSite','licenseError','siteLimit','email'];
        
        foreach( $props as $k){
                $config = str_replace('{'.$k.'}',$data['all'][$k],$config);
             }
        
       $rKeys = ['type','ip','login','password','publicPath','webmail','domains','nameServers','port_user','port_reseller','package','secret'];
       $rarr = $this->setArray($data[3], $rKeys);
       $config = str_replace("'{reseller}'",$rarr,$config);  
       
       $mkeys = ['display','SMTPHost','SMTPUser','SMTPPass','SMTPPort','SMTPCrypto'];  
       $rarr = $this->setArray($data[8], $mkeys); 
       $config = str_replace("'{mailconfig}',",$rarr,$config);  
       
       $pconfig = $data[5];
       if(isset($pconfig['dpid'])){
        $parray = "'dp'=>['label'=>'Dotpay','id'=>'".$pconfig['dpid']."','pin'=>'".$pconfig['dppin']."'],\n";
       } else {
        $parray = "//'dp'=>['label'=>'Dotpay','id'=>'','pin'=>''],\n";
       }
       if(isset($pconfig['pp'])){
        $parray .= "    'pp'=>['label'=>'PayPal','id'=>'".$pconfig['pp']."']\n";
       } else {
        $parray .= "    //'pp'=>['label'=>'PayPal','id'=>'']\n";
       } 
       $config = str_replace("{paymentMethods}",$parray,$config);  
    
      if(!$this->setFile('app/Config/MasterConfig.php',$config)) return false;
       

      $oldBase = 'http://domain_placeholder';
      $newBase = $data[4]['base'];
      $search = [$oldBase,str_replace('/','\/',$oldBase)];
      $replace = [$newBase,str_replace('/','\/',$newBase)];
      $this->setBase(WRITEPATH.'templates/',$search,$replace);
      $this->deleteDirectory(ROOTPATH.'app/Controllers/Install');
      
      $r = $session->get('check');
       if(isset($r['allowed'])){ 
            $sModel = newModel('SettingsModel');
            $sModel->setOption(
            'package',['public_key'=>$r['public_key'],'limit'=>$r['allowed'],'updates'=>$r['updates'],
            'newest'=>$r['current_version'],'white'=>$r['white'],'package'=>$r['package'],'lang'=>$r['lang']]
            ); 
                                            
            $sModel->setOption('license',['status'=>'ok']);       
        }
      
      return true;
    }
    
    protected function setArray($post,$keys){
        $data = '';
       foreach($keys as $k){
        $val = isset($post[$k]) ? $post[$k] : '';
        $data .= "     '".$k."'=>'".$val."',\n";
       }
       return $data;
    }

    
    public function getFile($path){
     $path = ROOTPATH.$path;  
     if(!$this->isFile($path))
     return false;
     
     return file_get_contents($path);  
    }
    public function setFile($path,$content){
     $path = ROOTPATH.$path;    
     $file = fopen($path, "w");
     if(!$file) return false;
     fwrite($file, $content);
     fclose($file);
     return true;
    }
    
    public function isFile($path){
      if(!is_file($path)) return false; 
      return true;
       
    }

}
