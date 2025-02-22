<?php
/**
 * Plugin Name: Floating WhatsApp Chat & Order
 * Description: Adds a customizable floating icon and an "Order on WhatsApp" button for WooCommerce products.
 * Version: 1.0.0
 * Author: Dominic_N
 * Author URI: https://dominicn.dev
 * License: GPL-2.0+
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
$plugin_root = plugin_dir_path(__FILE__);
    $css_file = $plugin_root . 'assets/font-awesome/css/font-awesome.css';
    $output_file = $plugin_root . 'assets/icons.json';

    die("File: {$css_file} Exists: ".file_exists($css_file).".");
    
    
    // $css_content = file_get_contents($css_file);
    // preg_match_all('/\.fa-([a-z0-9-]+):before\s*{\s*content:\s*"\\[^"\']+";\s*}/', $css_content, $matches);
    // preg_match_all('/\.fa-([a-z0-9-]+):before\s*{\s*content:\s*"\\([a-f0-9]+)";\s*}/i', $css_content, $matches);

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
require_once plugin_dir_path(__FILE__) . 'lib/fontawesome_icon_picker.php';
require_once plugin_dir_path(__FILE__) . 'includes/FloatingIconWhatsApp.php';
// require_once plugin_dir_path(__FILE__) . 'includes/OrderOnWhatsApp.php';

// new WCO_FloatingIconWhatsApp();
// new OrderOnWhatsApp();

// Include the settings file
require_once plugin_dir_path(__FILE__) . 'includes/FloatingIconWhatsAppSettings.php';



add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'apd_settings_link' );
function apd_settings_link( array $links ) {
    $settings_link = '<a href="'.get_admin_url ().'options-general.php?page=floating-whatsapp-settings">' . __('Settings', 'wco_whatsappchatorder') . '</a>';

    array_unshift($links, $settings_link);
    return $links;
}







 