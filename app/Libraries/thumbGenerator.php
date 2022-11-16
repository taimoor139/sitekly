<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;
class thumbGenerator {
    
    public $blockId = 'blocks-p8istsf8y';
    protected $FileManager;
    
   protected function techulus($url,$config){
 
        $API_URL = 'https://cdn.capture.techulus.in/';
        // Target URL
        $input_url = urlencode($url).'&full=true&vw=1920&vh=1080';
        $hash = md5($config['secret'] . 'url=' . $input_url);
        
        $url = $API_URL . $config['key'] . '/' . $hash . '/image?url=' . $input_url;
       
        return file_get_contents($url);
        
    }
    
   protected function screenly($url,$config)
    {
        $client = \Config\Services::curlrequest();
        
        try{
        $response = $client->request('POST', 'https://secure.screeenly.com/api/v1/fullsize', [
            'http_errors' => false,
            'timeout'  => 30,
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
            ],
            'form_params' => [
                'key' => $config,
                'url' => $url,
                'width' => 1400
            ],
        ]);
        } catch (\Exception $e)
        {
           //die($e->getMessage());
           return false;
        }
        
        $result = json_decode($response->getBody());

        if(!isset($result->base64_raw)) return false;
        
       return base64_decode( $result->base64_raw);

    }
    
    protected function capture($url,$type){
      $config = config('MasterConfig')->captureApi;
      $provider = $config['provider'][$type];
      if(!isset($config['keys'][$provider])) return false;
      return $this->$provider($url,$config['keys'][$provider]);  
    }
    
    
    
    public function saveHeights($directory,$key,$heights){
      $FileManager = newLib('FileManager'); 
      $FileManager->activePath = $FileManager->thumbsRoot.$directory.'/';
      $realKey = $FileManager->getFileContent('heights.json');
      
      if(empty($realKey) || $realKey != $key) return false;
      $FileManager->setFileContent('heights.json',$heights);
    }
    
    
    protected function cropSections(){
      $FileManager = $this->FileManager; 
      $heights = $FileManager->getFileContent('heights.json');
      $heights = json_decode($heights,true);
      $FileManager->setFileContent('heights.json','');
      
       if(!is_array($heights)) return ['error'=>'heights data missing'];

      $im = imageCreateFromPng($FileManager->activePath.'pages/full/'.$this->blockId.'.png');
      $width = imagesx($im); 
      $y = 0;

      foreach($heights as $k=>$height){ 
          $im2 = imagecrop($im, ['x' => 0, 'y' => $y, 'width' => $width, 'height' => $height]);
    
          imagejpeg($im2, $FileManager->activePath.'sections/full/'.$k.'.png');
          
          $this->resize($im2,600,null,$FileManager->activePath.'sections/600/'.$k.'.png');  
          
          imagedestroy($im2);
          $y += $height;
      }
 
    }
    
    protected function resize($img,$newwidth,$cropheight,$path){
      $width = imagesx($img);
      $height = imagesy($img);
      $newheight = $newwidth/$width * $height;
      $thumb = imagecreatetruecolor($newwidth, $newheight);
      imagecopyresampled($thumb, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
   
      if($cropheight && $newheight > $cropheight){
        $thumb = imagecrop($thumb, ['x' => 0, 'y' => 0, 'width' => $newwidth, 'height' => $cropheight]);
      }
      imagejpeg($thumb, $path, 75);
      imagedestroy($thumb);
    }
    
    
    public function generateThumbs($pages,$sections,$directory){
        
          $FileManager = $this->FileManager = newLib('FileManager'); 
          $FileManager->activePath = $FileManager->thumbsRoot.$directory.'/';
         $FileManager->deleteDirectory($FileManager->activePath);
          $directories = ['','pages','pages/full','pages/600','sections','sections/full','sections/600'];
          foreach($directories as $dir){
          mkdir($FileManager->activePath.$dir); 
          }
    

        
        $pages = json_decode($pages,true);
        
            
          
        foreach($pages as $k=>$page){
            if($k == $this->blockId){
                $hc = md5(time().rand());
                $FileManager->setFileContent('heights.json',$hc);
                $page['url'] .= '?hash-capture='.$hc.'&capture'; 
                
                
            } else{
              $page['url'] .= '?refresh='.time().'&capture';   
            }
    
    
      
           $image = $this->capture(base_url('viewtemplate/'.$directory.'/'.$page['url']),'template');

            if(!$image){
             dlog('unable to get screenshot');
             continue;   
            } 
           $FileManager->setFileContent('pages/full/'.$k.'.png',$image);
           
           $im = imageCreateFromPng($FileManager->activePath.'pages/full/'.$k.'.png');
            
           $this->resize($im,600,null,$FileManager->activePath.'pages/600/'.$k.'.png');  
           if($page['index'] == 0){
            $this->resize($im,400,400,$FileManager->activePath.'ico.jpg');
           }
        
        }
        
        $this->cropSections();
    
 
    }
    
    public function generateMain($directory){
          $previewDomain = config('MasterConfig')->previewDomain;
          $url = $previewDomain.'/project/'.$directory.'?capture&r='.time();
          
          $FileManager = $this->FileManager = newLib('FileManager'); 
          $FileManager->activePath = $FileManager->projectThumbsRoot;
          
          $img = $this->capture($url,'site');
          if($img){
          $this->resize(imagecreatefromstring($img),400,400,$FileManager->activePath.$directory.'.jpg');
          }      
    } 
    

    
    
}
    