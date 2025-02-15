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

// Require necessary files
require_once plugin_dir_path(__FILE__) . 'includes/FloatingIconWhatsApp.php';
// require_once plugin_dir_path(__FILE__) . 'includes/OrderOnWhatsApp.php';

// new WCO_FloatingIconWhatsApp();
// new OrderOnWhatsApp();

// Include the settings file
require_once plugin_dir_path(__FILE__) . 'includes/FloatingIconWhatsAppSettings.php';

