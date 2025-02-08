<?php
/**
 * Plugin Name: Floating WhatsApp Chat & Order
 * Description: Adds a customizable floating icon and an "Order on WhatsApp" button for WooCommerce products.
 * Version: 1.0.0
 * Author: Dominic_N
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


// Plugin Activation Hook
function floating_icon_whatsapp_activate() {
    if (!class_exists('WooCommerce')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die('WooCommerce is required for this plugin to work.');
    }

    $default_settings = [
        'icon' => 'fa-whatsapp',
        'color' => '#ffffff',
        'bg_color' => '#25D366',
        'position' => 'bottom-right',
        'bottom' => '20px',
        'right' => '20px',
        'message' => 'Hello, I need help!',
        'whatsapp_number' => '',
    ];
    add_option('floating_icon_whatsapp_settings', $default_settings);
}
register_activation_hook(__FILE__, 'floating_icon_whatsapp_activate');

// Plugin Deactivation Hook
function floating_icon_whatsapp_deactivate() {
    delete_option('floating_icon_whatsapp_settings');
}
register_deactivation_hook(__FILE__, 'floating_icon_whatsapp_deactivate');

register_deactivation_hook(__FILE__, 'floating_icon_whatsapp_deactivate');

// Require necessary files
require_once plugin_dir_path(__FILE__) . 'includes/FloatingIconWhatsApp.php';
require_once plugin_dir_path(__FILE__) . 'includes/OrderOnWhatsApp.php';

new FloatingIconWhatsApp();
new OrderOnWhatsApp();

class FloatingIconWhatsApp {
    public function __construct() {
        add_action('admin_menu', [$this, 'create_settings_page']);
        add_action('wp_footer', [$this, 'display_floating_icon']);
        if (class_exists('WooCommerce')) {
            add_action('woocommerce_after_shop_loop_item', [$this, 'add_whatsapp_order_button'], 15);
        }
    }

    public function create_settings_page() {
        add_menu_page('Floating Icon & WhatsApp', 'Floating Icon', 'manage_options', 'floating-icon-settings', [$this, 'settings_page_content'], 'dashicons-whatsapp');
    }

    public function settings_page_content() {
        echo '<div class="wrap"><h2>Floating Icon & WhatsApp Settings</h2></div>';
        // Add form fields for customization
    }

    public function display_floating_icon() {
        $icon = 'fa-whatsapp'; // Example, retrieve from settings
        $color = '#ffffff';
        $bg_color = '#25D366';
        $position = 'bottom-right';
        $bottom = '20px';
        $right = '20px';
        $message = 'Hello, I need help!';
        $whatsapp_number = '1234567890';
        
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

    public function add_whatsapp_order_button() {
        global $product;
        $product_title = $product->get_name();
        $product_price = $product->get_price();
        $product_link = get_permalink($product->get_id());
        $whatsapp_number = '1234567890';
        $message = "I'm interested in $product_title priced at $product_price.";

        echo "<a href='https://wa.me/$whatsapp_number?text=$message' class='whatsapp-order-button'>Order on WhatsApp</a>";
    }
}

new FloatingIconWhatsApp();
