<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 21/04/2017
 * Time: 20:28
 */
class brozzme_fullwidth_divi_settings
{

    public function __construct()
    {
        $this->options = get_option('bfd_general_settings');
        $this->tools_options = get_option('bfd_tools_settings');

        $this->settings_page_slug = B7EFD_SETTINGS_SLUG;
        $this->plugin_text_domain = B7EFD_TEXT_DOMAIN;
        $this->plugin_name = B7EFD;
        add_action('admin_init', array($this, '_settings_init'));
        add_action('admin_menu', array($this, '_add_admin_pages'), 110);

    }

    public function _add_admin_pages(){
        $page = add_submenu_page( BFSL_PLUGINS_DEV_GROUPE_ID,
            'Fullwidth Divi',
            'Fullwidth Divi',
            'manage_options',
            $this->settings_page_slug,
            array( $this, '_settings_page')
        );
    }

    public function _settings_page(){

        ?>
        <div class="wrap">

            <h2><?php echo $this->plugin_name; ?></h2>
            <?php

            $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general_settings';
            ?>

            <h2 class="nav-tab-wrapper">
                <a href="?page=<?php echo $this->settings_page_slug; ?>&tab=general_settings" class="nav-tab <?php echo $active_tab == 'general_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'General settings', $this->plugin_text_domain);?></a>
                <a href="?page=<?php echo $this->settings_page_slug; ?>&tab=tools_settings" class="nav-tab <?php echo $active_tab == 'tools_settings' ? 'nav-tab-active' : ''; ?>"><?php _e( 'Tools settings', $this->plugin_text_domain);?></a>
                <a href="?page=<?php echo $this->settings_page_slug; ?>&tab=help_options" class="nav-tab <?php echo $active_tab == 'help_options' ? 'nav-tab-active' : ''; ?>">Help</a>
            </h2>
            <form id="brozzme-theme-panel-form" action='options.php' method='post'>
                <?php
                if( $active_tab == 'help_options' ) {
                    settings_fields('B7EFDHelp');
                    do_settings_sections('B7EFDHelp');
                }
                elseif( $active_tab == 'tools_settings' ) {
                    settings_fields('B7EFDTools');
                    do_settings_sections('B7EFDTools');
                    submit_button();
                }
                else {
                    settings_fields('B7EFDSettings');
                    do_settings_sections('B7EFDSettings');
                    submit_button();
                }

                ?>

            </form>
        </div>
        <?php
    }
    public function _settings_init(){
        register_setting( 'B7EFDSettings', 'bfd_general_settings' );
        register_setting( 'B7EFDTools', 'bfd_tools_settings' );
        add_settings_section(
            'B7EFDSettings_section',
            __( 'General settings option ', $this->plugin_text_domain),
            array($this, 'bfd_general_settings_section_callback'),
            'B7EFDSettings'
        );
        /* General settings */
        add_settings_field(
            'bfd_enable',
            __( 'Enable Fullwidth Divi', $this->plugin_text_domain),
            array($this, 'bfd_enable_render'),
            'B7EFDSettings',
            'B7EFDSettings_section'
        );
        add_settings_field(
            'bfd_layout_type',
            __( 'Choose the layout', $this->plugin_text_domain),
            array($this, 'bfd_layout_type_render'),
            'B7EFDSettings',
            'B7EFDSettings_section'
        );
        if(brozzme_fullwidth_divi_core::is_woocommerce_activate() == true){
            add_settings_field(
                'bfd_layout_type_to_product',
                __( 'Apply layout type to Woocommerce product', $this->plugin_text_domain),
                array($this, 'bfd_layout_type_to_product_render'),
                'B7EFDSettings',
                'B7EFDSettings_section'
            );
        }
        add_settings_field(
            'bfd_single_title',
            __( 'Show title in layout', $this->plugin_text_domain),
            array($this, 'bfd_single_title_render'),
            'B7EFDSettings',
            'B7EFDSettings_section'
        );
        add_settings_field(
            'bfd_single_title_allow_overide',
            __( 'Allow overide from posts', $this->plugin_text_domain),
            array($this, 'bfd_single_title_allow_overide_render'),
            'B7EFDSettings',
            'B7EFDSettings_section'
        );
        add_settings_field(
            'bfd_post_dot_nav',
            __( 'Dot navigation', $this->plugin_text_domain),
            array($this, 'bfd_post_dot_nav_render'),
            'B7EFDSettings',
            'B7EFDSettings_section'
        );
        add_settings_field(
            'bfd_post_hide_nav',
            __( 'Hide navigation bar before scroll', $this->plugin_text_domain),
            array($this, 'bfd_post_hide_nav_render'),
            'B7EFDSettings',
            'B7EFDSettings_section'
        );
        add_settings_section(
            'B7EFDHelp_section',
            __( 'Help', $this->plugin_text_domain),
            array($this, 'bfd_help_section_callback'),
            'B7EFDHelp'
        );
        /* tools */
        add_settings_section(
            'B7EFDTools_section',
            __( 'Tools', $this->plugin_text_domain),
            array($this, 'bfd_tools_section_callback'),
            'B7EFDTools'
        );
        add_settings_field(
            'bfd_run_layout_tools',
            __( 'Apply layout option to all post types', $this->plugin_text_domain),
            array($this, 'bfd_run_layout_tools_render'),
            'B7EFDTools',
            'B7EFDTools_section'
        );
        add_settings_field(
            'bfd_run_title_tools',
            __( 'Apply title option to all posts', $this->plugin_text_domain),
            array($this, 'bfd_run_title_tools_render'),
            'B7EFDTools',
            'B7EFDTools_section'
        );
        add_settings_field(
            'bfd_run_side_nav_tools',
            __( 'Apply dot navigation option to all posts', $this->plugin_text_domain),
            array($this, 'bfd_run_side_nav_tools_render'),
            'B7EFDTools',
            'B7EFDTools_section'
        );
        add_settings_field(
            'bfd_run_hide_nav_tools',
            __( 'Apply hide nav bar before scroll option to all posts', $this->plugin_text_domain),
            array($this, 'bfd_run_hide_nav_tools_render'),
            'B7EFDTools',
            'B7EFDTools_section'
        );
    }

