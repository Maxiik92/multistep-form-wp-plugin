<?php
/*
 * Plugin Name: Max - Multistep form
 * Description: Zadanie pre Vigeo Studio shortcode : multistep_form
 * Author: Tomáš Max
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly
}
//spracovanie settings formularu
require_once plugin_dir_path(__FILE__) . 'includes/admin/admin.php';
//spracovanie multistep formularu
require_once plugin_dir_path(__FILE__) . 'includes/multistep-form/form.php';
//logovanie
require_once plugin_dir_path(__FILE__) . 'includes/logger.php';

//pridanie potrebnych scriptov
function multistep_form_enqueue_scripts()
{
  //ak neobsahuje stranka shortcode neimplementuj scripty
  if (!has_shortcode(get_post_field('post_content', get_the_ID()), 'multistep_form')) {
    return;
  }
  //jquery potrebne pre dalsie scripty
  wp_enqueue_script('jquery');

  //bootstrap
  wp_enqueue_script('bootstrap-script', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js', array(), null, true);
  wp_enqueue_style('bootstrap-style', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css');

  //country select
  wp_enqueue_script('bootstrap_country_select-script', 'https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.1.1/js/countrySelect.min.js', array(), null, true);
  wp_enqueue_style('bootstrap_country_select-style', 'https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.1.1/css/countrySelect.min.css');
  wp_add_inline_script('bootstrap_country_select-script', '
            jQuery(document).ready(function($) {
              $("#country").countrySelect({
                defaultCountry: "sk",
                responsiveDropdown: true
              });
            });');

  //telephone input
  wp_enqueue_script('tel-input-script', plugin_dir_url(__FILE__) . 'assets/intl-tel-input/build/js/intlTelInputWithUtils.min.js', ['jquery'], null, true);
  wp_enqueue_style('tel-input-style', plugin_dir_url(__FILE__) . 'assets/intl-tel-input/build/css/intlTelInput.min.css');
  wp_add_inline_script('tel-input-script', '
            const input = document.querySelector("#phone_number");
            const iti = window.intlTelInput(input, {
              initialCountry: "sk",
              separateDialCode: true,
              utilsScript: "' . plugin_dir_url(__FILE__) . '/assets/intl-tel-input/build/js/utils.js"
            });
            window.iti = iti;
            ');

  //ikony
  wp_enqueue_style('FA-style', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css');

  //custom styles
  wp_enqueue_style('multistep-form-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');

  //custom js
  wp_enqueue_script('multistep-form-script', plugin_dir_url(__FILE__) . 'assets/js/main.js', [], null, true);
  //pridanie type="module" pre custom script
  add_filter('script_loader_tag', 'add_type_module_to_script', 10, 2);
  wp_localize_script('multistep-form-script', 'multistepFormAjax', array(
    'ajax_url' => admin_url('admin-ajax.php'),
    'ajax_action' => 'submit_multistep_form'
  ));
}

function add_type_module_to_script($tag, $handle)
{
  if ('multistep-form-script' === $handle) {
    return str_replace(' src', ' type="module" src', $tag);
  }
  return $tag;
}

add_action('wp_enqueue_scripts', 'multistep_form_enqueue_scripts');