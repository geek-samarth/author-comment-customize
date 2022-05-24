<?php
/**
* Plugin Name: Author Comment Customize
* Plugin URI: http://geekcodelab.com/
* Description: Helps you to customize author comments.
* Version: 1.0
* Author: Geek Code Lab
* Author URI: http://geekcodelab.com/
* Text Domain: author-comment-customize
*/

if (!defined('ABSPATH')) exit;

define( 'GCLACC_BUILD', 1.0 );

if (!defined( 'GCLACC_PLUGIN_DIR_PATH' ))
	define( 'GCLACC_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__) );

if (!defined( 'GCLACC_PLUGIN_URL' ))
	define( 'GCLACC_PLUGIN_URL', plugins_url() . '/' . basename(dirname(__FILE__)) );

$plugin = plugin_basename(__FILE__);
add_filter( "plugin_action_links_$plugin", 'gclacc_add_plugin_settings_link');
function gclacc_add_plugin_settings_link( $links ) {
	$support_link = '<a href="https://geekcodelab.com/contact/" target="_blank" >' . __( 'Support', 'author-comment-customize' ) . '</a>'; 
	array_unshift( $links, $support_link );
	
	$setting_link = '<a href="'. admin_url('admin.php?page=gclacc') .'">' . __( 'Settings', 'author-comment-customize' ) . '</a>'; 
	array_unshift( $links, $setting_link );

	return $links;
}

require_once( GCLACC_PLUGIN_DIR_PATH . 'inc/class-gclacc-helper.php');
require_once( GCLACC_PLUGIN_DIR_PATH . 'inc/class-author-comment-customize.php');
require_once( GCLACC_PLUGIN_DIR_PATH . 'inc/class-social-icons.php');
// require_once( GCLACC_PLUGIN_DIR_PATH . 'functions.php');
require_once( GCLACC_PLUGIN_DIR_PATH . 'inc/class-admin-settings.php' );
require_once( GCLACC_PLUGIN_DIR_PATH . 'inc/class-user-settings.php' );
require_once( GCLACC_PLUGIN_DIR_PATH . '/customizer/customizer-library/customizer-library.php' );
require_once( GCLACC_PLUGIN_DIR_PATH . '/customizer/styles.php' );