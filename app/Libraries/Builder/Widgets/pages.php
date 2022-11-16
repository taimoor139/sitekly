<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */

/**
 * Contact form 
 */
$selectors = array(
'page' => 'page',
'subclass' => 'sub',
'label' => 'name',
'url' => 'url',
'title' => 'title',
'desc' => 'description',
'key' => 'keywords',
'altlang'=>'altlang'
);

$config = array(
'name' => 'pages',
'label' => lang('app.pages'),
'selector' => 'opages',
'controls'=>array(
array('[main-tabs]','tabs'=>array(lang('app.pages'))),

array('[maintab]'),

    array('[intab1]','label'=>lang('app.pages')),
        array('[repeater]','id'=>'pages'),
            array('element_repeater','class'=>'protectLast pagelist',
            //'deleteConfirm'=>lang('app.page-delete-confirm'),
            'settings'=>array('controls'=>'multisort,delete,clone','limit'=>'30','parent'=>$selectors['page'],'subclass'=>$selectors['subclass'])),
            array('text-by-input','class'=>'pname','label'=> lang('app.name'),'settings'=>array('selector'=>$selectors['label'],'copylabel'=>'true')),
            array('text-by-input','class'=>'purl','label'=> lang('app.url'),'settings'=>array('selector'=>$selectors['url'],'customSet'=>'validate_slug')),
            array('class-by-select','class'=>'autoHide','label'=> lang('app.auto-menu'),'options'=>array(lang('app.visible')=>'show',lang('app.hidden')=>'hide')),
            array('hidden-input','settings'=>array('customGet'=>'hideBlocks','customSet'=>'ignore')),
            array('[intab2]','label'=>lang('app.seo')),
            array('text-by-textarea','label'=> lang('app.title'),'settings'=>array('selector'=>$selectors['title'])),
            array('text-by-textarea','label'=> lang('app.description'),'settings'=>array('selector'=>$selectors['desc'])),
            array('text-by-textarea','label'=> lang('app.keywords'),'settings'=>array('selector'=>$selectors['key'])),
            array('text-by-textarea','label'=> lang('app.altlang'),'placeholder'=>lang('app.altlang-info'),'settings'=>array('selector'=>$selectors['altlang'])),
        array('[/repeater]'),
        
        array('[intab2]','label'=>lang('app.add-new')), 

            array('custom-input','class'=>'pagename','label'=>lang('app.name')),

            array('custom-button','class'=>'addPage','label'=>lang('app.add-page')),
array('[/maintab]'),
),
);