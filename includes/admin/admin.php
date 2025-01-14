<?php

if (!defined('ABSPATH')) {
  exit;
}

function multistepFormAddAdminMenu()
{
  add_menu_page(
    'Multistep Form Settings',
    'Multistep Form',
    'manage_options',
    'multistep-form',
    'multistepFormSettingsPage',
    'dashicons-forms'
  );
}

add_action('admin_menu', 'multistepFormAddAdminMenu');

function multistepFormRegisterSettings()
{
  register_setting('multistep_form_settings', 'multistep_form_steps');
  register_setting('multistep_form_settings', 'multistep_form_email');
}

add_action('admin_init', 'multistepFormRegisterSettings');

function multistepFormSettingsPage()
{
  include plugin_dir_path(__FILE__) . '../templates/admin-form.php';
}

function multistepFormAdminEnqueue($hook_suffix)
{
  if ($hook_suffix === 'toplevel_page_multistep-form') {
    wp_enqueue_style('multistep-admin-style', plugin_dir_url(__FILE__) . '../../assets/css/adminStyle.css');
    wp_enqueue_script('bootstrap-script', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js', array(), null, true);
    wp_enqueue_style('bootstrap-style', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css');
    wp_add_inline_script('bootstrap-script', '
            const tooltipTriggerList = document.querySelectorAll("[data-bs-toggle=\'tooltip\']");
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
        ');
  }
}

add_action('admin_enqueue_scripts', 'multistepFormAdminEnqueue');