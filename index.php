<?php
/**
 * Plugin Name:       FSD Happy Hour
 * Plugin URI:        https://fullstackdigital.io
 * Description:       A starter for plugin development on wordpress
 * Version:           1.0.0
 * Requires at least: 5.9
 * Requires PHP:      7.2
 * Author:            Full Stack Digital
 * Author URI:        https://fullstackdigital.io
 * Text Domain:       fsd-hh
 */

if(!function_exists('add_action')) {
  echo 'Seems like you stumbled here by accident. 😛';
  exit;
}

// Setup
define('FSDHH_DIR', plugin_dir_path(__FILE__));
define('FSDHH_FILE', __FILE__);

// Includes
$rootFiles = glob(FSDHH_DIR . 'includes/*.php');
$subdirectoryFiles = glob(FSDHH_DIR . 'includes/**/*.php');
$allFiles = array_merge($rootFiles, $subdirectoryFiles);

foreach($allFiles as $filename) {
  include_once($filename);
}

// Hooks
add_action('init', 'fsdhh_register_assets');
add_action('init', 'fsdhh_register_blocks');
add_action('init', 'fsdhh_happy_hour_post_type');
add_action('admin_menu', 'fsdhh_register_my_api_keys_page');


// Register Blocks
function fsdhh_register_blocks(){
  register_block_type( FSDHH_DIR . '/build/blocks/happy-hour', array(
    'render_callback' => 'fsdhh_happy_hour_render'
  ) );
}

// API Endpoint

add_action('rest_api_init', function () {
  register_rest_route( 'fsdhh/v1', '/fetch-google-data', array(
      'methods' => 'POST',
      'callback' => 'fetch_google_place_data',
      'permission_callback' => '__return_true'
  ));
});

