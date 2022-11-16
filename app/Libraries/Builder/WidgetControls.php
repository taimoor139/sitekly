<?php

/**
 * Sitekly Website Builder
 *
 * @copyright Websoft Zbigniew Giza (https://sitekly.com)
 * For the full copyright and license information, please view the License_Sitekly
 * file located in sitekly directory.
 */


$units = array(
    'px1440p100' => array('px' => array('step' => '1', 'max' => '1440'), '%' => array('step' => '1', 'max' => '100')),
    'vhvwpx1440' => array('vh' => array('step' => '1', 'max' => '100'), 'vw' => array('step' => '1', 'max' => '100'), 'px' => array('step' => '1', 'max' => '1440')),
    'px1440vhvw' => array('px' => array('step' => '1', 'max' => '1440'), 'vh' => array('step' => '1', 'max' => '100'), 'vw' => array('step' => '1', 'max' => '100')),
    'p100vhvwpx1440' => array('%' => array('step' => '1', 'max' => '100'), 'vh' => array('step' => '1', 'max' => '100'), 'vw' => array('step' => '1', 'max' => '100'), 'px' => array('step' => '1', 'max' => '1440')),
    'px100' => array('px' => array('step' => '1', 'max' => '100')),
    'px100widget' => array('px' => array('step' => '1', 'max' => '100', 'init' => '20')),
    'px300' => array('px' => array('step' => '1', 'max' => '300')),
    'px1000' => array('px' => array('step' => '1', 'max' => '1000')),
    'px1440' => array('px' => array('step' => '1', 'max' => '1440')),
    'p100' => array('%' => array('step' => '1', 'max' => '100')),
    'p100px1440' => array('%' => array('step' => '1', 'max' => '100'), 'px' => array('step' => '1', 'max' => '1440')),
    'pxup100' => array('px' => array('step' => '1', 'max' => ''), '%' => array('step' => '1', 'max' => '100')),
    'px400p100' => array('px' => array('step' => '1', 'max' => '400'), '%' => array('step' => '1', 'max' => '100')),
    'inner-columns' => array(lang('app.default') => '', '20%' => '-20', '25%' => '-25', '33%' => '-33', '40%' => '-40', '50%' => '-50', '60%' => '-60', '66%' => '-66', '75%' => '-75', '80%' => '-80', '100%' => '-100')
);

