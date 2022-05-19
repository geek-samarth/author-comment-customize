<?php
if(!class_exists('gclacc_user_settings')){

    class gclacc_user_settings
    {
        public static $social_icons = array(
            'addthis'       => 'Add This',
            'behance'       => 'Behance',
            'delicious'     => 'Delicious',
            'deviantart'    => 'Deviantart',
            'digg'          => 'Digg',
            'discord'       => 'Discord',
            'dribbble'      => 'Dribbble',
            'facebook'      => 'Facebook',
            'whatsapp'      => 'WhatsApp',
            'flickr'        => 'Flickr',
            'github'        => 'Github',
            'google'        => 'Google',
            'googleplus'    => 'Google Plus',
            'html5'         => 'Html5',
            'instagram'     => 'Instagram',
            'linkedin'      => 'Linkedin',
            'pinterest'     => 'Pinterest',
            'reddit'        => 'Reddit',
            'rss'           => 'Rss',
            'sharethis'     => 'Sharethis',
            'skype'         => 'Skype',
            'soundcloud'    => 'Soundcloud',
            'spotify'       => 'Spotify',
            'stackoverflow' => 'Stackoverflow',
            'steam'         => 'Steam',
            'stumbleUpon'   => 'StumbleUpon',
            'tumblr'        => 'Tumblr',
            'twitter'       => 'Twitter',
            'vimeo'         => 'Vimeo',
            'windows'       => 'Windows',
            'wordpress'     => 'WordPress',
            'yahoo'         => 'Yahoo',
            'youtube'       => 'Youtube',
            'xing'          => 'Xing',
            'mixcloud'      => 'MixCloud',
            'goodreads'     => 'Goodreads',
            'twitch'        => 'Twitch',
            'vk'            => 'VK',
            'medium'        => 'Medium',
            'quora'         => 'Quora',
            'meetup'        => 'Meetup',
            'user_email'    => 'Email',
            'snapchat'      => 'Snapchat',
            '500px'         => '500px',
            'mastodont'     => 'Mastodon',
            'telegram'      => 'Telegram',
            'phone'         => 'Phone'
        );

        public function __construct() {
            add_action('init', array($this, 'init'));
        }

        public function init(){
            // Social Links
            add_action('show_user_profile', array($this, 'add_social_area_links'));
            add_action('edit_user_profile', array($this, 'add_social_area_links'));

            add_action('personal_options_update', array($this, 'save_user_profile_option'));    // current user is editing their own profile
            add_action('edit_user_profile_update', array($this, 'save_user_profile_option'));   // save custom fields to WordPress profile page
        }

        public function add_social_area_links($profileuser) {
            $user_id = $profileuser->data->ID;
            $social_links = Gclacc_helper::get_user_social_links($user_id);
            $social_icons = Gclacc_helper::$social_icons;
    
            $user_meta = get_user_meta($user_id, 'gclacc_social_links', true);
            echo '<pre>';
            print_r($user_meta);
            echo '</pre>';
            ?>
            <div class="gclacc-user-profile-wrapper">
                <h2><?php esc_html_e('Social Media Links', 'author-comment-customize'); ?></h2>
                <table class="form-table" id="gclacc-social-table">
                    <?php
    
                    if (!empty($social_links)) {
                        foreach ($social_links as $social_platform => $social_link) {
                            ?>
                            <tr>
                                <th>
                                    <span class="gclacc-drag"></span>
                                    <select name="gclacc-social-icons[]">
                                        <?php foreach ($social_icons as $gclacc_social_id => $gclacc_social_name) { ?>
                                            <option value="<?php echo esc_attr($gclacc_social_id); ?>" <?php selected($gclacc_social_id, $social_platform); ?>><?php echo esc_html($gclacc_social_name); ?></option>
                                        <?php } ?>
                                    </select>
                                </th>
                                <td>
                                    <input name="gclacc-social-links[]"
                                           type="<?php echo ('whatsapp' == $social_platform || 'phone' == $social_platform) ? 'tel' : 'text'; ?>"
                                           class="regular-text"
                                           value="<?php echo ( 'whatsapp' == $social_platform  || 'telegram' == $social_platform || 'skype' == $social_platform || 'phone' == $social_platform ) ? esc_attr($social_link) : esc_url( $social_link ); ?>">
                                    <span class="dashicons dashicons-trash"></span>
                                <td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <th>
                                <span class="gclacc-drag"></span>
                                <select name="gclacc-social-icons[]">
                                    <?php foreach ($social_icons as $gclacc_social_id => $gclacc_social_name) { ?>
                                        <option value="<?php echo esc_attr($gclacc_social_id); ?>"><?php echo esc_html($gclacc_social_name); ?></option>
                                    <?php } ?>
                                </select>
                            </th>
                            <td>
                                <input name="gclacc-social-links[]" type="text" class="regular-text" value="">
                                <span class="dashicons dashicons-trash"></span>
                            <td>
                        </tr>
                        <?php
                    }
    
                    ?>
    
                </table>
    
                <div class="gclacc-add-social-link">
                    <a href="#"
                       class="button button-primary button-hero"></span><?php esc_html_e('+ Add new social platform', 'simple-author-box'); ?></a>
                </div>
            </div>
    
            <?php
        }

        public function save_user_profile_option($user_id) {

            if (isset($_POST['gclacc-social-icons']) && isset($_POST['gclacc-social-links'])) {
                $social_platforms = Gclacc_helper::$social_icons;
                $social_links     = array();
                foreach ( $_POST['gclacc-social-links'] as $index => $social_link ) {
                    if ( $social_link ) {
                        $social_platform = isset( $_POST['gclacc-social-icons'][ $index ] ) ? $_POST['gclacc-social-icons'][ $index ] : false;
                        if ( $social_platform && isset( $social_platforms[ $social_platform ] ) ) {
                            if ( 'whatsapp' == $social_platform  || 'telegram' == $social_platform || 'skype' == $social_platform || 'phone' == $social_platform) {
                                $social_links[ $social_platform ] = esc_html($social_link);
                            } else {
                                $social_links[ $social_platform ] = esc_url_raw( $social_link );
                            }
                        }
                    }
                }
                
                $social_platforms = Gclacc_helper::$social_icons;
                $social_links     = array();
                foreach ( $_POST['gclacc-social-links'] as $index => $social_link ) {
                    if ( $social_link ) {
                        $social_platform = isset( $_POST['gclacc-social-icons'][ $index ] ) ? $_POST['gclacc-social-icons'][ $index ] : false;
                        if ( $social_platform && isset( $social_platforms[ $social_platform ] ) ) {
                            if ( 'whatsapp' == $social_platform  || 'telegram' == $social_platform || 'skype' == $social_platform || 'phone' == $social_platform) {
                                $social_links[ $social_platform ] = esc_html($social_link);
                            } else {
                                $social_links[ $social_platform ] = esc_url_raw( $social_link );
                            }
                        }
                    }
                }
                
    
            update_user_meta($user_id, 'gclacc_social_links', $social_links);

            // echo '<pre>';
            // print_r($social_links);
            // echo '</pre>'; 
            // die;
            
    
            } else {
                delete_user_meta($user_id, 'gclacc_social_links');
            }
    
        }

    }
    new gclacc_user_settings();
}