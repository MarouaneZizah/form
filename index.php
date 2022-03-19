<?php
/*
Plugin Name: Better Form Plugin
Plugin URI:
Description: Form Plugin
Author: MTT
Author URI: http://maarouanezizah.com
Version: 0.1
*/

error_reporting(1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once(plugin_dir_path(__FILE__).'/functions.php');

function add_form_menu()
{
    add_menu_page(__('Forms'), __('Forms'), 'edit_themes', 'form-list', 'form_list');

    add_submenu_page('form-list', __('New Form'), __('New Form'), 'edit_themes', 'form-editor', 'form_editor',);
}

function form_list()
{
    include plugin_dir_path(__FILE__).'list.php';
}

function form_editor()
{
    include plugin_dir_path(__FILE__).'form.php';
}

add_action('admin_menu', 'add_form_menu');