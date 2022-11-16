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
'z-back-after' => '.z-back:after',
'row-container' => '.row-container',
'row'=> '.row-container .row',
'col' => '.row-container .row .sitekly-col',
);

$config = array(
'name' => 'inner-block',
'label' => lang('app.inner-block'),
'selector' => '.sitekly-block.sitekly-edit',
'html'=>'<section class="sitekly-block sitekly-edit">
<div class="z-back"></div>
<div class="row-container swidth">
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
    array('[intab1]','label'=>lang('app.fit')),
        array('margin-advanced-y','units'=>$units['px1440p100']),
        array('padding-advanced-y','units'=>$units['px1440p100']),
        array('height-slider','units'=>$units['vhvwpx1440']),
        array('width-slider','units'=>$units['px1440p100'],'settings'=>array('selector'=>$selectors['row-container'])),
        array('{column-spacing}','{units}'=>$units['px100'],'{column}'=>$selectors['col'],'{row}'=>$selectors['row']),
        array('align-content'),
        array('justify-content-full','settings'=>array('selector'=>$selectors['row'])),
    
array('[/maintab]'),
array('[maintab]'),
    array('[intab1]','label'=>lang('app.background')),
            array('{full-background}','{class-prefix}'=>'bg-','{selector}'=>$selectors['z-back']),
    
    array('[intab1]','label'=>lang('app.background-overlay')),
            array('{full-background}','{class-prefix}'=>'fg-','{selector}'=>$selectors['z-back-after']),
    
    array('[intab1]','label'=>lang('app.border')),
            array('border-radius','units'=>$units['pxup100'],'input-settings'=>array('selector'=>$selectors['z-back'])),
            array('(border)','settings'=>array('selector'=>$selectors['z-back']),'input-settings'=>array('selector'=>$selectors['z-back'])),
      
        array('[intab1]','label'=>lang('app.typography')),
            array('(typography)'),
     
            array('{visibility}'),    
array('[/maintab]'),

),
);