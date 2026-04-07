<?php

/*
Plugin Name: USM Notes
Description: Плагин для заметок
Version: 1.0
Author: Alina
*/

require_once plugin_dir_path(__FILE__) . 'includes/class-usm-notes-plugin.php';

function usm_notes_plugin_init()
{
    $usm_notes_plugin = new USM_Notes();
    $usm_notes_plugin->init();
}

add_action('plugins_loaded', 'usm_notes_plugin_init');