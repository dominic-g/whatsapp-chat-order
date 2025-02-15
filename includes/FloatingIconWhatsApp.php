<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WCO_FloatingIconWhatsApp {
    public function __construct() {
        // add_action('admin_init', [$this, 'register_settings']);
        // add_filter('woocommerce_get_settings_pages', [$this, 'add_settings_page']);
        add_action('wp_footer', [$this, 'display_floating_icon']);
        register_activation_hook(__FILE__, [$this, 'set_default_settings']);
    }


    /**
     * Add settings link under the plugin description in the Plugins page
     */
    public function set_default_settings() {
        $default_settings = array(
            'icon' => 'fa-whatsapp',
            'color' => '#ffffff',
            'bg_color' => '#25D366',
            'position' => 'bottom-right',
            'bottom' => '20px',
            'right' => '20px',
            'message' => 'Hello! I am interested in {page_title}',
            'whatsapp_number' => '',
            'excluded_pages' => array()
        );
        
        if (!get_option('floating_icon_settings')) {
            update_option('floating_icon_settings', $default_settings);
        }
    }
   
    public function display_floating_icon() {
        $settings = get_option('floating_icon_settings', array());
        
        if (!empty($settings['excluded_pages']) && is_page($settings['excluded_pages'])) return;
        
        $icon = esc_attr($settings['icon'] ?? 'fa-whatsapp');
        $color = esc_attr($settings['color'] ?? '#ffffff');
        $bg_color = esc_attr($settings['bg_color'] ?? '#25D366');
        $position = esc_attr($settings['position'] ?? 'bottom-right');
        $bottom = esc_attr($settings['bottom'] ?? '20px');
        $right = esc_attr($settings['right'] ?? '20px');
        $message = isset($settings['message']) ? urlencode(str_replace('{page_title}', get_the_title(), $settings['message'])) : '';
        $whatsapp_number = esc_attr($settings['whatsapp_number'] ?? '');

        echo "<style>
            .wco_floating-icon {
                position: fixed;
                $position: $bottom $right;
                background: $bg_color;
                color: $color;
                padding: 10px;
                border-radius: 50%;
                font-size: 24px;
                cursor: pointer;
                z-index: 999;
            }
        </style>
        <a href='https://wa.me/$whatsapp_number?text=$message' class='wco_floating-icon'><i class='fa $icon'></i></a>";
    }
}

new WCO_FloatingIconWhatsApp();
