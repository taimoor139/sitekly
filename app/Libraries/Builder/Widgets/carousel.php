<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Content carousel
 */
$selectors = array(
'window'=>'.cwindow',
'row'=>'.cwindow .crow',
'col'=>'.cwindow .crow .column',
'inner'=>'.cwindow .crow .column .column-inside',
'dot'=>'.dotscon .dot',
'dot-hover'=>'.dotscon .dot:hover,.dotscon .dot.active'
);

$config = array(
'name' => 'carousel',
'label' => lang('app.carousel'),
'selector' => '.carousel',
'html'=>'<div class="sitekly-edit carousel">
  <div class="cwindow">
    <div class="crow">
      <div class="column"><div class="column-inside"></div></div>
      <div class="column"><div class="column-inside"></div></div>
      <div class="column"><div class="column-inside"></div></div>
      <div class="column"><div class="column-inside"></div></div>
      <div class="column"><div class="column-inside"></div></div>
      <div class="column"><div class="column-inside"></div></div>
    </div>
  </div>
 <div class="dotscon"></div>
</div>',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.content'),lang('app.style'))),

array('[maintab]'),
    array('[intab1]','label'=>lang('app.slides')),
        array('[repeater]'),
            array('element_repeater','class'=>'protectLast','settings'=>array('controls'=>'sort,clone,delete','limit'=>'30','parent'=>$selectors['col'])),
                array('attr-by-input','label'=>lang('app.name'),'settings'=>array('iattr'=>'alt','copylabel'=>'true')),        
        array('[/repeater]'),

     array('[intab1]','label'=>lang('app.settings')),
        array('class-by-checkbox','label'=>lang('app.dots'),'on'=>'dots','off'=>''), 
        array('class-by-checkbox','label'=>lang('app.infinite'),'on'=>'infiniteScroll','off'=>''), 
        array('[desc-label]','label'=>lang('app.option-disabled-in-editor')),
        array('class-by-checkbox',"id"=>'isauto',"class"=>'altcons','label'=>lang('app.autoplay'),'on'=>'autoplay','off'=>''),
        array('[altcon]','class'=>'isauto autoplay'),
        array('[desc-label]','label'=>lang('app.option-disabled-in-editor')),
        array('default-slider','label'=>lang('app.delay'),'units' => array(''=> array('step'=>'1','min'=>'1','max'=>'100')),'settings'=>array('iattr'=>'data-delay','sattr'=>'val')),  
        array('[desc-label]','label'=>lang('app.time-in-seconds')),
        array('[/altcon]'),
array('[/maintab]'),

array('[maintab]'),
    array('[element]','label'=>lang('app.carousel')),
     
     array('[intab1]','label'=>lang('app.view')),
array('flex-columns','id'=>'carousel-cols','label'=> lang('app.columns-to-show'),'units'=>array( ''=> array('step'=>'1','max'=>'10',"min"=>"1")),'settings'=>array('selector'=>$selectors['col'])),
   array('[intab1]','label'=>lang('app.spacing')),
        array('margin-top','units'=>$units['px100widget']),
         array('{column-spacing}','{units}'=>$units['px100'],'{column}'=>$selectors['col'],'{row}'=>$selectors['row']),
        

 
   array('[intab1]','label'=>lang('app.dimensions')),             
        array('height-slider','units'=>$units['px1440vhvw'],'settings'=>array('selector'=>$selectors['row'])),
         
    
    array('[intab1]','label'=>lang('app.background')),
           array('(standard-background)','settings'=>array('selector'=>$selectors['window'])),
    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['window'])),
            array('(border)','settings'=>array('selector'=>$selectors['window']),'input-settings'=>array('selector'=>$selectors['window'])),
            array('{shadow}','{selector}'=>$selectors['window']),
            array('{animation}','{selector}'=>""), 
            array('{position}'),
    array('{visibility}'),
array('[element]','label'=>lang('app.column')),
       array('[intab1]','label'=>lang('app.spacing')),
       array('padding-master','units'=>$units['px100'],'label'=> lang('app.inner-spacing'),'settings'=>array('selector'=>$selectors['inner'])),
      array('[intab1]','label'=>lang('app.alignment')), 
       array('align-content','settings'=>array('selector'=>$selectors['inner'])),
         
    array('[intab1]','label'=>lang('app.background')),
           array('background-color','settings'=>array('selector'=>$selectors['inner'])),
    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['inner'])),
            array('(border)','settings'=>array('selector'=>$selectors['inner']),'input-settings'=>array('selector'=>$selectors['inner'])),
            
      array('[element]','label'=>lang('app.dots')), 
    array('[intab1]','label'=>lang('app.spacing')),
            array('margin-top','units'=>$units['px100widget'],'settings'=>array('selector'=>$selectors['dot'])),
            array('margin-left','units'=>$units['px100'],'label'=> lang('app.spacing'),'settings'=>array('selector'=>$selectors['dot'])),
      
      array('[intab1]','label'=>lang('app.dimensions')),      
            array('width-slider','units'=>$units['px100'],'label'=> lang('app.size'),'settings'=>array('selector'=>$selectors['dot'],'duplicate'=>array("iprop"=>"height"))),
            
    array('[intab1]','label'=>lang('app.background')),
            array('background-color','parentHover'=>$selectors['dot-hover'],'settings'=>array('selector'=>$selectors['dot'])),
    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['dot'])),
            array('(border)','settings'=>array('selector'=>$selectors['dot']),'input-settings'=>array('selector'=>$selectors['dot'])),
            array('{shadow}','{selector}'=>$selectors['dot']),
            
array('[/maintab]'),

),
);