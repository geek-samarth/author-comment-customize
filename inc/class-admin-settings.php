<?php
/*
    Admin menu page setting
*/
if (!defined('ABSPATH')) exit;

if(!class_exists('gclacc_admin_settings')){
    
    $gclacc_options = get_option('gclacc_comment_box_options');
    $border_styles  = array( "Solid", "Dashed", "Groove", "Outset", "Ridge" );
    $font_styles    = array( "Bold", "Italic", "Underline" );
    $icons_type     = array( "Simple", "Square Colored", "Circle Colored" );
    
    class gclacc_admin_settings
    {
        public function __construct() {
            add_action( 'admin_init', array( $this, 'gclacc_register_settings_init' )); 
            add_action( 'admin_menu', array( $this, 'gclacc_admin_menu' ));
        }

        static function gclacc_admin_menu() {
            add_menu_page(
                __( 'Author Comment Customize', 'textdomain' ),
                'Author Comment Customize',
                'manage_options',
                'gclacc',
                array('gclacc_admin_settings','gclacc_admin_html'),
                'dashicons-admin-customizer',
                99
            );
        }

        static function gclacc_admin_html() {

            // add error/update messages
 
            // check if the user have submitted the settings
            // WordPress will add the "settings-updated" $_GET parameter to the url
            if ( isset( $_GET['settings-updated'] ) ) {
                // add settings saved message with the class of "updated"
                add_settings_error( 'gclacc_messages', 'gclacc_message', __( 'Settings Saved', 'author-comment-customize' ), 'updated' );
            }
        
            // show error/update messages
            settings_errors( 'gclacc_messages' );
            ?>
            <div class="wrap">
                <h1>Author Comment Customize</h1>
                
                <form action="options.php" method="post">
                    <?php settings_fields('gclacc-comments-customize-options'); ?>

                    <div class="gclacc-section">
                        <?php do_settings_sections('gclacc_comment_box_section'); ?>
                    </div>

                    <div class="gclacc-section">
                        <?php do_settings_sections('gclacc_author_label_section'); ?>
                    </div>

                    <div class="gclacc-section">
                        <?php do_settings_sections('gclacc_author_sub_title_section'); ?>
                    </div>

                    <div class="gclacc-section">
                        <?php do_settings_sections('gclacc_commenter_user_role_section'); ?>
                    </div>

                    <div class="gclacc-section">
                        <?php do_settings_sections('gclacc_avatar_section'); ?>
                    </div>
                    
                    <div class="gclacc-section">
                        <?php do_settings_sections('gclacc_social_links_section'); ?>
                    </div>
                    
                    <?php submit_button('Save Settings'); ?>
                </form>
            </div> 
            <?php
        }

        public function gclacc_register_settings_init() {
            register_setting('gclacc-comments-customize-options', 'gclacc_comment_box_options', array($this, 'sanitize_settings'));

            add_settings_section(
                'gclacc_comment_box_setting',
                __('Comment Box Settings', 'author-comment-customize'),
                array(),
                'gclacc_comment_box_section'
            );

            add_settings_field(
                'comment_box_background_color',
                __('Background color', 'author-comment-customize'),
                array($this, 'select_color_html'),
                'gclacc_comment_box_section',
                'gclacc_comment_box_setting',
                [
                    'label_for'     => 'comment_box_background_color',
                    'description'   => 'Change the author comment box background color.'
                ]
            );

            add_settings_field(
                'comment_box_border_style',
                __('Border Style', 'author-comment-customize'),
                array($this, 'select_border_style'),
                'gclacc_comment_box_section',
                'gclacc_comment_box_setting',
                [
                    'label_for'     => 'comment_box_border_style',
                    'description'   => 'Change the author comment box border Style.'
                ]
            );
    
            add_settings_field(
                'comment_box_border_radius',
                __('Border Radius', 'author-comment-customize'),
                array($this, 'border_radius'),
                'gclacc_comment_box_section',
                'gclacc_comment_box_setting',
                [
                    'label_for'     => 'comment_box_border_radius',
                    'description'   => 'Change the author comment box border Radius.'
                ]
            );
    
            add_settings_field(
                'comment_box_border_width',
                __('Border Width', 'author-comment-customize'),
                array($this, 'border_width'),
                'gclacc_comment_box_section',
                'gclacc_comment_box_setting',
                [
                    'label_for'     => 'comment_box_border_width',
                    'description'   => 'Change the author comment box border Width.'
                ]
            );
    
            add_settings_field(
                'comment_box_border_color',
                __('Border color', 'author-comment-customize'),
                array($this, 'border_color'),
                'gclacc_comment_box_section',
                'gclacc_comment_box_setting',
                [
                    'label_for'     => 'comment_box_border_color',
                    'description'   => 'Change the author comment box border color.'
                ]
            );
    
            add_settings_section(
                'gclacc_comment_box_author_label_setting',
                __('Author name Settings', 'author-comment-customize'),
                array(),
                'gclacc_author_label_section'
            );
    
            add_settings_field(
                'author_label_font_size',
                __('Font Size', 'author-comment-customize'),
                array($this, 'font_size'),
                'gclacc_author_label_section',
                'gclacc_comment_box_author_label_setting',
                [
                    'label_for'     => 'author_label_font_size',
                    'description'   => 'Change the author label font size.'
                ]
            );
    
            add_settings_field(
                'author_label_font_color',
                __('Font color', 'author-comment-customize'),
                array($this, 'text_color'),
                'gclacc_author_label_section',
                'gclacc_comment_box_author_label_setting',
                [
                    'label_for'     => 'author_label_font_color',
                    'description'   => 'Change the author label font color.'
                ]
            );
    
            add_settings_field(
                'author_label_font_style',
                __('Font Style', 'author-comment-customize'),
                array($this, 'select_font_style'),
                'gclacc_author_label_section',
                'gclacc_comment_box_author_label_setting',
                [
                    'label_for'     => 'author_label_font_style',
                    'description'   => 'Change the author label font style.'
                ]
            );
    
            add_settings_section(
                'gclacc_comment_box_author_sub_title_setting',
                __('Sub Title Settings', 'author-comment-customize'),
                array(),
                'gclacc_author_sub_title_section'
            );
    
            add_settings_field(
                'author_sub_title',
                __('Sub Title', 'author-comment-customize'),
                array($this, 'sub_title_text'),
                'gclacc_author_sub_title_section',
                'gclacc_comment_box_author_sub_title_setting',
                [
                    'label_for'     => 'author_sub_title',
                    'description'   => 'Add author sub title in comment.'
                ]
            );
    
            add_settings_field(
                'author_sub_title_font_size',
                __('Font Size', 'author-comment-customize'),
                array($this, 'font_size'),
                'gclacc_author_sub_title_section',
                'gclacc_comment_box_author_sub_title_setting',
                [
                    'label_for'     => 'author_sub_title_font_size',
                    'description'   => 'Change the author sub title font size.'
                ]
            );
    
            add_settings_field(
                'author_sub_title_font_color',
                __('Font color', 'author-comment-customize'),
                array($this, 'text_color'),
                'gclacc_author_sub_title_section',
                'gclacc_comment_box_author_sub_title_setting',
                [
                    'label_for'     => 'author_sub_title_font_color',
                    'description'   => 'Change the author sub title font color.'
                ]
            );
    
            add_settings_field(
                'author_sub_title_font_style',
                __('Font Style', 'author-comment-customize'),
                array($this, 'select_font_style'),
                'gclacc_author_sub_title_section',
                'gclacc_comment_box_author_sub_title_setting',
                [
                    'label_for'     => 'author_sub_title_font_style',
                    'description'   => 'Change the author sub title font style.'
                ]
            );
            
            add_settings_section(
                'gclacc_commenter_user_role_setting',
                __('Commenter user role Settings', 'author-comment-customize'),
                array(),
                'gclacc_commenter_user_role_section'
            );
    
            add_settings_field(
                'commenter_user_role_text_color',
                __('Font color', 'author-comment-customize'),
                array($this, 'text_color'),
                'gclacc_commenter_user_role_section',
                'gclacc_commenter_user_role_setting',
                [
                    'label_for'     => 'commenter_user_role_text_color',
                    'description'   => 'Change the author sub title font color.'
                ]
            );
    
            add_settings_field(
                'commenter_user_role_background_color',
                __('Font color', 'author-comment-customize'),
                array($this, 'select_color_html'),
                'gclacc_commenter_user_role_section',
                'gclacc_commenter_user_role_setting',
                [
                    'label_for'     => 'commenter_user_role_background_color',
                    'description'   => 'Change the author sub title font color.'
                ]
            );
    
            add_settings_field(
                'commenter_user_role_border_color',
                __('Border Color', 'author-comment-customize'),
                array($this, 'border_color'),
                'gclacc_commenter_user_role_section',
                'gclacc_commenter_user_role_setting',
                [
                    'label_for'     => 'commenter_user_role_border_color',
                    'description'   => 'Change the author comment box border Style.'
                ]
            );
    
            add_settings_field(
                'commenter_user_role_border_style',
                __('Border Style', 'author-comment-customize'),
                array($this, 'select_border_style'),
                'gclacc_commenter_user_role_section',
                'gclacc_commenter_user_role_setting',
                [
                    'label_for'     => 'commenter_user_role_border_style',
                    'description'   => 'Change the author comment box border Style.'
                ]
            );            
    
            add_settings_field(
                'commenter_user_role_border_radius',
                __('Border Color', 'author-comment-customize'),
                array($this, 'border_radius'),
                'gclacc_commenter_user_role_section',
                'gclacc_commenter_user_role_setting',
                [
                    'label_for'     => 'commenter_user_role_border_radius',
                    'description'   => 'Change the author comment box border Style.'
                ]
            );
    
            add_settings_field(
                'commenter_user_role_border_width',
                __('Border Color', 'author-comment-customize'),
                array($this, 'border_width'),
                'gclacc_commenter_user_role_section',
                'gclacc_commenter_user_role_setting',
                [
                    'label_for'     => 'commenter_user_role_border_width',
                    'description'   => 'Change the author comment box border Style.'
                ]
            );

            add_settings_section(
                'gclacc_author_social_links_setting',
                __('Author Social Links Settings', 'author-comment-customize'),
                array(),
                'gclacc_social_links_section'
            );
    
            add_settings_field(
                'author_social_links',
                __('Font Style', 'author-comment-customize'),
                array($this, 'author_social_links'),
                'gclacc_social_links_section',
                'gclacc_author_social_links_setting',
                [
                    'label_for'     => 'author_social_links',
                    'description'   => 'Add social links in comment box.'
                ]
            );

            add_settings_field(
                'author_social_icons_type',
                __('Font Style', 'author-comment-customize'),
                array($this, 'author_social_icons_type'),
                'gclacc_social_links_section',
                'gclacc_author_social_links_setting',
                [
                    'label_for'     => 'author_social_icons_type',
                    'description'   => 'Add social links in comment box.'
                ]
            );

            add_settings_section(
                'gclacc_avatar_setting',
                __('Avatar Image', 'author-comment-customize'),
                array(),
                'gclacc_avatar_section'
            );

            add_settings_field(
                'avatar_image_style',
                __('Image style', 'author-comment-customize'),
                array($this, 'image_style_html'),
                'gclacc_avatar_section',
                'gclacc_avatar_setting',
                [
                    'label_for'     => 'avatar_image_style',
                    'description'   => 'Change the author comment box background color.'
                ]
            );

        }

        static function select_color_html($args) {
            global $gclacc_options;

            echo '<pre>';
            print_r($gclacc_options);
            echo '</pre>';
            
            $value = isset($gclacc_options[$args['label_for']]) ? $gclacc_options[$args['label_for']] : '';
            ?>
                <div class="gclacc-feature-field">
                    <input type="text" class="gclacc_colorpicker" name="gclacc_comment_box_options[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>" value="<?php _e($value); ?>" >
                </div>
                <p class="gclacc-input-note"><?php esc_attr_e($args['description'],'author-comment-customize') ?></p>
            <?php
        }

        static function select_border_style($args) {
            global $gclacc_options, $border_styles;
            
            $select_value = isset($gclacc_options[$args['label_for']]) ? $gclacc_options[$args['label_for']] : '';
            ?>
            <div class="gclacc-feature-field">
                <select name="gclacc_comment_box_options[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>">
                    <option value="" <?php if(empty($select_value)){ _e('selected'); } ?>><?php esc_attr_e('Select'); ?></option>
                    <?php 
                    foreach ($border_styles as $key => $value) {

                        $key = strtolower(str_replace(" ","-",$value));
                        ?>
                        <option value="<?php esc_attr_e($key); ?>" <?php  if($select_value == $key){ _e('selected'); } ?>><?php esc_attr_e($value); ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <p class="gclaccp-input-note"><?php esc_attr_e($args['description'],'woocommerce-shop-page-customizer-pro') ?></p>
            <?php
        }

        static function border_radius($args) {
            global $gclacc_options;
            $value = isset($gclacc_options[$args['label_for']]) ? $gclacc_options[$args['label_for']] : '';
            ?>
                <div class="gclacc-feature-field">
                    <input type="number" name="gclacc_comment_box_options[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>" value="<?php _e($value); ?>" >
                </div>
                <p class="gclacc-input-note"><?php esc_attr_e($args['description'],'author-comment-customize') ?></p>
            <?php
        }

        static function border_width($args) {
            global $gclacc_options;
            $value = isset($gclacc_options[$args['label_for']]) ? $gclacc_options[$args['label_for']] : '';
            ?>
                <div class="gclacc-feature-field">
                    <input type="number" class="" name="gclacc_comment_box_options[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>" value="<?php _e($value); ?>" >
                </div>
                <p class="gclacc-input-note"><?php esc_attr_e($args['description'],'author-comment-customize') ?></p>
            <?php
        }

        static function border_color($args) {
            global $gclacc_options;
            $value = isset($gclacc_options[$args['label_for']]) ? $gclacc_options[$args['label_for']] : '';
            ?>
                <div class="gclacc-feature-field">
                    <input type="text" class="gclacc_colorpicker" name="gclacc_comment_box_options[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>" value="<?php _e($value); ?>" >
                </div>
                <p class="gclacc-input-note"><?php esc_attr_e($args['description'],'author-comment-customize') ?></p>
            <?php
        }

        static function text_color($args) {
            global $gclacc_options;
            $value = isset($gclacc_options[$args['label_for']]) ? $gclacc_options[$args['label_for']] : '';
            ?>
                <div class="gclacc-feature-field">
                    <input type="text" class="gclacc_colorpicker" name="gclacc_comment_box_options[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>" value="<?php _e($value); ?>" >
                </div>
                <p class="gclacc-input-note"><?php esc_attr_e($args['description'],'author-comment-customize') ?></p>
            <?php
        }
        
        static function font_size($args) {
            global $gclacc_options;
            $value = isset($gclacc_options[$args['label_for']]) ? $gclacc_options[$args['label_for']] : '';
            ?>
                <div class="gclacc-feature-field">
                    <input type="number" class="" name="gclacc_comment_box_options[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>" value="<?php _e($value); ?>" >
                </div>
                <p class="gclacc-input-note"><?php esc_attr_e($args['description'],'author-comment-customize') ?></p>
            <?php
        }

        static function select_font_style($args) {
            global $gclacc_options, $font_styles;
            
            $select_value = isset($gclacc_options[$args['label_for']]) ? $gclacc_options[$args['label_for']] : '';
            ?>
            <div class="gclacc-feature-field">
                <select name="gclacc_comment_box_options[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>">
                    <option value="" <?php if(empty($select_value)){ _e('selected'); } ?>><?php esc_attr_e('Select'); ?></option>
                    <?php 
                    foreach ($font_styles as $key => $value) {

                        $key = strtolower(str_replace(" ","-",$value));
                        ?>
                        <option value="<?php esc_attr_e($key); ?>" <?php  if($select_value == $key){ _e('selected'); } ?>><?php esc_attr_e($value); ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <p class="gclaccp-input-note"><?php esc_attr_e($args['description'],'woocommerce-shop-page-customizer-pro') ?></p>
            <?php
        }

        static function sub_title_text($args) {
            global $gclacc_options;
            $value = isset($gclacc_options[$args['label_for']]) ? $gclacc_options[$args['label_for']] : '';
            ?>
                <div class="gclacc-feature-field">
                    <input type="text" class="" name="gclacc_comment_box_options[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>" value="<?php _e($value); ?>" >
                </div>
                <p class="gclacc-input-note"><?php esc_attr_e($args['description'],'author-comment-customize') ?></p>
            <?php
        }

        static function author_social_links($args){
            global $gclacc_options;
            $value = isset($gclacc_options[$args['label_for']]) ? $gclacc_options[$args['label_for']] : '';
            ?>  
            <label class="gclacc-switch">
				<input type="checkbox" class="gclacc-checkbox" name="gclacc_comment_box_options[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>" value="on" <?php if($value == "on"){ _e('checked'); } ?> >
				<span class="gclacc-slider gclacc-round"></span>
			</label>
            <?php
        }
        
        static function author_social_icons_type($args){
            global $gclacc_options, $icons_type;
            
            $select_value = isset($gclacc_options[$args['label_for']]) ? $gclacc_options[$args['label_for']] : '';
            ?>
            <div class="gclacc-feature-field">
                <select name="gclacc_comment_box_options[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>">
                    <option value="" <?php if(empty($select_value)){ _e('selected'); } ?>><?php esc_attr_e('Select'); ?></option>
                    <?php 
                    foreach ($icons_type as $key => $value) {

                        $key = strtolower(str_replace(" ","-",$value));
                        ?>
                        <option value="<?php esc_attr_e($key); ?>" <?php  if($select_value == $key){ _e('selected'); } ?>><?php esc_attr_e($value); ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <p class="gclaccp-input-note"><?php esc_attr_e($args['description'],'woocommerce-shop-page-customizer-pro') ?></p>
            <?php
        }

        static function image_style_html($args) {
            global $gclacc_options;
            $image_styles = array("Square","Circle");
            
            $select_value = isset($gclacc_options[$args['label_for']]) ? $gclacc_options[$args['label_for']] : '';
            ?>
            <div class="gclacc-feature-field">
                <select name="gclacc_comment_box_options[<?php esc_attr_e( $args['label_for'] ); ?>]" id="<?php esc_attr_e( $args['label_for'] ); ?>">
                    <option value="" <?php if(empty($select_value)){ _e('selected'); } ?>><?php esc_attr_e('Select'); ?></option>
                    <?php 
                    foreach ($image_styles as $key => $value) {

                        $key = strtolower(str_replace(" ","-",$value));
                        ?>
                        <option value="<?php esc_attr_e($key); ?>" <?php  if($select_value == $key){ _e('selected'); } ?>><?php esc_attr_e($value); ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <p class="gclaccp-input-note"><?php esc_attr_e($args['description'],'woocommerce-shop-page-customizer-pro') ?></p>
            <?php
        }
        

        public function sanitize_settings($input) {
            $new_input = array();

            // print_r($input); die;
            if (isset($input['comment_box_background_color']) && !empty($input['comment_box_background_color'])) {

                
                $new_input['comment_box_background_color'] = sanitize_text_field($input['comment_box_background_color']);
            }

            if (isset($input['comment_box_border_style']) && !empty($input['comment_box_border_style'])) {

                $new_input['comment_box_border_style'] = sanitize_text_field($input['comment_box_border_style']);
            }

            if (isset($input['comment_box_border_radius']) && !empty($input['comment_box_border_radius'])) {

                $new_input['comment_box_border_radius'] = sanitize_text_field($input['comment_box_border_radius']);
            }

            if (isset($input['comment_box_border_width']) && !empty($input['comment_box_border_width'])) {

                $new_input['comment_box_border_width'] = sanitize_text_field($input['comment_box_border_width']);
            }

            if (isset($input['comment_box_border_color']) && !empty($input['comment_box_border_color'])) {

                $new_input['comment_box_border_color'] = sanitize_text_field($input['comment_box_border_color']);
            }

            if (isset($input['author_label_font_size']) && !empty($input['author_label_font_size'])) {

                $new_input['author_label_font_size'] = sanitize_text_field($input['author_label_font_size']);
            }

            if (isset($input['author_label_font_color']) && !empty($input['author_label_font_color'])) {

                $new_input['author_label_font_color'] = sanitize_text_field($input['author_label_font_color']);
            }

            if (isset($input['author_label_font_style']) && !empty($input['author_label_font_style'])) {

                $new_input['author_label_font_style'] = sanitize_text_field($input['author_label_font_style']);
            }

            if (isset($input['author_sub_title']) && !empty($input['author_sub_title'])) {

                $new_input['author_sub_title'] = sanitize_text_field($input['author_sub_title']);
            }

            if (isset($input['author_sub_title_font_size']) && !empty($input['author_sub_title_font_size'])) {

                $new_input['author_sub_title_font_size'] = sanitize_text_field($input['author_sub_title_font_size']);
            }

            if (isset($input['author_sub_title_font_color']) && !empty($input['author_sub_title_font_color'])) {

                $new_input['author_sub_title_font_color'] = sanitize_text_field($input['author_sub_title_font_color']);
            }

            if (isset($input['author_sub_title_font_style']) && !empty($input['author_sub_title_font_style'])) {

                $new_input['author_sub_title_font_style'] = sanitize_text_field($input['author_sub_title_font_style']);
            }

            if (isset($input['commenter_user_role_text_color']) && !empty($input['commenter_user_role_text_color'])) {

                $new_input['commenter_user_role_text_color'] = sanitize_text_field($input['commenter_user_role_text_color']);
            }

            if (isset($input['commenter_user_role_background_color']) && !empty($input['commenter_user_role_background_color'])) {

                $new_input['commenter_user_role_background_color'] = sanitize_text_field($input['commenter_user_role_background_color']);
            }

            if (isset($input['commenter_user_role_border_color']) && !empty($input['commenter_user_role_border_color'])) {

                $new_input['commenter_user_role_border_color'] = sanitize_text_field($input['commenter_user_role_border_color']);
            }

            if (isset($input['commenter_user_role_border_style']) && !empty($input['commenter_user_role_border_style'])) {

                $new_input['commenter_user_role_border_style'] = sanitize_text_field($input['commenter_user_role_border_style']);
            }

            if (isset($input['commenter_user_role_border_radius']) && !empty($input['commenter_user_role_border_radius'])) {

                $new_input['commenter_user_role_border_radius'] = sanitize_text_field($input['commenter_user_role_border_radius']);
            }

            if (isset($input['commenter_user_role_border_width']) && !empty($input['commenter_user_role_border_width'])) {

                $new_input['commenter_user_role_border_width'] = sanitize_text_field($input['commenter_user_role_border_width']);
            }

            if (isset($input['author_social_links']) && !empty($input['author_social_links'])) {

                $new_input['author_social_links'] = sanitize_text_field($input['author_social_links']);
            }

            if (isset($input['author_social_icons_type']) && !empty($input['author_social_icons_type'])) {

                $new_input['author_social_icons_type'] = sanitize_text_field($input['author_social_icons_type']);
            }

            if (isset($input['avatar_image_style']) && !empty($input['avatar_image_style'])) {

                $new_input['avatar_image_style'] = sanitize_text_field($input['avatar_image_style']);
            }

            return $new_input;
        }
    }

    new gclacc_admin_settings();
}