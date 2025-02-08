<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class FloatingIconWhatsApp {
    public function __construct() {
        add_action('admin_init', [$this, 'register_settings']);
        add_filter('woocommerce_get_settings_pages', [$this, 'add_settings_page']);
        add_action('wp_footer', [$this, 'display_floating_icon']);
    }

    public function register_settings() {
        register_setting('woocommerce_floating_icon_settings_group', 'floating_icon_settings');
    }

    public function add_settings_page($settings) {
        $settings[] = include 'FloatingIconWhatsAppSettings.php';
        return $settings;
    }

    public function display_floating_icon() {
        $settings = get_option('floating_icon_settings');
        if (is_page($settings['excluded_pages'])) return;
        
        $icon = esc_attr($settings['icon']);
        $color = esc_attr($settings['color']);
        $bg_color = esc_attr($settings['bg_color']);
        $position = esc_attr($settings['position']);
        $bottom = esc_attr($settings['bottom']);
        $right = esc_attr($settings['right']);
        $message = urlencode(str_replace('{page_title}', get_the_title(), $settings['message']));
        $whatsapp_number = esc_attr($settings['whatsapp_number']);

        echo "<style>
            .floating-icon {
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
        <a href='https://wa.me/$whatsapp_number?text=$message' class='floating-icon'><i class='fa $icon'></i></a>";
    }
}

new FloatingIconWhatsApp();
