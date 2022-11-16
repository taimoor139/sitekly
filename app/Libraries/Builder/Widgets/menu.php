<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Menu 
 */
$selectors = array(
'navcon' => '.navcon',
'ul' => '.navcon .nav',
'link' => '.navcon .nav li',
'link-a' => '.navcon .nav li a',
'link-a-hover' => '.navcon .nav li a:hover,.navcon .nav li a.active',
'dropdown' => '.navcon .nav li .subnav',
'dropdown-link' => '.navcon .nav li ul li',
'dropdown-link-a' => '.navcon .nav li ul li a',
'dropdown-link-a-hover' => '.navcon .nav li ul li a:hover',
'button' => '.navcon a.toggle'
);

$config = array(
'name' => 'menu',
'label' => lang('app.menu'),
'selector' => '.z-menu',
'html'=>'<div class="z-menu sitekly-edit">
<div class="navcon">
<a class="toggle"></a>
<ul class="nav"></ul>
</div>
</div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),

array('[maintab]'),
array('[intab1]','label'=>lang('app.menu')),

 array('custom-select',"id"=>'menuSelect',"class"=>'altcons','label'=>lang('app.choose-menu'),'settings'=>array('customGet'=>'menuAddList','customSet'=>'menuListPick')),
    array('[altcon]','class'=>'menuSelect newMenu'),
    array('custom-input','class'=>'menuName','label'=>lang('app.menu-name')),
        array('custom-button','class'=>'addMenu custom-edit','label'=>lang('app.create-menu')),
    array('[/altcon]'),
    
     array('[altcon]','class'=>'menuSelect allexept','id'=>'newMenu'),
        array('[altcon]','class'=>'menuSelect allexept','id'=>'autoMenu'),
    array('custom-input','class'=>'menuName2','label'=>lang('app.menu-name')),
    array('[inlinecon]'),
        array('custom-button','class'=>'editMenu custom-edit','label'=>lang('app.edit-menu')),
        array('custom-button','class'=>'delMenu','label'=>lang('app.delete-menu')),
    array('[/inlinecon]'),    
    array('[/altcon]'),
    array('[/altcon]'),

array('[/maintab]'),

array('[maintab]'),
array('[element-group]','label'=>lang('app.main-menu')),
array('[element]','label'=>lang('app.menu')),

    array('[intab1]','label'=>lang('app.view')),
    array('default-select',"class"=>'altcons',"id"=>'menuview','label'=> lang('app.view'),'options' => array(lang('app.horizontal')=> "-normal",lang('app.dropdown')=> "-drop",lang('app.vertical')=> "-vert"),'settings' => array('prefix'=>'viewport',"sattr"=>"val","special"=>"class",'scope'=>'.z-pop-cont')),

    array('[intab1]','label'=>lang('app.spacing')),
    array('margin-top','units'=>$units['px100widget']),
    
    array('[intab1]','label'=>lang('app.dimensions')),
    
    //array('width-slider','units'=>$units['px1440p100'],'settings'=>array('selector'=>$selectors['navcon'])),
    array('width-slider','units'=>$units['px1440p100'],'settings'=>array('selector'=>$selectors['navcon'],'clonecss'=>array('selector'=>$selectors['ul'],"iprop"=>"width"))), 
    
    array('[intab1]','label'=>lang('app.alignment')), 
        
    array('[altcon]','class'=>'menuview -normal'), 
    array('responsive-align-class-full','settings'=>array('selector'=>$selectors['ul'])),
    array('[/altcon]'),
    
    array('[altcon]','class'=>'menuview -drop -vert'), 
    array('responsive-align-class'),
    array('[/altcon]'),
    
    
    
    
    array('[intab1]','label'=>lang('app.background')),
    array('background-color','settings'=>array('selector'=>$selectors['ul'])),
    array('[intab1]','label'=>lang('app.border')),
    array('(border)','settings'=>array('selector'=>$selectors['ul']),'input-settings'=>array('selector'=>$selectors['ul'])),
    array('{shadow}','{selector}'=>$selectors['ul']),
    array('{animation}','{selector}'=>""), 
     array('{position}'), array('{visibility}'),    
