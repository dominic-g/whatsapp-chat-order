<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class FloatingIconWhatsAppSettings extends WC_Settings_Page {
    
    public function __construct() {
        $this->id    = 'floating_icon_whatsapp';
        $this->label = __('Floating Icon WhatsApp', 'woocommerce');
        
        add_filter('woocommerce_settings_tabs_array', array($this, 'add_settings_page'), 50);
        add_action('woocommerce_settings_' . $this->id, array($this, 'output')); 
        add_action('woocommerce_settings_save_' . $this->id, array($this, 'save'));
    }
    
    public function add_settings_page($tabs) {
        $tabs[$this->id] = $this->label;
        return $tabs;
    }

    public function output() {
        global $current_section;
        
        $settings = $this->get_settings();
        WC_Admin_Settings::output_fields($settings);
    }

    public function save() {
        global $current_section;
        
        $settings = $this->get_settings();
        WC_Admin_Settings::save_fields($settings);
    }
    
    public function get_settings() {
        return array(
            array(
                'title' => __('Floating Icon WhatsApp Settings', 'woocommerce'),
                'type'  => 'title',
                'desc'  => __('Customize the floating WhatsApp icon.', 'woocommerce'),
                'id'    => 'floating_icon_whatsapp_settings'
            ),
            array(
                'title'   => __('Font Awesome Icon', 'woocommerce'),
                'id'      => 'floating_icon_whatsapp_icon',
                'type'    => 'text',
                'default' => 'fa-whatsapp',
            ),
            array(
                'title'   => __('Icon Color', 'woocommerce'),
                'id'      => 'floating_icon_whatsapp_color',
                'type'    => 'color',
                'default' => '#ffffff',
            ),
            array(
                'title'   => __('Background Color', 'woocommerce'),
                'id'      => 'floating_icon_whatsapp_bg_color',
                'type'    => 'color',
                'default' => '#25D366',
            ),
            array(
                'title'   => __('WhatsApp Number', 'woocommerce'),
                'id'      => 'floating_icon_whatsapp_number',
                'type'    => 'text',
                'default' => '',
            ),
            array(
                'type' => 'sectionend',
                'id'   => 'floating_icon_whatsapp_settings'
            )
        );
    }
}

return new FloatingIconWhatsAppSettings();
