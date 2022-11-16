<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;


class FileManager {
    public $type;

    
    public $templatesRoot;
    public $projectsRoot;
    public $thumbsRoot;
    
    public $activePath;
    public $previewUrl;
    
    public function __construct(){
        $this->templatesRoot = WRITEPATH.'templates/';
        $this->thumbsRoot = FCPATH.'thumbs/';
        $this->projectThumbsRoot = FCPATH.'pthumbs/';
        $this->projectsRoot = WRITEPATH.'projects/'; 
        $this->viewProject = 'project';
        $this->viewTemplate = 'viewtemplate';     
    }
    
    public function setPath($type,$directory){
      if($type == 'local'){
        $base = $this->projectsRoot;
        $this->previewUrl = config('MasterConfig')->previewDomain.'/'.$this->viewProject.'/'.$directory;
        $this->baseurl = '';
        $this->previewUrl = '';
        $this->type = 'project';
      } else if($type == 'project'){
        $base = $this->projectsRoot;
        $this->previewUrl = config('MasterConfig')->previewDomain.'/'.$this->viewProject.'/'.$directory;
        $this->baseurl = config('MasterConfig')->previewDomain;
        $this->type = 'project';
      } else{
        $base = $this->templatesRoot;
        $this->previewUrl = ($type == 'template') ? base_url($this->viewTemplate.'/'.$directory) : base_url();
        $this->baseurl = base_url();
        $this->type = ($type == 'template') ? 'template' : 'builder';
      }
      if(is_dir($base.$directory)) {
        $this->activePath = $base.$directory.'/';
        return true;
      }
      return false;
    }

    
     public function cloneSiteFiles($src, $dest, $search=null, $replace=null,$type=null){

        // If source is not a directory stop processing
        if(!is_dir($src)) return false;
        // If the destination directory does not exist create it
        if(!is_dir($dest)) { 
            
            if($search && $type == 'site' && basename($dest) == 'themeconfig'){
              return false;  
            }
            
            if($search && $type == 'site' && basename($dest) == 'draft'){
              return false;  
            }

            if(!mkdir($dest)) {
                // If the destination directory could not be created stop processing
                return false;
            }    
        }
    
        // Open the source directory to read in files
        $i = new \DirectoryIterator($src);
        foreach($i as $f) {
            if($f->isFile()) {
                if($search && in_array($f->getExtension(),['json','html','css'] )){
                    
                   $content = str_replace($search,$replace,file_get_contents($f->getRealPath()));
                   file_put_contents("$dest/" . $f->getFilename(),$content);

                } else {
                    copy($f->getRealPath(), "$dest/" . $f->getFilename());
                }
  
            } else if(!$f->isDot() && $f->isDir()) {
                 
                $this->cloneSiteFiles($f->getRealPath(), "$dest/$f", $search, $replace,$type);
            }
        }
        return true;
    }
    
    
      public function deleteDirectory($path) {
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
    
    public function deleteFile($path){
        if(is_file($path)){
            unlink($path);
        }
    }
    
     public function getFileContent($path){
     if(!$this->isFile($path))
     return false;
     
     return file_get_contents($this->activePath.$path);  
    }
    
    public function setFileContent($path,$content){
     $file = fopen($this->activePath.$path, "w");
     if(!$file) return false;
     fwrite($file, $content);
     fclose($file);
     return true;
    }
    
   public function isFile($path){
      if(!is_file($this->activePath.$path)) return false; 
      return true;
       
    }
   
   public function fileData($path){
            $filepath = $this->activePath.$path;
        $data = [];
        $data['timestamp'] = filemtime($filepath);
        $data['date'] = gmdate('D, d M Y H:i:s', $data['timestamp']);
        $data['last_date'] = getenv('HTTP_IF_MODIFIED_SINCE');
        $data['last_timestamp'] = strtotime($data['last_date']);
        $data['changed'] = ($data['timestamp'] == $data['last_timestamp']) ? false : true;
        return $data;
    }
 
 
 public function searchWhere($array,$key,$value){
        foreach($array as $k=>$v){
            
        if($v[$key] == $value){
        
        return [$k,$v];
          break; 
         } 
        }
      return false;     
    }
    
  public function getPage($page=null){
            $files = [
        'project'=>'config/pages.json',
        'template'=>'themeconfig/data/pages.json',
        'builder'=>'themeconfig/data/dynamicpages.json'
        ];

        $file = $this->getFileContent($files[$this->type]); 
        if(!$file) return dlog($files[$this->type].' not found');

        $pages = json_decode($file,true);

        if($page){  
        return $this->searchWhere($pages,'url',$page);   
        } else {
        return  $this->searchWhere($pages,'index','0');   
        } 
  } 
  
  public function getFonts(){
        $files = [
        'project'=>'config/fonts.json',
        'template'=>'themeconfig/data/fonts.json',
        'builder'=>'config/fonts.json'
        ];
        
        $file = $this->getFileContent($files[$this->type]); 
        if(!$file) return dlog($files[$this->type].' not found');

        $fonts = json_decode($file,true);

        $p = "";
        foreach($fonts as $name=>$weights){
            $p .= $name.":";   
            
            foreach($weights as $weight){
            $p .= $weight.",";   
            }
        $p = rtrim($p,',');
        $p .='|';
        }
        $p = rtrim($p,'|');
        
        return '<link href="https://fonts.googleapis.com/css?family='.$p.'&display=swap" rel="stylesheet">'; 

  }  

}

