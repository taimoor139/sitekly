<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Global design change
 */
 

$config = array(
'name' => 'globaldesign',
'label' => lang('app.site-design'),
'selector' => 'globalDesign',

'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.colors'),lang('app.fonts'))),


array('[maintab]'),
    array('[intab1]','label'=>lang('app.background')),

    array('color-palette','label'=>lang('app.solid-background'),'settings'=>array('customGet'=>'palette_get','customSet'=>'palette_set','select'=>'sbg')),
     array('color-palette','label'=>lang('app.gradient-background'),'settings'=>array('customGet'=>'palette_get','customSet'=>'palette_set','select'=>'gbg')),
    array('[intab1]','label'=>lang('app.text')),
     array('color-palette','label'=>lang('app.font-colors'),'settings'=>array('customGet'=>'palette_get','customSet'=>'palette_set','select'=>'fc')),
array('[/maintab]'),

array('[maintab]'),
    array('[intab1]','label'=>lang('app.fonts')),
    array('hidden-input','label'=>lang('app.font-family'),'settings'=>array('customGet'=>'palette_get','customSet'=>'palette_set','select'=>'ff')),
    array('font-family','conclass'=>'fselect','settings'=>array('customGet'=>'ignore','customSet'=>'ignore')), 
array('[/maintab]'),


),
);