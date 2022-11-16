<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Privileges extends BaseConfig
{

    public $roles = [

        'guest' => [
            'demologin',
            'register',
            'resetPassword'
        ],

        'package_1' => [ //_package id 

        ],

        'user_demo' => [
            'site_preview',
            'site_edit',
            'site_delete',
            'site_add',
            'site_export',
            'section_export',
            'site_info' => ['space', 'status', 'package', 'expire'],
            'subscription_manage',
            'package_change',
            'domain_manage',
            'mailbox_view',
            'mailbox_add',
            'mailbox_change',
            'mailbox_delete',
            'widgets_allowed' => ['block', 'column', 'slider', 'col', 'container', 'menu', 'title', 'paragraph', 'divider', 'button', 'cform-custom', 'img', 'icon', 'iconlist', 'iconbox', 'imagebox', 'video', 'gallery', 'carousel', 'map', 'accordion', 'social-buttons', 'custom-code'],
            'tools_allowed' => ['sections', 'templates', 'media', 'pages', 'settings', 'design', 'globals'],
        ],

        'autoUser' => [ //default role for hosting provider mode
            'site_preview',
            'site_edit',
            'site_delete',
            'site_add',
            'site_export',
            'section_export',
            'site_info' => ['space', 'status', 'package', 'expire'],
            'subscription_manage',
            'package_change',
            'domain_manage',
            'profile_edit',
            'widgets_allowed' => ['block', 'column', 'slider', 'col', 'container', 'menu', 'title', 'paragraph', 'divider', 'button', 'cform-custom', 'img', 'icon', 'iconlist', 'iconbox', 'imagebox', 'video', 'gallery', 'carousel', 'map', 'accordion', 'social-buttons', 'custom-code'],
            'tools_allowed' => ['sections', 'templates', 'media', 'pages', 'settings', 'design', 'globals'],
        ],

        'user' => [ //default role for new user
            'site_preview',
            'site_edit',
            'site_delete',
            'site_add',
            'site_export',
            'section_export',
            'site_info' => ['space', 'status', 'package', 'expire'],
            'subscription_manage',
            'package_change',
            'domain_manage',
            'mailbox_view',
            'mailbox_add',
            'mailbox_change',
            'mailbox_delete',
            'profile_edit',
            'widgets_allowed' => ['block', 'column', 'slider', 'col', 'container', 'menu', 'title', 'paragraph', 'divider', 'button', 'cform', 'img', 'icon', 'iconlist', 'iconbox', 'imagebox', 'video', 'gallery', 'carousel', 'map', 'accordion', 'social-buttons', 'custom-code'],
            'tools_allowed' => ['sections', 'templates', 'media', 'pages', 'settings', 'design', 'globals'],
        ],

        'user_limited' => [
            'site_preview',
            'site_edit',
            'site_add',
            'site_info' => ['space', 'status', 'package', 'expire'],
            'profile_edit',
            'widgets_allowed' => ['menu', 'title', 'paragraph', 'divider', 'button', 'img', 'icon', 'iconlist', 'iconbox', 'imagebox', 'video'],
            'tools_allowed' => [],
        ],

        'admin' => [
            'site_preview',
            'site_edit',
            'site_delete',
            'site_add',
            'site_export',
            'section_export',
            'site_info' => ['space', 'status', 'package', 'expire'],
            'subscription_manage',
            'package_change',
            'domain_manage',
            'mailbox_view',
            'mailbox_add',
            'mailbox_change',
            'mailbox_delete',
            'profile_edit',
            'widgets_allowed' => ['block', 'column', 'slider', 'col', 'container', 'menu', 'title', 'paragraph', 'divider', 'button', 'cform-custom', 'img', 'icon', 'iconlist', 'iconbox', 'imagebox', 'video', 'gallery', 'carousel', 'map', 'accordion', 'social-buttons', 'custom-code', 'dynamic-widget'],
            'tools_allowed' => ['sections', 'templates', 'media', 'pages', 'settings', 'design', 'globals'],
            'admin_info' => ['system', 'stat_new-users', 'stat_new-sites', 'stat_income-statistics'],
            'admin_templates' => ['view', 'status', 'delete', 'translate', 'edit', 'add_new', 'builder_templates'],
            'admin_pricing_manage',
            'admin_users' => ['view', 'manage', 'login', 'manage_admins'],
            'admin_sites_manage',
        ],

        'admin_limited' => [
            'site_preview',
            'site_edit',
            'site_delete',
            'site_add',
            'site_export',
            'section_export',
            'site_info' => ['space', 'status', 'package', 'expire'],
            'subscription_manage',
            'package_change',
            'domain_manage',
            'mailbox_view',
            'mailbox_add',
            'mailbox_change',
            'mailbox_delete',
            'profile_edit',
            'widgets_allowed' => ['block', 'column', 'slider', 'col', 'container', 'menu', 'title', 'paragraph', 'divider', 'button', 'cform-custom', 'img', 'icon', 'iconlist', 'iconbox', 'imagebox', 'video', 'gallery', 'carousel', 'map', 'accordion', 'social-buttons', 'custom-code'],
            'tools_allowed' => ['sections', 'templates', 'media', 'pages', 'settings', 'design', 'globals'],
            'admin_info' => ['stat_new-users', 'stat_new-sites'],
            'admin_templates' => ['view', 'status', 'delete', 'translate', 'edit', 'add_new'],
            'admin_users' => ['view', 'manage', 'login'],
            'admin_sites_manage',
        ],

        'designer' => [
            'site_preview',
            'site_edit',
            'site_delete',
            'site_add',
            'site_export',
            'section_export',
            'site_info' => ['space', 'status', 'package', 'expire'],
            'subscription_manage',
            'package_change',
            'domain_manage',
            'mailbox_view',
            'mailbox_add',
            'mailbox_change',
            'mailbox_delete',
            'profile_edit',
            'widgets_allowed' => ['block', 'column', 'slider', 'col', 'container', 'menu', 'title', 'paragraph', 'divider', 'button', 'cform-custom', 'img', 'icon', 'iconlist', 'iconbox', 'imagebox', 'video', 'gallery', 'carousel', 'map', 'accordion', 'social-buttons', 'custom-code'],
            'tools_allowed' => ['sections', 'templates', 'media', 'pages', 'settings', 'design', 'globals'],

        ],

        'designer_limited' => [
            'site_preview',
            'site_edit',
            'profile_edit',
            'widgets_allowed' => ['block', 'column', 'slider', 'col', 'container', 'menu', 'title', 'paragraph', 'divider', 'button', 'cform-custom', 'img', 'icon', 'iconlist', 'iconbox', 'imagebox', 'video', 'gallery', 'carousel', 'map', 'accordion', 'social-buttons', 'custom-code'],
            'tools_allowed' => ['sections', 'templates', 'media', 'pages', 'settings', 'design', 'globals'],
        ]

    ];
}