array('[element]','label'=>lang('app.link')),
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('padding-advanced-x-y','units'=>$units['px100'],'settings'=>array('selector'=>$selectors['link-a'])),
    
    array('[intab1]','label'=>lang('app.alignment')), 
    array('text-align-no-justify','settings'=>array('selector'=>$selectors['link-a'])),  
      
    array('[intab1]','label'=>lang('app.typography')),
    array('(typography)','parentHover'=>$selectors['link-a-hover'],'settings'=>array('selector'=>$selectors['link-a'])),  
    
    array('[intab1]','label'=>lang('app.background')),
    array('background-color','parentHover'=>$selectors['link-a-hover'],'settings'=>array('selector'=>$selectors['link-a'])),
    array('[altcon]','class'=>'menuview -drop -vert endtab1'),
    
    array('[intab1]','label'=>lang('app.divider')),
    array('(border-top)','settings'=>array('selector'=>$selectors['link']),'input-settings'=>array('selector'=>$selectors['link'])),
    array('[/altcon]'),

array('[element-group]','label'=>lang('app.second-level-menu')),


array('[element]','label'=>lang('app.menu')),
    
    array('[altcon]','class'=>'menuview -normal -vert'), 
    array('[intab1]','label'=>lang('app.alignment')),    
    array('default-select','label'=> lang('app.align'),'options' => array(lang('app.default')=> "",lang('app.left')=> "-subleft",lang('app.right')=> "-subright"),'settings' => array('selector'=>$selectors['dropdown'],'prefix'=>'viewport',"sattr"=>"val","special"=>"class")),
    
    array('width-slider','units'=>$units['px1440p100'],'settings'=>array('selector'=>$selectors['dropdown'])),
    array('[/altcon]'),
    array('[intab1]','label'=>lang('app.border')),
    array('(border)','settings'=>array('selector'=>$selectors['dropdown']),'input-settings'=>array('selector'=>$selectors['dropdown'])),
    
    array('[altcon]','class'=>'menuview -normal -vert'), 
    array('{shadow}','{selector}'=>$selectors['dropdown']),
    array('[/altcon]'),
    
array('[element]','label'=>lang('app.link')),
    
    array('[intab1]','label'=>lang('app.spacing')),
    array('padding-advanced-x-y','units'=>$units['px100'],'settings'=>array('selector'=>$selectors['dropdown-link-a'])),
    
    array('[intab1]','label'=>lang('app.alignment')),
    array('text-align-no-justify','settings'=>array('selector'=>$selectors['dropdown-link-a'])), 
    
    array('[intab1]','label'=>lang('app.typography')),
    array('(typography)','settings'=>array('selector'=>$selectors['dropdown-link-a'])),
    
    array('[intab1]','label'=>lang('app.background')),
    array('background-color','settings'=>array('selector'=>$selectors['dropdown-link-a'])),
    
    array('[intab1]','label'=>lang('app.divider')),
    array('(border-top)','settings'=>array('selector'=>$selectors['dropdown-link']),'input-settings'=>array('selector'=>$selectors['dropdown-link'])),   
    
array('[element-group]','label'=>lang('app.dropdown'),'class'=>'altcon menuview -drop'),
array('[element]','label'=>lang('app.button'),'class'=>'altcon menuview -drop'),
    

     
     array('[intab1]','label'=>lang('app.spacing')),       
            array('padding-advanced-x-y','label'=> lang('app.inner-spacing'),'units'=>$units['px100'],'settings'=>array('selector'=>$selectors['button'])),

    array('[intab1]','label'=>lang('app.dimensions')),
            array('font-size','label'=>lang('app.size'),'units'=>$units['px300'],'settings'=>array('selector'=>$selectors['button'])),
            array('width-slider','units'=>$units['px1440p100'],'settings'=>array('selector'=>$selectors['button'])),    

    array('[intab1]','label'=>lang('app.alignment')),        
            array('align-self-as-x','settings'=>array('selector'=>$selectors['button'])),
          //  array('align-no-justify','label'=> lang('app.content-align'),'settings'=>array('selector'=>$selectors['button'])),
    
     array('[intab1]','label'=>lang('app.colors')),       
            array('text-color','label'=>lang('app.color'),'settings'=>array('selector'=>$selectors['button'])),
            array('background-color','settings'=>array('selector'=>$selectors['button'])),

    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['button'])),
            array('(border)','settings'=>array('selector'=>$selectors['button']),'input-settings'=>array('selector'=>$selectors['button'])),   
            array('{shadow}','{selector}'=>$selectors['button']),
array('[/maintab]'),
),
);