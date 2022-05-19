<?php
/**
 * Our main plugin class
*/
if (!defined('ABSPATH')) exit;

if(!class_exists('Author_comment_customize')) {
    class Author_comment_customize
    {
        private $options;

        public function __construct() {
            add_action('wp_enqueue_scripts', array( $this,'gclacc_front_enqueue' ));
            add_action('admin_enqueue_scripts',array($this,'gclacc_admin_enqueue'));
        }

        static function gclacc_front_enqueue() {
            wp_enqueue_style( 'gclacc-front-style', GCLACC_PLUGIN_URL . '/assets/css/front-style.css' , '', GCLACC_BUILD );
        }

        static function gclacc_admin_enqueue($hook) {
            $gclacc_helper = array();
            $gclacc_helper["socialIcons"] = Gclacc_helper::$social_icons;

            if('toplevel_page_gclacc' == $hook){
                wp_enqueue_style( 'gclacc-admin-style', GCLACC_PLUGIN_URL . '/assets/css/admin-style.css' , array( 'wp-color-picker' ), GCLACC_BUILD );
                wp_enqueue_script('gclacc-admin-js', GCLACC_PLUGIN_URL . '/assets/js/admin-script.js' ,array( 'jquery', 'wp-color-picker' ),GCLACC_BUILD);

            } elseif ('profile.php' == $hook || 'user-edit.php' == $hook) {
                wp_enqueue_script('gclacc-editor', GCLACC_PLUGIN_URL . '/assets/js/gclascc-editor.js');
                wp_localize_script('gclacc-editor', 'GCLACC_helper', $gclacc_helper);
            }
        }
    }

    new Author_comment_customize();
}
