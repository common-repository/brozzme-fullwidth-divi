<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 21/04/2017
 * Time: 21:40
 */
class brozzme_fullwidth_divi_core
{

    public function __construct()
    {
        $this->options = get_option('bfd_general_settings');
        
        add_action('save_post', array($this, 'check_builder_post_config'), 99, 2);

        // init to get right value
        add_action('wp_head', array($this,'_verify_value'));
    }

    /**
     * Save layout and title meta data for post-type that apply to condition
     * @param $post_id
     * @param $post
     */
    public function check_builder_post_config($post_id, $post){

        if($this->is_theme() === true){
            $et_pb_page_layout = get_post_meta($post_id, '_et_pb_page_layout', true);
            $et_single_title = get_post_meta($post_id, '_et_single_title', true);
            $et_dot_nav = get_post_meta($post_id, '_et_pb_post_hide_nav', true);
            $et_post_hide_nav = get_post_meta($post_id, '_et_pb_side_nav', true);

            if(in_array($post->post_type, $this->_get_post_types($post))){
                if(!$et_pb_page_layout || $et_pb_page_layout !== $this->options['bfd_layout_type']){
                    $new_page_layout = update_post_meta($post_id, '_et_pb_page_layout', $this->options['bfd_layout_type']);
                }
                if(!$et_dot_nav || $et_dot_nav !== $this->options['bfd_post_dot_nav']){
                    $new_dot_nav = update_post_meta($post_id, '_et_pb_side_nav', $this->options['bfd_post_dot_nav']);
                }
                if(!$et_post_hide_nav || $et_post_hide_nav != $this->options['bfd_post_hide_nav']){
                    $new_hide_nav = update_post_meta($post_id, '_et_pb_post_hide_nav', $this->options['bfd_post_hide_nav']);
                }
                if(!$et_single_title || $et_single_title !== $this->options['bfd_single_title']){
                    $new_single_title = update_post_meta($post_id, '_et_single_title', $this->options['bfd_single_title']);
                    $new_show_title = update_post_meta($post_id, '_et_pb_show_title', $this->options['bfd_single_title']);
                }
            }

            if($post->post_type === 'post' && get_post_meta($post_id, '_et_pb_use_builder', true) === 'on'){
                if(!$et_single_title || $et_single_title !== $this->options['bfd_single_title']){
                    $new_single_title = update_post_meta($post_id, '_et_single_title', $this->options['bfd_single_title']);
                    $new_show_title = update_post_meta($post_id, '_et_pb_show_title', $this->options['bfd_single_title']);
                }
            }
        }
    }

    /**
     * Check if the theme is DIVI
     * @return bool
     */
    public static function is_theme(){
        $the_theme = wp_get_theme();

        if($the_theme->get_template() == 'Divi'){
            return true;
        }
    }

    /**
     * @return bool
     */
    public static function is_woocommerce_activate(){
        if(is_admin()){
            if(is_plugin_active('woocommerce/woocommerce.php')){
                return true;
            }
            else{
                return false;
            }
        }
        return false;
    }

    /**
     * @param $post
     * @return array
     */
    public function _get_post_types($post){

        $array_post_types = array('post');

        if($post->post_type == 'page'){
            $array_post_types = array_merge($array_post_types, array('page'));
        }
        if($this->options['bfd_layout_type_to_product'] == 'true' && $post->post_type == 'product'){
            $array_post_types = array_merge($array_post_types, array('product'));
        }

        $array_post_types = apply_filters('bfd_layout_tools_post_types', $array_post_types);

        return $array_post_types;

    }

    /**
     * @param $meta_name
     * @return bool
     */
    public static function _run_layout_tools($meta_name){

        $options = get_option('bfd_general_settings');

        if($meta_name == '_et_single_title'){
            $option = $options['bfd_single_title'];
        }
        else{
            $option = $options['bfd_layout_type'];
        }

        $array_post_types = array('post');

        if($meta_name != '_et_single_title'){
            $array_post_types = array_merge($array_post_types, array('page'));
        }
        if($options['bfd_layout_type_to_product'] == 'true'){
            $array_post_types = array_merge($array_post_types, array('product'));
        }

        $array_post_types = apply_filters('bfd_layout_tools_post_types', $array_post_types);

        foreach ($array_post_types as $post_type){
            $response[$post_type] = self::_query_posts($post_type, $meta_name, $option);
        }

        return true;
    }

    /**
     * @param $post_type
     * @param $meta_name
     * @param $option
     */
    public static function _query_posts($post_type, $meta_name, $option){
        
        $args = array(
            'post_type'=> $post_type,
            'posts_per_page'=> -1,
            'post_status'=> array('pending', 'draft', 'publish', 'private')
        );
        $query = new WP_Query($args);
        
        foreach ($query->posts as $post){
            if($meta_name === '_et_single_title'){
                update_post_meta($post->ID, '_et_pb_show_title', $option);
            }
            update_post_meta($post->ID, $meta_name, $option);
        }
    }

    /**
     *
     */
    public function _verify_value(){
        global $post;

        $post_id = $post->ID;

        if($this->is_theme() === true){
            $et_single_title = get_post_meta($post_id, '_et_single_title', true);
            $et_show_title = get_post_meta($post_id, '_et_pb_show_title', true);

            if($this->options['bfd_single_title_allow_overide'] !== 'true'){
                if($this->options['bfd_single_title'] !== $et_show_title){
                    $new_single_title = update_post_meta($post_id, '_et_single_title', $this->options['bfd_single_title']);
                    $new_show_title = update_post_meta($post_id, '_et_pb_show_title', $this->options['bfd_single_title']);
                }
            }
        }
    }
}

new brozzme_fullwidth_divi_core();