$controls = array(
    'margin-advanced' => array(
        'type' => 'connected_inputs',
        'label' => lang('app.out-spacing'),
        'settings' => array(
            'inputs' => array(
                array("label" => lang('app.top'), "iprop" => "margin-top", "sattr" => "val"),
                array("label" => lang('app.bottom'), "iprop" => "margin-bottom", "sattr" => "val"),
                array("label" => lang('app.left'), "iprop" => "margin-left", "sattr" => "val"),
                array("label" => lang('app.right'), "iprop" => "margin-right", "sattr" => "val")
            ),
            'connect' => array("special" => "valcon1")
        )
    ),
    'margin-advanced-x-y' => array(
        'type' => 'connected_inputs',
        'label' => lang('app.out-spacing'),
        'settings' => array(
            'inputs' => array(
                array("label" => lang('app.top'), "iprop" => "margin-top", "sattr" => "val", 'duplicate' => array("iprop" => "margin-bottom")),

                array("label" => lang('app.left'), "iprop" => "margin-left", "sattr" => "val", 'duplicate' => array("iprop" => "margin-right")),

            ),
            'connect' => array("special" => "valcon1")
        )
    ),
    'margin-advanced-y' => array(
        'type' => 'connected_inputs',
        'label' => lang('app.out-spacing'),
        'settings' => array(
            'inputs' => array(
                array("label" => lang('app.top'), "iprop" => "margin-top", "sattr" => "val"),
                array("label" => lang('app.bottom'), "iprop" => "margin-bottom", "sattr" => "val"),
            ),
            'connect' => array("special" => "valcon1")
        )
    ),
    'margin-master' => array(
        'type' => 'slider_input',
        'label' => lang('app.out-spacing'),
        'settings' => array("sattr" => "val", "iprop" => "margin")
    ),
    'margin-master-x' => array(
        'type' => 'slider_input',
        'label' => lang('app.out-spacing-x'),

        'settings' => array("sattr" => "val", "iprop" => "margin-left", 'duplicate' => array("iprop" => "margin-right"))
    ),
    'margin-master-y' => array(
        'type' => 'slider_input',
        'label' => lang('app.out-spacing-y'),

        'settings' => array("sattr" => "val", "iprop" => "margin-top", 'duplicate' => array("iprop" => "margin-bottom"))
    ),

    'margin-top' => array(
        'type' => 'slider_input',
        'label' => lang('app.margin-top'),
        'settings' => array("sattr" => "val", "iprop" => "margin-top")
    ),
    'margin-bottom' => array(
        'type' => 'slider_input',
        'label' => lang('app.margin-bottom'),
        'settings' => array("sattr" => "val", "iprop" => "margin-bottom")
    ),
    'margin-right' => array(
        'type' => 'slider_input',
        'label' => lang('app.margin-right'),
        'settings' => array("sattr" => "val", "iprop" => "margin-right")
    ),
    'margin-left' => array(
        'type' => 'slider_input',
        'label' => lang('app.margin-left'),
        'settings' => array("sattr" => "val", "iprop" => "margin-left")
    ),
    'padding-master' => array(
        'type' => 'slider_input',
        'label' => lang('app.inner-spacing'),
        'settings' => array("sattr" => "val", "iprop" => "padding")
    ),
    'padding-master-x' => array(
        'type' => 'slider_input',
        'label' => lang('app.inner-spacing-x'),

        'settings' => array("sattr" => "val", "iprop" => "padding-left", 'duplicate' => array("iprop" => "padding-right"))
    ),
    'padding-master-y' => array(
        'type' => 'slider_input',
        'label' => lang('app.inner-spacing-y'),

        'settings' => array("sattr" => "val", "iprop" => "padding-top", 'duplicate' => array("iprop" => "padding-bottom"))
    ),
    'padding-advanced' => array(
        'name' => 'padding',
        'type' => 'connected_inputs',
        'label' => lang('app.in-spacing'),
        'settings' => array(
            'inputs' => array(
                array("label" => lang('app.top'), "iprop" => "padding-top", "sattr" => "val"),
                array("label" => lang('app.bottom'), "iprop" => "padding-bottom", "sattr" => "val"),
                array("label" => lang('app.left'), "iprop" => "padding-left", "sattr" => "val"),
                array("label" => lang('app.right'), "iprop" => "padding-right", "sattr" => "val")
            ),
            'connect' => array("special" => "valcon1")
        )
    ),
    'padding-advanced-x-y' => array(
        'type' => 'connected_inputs',
        'label' => lang('app.out-spacing'),
        'settings' => array(
            'inputs' => array(
                array("label" => lang('app.vertical'), "iprop" => "padding-top", "sattr" => "val", 'duplicate' => array("iprop" => "padding-bottom")),

                array("label" => lang('app.horizontal'), "iprop" => "padding-left", "sattr" => "val", 'duplicate' => array("iprop" => "padding-right")),

            ),
            'connect' => array("special" => "valcon1")
        )
    ),
    'padding-advanced-y' => array(
        'name' => 'padding',
        'type' => 'connected_inputs',
        'label' => lang('app.in-spacing'),
        'settings' => array(
            'inputs' => array(
                array("label" => lang('app.top'), "iprop" => "padding-top", "sattr" => "val"),
                array("label" => lang('app.bottom'), "iprop" => "padding-bottom", "sattr" => "val"),
            ),
            'connect' => array("special" => "valcon1")
        )
    ),
    'padding-advanced-x' => array(
        'name' => 'padding',
        'type' => 'connected_inputs',
        'label' => lang('app.in-spacing'),
        'settings' => array(
            'inputs' => array(
                array("label" => lang('app.left'), "iprop" => "padding-left", "sattr" => "val"),
                array("label" => lang('app.right'), "iprop" => "padding-right", "sattr" => "val"),
            ),
            'connect' => array("special" => "valcon1")
        )
    ),
    'padding-left' => array(
        'type' => 'slider_input',
        'label' => lang('app.padding-left'),
        'settings' => array("sattr" => "val", "iprop" => "padding-left")
    ),
    'padding-bottom' => array(
        'type' => 'slider_input',
        'label' => lang('app.padding-bottom'),
        'settings' => array("sattr" => "val", "iprop" => "padding-bottom")
    ),

    'height-slider' => array(
        'name' => 'height',
        'type' => 'slider_input',
        'label' => lang('app.height'),
        'settings' => array("iprop" => "min-height", "sattr" => "val")
    ),
    'width-slider' => array(
        'name' => 'width',
        'type' => 'slider_input',
        'label' => lang('app.width'),
        'settings' => array("iprop" => "width", "sattr" => "val")
    ),
    'flex-columns' => array(
        'name' => 'width',
        'type' => 'slider_input',
        'label' => lang('app.columns-in-row'),
        'settings' => array("sattr" => "val", "iprop" => 'width', "filter" => 'flex-calc')
    ),

    'align-content' => array(
        'type' => 'select',
        'label' => lang('app.align-content-y'),
        'options' => array(lang('app.default') => "", lang('app.top') => "flex-start", lang('app.center') => "center", lang('app.bottom') => "flex-end"),
        'settings' => array("iprop" => "align-content", "sattr" => "val")
    ),
    'align-items' => array(
        'type' => 'select',
        'label' => lang('app.align-content-y'),
        'options' => array(lang('app.default') => "", lang('app.top') => "flex-start", lang('app.center') => "center", lang('app.bottom') => "flex-end"),
        'settings' => array("iprop" => "align-items", "sattr" => "val")
    ),
    'justify-content' => array(
        'type' => 'select',
        'label' => lang('app.align-content-x'),
        'options' => array(lang('app.default') => "", lang('app.left') => "flex-start", lang('app.center') => "center", lang('app.right') => "flex-end"),
        'settings' => array("iprop" => "justify-content", "sattr" => "val")
    ),
    'justify-content-full' => array(
        'type' => 'select',
        'label' => lang('app.align-content-x'),
        'options' => array(lang('app.default') => "", lang('app.left') => "flex-start", lang('app.right') => "flex-end", lang('app.center') => "center", lang('app.justify') => "space-between"),
        'settings' => array("iprop" => "justify-content", "sattr" => "val")
    ),

    'align-self' => array(
        'type' => 'select',
        'label' => lang('app.align-content-y'),
        'options' => array(lang('app.default') => "", lang('app.top') => "flex-start", lang('app.center') => "center", lang('app.bottom') => "flex-end"),
        'settings' => array("iprop" => "align-self", "sattr" => "val")
    ),
    'align-self-as-x' => array(
        'type' => 'select',
        'label' => lang('app.align-content-y'),
        'options' => array(lang('app.default') => "", lang('app.left') => "flex-start", lang('app.center') => "center", lang('app.right') => "flex-end"),
        'settings' => array("iprop" => "align-self", "sattr" => "val")
    ),
    'text-align-select' => array(
        'type' => 'select',
        'label' => lang('app.align'),
        'options' => array(lang('app.default') => "", lang('app.left') => "left", lang('app.center') => "center", lang('app.right') => "right", lang('app.justify') => "justify"),
        'settings' => array("iprop" => "text-align", "sattr" => "val")
    ),
    'text-align' => array(
        'type' => 'iconSelect',
        'label' => lang('app.align'),
        'options' => array(lang('app.default') => "", lang('app.left') => "left", lang('app.center') => "center", lang('app.right') => "right", lang('app.justify') => "justify"),
        'settings' => array("iprop" => "text-align", "sattr" => "icon-val")
    ),
    'text-align-no-justify' => array(
        'type' => 'iconSelect',
        'label' => lang('app.align'),
        'options' => array(lang('app.default') => "", lang('app.left') => "left", lang('app.center') => "center", lang('app.right') => "right"),
        'settings' => array("iprop" => "text-align", "sattr" => "icon-val")
    ),
    'align-no-justify' => array(
        'type' => 'select',
        'label' => lang('app.align'),
        'options' => array(lang('app.default') => "", lang('app.left') => "left", lang('app.center') => "center", lang('app.right') => "right"),
        'settings' => array("iprop" => "text-align", "sattr" => "val")
    ),
    'text-type' => array(
        'type' => 'select',
        'label' => lang('app.type'),
        'options' => array(lang('app.heading') . ' 1' => 'H1', lang('app.heading') . ' 2' => 'H2', lang('app.heading') . ' 3' => 'H3', lang('app.heading') . ' 4' => 'H4', lang('app.heading') . ' 5' => 'H5', lang('app.heading') . ' 6' => 'H6', lang('app.paragraph') => 'P'),
        'settings' => array("iattr" => "text-tag", "sattr" => "val")
    ),
    'quick-select' => array(
        'type' => 'input',
        'conclass' => 'full-width',
        'class' => 'quickfontinp',
        'label' => lang('app.quick-select'),
        'settings' => array('customGet' => 'ignore', 'customSet' => 'ignore')
    ),
    'font-family' => array(
        'type' => 'input',
        'label' => lang('app.font-family'),
        'class' => 'fontselectinp',
        'settings' => array("iprop" => "font-family", "sattr" => "val", "action" => "fontset"),
    ),
    'font-weight' => array(
        'type' => 'select',
        'label' => lang('app.font-weight'),
        'id' => 'fontWeight',
        'options' => array(lang('app.default') => "", '100' => '100', '300' => '300', '400' => '400', '500' => '500', '600' => '600', '700' => '700', '900' => '900'),
        'settings' => array("iprop" => "font-weight", "sattr" => "val"),
    ),
    'font-style' => array(
        'type' => 'select',
        'label' => lang('app.font-style'),
        'id' => 'fontStyle',
        'options' => array(lang('app.default') => "", lang('app.normal') => "normal", lang('app.italic') => "italic", lang('app.oblique') => "oblique"),
        'settings' => array("iprop" => "font-style", "sattr" => "val"),
    ),
    'text-transform' => array(
        'type' => 'select',
        'label' => lang('app.transform'),
        'options' => array(lang('app.default') => "", lang('app.normal') => "none", lang('app.capitalize') => "capitalize", lang('app.lowercase') => "lowercase", lang('app.uppercase') => "uppercase"),
        'settings' => array("iprop" => "text-transform", "sattr" => "val"),
    ),
    'text-decoration' => array(
        'type' => 'select',
        'label' => lang('app.text-decoration'),
        'options' => array(lang('app.default') => "", lang('app.normal') => "none", lang('app.underline') => "underline", lang('app.overline') => "overline", lang('app.linetrough') => "line-through"),
        'settings' => array("iprop" => "text-decoration", "sattr" => "val")
    ),
    'text-color' => array(
        'type' => 'color',
        'label' => lang('app.text-color'),
        'id' => 'txtcolor',
        'settings' => array("iprop" => "color", "sattr" => "css", "sprop" => "background-color")
    ),
    'font-size' => array(
        'type' => 'slider_input',
        'label' => lang('app.font-size'),
        'id' => 'fontSize',
        'units' => array('px' => array('step' => '1', 'max' => '200'), 'rem' => array('step' => '0.1', 'max' => '10')),
        'settings' => array("iprop" => "font-size", "sattr" => "val")
    ),
    'letter-spacing' => array(
        'type' => 'slider_input',
        'label' => lang('app.letter-spacing'),
        'units' => array('em' => array('step' => '0.01', 'min' => '0', 'max' => '10'), 'px' => array('step' => '1', 'min' => '-5', 'max' => '100')),
        'settings' => array("iprop" => "letter-spacing", "sattr" => "val")
    ),
    'line-height' => array(
        'type' => 'slider_input',
        'label' => lang('app.line-height'),
        'id' => 'lineHeight',
        'units' => array('em' => array('step' => '0.1', 'max' => '10'), 'px' => array('step' => '1', 'max' => '100')),
        'settings' => array("iprop" => "line-height", "sattr" => "val")
    ),
    'element_repeater' => array(
        'type' => 'element_repeater',
        'label' => lang('app.label'),
        'settings' => array('special' => 'repeater')
    ),

    'input-type' => array(
        'type' => 'select',
        'label' => lang('app.type'),
        'options' => array(
            lang('app.textarea') => "TEXTAREA", lang('app.input') => "text", lang('app.select-list') => "SELECT",
            lang('app.email') => "email", lang('app.checkbox') => "checkbox"
        ),
        'settings' => array("iattr" => "tag", "sattr" => "val")
    ),
    'input-type-full' => array(
        'type' => 'select',
        'label' => lang('app.type'),
        'options' => array(
            lang('app.textarea') => "TEXTAREA", lang('app.input') => "text", lang('app.select-list') => "SELECT",
            lang('app.email') => "email", lang('app.checkbox') => "checkbox", lang('app.date') => "date", lang('app.number') => "number", lang('app.multiple-items') => "radio"
        ),
        'settings' => array("iattr" => "tag", "sattr" => "val")
    ),

    'href' => array(
        'type' => 'input',
        'label' => lang('app.link'),
        'settings' => array("sattr" => "val", 'iattr' => 'href'),
    ),
    'alt' => array(
        'type' => 'input',
        'label' => lang('app.alt-text'),
        'settings' => array("sattr" => "val", 'iattr' => 'alt'),
    ),
    'background-type' => array(
        'type' => 'select',
        'label' => lang('app.background-type'),
        "id" => 'altg1',
        "class" => 'altcons',
        // 'options' => array(lang('app.standard')=> "bg-s",lang('app.gradient')=> "bg-g"),
        'settings' => array("sattr" => "val", "special" => "class")
    ),
    'background-color' => array(
        'type' => 'color',
        'label' => lang('app.background-color'),
        'settings' => array("iprop" => "background-color", "sattr" => "css", "sprop" => "background-color")
    ),
    'background-image' => array(
        'type' => 'image',
        'label' => lang('app.background-image'),
        'conclass' => 'depend',
        'controls' => array('info' => true, 'delete' => true),
        'settings' => array("iprop" => "background-image", "sattr" => "css", "sprop" => "background-image", "depended" => "bimg", "disableval" => "none", "scope" => ".intabcon")
    ),
    'background-repeat' => array(
        'type' => 'select',
        'label' => lang('app.repeating'),
        'conclass' => 'depend bimg',
        'options' => array(lang('app.default') => "", lang('app.repeat') => "repeat", lang('app.repeat-x') => "repeat-x", lang('app.repeat-y') => "repeat-y", lang('app.dont-repeat') => "no-repeat"),
        'settings' => array("iprop" => "background-repeat", "sattr" => "val")
    ),
    'background-attachment' => array(
        'type' => 'select',
        'label' => lang('app.background-attachment'),
        'conclass' => 'depend bimg',
        'options' => array(lang('app.default') => "", lang('app.fixed') => "fixed", lang('app.scroll') => "scroll"),
        'settings' => array("iprop" => "background-attachment", "sattr" => "val")
    ),
    'background-position' => array(
        'type' => 'connected_inputs',
        'label' => lang('app.background-position'), 'conclass' => 'depend bimg',
        'units' => array('%' => array('step' => '1', 'max' => '100'), 'px' => array('step' => '1', 'max' => '')),
        'settings' => array(
            'inputs' => array(
                array("label" => lang('app.x-axis'), "iprop" => "background-position-x", "sattr" => "val"),
                array("label" => lang('app.y-axis'), "iprop" => "background-position-y", "sattr" => "val")
            ),
            'connect' => array("special" => "valcon1")
        )
    ),
    'background-size' => array(
        'type' => 'select',
        'label' => lang('app.background-size'),
        'conclass' => 'depend bimg',
        'options' => array(lang('app.default') => "", lang('app.contain') => "contain", lang('app.cover') => "cover"),
        'settings' => array("iprop" => "background-size", "sattr" => "val")
    ),

    'gradient-color1' => array(
        'type' => 'color',
        'label' => lang('app.color'),
        'id' => 'fcol',
        'settings' => array("iprop" => "background-image", "sattr" => "css", "sprop" => "background-color", "special" => "gradient")
    ),
    'gradient-loc1' => array(
        'type' => 'slider_input', 'label' => lang('app.location'), 'id' => 'loc1',
        'units' => array('%' => array('step' => '1', 'max' => '100')),
        'settings' => array("special" => "gradient")
    ),
    'gradient-color2' => array(
        'type' => 'color',
        'label' => lang('app.second-color'),
        'id' => 'scol',
        'settings' => array("special" => "gradient"),
    ),
    'gradient-loc2' => array(
        'type' => 'slider_input',
        'label' => lang('app.location'),
        'id' => 'loc2',
        'units' => array('%' => array('step' => '1', 'max' => '100')),
        'settings' =>  array("special" => "gradient"),
    ),
    'gradient-type' => array(
        'type' => 'select',
        'label' => lang('app.type'),
        'id' => 'gtypes',
        'options' => array(lang('app.linear') => "linear-gradient", lang('app.radial') => "radial-gradient"),
        'settings' => array("dependedOpt" => "gtype", "special" => "gradient")
    ),
    'gradient-angle' => array(
        'type' => 'slider_input',
        'label' => lang('app.angle'),
        'conclass' => 'depend gtype linear-gradient',
        'id' => 'angl',
        'units' => array('%' => array('step' => '1', 'max' => '360')),
        'settings' => array("special" => "gradient")
    ),
    'gradient-loc3' => array(
        'type' => 'connected_inputs',
        'label' => lang('app.location'),
        'conclass' => 'depend gtype radial-gradient',
        'inputids' => array('xaxis', 'yaxis'),
        'units' => array(
            '%' => array('step' => '1', 'max' => '100'),
        ),
        'settings' => array(
            'inputs' => array(
                array("label" => lang('app.x-axis'), "special" => "gradient"),
                array("label" => lang('app.x-axis'), "special" => "gradient")
            ),
            'connect' => array("special" => "valcon1")
        )
    ),
    'opacity' => array(
        'type' => 'slider_input',
        'label' => lang('app.opacity'),
        'units' => array('' => array('step' => '0.01', 'max' => '1')),
        'settings' => array("sattr" => "val", "iprop" => "opacity")
    ),

    'border-radius' => array(
        'name' => 'border-radius',
        'type' => 'connected_inputs',
        'label' => lang('app.border-radius'),
        'conclass' => 'bradcon radius',
        'inputids' => array('t', 'b', 'l', 'r'),
        'settings' => array(
            'inputs' => array(
                array("label" => lang('app.top'), "special" => "border", "iprop" => "border-radius"),
                array("label" => lang('app.right'), "special" => "border", "iprop" => "border-radius"),
                array("label" => lang('app.bottom'), "special" => "border", "iprop" => "border-radius"),
                array("label" => lang('app.left'), "special" => "border", "iprop" => "border-radius")
            ),
            'connect' => array("special" => "valcon1")
        )
    ),
    'border-style' => array(
        'type' => 'select',
        'label' => lang('app.border-style'),
        'options' => array(lang('app.default') => "", lang('app.none') => "none", lang('app.solid') => "solid", lang('app.dotted') => "dotted", lang('app.dashed') => "dashed"),
        'settings' => array("iprop" => "border-style", "sattr" => "val", "dependedOpt" => "border-depend", 'scope' => '.intabcon1')
    ),
    'border-color' => array(
        'type' => 'color',
        'label' => lang('app.color'),
        'inlineconclass' => 'border-depend dotted solid dashed',
        'conclass' => 'border-depend dotted solid dashed',
        'settings' => array("iprop" => "border-color", "sattr" => "css", "sprop" => "background-color"),
    ),
    'border-width' => array(
        'type' => 'connected_inputs', 'label' => lang('app.border-width'),
        'units' => array(
            'px' => array('step' => '1', 'max' => ''),
        ),
        'conclass' => 'border-depend dotted solid dashed bradcon width',
        'inputids' => array('t', 'b', 'l', 'r'),
        'settings' => array(
            'inputs' => array(
                array("label" => lang('app.top'), "special" => "border", "iprop" => "border-width"),
                array("label" => lang('app.right'), "special" => "border", "iprop" => "border-width"),
                array("label" => lang('app.bottom'), "special" => "border", "iprop" => "border-width"),
                array("label" => lang('app.left'), "special" => "border", "iprop" => "border-width")

            ),
            'connect' => array("special" => "valcon1")
        )
    ),
    'border-width-bottom' => array(
        'type' => 'slider_input',
        'label' => lang('app.border-width'),
        'conclass' => 'border-depend dotted solid dashed',
        'units' => array('px' => array('step' => '1', 'max' => '20')),
        'settings' => array("sattr" => "val", "iprop" => "border-bottom-width")
    ),
    'border-width-top' => array(
        'type' => 'slider_input',
        'label' => lang('app.border-width'),
        'conclass' => 'border-depend dotted solid dashed',
        'units' => array('px' => array('step' => '1', 'max' => '20')),
        'settings' => array("sattr" => "val", "iprop" => "border-top-width")
    ),
    'image-src' => array(
        'type' => 'image',
        'label' => lang('app.image'),
        'conclass' => 'depend',
        'settings' =>  array("iattr" => "src", "sattr" => "css", "sprop" => "background-image", "depended" => "bimg")
    ),
    'image-width' => array(
        'type' => 'slider_input',
        'label' => lang('app.image-width'),
        'class' => 'img-width',
        'units' => array('px' => array('step' => '1', 'min' => '1', 'max' => '200')),
        'settings' => array('customGet' => 'image_params', 'customSet' => 'image_params', "ignoreLive" => '1', 'noFullChange' => '1')
    ),
    'thumb-width' => array(
        'type' => 'slider_input',
        'label' => lang('app.image-width'),
        'class' => 'img-width',
        'units' => array('px' => array('step' => '1', 'min' => '1', 'max' => '200')),
        'settings' => array("iattr" => "data-thumb", "sattr" => "val")
    ),
    'image-update' => array(
        'type' => 'button',
        'label' => 'update',
        'settings' => array('customGet' => 'ignore', 'customSet' => 'ignore')
    ),
    'icon' => array(
        'type' => 'icon',
        'label' => lang('app.icon'),
        'settings' =>  array("special" => "icon")
    ),
    'responsive-align-class' => array(
        'type' => 'select',
        'label' => lang('app.align'),
        'options' => array(lang('app.default') => "", lang('app.left') => '-left', lang('app.center') => '-center', lang('app.right') => '-right'),
        'settings' => array('prefix' => 'viewport', "sattr" => "val", "special" => "class")
    ),
    'responsive-align-class-full' => array(
        'type' => 'select',
        'label' => lang('app.align'),
        'options' => array(lang('app.default') => "", lang('app.left') => '-left', lang('app.center') => '-center', lang('app.right') => '-right', lang('app.justify') => '-justify'),
        'settings' => array('prefix' => 'viewport', "sattr" => "val", "special" => "class")
    ),
    'responsive-absolute-align' => array(
        'type' => 'select',
        'label' => lang('app.align'),
        'options' => array(lang('app.default') => "", lang('app.left') => '-ableft', lang('app.center') => '-abcenter', lang('app.right') => '-abright'),
        'settings' => array('prefix' => 'viewport', "sattr" => "val", "special" => "class")
    ),
    'responsive-justify-self' => array(
        'type' => 'select',
        'label' => lang('app.align'),
        'options' => array(lang('app.default') => "", lang('app.left') => '', lang('app.center') => '-js-center', lang('app.right') => '-js-right'),
        'settings' => array('prefix' => 'viewport', "sattr" => "val", "special" => "class")
    ),
    'video-aspect-ratio' => array(
        'type' => 'select',
        'label' => lang('app.aspect-ratio'),
        'options' => array("16:9" => "", "1:1" => "100%", "4:3" => "75%", "1.85:1" => "54.05%", "2:1" => "50%", "2.39:1" => "41.84%"),
        'settings' => array("iprop" => "padding-bottom", "sattr" => "val")
    ),
    'text-by-input' => array(
        'type' => 'input',
        'label' => lang('app.text'),
        'settings' => array("iattr" => "text", "sattr" => "val")
    ),
    'attr-by-input' => array(
        'type' => 'input',
        'label' => lang('app.value'),
        'settings' => array("sattr" => "val"),
    ),
    'val-by-input' => array(
        'type' => 'input',
        'label' => lang('app.value'),
        'settings' => array("iattr" => "val", "sattr" => "val"),
    ),
    'select-options-by-textarea' => array(
        'type' => 'textarea',
        'label' => lang('app.options'),
        'settings' => array('selector' => '.inpc', "iattr" => "options", "sattr" => "val"),
    ),
    'class-by-select' => array(
        'type' => 'select',
        'settings' => array("sattr" => "val", "special" => "class")
    ),
    'attr-by-select' => array(
        'type' => 'select',
        'settings' => array("sattr" => "val")
    ),
    'class-by-checkbox' => array(
        'type' => 'checkbox',
        'off' => '',
        'on' => '',
        'settings' => array("sattr" => "val", "special" => "class")
    ),
    'attr-by-checkbox' => array(
        'type' => 'checkbox',
        'off' => '',
        'on' => '',
        'settings' => array("sattr" => "check")
    ),
    'html-by-tiny' => array(
        'type' => 'tinymce',
        'class' => 'unselectable',
        'settings' => array('selector' => '.inpc', "iattr" => "tinyhtml", "sattr" => "val"),
    ),
    'codemirror' => array(
        'type' => 'textarea',
        'label' => '',
        'id' => 'code',
        'class' => 'init',
        'conclass' => 'full-width',
        'settings' => array("sattr" => "code", 'iattr' => 'html'),
    ),
    'html-by-textarea' => array(
        'type' => 'textarea',
        'label' => lang('app.text'),
        'settings' => array('selector' => '.inpc', "iattr" => "html", "sattr" => "val"),
    ),
    'brhtml-by-textarea' => array(
        'type' => 'textarea',
        'label' => lang('app.text'),
        'settings' => array('selector' => '.inpc', "iattr" => "brhtml", "sattr" => "val"),
    ),
    'code-highlight' => array(
        'type' => 'codeHighlight',
        'label' => lang('app.text'),
        'settings' => array("iattr" => "html", "sattr" => "val"),
    ),
    'text-by-textarea' => array(
        'type' => 'textarea',
        'label' => lang('app.text'),
        'conclass' => 'full-width',
        'settings' => array('selector' => '.inpc', "iattr" => "text", "sattr" => "val"),
    ),
    'custom-select' => array(
        'type' => 'select',
        'settings' => array('customGet' => 'ignore', 'customSet' => 'ignore')
    ),
    'custom-input' => array(
        'type' => 'input',
        'settings' => array('customGet' => 'ignore', 'customSet' => 'ignore')
    ),
    'hidden-input' => array(
        'type' => 'input',
        'hidden' => true,
        'settings' => array()
    ),
    'custom-button' => array(
        'type' => 'button',
        'settings' => array('customGet' => 'ignore', 'customSet' => 'ignore')
    ),
    'custom-slider' => array(
        'type' => 'slider_input',
        'settings' => array()
    ),
    'custom-checkbox' => array(
        'type' => 'checkbox',
        'on' => '1',
        'off' => '0',
        'settings' => array('customGet' => 'ignore', 'customSet' => 'ignore')
    ),
    'default-textarea' => array(
        'type' => 'textarea',
        'label' => lang('app.text'),
        'settings' => array("sattr" => "val"),
    ),
    'default-checkbox' => array(
        'type' => 'checkbox',
        'on' => '1',
        'off' => '0',
        'settings' => array()
    ),
    'default-input' => array(
        'type' => 'input',
        'settings' => array()
    ),
    'default-select' => array(
        'type' => 'select',
        'settings' => array()
    ),
    'default-slider' => array(
        'type' => 'slider_input',
        'settings' => array()
    ),
    'default-color' => array(
        'type' => 'color',
        'label' => lang('app.color'),
        'settings' => array("sattr" => "css", "sprop" => "background-color"),
    ),
    'color-palette' => array(
        'type' => 'color_palette',
        'settings' => array()
    ),
    '(typography)' => array('quick-select', 'text-color', 'font-family', 'font-size', 'font-weight', '[advanced]' => array('label' => lang('app.advanced')), 'font-style', 'text-transform', 'text-decoration', 'letter-spacing', 'line-height', '[/advanced]'),
    '(standard-background)' => array('background-color', 'background-image', 'background-repeat', 'background-attachment', 'background-position', 'background-size'),
    '(gradient-background)' => array('gradient-color1', 'gradient-loc1', 'gradient-color2', 'gradient-loc2', 'gradient-type', 'gradient-angle', 'gradient-loc3'),
    //'(image-modify)' => array('[advanced]'=>array('label'=>lang('app.modify-image'),'class'=>'bordered depend bimg'),'image-width','image-quality','enable-transparent','[/advanced]'),
    '{visibility}' => array(
        array('[intab1]', 'label' => lang('app.viewport-visibility')), array('class-by-checkbox', 'label' => lang('app.hide-lg'), "on" => 'lg-hide'),
        array('class-by-checkbox', 'label' => lang('app.hide-md'), "on" => 'md-hide'),
        array('class-by-checkbox', 'label' => lang('app.hide-sm'), "on" => 'sm-hide'),
        array('class-by-checkbox', 'label' => lang('app.hide-xs'), "on" => 'xs-hide'),
        array('class-by-checkbox', 'label' => lang('app.preview-hidden'), "on" => 'show-hidden', 'settings' => array('outsideSelector' => '[frame]body'))
    ),

    '{position}' => array(
        array('[intab1]', 'label' => lang('app.position')),
        array('class-by-select', 'label' => lang('app.position'), 'options' => array(lang('app.default') => '', lang('app.inline') => '-inline', lang('app.block') => '-block'), 'settings' => array('prefix' => 'viewport', "dependedOpt" => 'position', 'scope' => '.intabcon1')),
        array('[dependcon]', 'class' => 'position -inline'),
        array('width-slider', 'units' => $units['p100px1440'], 'label' => lang('app.width')),
        array('align-self'),
        //  array('responsive-justify-self',"class"=>"altcons",'id'=>'rjs'),

        array('margin-left', 'units' => $units['p100px1440']),
        //  array('[altcon]','class'=>'rjs notEmpty'),
        // array('hidden-input','value'=>'','settings'=>array('iprop'=>'margin-left','sattr'=>'val')),
        // array('[/altcon]'),
        array('[/dependcon]'),
    ),
    '{shadow}' => array(
        array('[intab1]', 'label' => lang('app.box-shadow')),
        array('default-select', 'class' => 'altcons bsht', 'id' => 'box-shadow', 'options' => array(lang('app.default') => "default", lang('app.none') => "none", lang('app.inside') => "inside", lang('app.outside') => "outside"), 'settings' => array('special' => 'shadow')),
        array('[altcon]', 'class' => 'box-shadow inside outside'),
        array('default-slider', 'label' => lang('app.horizontal'), 'class' => 'bsh', 'units' => array('px' => array('min' => '-100', 'step' => '1', 'max' => '100')), 'settings' => array('special' => 'shadow', 'selector' => '{selector}')),
        array('default-slider', 'label' => lang('app.vertical'), 'class' => 'bsh', 'units' => array('px' => array('min' => '-100', 'step' => '1', 'max' => '100')), 'settings' => array('special' => 'shadow', 'selector' => '{selector}')),
        array('default-slider', 'label' => lang('app.blur'), 'class' => 'bsh', 'units' => array('px' => array('min' => '0', 'step' => '1', 'max' => '200')), 'settings' => array('special' => 'shadow', 'selector' => '{selector}')),
        array('default-slider', 'label' => lang('app.spread'), 'class' => 'bsh', 'units' => array('px' => array('min' => '0', 'step' => '1', 'max' => '200')), 'settings' => array('special' => 'shadow', 'selector' => '{selector}')),
        array('default-color', 'class' => 'bshc', 'hidehover' => '{hidehover}', 'settings' => array('special' => 'shadow', 'selector' => '{selector}')),
        array('[/altcon]'),
    ),
    '{animation}' => array(
        array('[intab1]', 'label' => lang('app.animation')),
        array('default-select', 'label' => lang('app.onshow-animation'), 'class' => 'altcons animation-enable', 'id' => 'animation', 'options' => array(lang('app.default') => "", lang('app.none') => "-animate-none", lang('app.animate') => "-animate"), 'settings' => array('special' => 'class', 'prefix' => 'viewport', 'selector' => '{selector}')),
        array('[altcon]', 'class' => 'animation -animate'),
        array(
            'default-select', 'class' => 'animation-preview animation-type', 'label' => lang('app.animation'),
            'options' => array("fadeIn" => "fadeIn", "fadeInDown" => "fadeInDown", "fadeInDownBig" => "fadeInDownBig", "fadeInLeft" => "fadeInLeft", "fadeInLeftBig" => "fadeInLeftBig", "fadeInRight" => "fadeInRight", "fadeInRightBig" => "fadeInRightBig", "fadeInUp" => "fadeInUp", "fadeInUpBig" => "fadeInUpBig", "slideInUp" => "slideInUp", "slideInDown" => "slideInDown", "slideInLeft" => "slideInLeft", "slideInRight" => "slideInRight", "zoomIn" => "zoomIn", "zoomInDown" => "zoomInDown", "zoomInLeft" => "zoomInLeft", "zoomInRight" => "zoomInRight", "zoomInUp" => "zoomInUp", "flip" => "flip", "flipInX" => "flipInX", "flipInY" => "flipInY", "rotateIn" => "rotateIn", "rotateInDownLeft" => "rotateInDownLeft", "rotateInDownRight" => "rotateInDownRight", "rotateInUpLeft" => "rotateInUpLeft", "rotateInUpRight" => "rotateInUpRight", "bounceInDown" => "bounceInDown", "bounceInLeft" => "bounceInLeft", "bounceInRight" => "bounceInRight", "bounceInUp" => "bounceInUp", "lightSpeedIn" => "lightSpeedIn", "hinge" => "hinge", "jackInTheBox" => "jackInTheBox", "rollIn" => "rollIn", "bounce" => "bounce", "flash" => "flash", "pulse" => "pulse", "rubberBand" => "rubberBand", "shake" => "shake", "swing" => "swing", "tada" => "tada", "wobble" => "wobble", "jello" => "jello", "heartBeat" => "heartBeat"),
            'settings' => array("iprop" => "--animation-name", "variableprop" => 'true', "sattr" => "val", 'selector' => '{selector}')
        ),
        array('default-slider', 'label' => lang('app.duration'), 'class' => 'animation-preview', 'units' => array('s' => array('min' => '0.1', 'step' => '0.1', 'max' => '10')), 'settings' => array('iprop' => 'animation-duration', 'sattr' => 'val', 'selector' => '{selector}')),
        array('default-slider', 'label' => lang('app.delay'), 'class' => 'animation-preview', 'units' => array('s' => array('min' => '0', 'step' => '0.1', 'max' => '10')), 'settings' => array('iprop' => 'animation-delay', 'sattr' => 'val', 'selector' => '{selector}')),
        array('[/altcon]'),
        array('[altcon]', 'class' => 'animation -animate-none'),
        array('hidden-input', 'value' => 'none', 'settings' => array('customGet' => 'ignore', 'selector' => '{selector}', "iprop" => "--animation-name", "sattr" => "val")),
        array('[/altcon]'),
    ),
    '{scroll}' => array(
        array('default-select', 'label' => lang('app.background-scroll'), 'class' => 'altcons', 'id' => 'scroll', 'options' => array(lang('app.default') => "", lang('app.none') => "-scroll-none", lang('app.scroll') => "-scroll"), 'settings' => array('special' => 'class', 'prefix' => 'viewport', 'selector' => '{selector}')),

        array('[altcon]', 'class' => 'scroll -scroll'),
        array('default-slider', 'label' => lang('app.speed'), 'units' => array('' => array('min' => '1', 'step' => '1', 'max' => '9')), 'settings' => array('iprop' => '--scroll-speed', "variableprop" => 'true', 'sattr' => 'val', 'selector' => '{selector}')),
        array('[/altcon]'),

        array('[altcon]', 'class' => 'scroll -scroll-none'),
        array('hidden-input', 'value' => 'none', 'settings' => array('customGet' => 'ignore', 'selector' => '{selector}', "iprop" => "--scroll-speed", "sattr" => "val")),
        array('hidden-input', 'value' => '', 'settings' => array('customGet' => 'ignore', 'selector' => '{selector}', "inlineProp" => "background-position-y", "sattr" => "val")),
        array('[/altcon]'),
        array('[altcon]', 'class' => 'scroll onEmpty'),
        array('hidden-input', 'value' => '', 'settings' => array('customGet' => 'ignore', 'selector' => '{selector}', "iprop" => "--scroll-speed", "sattr" => "val")),
        array('hidden-input', 'value' => '', 'settings' => array('customGet' => 'ignore', 'selector' => '{selector}', "inlineProp" => "background-position-y", "sattr" => "val")),
        array('[/altcon]'),
    ),
    '{stretch}' => array(
        array('class-by-select', 'conclass' => 'full-width', 'class' => 'bg-stretch', 'label' => lang('app.stretch-background'), 'options' => array(lang('app.default') => "", lang('app.stretch') => "-stretch", lang('app.unstretch') => "-no-stretch"), 'settings' => array('prefix' => 'viewport', 'selector' => '{selector}')),
        array('[desc-label]', 'label' => lang('app.stretch-background-desc')),
    ),
    '{anchor}' => array(
        array('[intab1]', 'label' => lang('app.anchor')),
        array('attr-by-input', 'label' => lang('app.name'), 'class' => 'altcons', "id" => 'anchor', 'settings' => array('iattr' => 'id', 'selector' => '{selector}')),
        array('[altcon]', 'class' => 'notEmpty anchor'),
        array('[desc-label]', 'label' => lang('app.add-hash-for-link')),
        array('custom-slider', 'label' => lang('app.sections-included'), 'class' => 'section-include', 'units' => array('' => array('step' => '1', 'max' => '10', 'min' => '1')), 'settings' => array('iattr' => 'data-include', 'sattr' => 'val', 'selector' => '{selector}')),
        array('default-slider', 'label' => lang('app.offset'), 'class' => 'anchor-offset', 'units' => array('px' => array('min' => '-200', 'step' => '1', 'max' => '200')), 'settings' => array('iprop' => 'top', 'sattr' => 'val', 'selector' => '{selector}')),
        array('[/altcon]'),
    ),

    '{full-background}' => array(
        array('background-type', 'options' => array(lang('app.default') => "", lang('app.none') => "-{class-prefix}n", lang('app.standard') => "-{class-prefix}s", lang('app.gradient') => "-{class-prefix}g"), 'settings' => array('prefix' => 'viewport')),
        array('[altcon]', 'class' => 'altg1 -{class-prefix}s'),
        array('(standard-background)', 'settings' => array('selector' => '{selector}')),
        array('[/altcon]'),
        array('[altcon]', 'class' => 'altg1 -{class-prefix}g'),
        array('(gradient-background)', 'hidehover' => 'true', 'settings' => array('selector' => '{selector}')),
        array('[/altcon]'),
        array('[altcon]', 'class' => 'altg1 -{class-prefix}n'),
        array('hidden-input', 'value' => 'none', 'settings' => array('customGet' => 'ignore', 'selector' => '{selector}', "iprop" => "background-image", "sattr" => "val")),
        array('hidden-input', 'value' => 'transparent', 'settings' => array('customGet' => 'ignore', 'selector' => '{selector}', "iprop" => "background-color", "sattr" => "val")),
        array('[/altcon]'),
        array('[altcon]', 'class' => 'altg1 onEmpty'),
        array('hidden-input', 'value' => '', 'settings' => array('customGet' => 'ignore', 'selector' => '{selector}', "iprop" => "background-image", "sattr" => "val")),
        array('hidden-input', 'value' => '', 'settings' => array('customGet' => 'ignore', 'selector' => '{selector}', "iprop" => "background-color", "sattr" => "val")),
        array('[/altcon]'),
    ),
    '{column-spacing}' => array(
        array(
            'padding-left', 'units' => '{units}', 'label' => lang('app.column-spacing'),
            'settings' => array('selector' => '{column}', 'clonecss' => array('selector' => '{row}', "iprop" => "margin-left", 'action' => 'oposite'))
        )
    ),
    '{row-spacing}' => array(
        array(
            'padding-bottom', 'units' => '{units}', 'label' => lang('app.row-spacing'),
            'settings' => array('selector' => '{column}', 'clonecss' => array('selector' => '{row}', "iprop" => "margin-bottom", 'action' => 'oposite'))
        )
    ),

    '(border)' => array('border-style', 'border-color', 'border-width'),
    '(border-bottom)' => array('border-style', 'border-color', 'border-width-bottom'),
    '(border-top)' => array('border-style', 'border-color', 'border-width-top'),



);
