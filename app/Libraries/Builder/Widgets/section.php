<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Section 
 */
$selectors = array(
'z-back'=>'.z-back',
'anchor'=>'.anchor',
'z-back-after' => '.z-back:after',
'row-container' => '.row-container',
'row'=> '.row-container .row',
'rowClass'=> 'useClass .row-container .row',
'col' => '.row-container .row .sitekly-col',
'colClass' => 'useClass .row-container .row .sitekly-col',
'sticky'=> '[this].fixed',
'sticky-back'=> '[this].fixed .z-back',
);

$config = array(
'name' => 'block',
'label' => lang('app.block'),
'selector' => '.sitekly-block:not(\'.cblock\')',
'html'=>'<section class="sitekly-block">
<div class="z-back"></div>
<a class="anchor"></a>
<div class="row-container">
<div class="row">
<div class="sitekly-col col-md-12 col-sm-12 col-xs-12 col-lg-12">
<div class="box-row"><div class="z-back"></div></div>
</div>
</div>
</div>
</section>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.layout'),lang('app.style'))),

array('[maintab]'),
    array('[intab1]','label'=>lang('app.spacing')),
        array('margin-advanced-y','units'=>$units['px1440p100']),
        array('padding-advanced-x','units'=>$units['px1440p100']),
        array('padding-advanced-y','label'=>'','units'=>$units['px1440p100']),
        
        array('{column-spacing}','{units}'=>$units['px100'],'{column}'=>$selectors['colClass'],'{row}'=>$selectors['rowClass']),
        array('{row-spacing}','{units}'=>$units['px100'],'{column}'=>$selectors['colClass'],'{row}'=>$selectors['rowClass']),
     
     array('[intab1]','label'=>lang('app.dimensions')),           
        array('height-slider','units'=>$units['vhvwpx1440']),
        array('width-slider','units'=>$units['px1440p100'],'settings'=>array('selector'=>$selectors['row-container'],"iprop"=>"max-width")),

    array('[intab1]','label'=>lang('app.alignment')),
    array('[multiselect]','label'=>lang('app.align-content')),
        array('justify-content-full','label'=>lang('app.horizontal'),'settings'=>array('selector'=>$selectors['row'])),
        array('align-items','label'=>lang('app.vertical')),
        
    array('[/multiselect]'),

    array('[intab1]','label'=>lang('app.sticky')),
        array('class-by-checkbox','label'=> lang('app.sticky'),"on"=>'sticky',"id"=>'issticky',"class"=>'altcons'),
        array('[altcon]','class'=>'issticky sticky'),
        array('padding-advanced-y','units'=>$units['px1440p100'],'settings'=>array('selector'=>$selectors['sticky'])),
        array('background-color','hidehover'=>'true','settings'=>array('selector'=>$selectors['sticky-back'])),
        array('[/altcon]'),
        array('{anchor}','{selector}'=>$selectors['anchor']), 
    
    array('[intab1]','label'=>lang('app.category')),    
    array('default-select',"id"=>'sectionCat',"class"=>'altcons','label'=>lang('app.choose-category'),'settings'=>array("iattr"=>"data-name","sattr"=>"val",'customGet'=>'sectionCategories')),
    array('[altcon]','class'=>'sectionCat customLink'),
    array('default-input','class'=>'owncat','label'=>lang('app.category-name'),'settings' => array("iattr"=>"data-name","sattr"=>"val",'filter'=>'upperLower')),
    array('[/altcon]'),
        
        
array('[/maintab]'),
array('[maintab]'),
    array('[intab1]','label'=>lang('app.background')),
            array('{full-background}','{class-prefix}'=>'bg-','{selector}'=>$selectors['z-back']),

    array('[intab1]','label'=>lang('app.background-overlay')),
            array('{full-background}','{class-prefix}'=>'fg-','{selector}'=>$selectors['z-back-after']),
            array('opacity','settings'=>array('selector'=>$selectors['z-back-after'])),
    
     array('[intab1]','label'=>lang('app.background-effects')),        
            array('{scroll}','{selector}'=>$selectors['z-back']),
            array('{stretch}','{selector}'=>$selectors['z-back']),            
            
    
    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['z-back'])),
            array('(border)','settings'=>array('selector'=>$selectors['z-back']),'input-settings'=>array('selector'=>$selectors['z-back'])),
            array('{shadow}','{selector}'=>$selectors['z-back']),
            array('{animation}','{selector}'=>""), 
      array('{visibility}'),
    
array('[/maintab]'),

),
);