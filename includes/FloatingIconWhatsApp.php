<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WCO_FloatingIconWhatsApp {
    public function __construct() {
        // add_action('admin_init', [$this, 'register_settings']);
        // add_filter('woocommerce_get_settings_pages', [$this, 'add_settings_page']);
        add_action('wp_footer', [$this, 'display_floating_icon']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
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
            'message' => 'Hello! I need help in {page_title}',
            'whatsapp_number' => '',
            'excluded_pages' => array()
        );
        
        if (!get_option('floating_icon_settings')) {
            update_option('floating_icon_settings', $default_settings);
        }
    }
   

    /**
     * Enqueue styles and scripts
     */
    public function enqueue_assets() {
        wp_enqueue_style(
            'floating-whatsapp-font-awesome',
            plugin_dir_url(dirname(__FILE__)) . 'assets/font-awesome/css/font-awesome.css',
            [],
            '4.7.0'
        );
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
        $msg = isset($settings['message']) ? $settings['message'] : 'Hello! I need help in {page_title}';
        $message = urlencode(str_replace('{page_title}', get_the_title(), $msg));
        $whatsapp_number = esc_attr($settings['whatsapp_number'] ?? '');

        $horizontal = null;
        if($position == 'bottom-right' && !empty($right)){
            $horizontal = "right: {$right};";
        }
        if($position == 'bottom-left' && !empty($right)){
            $horizontal = "left: {$right};";
        }

        echo "<style>
            .wco_floating-icon {
                position: fixed;
                bottom: $bottom;
                $horizontal
                background: $bg_color;
                color: $color;
                padding: 10px 17px;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
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
