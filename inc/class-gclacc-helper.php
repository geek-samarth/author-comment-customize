<?php
/**
 * Our main plugin class
*/
if (!defined('ABSPATH')) exit;

if(!class_exists('Gclacc_helper')) {

    class Gclacc_helper {

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
            'phone'                    => 'Phone'
        );

        public static function get_user_social_links($userd_id, $show_email = false)
        {

            $social_icons = apply_filters('gclacc_social_icons', Simple_Author_Box_Helper::$social_icons);
            $social_links = get_user_meta($userd_id, 'gclacc_social_links', true);

            if (!is_array($social_links)) {
                $social_links = array();
            }

            return $social_links;
        }

    }
    new Gclacc_helper();
}