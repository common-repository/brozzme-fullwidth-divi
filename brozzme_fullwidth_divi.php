<?php
/*
Plugin Name: Brozzme Fullwidth and Automatic Layout in Divi
Plugin URI: https://brozzme.com/
Description: Fullwidth page made easy with Divi theme, save all your new content without worry of this, update in one click all your content, your layout type choices are apply everytime.
Version: 1.1
Author: Benoti
Author URI: https://brozzme.com

*/

class brozzme_fullwidth_divi{
    
    public function __construct()
    {
        // Define plugin constants
        $this->basename			 = plugin_basename( __FILE__ );
        $this->directory_path    = plugin_dir_path( __FILE__ );
        $this->directory_url	 = plugins_url( dirname( $this->basename ) );

        // group menu ID
        $this->plugin_dev_group = 'Brozzme';
        $this->plugin_dev_group_id = 'brozzme-plugins';

        // plugin info
        $this->plugin_name = 'Brozzme Fullwidth and Automatic Layout in Divi';
        $this->settings_page_slug = 'brozzme-fullwidth-divi';
        $this->plugin_version = '1.0';
        $this->plugin_txt_domain = 'brozzme-fullwidth-divi';

        $this->_define_constants();

        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'desactivate'));
        register_uninstall_hook(__FILE__, array('brozzme_fullwidth_divi', 'uninstall'));

        $this->plugin_settings();

        add_action( 'plugins_loaded', array($this, 'bfd_load_textdomain') );

        add_filter( 'plugin_action_links_' . $this->basename, array( $this, 'add_action_links' ) );
        add_action( 'admin_enqueue_scripts', array( $this, '_add_settings_styles') );

    }

    public function _define_constants(){

        defined('BFSL_PLUGINS_DEV_GROUPE')    or define('BFSL_PLUGINS_DEV_GROUPE', $this->plugin_dev_group);
        defined('BFSL_PLUGINS_DEV_GROUPE_ID') or define('BFSL_PLUGINS_DEV_GROUPE_ID', $this->plugin_dev_group_id);
        defined('BFSL_PLUGINS_URL') or define('BFSL_PLUGINS_URL', $this->directory_url);
        defined('BFSL_PLUGINS_SLUG') or define('BFSL_PLUGINS_SLUG', $this->settings_page_slug);

        defined('B7EFD')    or define('B7EFD', $this->plugin_name);
        defined('B7EFD_BASENAME')    or define('B7EFD_BASENAME', $this->basename);
        defined('B7EFD_DIR')    or define('B7EFD_DIR', $this->directory_path);
        defined('B7EFD_DIR_URL')    or define('B7EFD_DIR_URL', $this->directory_url);
        defined('B7EFD_SETTINGS_SLUG')  or define('B7EFD_SETTINGS_SLUG', $this->settings_page_slug);
        defined('B7EFD_VERSION')        or define('B7EFD_VERSION', $this->plugin_version);
        defined('B7EFD_TEXT_DOMAIN')    or define('B7EFD_TEXT_DOMAIN', $this->plugin_txt_domain);

    }

    /**
     * Add plugin setting link to plugins page
     *
     * @param $links
     * @return array
     */
    public function add_action_links ($links ) {
        $mylinks = array(
            '<a href="' . admin_url('admin.php?page='.$this->settings_page_slug ) . '">' . __( 'Settings', $this->plugin_txt_domain ) . '</a>',
        );
        return array_merge( $links, $mylinks );
    }

    /**
     * include files for settings page & brozzme panel
     */
    public function plugin_settings(){
        if (is_admin() && !class_exists('brozzme_plugins_page')){
            include_once ($this->directory_path . 'includes/brozzme_plugins_page.php');
        }
        include_once $this->directory_path . 'includes/brozzme_fullwidth_divi_settings.php';
        include_once $this->directory_path . 'includes/brozzme_fullwidth_divi_core.php';
    }


    /**
     * load text domain
     */
    public function bfd_load_textdomain() {
        load_plugin_textdomain( $this->plugin_txt_domain, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    public function _add_settings_styles($hook){

        if($hook == 'brozzme_page_' . $this->settings_page_slug || $hook === 'toplevel_page_brozzme-plugins'){
            wp_enqueue_style( 'brozzme-fullwidth-divi', plugin_dir_url( __FILE__ ) . 'css/brozzme-admin-css.css');
        }

    }
    /**
     * activation sequence
     */
    public function activate(){
        if(!get_option('bfd_general_settings')){

            $options = array(
                'bfd_enable' => 'true',
                'bfd_layout_type' => 'et_full_width_page',
                'bfd_single_title' => 'on',
                'bfd_single_title_allow_overide' => 'false',
                'bfd_post_dot_nav' => 'off',
                'bfd_post_hide_nav' => 'default'
            );

            add_option('bfd_general_settings', $options);
        }
    }
    /**
     * desactivation sequence
     */
    public function desactivate(){
        // delete_option('bfd_general_settings');
    }
    /**
     * uninstall sequence
     */
    function uninstall(){
        delete_option('bfd_general_settings');
    }
}

new brozzme_fullwidth_divi();