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
            add_action('wp_enqueue_scripts', array( $this,'gclacc_front_enqueue' ));                    // enqueue
            add_action('admin_enqueue_scripts',array($this,'gclacc_admin_enqueue'));                    // admin enqueue
            add_filter('comment_reply_link', array( $this,'filter_comment_reply_link3'), 10, 4);        // comment reply html
            add_filter('get_comment_author', array( $this,'gclacc_get_comment_author_role'), 10, 3);    // Get comment author role
            add_filter('get_comment_author_link', array( $this, 'gclacc_comment_author_role' ));        // Display comment author
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

        // Get comment author role 
        public function gclacc_get_comment_author_role($author, $comment_comment_id, $comment ) {
            $authoremail = get_comment_author_email( $comment); 
            // Check if user is registered
            if (email_exists($authoremail)) {
                $commet_user_role = get_user_by( 'email', $authoremail );
                $comment_user_role = $commet_user_role->roles[0];
                // HTML output to add next to comment author name
                $this->comment_user_role = ' <span class="comment-author-label comment-author-label-'.$comment_user_role.'">' . ucfirst($comment_user_role) . '</span>';
            } else { 
                $this->comment_user_role = '';
            }
            return $author;
        }
    
        // Display comment author
        public function gclacc_comment_author_role($author) { 
            return $author .= $this->comment_user_role;
        }

        // define the comment_reply_link callback 
        public function filter_comment_reply_link3( $args_before_link_args_after, $args, $comment, $post ) {
            $user_id = $post->post_author;
            
            
            // is author comment
            if( $comment->user_id === $user_id ) {
                global $gclacc_options;
                $icon_type = (isset($gclacc_options["author_social_icons_type"]) && !empty($gclacc_options["author_social_icons_type"])) ? $gclacc_options["author_social_icons_type"]: 'simple';
                $user_social_data = get_user_meta($user_id, 'gclacc_social_links', true);
                
                if(isset($gclacc_options["author_social_links"]) && !empty($gclacc_options["author_social_links"]))    $social_link_status = $gclacc_options["author_social_links"];
                    


                // $social_link_status == 'on'
                // echo $social_link_status . '  - social_link_status';
                if(isset($social_link_status) && $social_link_status == 'on' && !empty($user_social_data)) { ?>
                    <div class="gclacc-social-html">

                        <?php
                        if ($icon_type == 'square-colored') {
                            ?>
                                <div class="gclacc-square-icons">
                                    
                                    <?php
                                    
                                    foreach($user_social_data as $icon => $social_link) {
                                    

                                        $icon_html = Gclacc_social_icons::get_social_icons($icon, $icon_type);

                                        ?>   
                                        
                                        <a href="<?php esc_url($social_link); ?>" class="gclacc-icon-color" target="_blank">
                                            <?php echo $icon_html; ?>
                                        </a>

                                        <?php
                                    } ?>
                                </div>
                            <?php
                        } elseif ($icon_type == 'circle-colored') {
                            ?>
                                <div class="gclacc-circle-icons">
                                    <?php
                                    foreach($user_social_data as $icon => $social_link) {
                                        
                                        
                                        $icon_html = Gclacc_social_icons::get_social_icons($icon, $icon_type); ?>
                                        
                                        <a href="<?php esc_url($social_link); ?>" class="gclacc-icon-color" target="_blank">
                                            <?php echo $icon_html; ?>
                                        </a>

                                        <?php 
                                    } ?>
                                </div>
                            <?php
                        } else {
                            ?>
                                <div class="gclacc-simple-icons">
                                    <?php
                                    
                                    
                                    foreach($user_social_data as $icon => $social_link) {
                                        
                                        $icon_html = Gclacc_social_icons::get_social_icons($icon, $icon_type); ?>
                                        
                                        <a href="<?php esc_url($social_link); ?>" class="gclacc-icon-color" target="_blank">
                                            <?php echo $icon_html; ?>
                                        </a>

                                        <?php  
                                        
                                    } ?>
                                </div>
                            <?php
                        } ?>
                    </div>

                    <?php
                }

            }

        }
    }

    new Author_comment_customize();
}
