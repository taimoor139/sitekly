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
    'formcon' => '.formcon',
    'form' => '.formcon form',
    'agroup' => '.formcon form .pg',
    'igroup' => '.formcon form .form-group',
    'label' => '.formcon form .form-group label',
    'label-inside' => '.formcon form .form-group .input-group .label',
    'input' => '.formcon form .form-group .input-group .inpc',
    'submit' => '.formcon form .pg .submit',
    'submit-con' => '.formcon form .pg.submit',
    'z-back' => '.formcon .z-back',
    'z-back-after' => '.formcon .z-back:after'
);

$config = array(
    'name' => 'cform',
    'label' => lang('app.form-builder'),
    'selector' => '.cform',
    'html' => '<div class="cform sitekly-edit">
<div class="formcon">
<div class="z-back"></div>
<form action="" method="post">
<div class="form-group pg"><label>' . lang('app.name') . '</label><div class="input-group"><input type="text" name="' . lang('app.name') . '" class="inpc"></div></div>
<div class="form-group pg"><label>' . lang('app.email') . '</label><div class="input-group"><input type="text" name="' . lang('app.email') . '" class="inpc"></div></div>
<div class="form-group pg"><label>' . lang('app.message') . '</label><div class="input-group"><textarea name="' . lang('app.message') . '" class="inpc"></textarea></div></div>
<div class="pg submit"><input type="submit" class="submit" value="' . lang('app.send') . '"/></div>
</form>
</div>
</div>',
    'controls' => array(
        array('[main-tabs]', 'tabs' => array(lang('app.content'), lang('app.style'))),

        array('[maintab]'),

        array('[intab1]', 'label' => lang('app.form-fields')),
        array('[repeater]'),
        array('element_repeater', 'class' => 'protectLast', 'settings' => array('controls' => 'sort,clone,delete', 'limit' => '30', 'parent' => $selectors['igroup'])),

        array('text-by-input', 'label' => lang('app.label'), 'settings' => array('selector' => $selectors['label'], 'cloneattr' => array('selector' => $selectors['input'], 'iattr' => 'name'), 'copylabel' => 'true')),

        array('input-type', "id" => 'altg1', "class" => 'altcons', 'settings' => array('selector' => $selectors['input'])),
        array('[altcon]', 'class' => 'altg1 text email TEXTAREA'),
        array('attr-by-input', 'label' => lang('app.placeholder'), 'settings' => array('selector' => $selectors['input'], "iattr" => "placeholder")),
        array('[/altcon]'),

        array('[altcon]', 'class' => 'altg1 SELECT radio'),
        array('select-options-by-textarea', 'settings' => array('selector' => $selectors['input'])),
        array('[/altcon]'),
        array('[altcon]', 'class' => 'altg1 checkbox'),
        array('text-by-input', 'settings' => array('iattr' => 'options', 'selector' => $selectors['input'])),
        array('[/altcon]'),
        array('attr-by-checkbox', 'label' => lang('app.required'), 'off' => "", 'on' => "required", 'settings' => array('selector' => $selectors['input'], 'iattr' => 'required')),
        array('class-by-select', 'label' => lang('app.width'), 'settings' => array('prefix' => 'viewport'), 'options' => $units['inner-columns']),
        array('[/repeater]'),
        array('custom-button', 'class' => 'addInput', 'label' => lang('app.add-item')),

        array('[intab1]', 'label' => lang('app.button')),
        array('val-by-input', 'label' => lang('app.label'), 'settings' => array('selector' => $selectors['submit'])),
        array('[intab1]', 'label' => lang('app.settings')),
        array('custom-input', 'conclass' => 'full-width', 'label' => lang('app.email-contact-form'), 'id' => 'mail', 'settings' => array('customGet' => 'emailTo', 'customSet' => 'emailTo')),
        array('default-textarea', 'conclass' => 'full-width', 'label' => lang('app.subject'), 'id' => 'subject', 'settings' => array('customGet' => 'emailTo', 'customSet' => 'emailTo')),
        array('default-textarea', 'conclass' => 'full-width', 'label' => lang('app.success-message'), 'id' => 'success', 'settings' => array('customGet' => 'emailTo', 'customSet' => 'emailTo')),
        array('default-textarea', 'conclass' => 'full-width', 'label' => lang('app.fail-message'), 'id' => 'fail', 'settings' => array('customGet' => 'emailTo', 'customSet' => 'emailTo')),

        array('[/maintab]'),

        array('[maintab]'),

        array('[element]', 'label' => lang('app.form')),
        array('[intab1]', 'label' => lang('app.spacing')),
        array('margin-top', 'units' => $units['px100widget']),
        array('padding-advanced-x-y', 'units' => $units['px100'], 'label' => lang('app.inner-spacing'), 'settings' => array('selector' => $selectors['formcon'])),
        array('margin-bottom', 'units' => $units['px100'], 'label' => lang('app.row-spacing'), 'settings' => array('selector' => $selectors['igroup'])),
        array('{column-spacing}', '{units}' => $units['px100'], '{column}' => $selectors['agroup'], '{row}' => $selectors['form']),
        array('[intab1]', 'label' => lang('app.typography')),
        array('(typography)'),
        array('[intab1]', 'label' => lang('app.background')),
        array('background-color', 'settings' => array('selector' => $selectors['z-back'])),
        array('[intab1]', 'label' => lang('app.border')),
        array('border-radius', 'units' => $units['pxup100'], 'input-settings' => array('selector' => $selectors['formcon'])),
        array('(border)', 'settings' => array('selector' => $selectors['formcon']), 'input-settings' => array('selector' => $selectors['formcon'])),
        array('{shadow}', '{selector}' => $selectors['formcon']),
        array('{animation}', '{selector}' => ""),
        array('{position}'), array('{visibility}'),
        array('[element]', 'label' => lang('app.label')),
        array('[intab1]', 'label' => lang('app.spacing')),
        array('margin-bottom', 'units' => $units['px100'], 'label' => lang('app.spacing'), 'settings' => array('selector' => $selectors['label'])),
        array('[intab1]', 'label' => lang('app.typography')),
        array('(typography)', 'settings' => array('selector' => $selectors['label']), 'text-color' => array('settings' => array('selector' => $selectors['label'] . ',' . $selectors['label-inside']))),

        array('[element]', 'label' => lang('app.input')),

        array('[intab1]', 'label' => lang('app.spacing')),
        array('padding-advanced-x-y', 'units' => $units['px100'], 'settings' => array('selector' => $selectors['input'])),

        array('[intab1]', 'label' => lang('app.typography')),
        array('(typography)', 'settings' => array('selector' => $selectors['input'])),
        array('[intab1]', 'label' => lang('app.background')),
        array('background-color', 'settings' => array('selector' => $selectors['input'])),
        array('[intab1]', 'label' => lang('app.border')),
        array('border-radius', 'units' => $units['pxup100'], 'input-settings' => array('selector' => $selectors['input'])),
        array('(border)', 'settings' => array('selector' => $selectors['input']), 'input-settings' => array('selector' => $selectors['input'])),
        array('{shadow}', '{selector}' => $selectors['input']),

        array('[element]', 'label' => lang('app.button')),

        array('[intab1]', 'label' => lang('app.spacing')),
        array('margin-top', 'units' => $units['px100'], 'label' => lang('app.spacing'), 'settings' => array('selector' => $selectors['submit-con'])),
        array('padding-advanced-x-y', 'units' => $units['px100'], 'settings' => array('selector' => $selectors['submit'])),
        // array('padding-master-y','units'=>$units['px100'],'settings'=>array('selector'=>$selectors['submit'])),

        array('[intab1]', 'label' => lang('app.dimensions')),
        array('width-slider', 'units' => $units['p100'], 'settings' => array('selector' => $selectors['submit'])),

        array('[intab1]', 'label' => lang('app.alignment')),
        array('align-no-justify', 'settings' => array('selector' => $selectors['submit-con'])),

        array('[intab1]', 'label' => lang('app.typography')),
        array('(typography)', 'settings' => array('selector' => $selectors['submit'])),
        array('[intab1]', 'label' => lang('app.background')),
        array('background-color', 'settings' => array('selector' => $selectors['submit'])),
        array('[intab1]', 'label' => lang('app.border')),
        array('border-radius', 'units' => $units['pxup100'], 'input-settings' => array('selector' => $selectors['submit'])),
        array('(border)', 'settings' => array('selector' => $selectors['submit']), 'input-settings' => array('selector' => $selectors['submit'])),
        array('{shadow}', '{selector}' => $selectors['submit']),
        array('[/maintab]'),
    ),
);
