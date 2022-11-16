<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Column
 */
$selectors = array(
'box-row'=>'.box-row',
'z-back'=>'.box-row .z-back',
'sitekly-edit'=>'useClass .box-row .sitekly-edit',
'z-back-after' => '.box-row .z-back:after',
);

$config = array(
'name' => 'col',
'label' => lang('app.column'),
'selector' => '.sitekly-col',
'html'=>'<div class="sitekly-col col-md-12 col-sm-12 col-xs-12 col-lg-12">
<div class="box-row"><div class="z-back"></div></div>
</div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.layout'),lang('app.style'))),

array('[maintab]'),
   array('[intab1]','label'=>lang('app.spacing')),
        array('margin-top','units'=>$units['px100widget'],'label'=> lang('app.widget-spacing'),'settings'=>array('selector'=>$selectors['sitekly-edit'])),
        array('padding-advanced','label'=> lang('app.out-spacing'),'units'=>$units['px1440p100']),
        array('padding-advanced','units'=>$units['px1440p100'],'settings'=>array('selector'=>$selectors['box-row'])),
        
 
   array('[intab1]','label'=>lang('app.dimensions')),             
        array('height-slider','units'=>$units['p100vhvwpx1440'],'settings'=>array('selector'=>$selectors['box-row'])),
        array('custom-slider','label'=> lang('app.width'),'units'=>array( ''=> array('step'=>'1','max'=>'12',"min"=>"1")),'settings'=>array("sattr"=>"val","special"=>"class",'prefix'=>'viewport-col')),
        
   array('[intab1]','label'=>lang('app.alignment')), 
   array('[multiselect]','label'=>lang('app.align-content')),    
        array('justify-content','label'=>lang('app.horizontal'),'settings'=>array('selector'=>$selectors['box-row'])),
        array('align-items','label'=>lang('app.vertical'),'settings'=>array('selector'=>$selectors['box-row'],'duplicate'=>array('iprop'=>'align-content'))),
        
    array('[/multiselect]'),
    
array('[/maintab]'),

array('[maintab]'),
    array('[intab1]','label'=>lang('app.background')),
            array('{full-background}','{class-prefix}'=>'bg-','{selector}'=>$selectors['z-back']),
            array('{scroll}','{selector}'=>$selectors['z-back']),
    array('[intab1]','label'=>lang('app.background-overlay')),
            array('{full-background}','{class-prefix}'=>'fg-','{selector}'=>$selectors['z-back-after']),
            array('opacity','settings'=>array('selector'=>$selectors['z-back-after'])),
    
    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['z-back'])),
            array('(border)','settings'=>array('selector'=>$selectors['z-back']),'input-settings'=>array('selector'=>$selectors['z-back'])),
     
     array('{shadow}','{selector}'=>$selectors['z-back']),
     array('{animation}','{selector}'=>""), 
  array('{visibility}'),
array('[/maintab]'),

),
);