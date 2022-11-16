<?php 

class files {

    public function getPage($page=null){

        $file = $this->getFile('config/pages.json'); 
        if(!$file) return $this->view404();

        $pages = json_decode($file,true);

        if($page){  
        $pageData = $this->searchWhere($pages,'url',$page);   
        } else {
        $pageData = $this->searchWhere($pages,'index','0');   
        } 
        
        $settings = json_decode($this->getFile('config/settings.json'),true);
        
        $suffix = (isset($settings['website']['title-suffix']) && $settings['website']['title-suffix'] == 1) ? ' - '.$settings['website']['name'] : '';
		
		$data = [
       'key' => $pageData[0],
       'content' => $pageData[1]['content'],
       ];
       
       $meta = ['title','description','keywords','altlang'];
       foreach($meta as $key){
            $data['meta'][$key] = isset($pageData[1][$key]) ? $pageData[1][$key] : null;
       }
       $data['meta']['title'] .= $suffix;
       
       
		return $data;
    }
    
     public function getStatus(){

        $file = $this->getFile('config/expire'); 
        if(!$file) return false;
        $data = explode(',',$file);
        if($data[1] == '0'){
          echo 'blocked';
          return false;
        } 
        
        if($data[0] < time()){
          echo 'expired';
          return false;
        }
      return true;  
        
    }
    
    public function processForm($formid){
        if(empty($_POST)) return false;
        $settings = json_decode($this->getFile('config/settings.json'),true);
        if(!isset($settings['forms'][$formid]['mail'])) return ['status'=>0,'message'=>$form['fail']];
        
        $form = $settings['forms'][$formid];
        $message = '';
        $headers = 'From: mailer@'.$_SERVER['HTTP_HOST'] . "\r\n".
        "Content-Type: text/html;charset=utf-8\r\n";

        foreach($_POST as $k=>$v){
            $message .= '<p><b>'.htmlspecialchars($k, ENT_QUOTES).':</b> '.htmlspecialchars($v, ENT_QUOTES).'</p>';  
        }
        
        if(mail(trim($form['mail']), $form['subject'], $message, $headers)){
            return ['status'=>1,'message'=>$form['success']];
        } else {
            return ['status'=>0,'message'=>$form['fail']];
        }
        
        
    }
	
	protected function searchWhere($array,$key,$value){
        foreach($array as $k=>$v){
        if($v[$key] == $value){
        return [$k,$v];
          break; 
         } 
        }
      return false;     
    }
	
	public function isFile($path){
      if(!is_file($path)) return false; 
      return true;
       
    }	
	
	public function getFile($path){
      $path = dirname(__DIR__).'/'.$path;
     if(!$this->isFile($path))
     return false;
     
     return file_get_contents($path);  
    }
	
	public function view404(){
	echo '404';
	}
	public function view($view,$data){	
	extract($data);	
	include dirname(__DIR__).'/'.$view.'.php';	
	}
	

}
