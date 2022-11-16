<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

namespace App\Libraries;
class Exports {
        
       public function getExports(){
        
        $language = \Config\Services::language();
        $locale = $language->getLocale();
        
        if ( ! $exports = cache('exports'))
        {
            $model = newModel('TemplateModel');
            $templates = $model->where(['status'=>1,'type'=>'1'])->findAll(); 
            $FileManager = newLib('FileManager');
            $locale = service('request')->getLocale();
    
            $exports = [
            'pages'=>[],
            'sections'=>[],
            'sectionCategories'=>[],
            'pageCategories'=>[]
            ];
            
            foreach ($templates as $t) {
                
                $FileManager->setPath('template',$t['id']);
                
                $files = [
                'pages'=> 'themeconfig/exports/pages.json',
                'sections'=> 'themeconfig/exports/sections.json',            
                'settings'=> 'config/settings.json'
                ];
    
                foreach($files as $file){
                    if(!$FileManager->isFile($file)) continue 2;
                }
               
                
                $pages = json_decode($FileManager->getFileContent($files['pages']), true);
                $settings = json_decode($FileManager->getFileContent($files['settings']), true);
                $exports['themes'][ucfirst($settings['website']['name'])] = [];
                  
                foreach ($pages as $key=>$data) {
                     $exports['pageCategories'][ucfirst($data['title'])] = [];
                     $data = array('id'=>$t['id'],'pageID'=>$key,'themeName2'=>ucfirst($settings['website']['name']),'pageName'=>ucfirst($data['title']));
                     
                     $exports['pages'][] = $data;
                }
                
            
                $sections = json_decode($FileManager->getFileContent($files['sections']), true);
                
                foreach ($sections as $key=>$data) {
                    if(!isset($data['category'])) continue;
    
                $exports['sectionCategories'][ucfirst($data['category'])] = [];
                $data = array('sectionID'=>$key,'sectionCategory'=>ucfirst($data['category']),'id'=>$t['id'],'themeName'=>ucfirst($settings['website']['name']));
                
                $exports['sections'][] = $data;
                     
                }
                
    
            }
            
           
           $SettingsModel = newModel('SettingsModel');
           $exports_lang = $SettingsModel->getOption('exports_lang',true);
           if($exports_lang) {
           $exports = array_merge_recursive($exports,$exports_lang);
           }
           ksort($exports['sectionCategories']);
           ksort($exports['pageCategories']); 
           
           
            $config = config('App');
            $locales = $config->supportedLocales;
            
           
           $localized = [
           'sectionCategories'=>[],
           'themes'=>[],
           'pageCategories'=>[]
           ];
           $exports['localizedAll'] = [];
           
           foreach($locales as $loc){
           $key = array_search($loc,$locales)-1;
           
           foreach($localized as $lk=>$la){
            
                foreach($exports[$lk] as $k=>$v){
            
              $exports['localizedAll'][$loc][$lk][$k] = ($key>=0 && isset($v[$key])) ? $v[$key] : $k; 
                
               }
           }
        }
       cache()->save('exports', $exports, 86400); 
        
        
    }
      $exports['localized'] = isset($exports['localizedAll'][$locale]) ? $exports['localizedAll'][$locale] : array_shift($exports['localizedAll']); 
      return $exports;  
    }


}
    