    public function bfd_general_settings_section_callback(){

    }

    public function bfd_enable_render(){
        ?>
        <div id="bounds">
            <label class="on"><input type="radio" name="bfd_general_settings[bfd_enable]" value="true"  <?php checked( $this->options['bfd_enable'], 'true' ); ?>>
                <span><?php _e( 'Yes', $this->plugin_text_domain);?></span></label>
            <label class="off"><input type="radio" name="bfd_general_settings[bfd_enable]" value="false"  <?php checked( $this->options['bfd_enable'], 'false' ); ?>>
                <span><?php _e( 'No', $this->plugin_text_domain);?></span></label>
        </div>

        <?php
    }

    public function bfd_single_title_allow_overide_render(){
        ?>
        <div id="bounds">
            <label class="on"><input type="radio" name="bfd_general_settings[bfd_single_title_allow_overide]" value="true"  <?php checked( $this->options['bfd_single_title_allow_overide'], 'true' ); ?>>
                <span><?php _e( 'Yes', $this->plugin_text_domain);?></span></label>
            <label class="off"><input type="radio" name="bfd_general_settings[bfd_single_title_allow_overide]" value="false"  <?php checked( $this->options['bfd_single_title_allow_overide'], 'false' ); ?>>
                <span><?php _e( 'No', $this->plugin_text_domain);?></span></label>
        </div>

        <?php
    }
    public function bfd_layout_type_render(){
        ?>
        <input type="radio" name="bfd_general_settings[bfd_layout_type]" value="et_full_width_page"  <?php checked( $this->options['bfd_layout_type'], 'et_full_width_page' ); ?>> <?php _e('Fullwidth', $this->plugin_text_domain);?><br/>
        <input type="radio" name="bfd_general_settings[bfd_layout_type]" value="et_no_sidebar"  <?php checked( $this->options['bfd_layout_type'], 'et_no_sidebar' ); ?>> <?php _e('No sidebar', $this->plugin_text_domain);?><br/>
        <input type="radio" name="bfd_general_settings[bfd_layout_type]" value="et_left_sidebar"  <?php checked( $this->options['bfd_layout_type'], 'et_left_sidebar' ); ?>> <?php _e('Left sidebar', $this->plugin_text_domain);?><br/>
        <input type="radio" name="bfd_general_settings[bfd_layout_type]" value="et_right_sidebar"  <?php checked( $this->options['bfd_layout_type'], 'et_right_sidebar' ); ?>> <?php _e('Right sidebar', $this->plugin_text_domain);?><br/>

        <?php
    }
    public function bfd_layout_type_to_product_render(){
        ?>
        <input type="radio" name="bfd_general_settings[bfd_layout_type_to_product]" value="true"  <?php checked( $this->options['bfd_layout_type_to_product'], 'true' ); ?>> <?php _e('Yes', $this->plugin_text_domain);?>
        <input type="radio" name="bfd_general_settings[bfd_layout_type_to_product]" value="false"  <?php checked( $this->options['bfd_layout_type_to_product'], 'false' ); ?>> <?php _e('No', $this->plugin_text_domain);?>

        <?php
    }
    public function bfd_single_title_render(){
        ?>
        <input type="radio" name="bfd_general_settings[bfd_single_title]" value="on"  <?php checked( $this->options['bfd_single_title'], 'on' ); ?>> <?php _e('On', $this->plugin_text_domain);?>
        <input type="radio" name="bfd_general_settings[bfd_single_title]" value="off"  <?php checked( $this->options['bfd_single_title'], 'off' ); ?>> <?php _e('Off', $this->plugin_text_domain);?>

        <?php
    }
    public function bfd_post_hide_nav_render(){
        ?>
        <input type="radio" name="bfd_general_settings[bfd_post_hide_nav]" value="default"  <?php checked( $this->options['bfd_post_hide_nav'], 'default' ); ?>> <?php _e('Default', $this->plugin_text_domain);?>
        <input type="radio" name="bfd_general_settings[bfd_post_hide_nav]" value="on"  <?php checked( $this->options['bfd_post_hide_nav'], 'on' ); ?>> <?php _e('On', $this->plugin_text_domain);?>
        <input type="radio" name="bfd_general_settings[bfd_post_hide_nav]" value="off"  <?php checked( $this->options['bfd_post_hide_nav'], 'off' ); ?>> <?php _e('Off', $this->plugin_text_domain);?>

        <?php
    }
    public function bfd_post_dot_nav_render(){
        ?>
        <input type="radio" name="bfd_general_settings[bfd_post_dot_nav]" value="on"  <?php checked( $this->options['bfd_post_dot_nav'], 'on' ); ?>> <?php _e('On', $this->plugin_text_domain);?>
        <input type="radio" name="bfd_general_settings[bfd_post_dot_nav]" value="off"  <?php checked( $this->options['bfd_post_dot_nav'], 'off' ); ?>> <?php _e('Off', $this->plugin_text_domain);?>

        <?php
    }
    public function bfd_help_section_callback(){
        ?>
        <div class="brozzme-info">
            <?php _e('This plugin intend to modify globally the Divi layout easily for the whole website.', $this->plugin_text_domain);?><br/>
            <?php _e('Usually, if do not want the right sidebar (the default position), you need to set the layout sidebar position.<br/>With <b>Brozzme Fullwidth and Automatic Layout in Divi</b>, each new post will have the predefine layout that you choose in the plugin option page.', $this->plugin_text_domain);?><br/>
            <?php _e('The tools tab allows you to modify the layout type of all posts, pages, Woocommerce products and other custom post type (with filter only - see faq).', $this->plugin_text_domain);?><br/>
            <?php _e('Save time and keep the same general layout type in your whole website.', $this->plugin_text_domain);?><br/>
            <ul>
                <li><?php _e('Template : fullwidth, left or right sidebar.', $this->plugin_text_domain);?></li>
                <li><?php _e('Show or hide post title (only when page builder is used with post).', $this->plugin_text_domain);?></li>
                <li><?php _e('Enable dot navigation', $this->plugin_text_domain);?></li>
                <li><?php _e('Hide nav bar before scroll', $this->plugin_text_domain);?></li>
            </ul>
        </div>
        <?php
    }
    public function bfd_tools_section_callback(){
        ?>
        <p><?php _e('When you just activate Brozzme Fullwidth and Automatic Layout in Divi, this tools make all your post, page and product like you want them to be.', $this->plugin_text_domain);?></p>
        <?php

        if(brozzme_fullwidth_divi_core::is_woocommerce_activate() === true){
            _e('Woocommerce is activate, this tools will modify products if applicable (see General settings tab).', $this->plugin_text_domain);
        }
    }
    public function bfd_run_layout_tools_render(){

        ?>
        <input type="checkbox" name="bfd_tools_settings[bfd_run_layout_tools]" value="true"> <?php _e('Confirm', $this->plugin_text_domain);?>
        <?php

        if($_REQUEST['settings-updated']== 'true'){
            if($this->tools_options['bfd_run_layout_tools']== 'true'){
                $run_layout_tools = brozzme_fullwidth_divi_core::_run_layout_tools('_et_pb_page_layout');
            }
        }
    }
    public function bfd_run_title_tools_render(){
        ?>
        <input type="checkbox" name="bfd_tools_settings[bfd_run_title_tools]" value="true"> <?php _e('Confirm', $this->plugin_text_domain);?>
        <?php

        if($_REQUEST['settings-updated']== 'true'){
            if($this->tools_options['bfd_run_title_tools']== 'true'){
                $run_layout_tools = brozzme_fullwidth_divi_core::_run_layout_tools('_et_single_title');
            }
        }
    }
    public function bfd_run_side_nav_tools_render(){
        ?>
        <input type="checkbox" name="bfd_tools_settings[bfd_run_side_nav_tools]" value="true"> <?php _e('Confirm', $this->plugin_text_domain);?>
        <?php

        if($_REQUEST['settings-updated']== 'true'){
            if($this->tools_options['bfd_run_side_nav_tools']== 'true'){
                $run_layout_tools = brozzme_fullwidth_divi_core::_run_layout_tools('_et_pb_side_nav');
            }

        }
    }
    public function bfd_run_hide_nav_tools_render(){
        ?>
        <input type="checkbox" name="bfd_tools_settings[bfd_run_hide_nav_tools]" value="true"> <?php _e('Confirm', $this->plugin_text_domain);?>
        <?php

        if($_REQUEST['settings-updated']== 'true'){
            if($this->tools_options['bfd_run_hide_nav_tools']== 'true'){
                $run_layout_tools = brozzme_fullwidth_divi_core::_run_layout_tools('_et_pb_post_hide_nav');
            }

        }
    }
}
new brozzme_fullwidth_divi_settings();