<?php

/*
  Plugin Name: AlT Stick It
  Version: 2.1.0
  Plugin URI: http://wordpress.lived.fr/plugins/alt-stick-it/
  Description: Make a sticky menu effect of any part on your website !
  Author: AlTi5
  Author URI: http://wordpress.lived.fr/AlTi5
 */

if (!class_exists('alt-stick-it')) {

    class who_stick_it {

        public static function hooks() {
            add_action('plugins_loaded', array(__CLASS__, 'constants'));
            add_action('plugins_loaded', array(__CLASS__, 'includes'));
            if (is_admin()) {
                add_action('admin_menu', array(__CLASS__, 'add_settings_panels'));
                add_action('save_post', array(__CLASS__, 'save_post'));
            } 
                add_action('wp_enqueue_scripts', array(__CLASS__, 'altstickit_enqueue_scripts'));
            
        }

        public static function altstickit_enqueue_scripts() {
            wp_enqueue_script('altstickit', ALTSTICKIT_ASSETS . 'sticky.js', ALTSTICKIT_VERSION);
        }

        public static function add_settings_panels() {
            global $tblbords_option;
            add_submenu_page(
                    'options-general.php', __('AlT Stick it'), __('AlT Stick it'), 'administrator', 'alt-stick-it', array(__CLASS__, 'tblbords')
            );
        }

        public static function constants() {
            define('ALTSTICKIT_VERSION', '2.1.0');
            define('ALTSTICKIT_DIR', trailingslashit(plugin_dir_path(__FILE__)));
            define('ALTSTICKIT_URI', trailingslashit(plugin_dir_url(__FILE__)));
            define('ALTSTICKIT_INCLUDES', ALTSTICKIT_DIR . trailingslashit('includes'));
            define('ALTSTICKIT_ASSETS', ALTSTICKIT_URI . trailingslashit('assets'));
        }

        public static function tblbords() {
            global $tblbords_option;
            require_once 'template/tblbords.php';
        }

        public static function includes() {
            require_once( ALTSTICKIT_INCLUDES . 'functions.php' );
        }

        private static function set_option($option, $value) {
            if (get_option($option) !== FALSE) {
                update_option($option, $value);
            } else {
                add_option($option, $value, '', 'no');
            }
        }

        public static function save_post($post_id) {
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
                return $post_id;
            if (isset($_POST['post_type'])) {
                if ('distributeurs' != $_POST['post_type'] || !current_user_can('edit_post', $post_id)) {
                    return $post_id;
                }
            }
            if ($parent_post_id = wp_is_post_revision($post_id)) {
                $post_id = $parent_post_id;
            }
        }

    }

    who_stick_it::hooks();
}

