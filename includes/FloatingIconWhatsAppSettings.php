<?php

/*if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WCO_FloatingIconWhatsAppSettings extends WC_Settings_Page {
    
    public function __construct() {
        $this->id    = 'floating_icon_whatsapp';
        $this->label = __('Floating Icon WhatsApp', 'wco_whatsappchatorder');
        
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
                'title' => __('Floating Icon WhatsApp Settings', 'wco_whatsappchatorder'),
                'type'  => 'title',
                'desc'  => __('Customize the floating WhatsApp icon.', 'wco_whatsappchatorder'),
                'id'    => 'floating_icon_whatsapp_settings'
            ),
            array(
                'title'   => __('Font Awesome Icon', 'wco_whatsappchatorder'),
                'id'      => 'floating_icon_whatsapp_icon',
                'type'    => 'text',
                'default' => 'fa-whatsapp',
            ),
            array(
                'title'   => __('Icon Color', 'wco_whatsappchatorder'),
                'id'      => 'floating_icon_whatsapp_color',
                'type'    => 'color',
                'default' => '#ffffff',
            ),
            array(
                'title'   => __('Background Color', 'wco_whatsappchatorder'),
                'id'      => 'floating_icon_whatsapp_bg_color',
                'type'    => 'color',
                'default' => '#25D366',
            ),
            array(
                'title'   => __('WhatsApp Number', 'wco_whatsappchatorder'),
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

return new WCO_FloatingIconWhatsAppSettings();

<?php*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WCO_FloatingIconWhatsAppSettings {
    
    public function __construct() {
        add_action('admin_menu', [$this, 'add_settings_page']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function add_settings_page() {
        add_options_page(
            __('Floating WhatsApp Icon', 'wco_whatsappchatorder'),
            __('Floating WhatsApp', 'wco_whatsappchatorder'),
            'manage_options',
            'floating-whatsapp-settings',
            [$this, 'settings_page_content']
        );
    }

    public function register_settings() {
        register_setting('floating_whatsapp_group', 'floating_whatsapp_settings');

        add_settings_section(
            'floating_whatsapp_section',
            __('Floating WhatsApp Icon Settings', 'wco_whatsappchatorder'),
            null,
            'floating-whatsapp-settings'
        );

        add_settings_field(
            'icon',
            __('Font Awesome Icon', 'wco_whatsappchatorder'),
            [$this, 'text_field_callback'],
            'floating-whatsapp-settings',
            'floating_whatsapp_section',
            ['id' => 'icon', 'default' => 'fa-whatsapp']
        );

        add_settings_field(
            'color',
            __('Icon Color', 'wco_whatsappchatorder'),
            [$this, 'color_field_callback'],
            'floating-whatsapp-settings',
            'floating_whatsapp_section',
            ['id' => 'color', 'default' => '#ffffff']
        );

        add_settings_field(
            'bg_color',
            __('Background Color', 'wco_whatsappchatorder'),
            [$this, 'color_field_callback'],
            'floating-whatsapp-settings',
            'floating_whatsapp_section',
            ['id' => 'bg_color', 'default' => '#25D366']
        );

        add_settings_field(
            'whatsapp_number',
            __('WhatsApp Number', 'wco_whatsappchatorder'),
            [$this, 'text_field_callback'],
            'floating-whatsapp-settings',
            'floating_whatsapp_section',
            ['id' => 'whatsapp_number', 'default' => '']
        );
        
        add_settings_field(
            'message',
            __('Default Message', 'wco_whatsappchatorder'),
            [$this, 'text_field_callback'],
            'floating-whatsapp-settings',
            'floating_whatsapp_section',
            ['id' => 'message', 'default' => 'Hello! I have a question about {page_title}']
        );
    }

    public function settings_page_content() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Floating WhatsApp Icon Settings', 'wco_whatsappchatorder'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('floating_whatsapp_group');
                do_settings_sections('floating-whatsapp-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function text_field_callback($args) {
        $options = get_option('floating_whatsapp_settings', []);
        $value = isset($options[$args['id']]) ? esc_attr($options[$args['id']]) : $args['default'];
        echo "<input type='text' name='floating_whatsapp_settings[{$args['id']}]' value='$value' class='regular-text' />";
    }

    public function color_field_callback($args) {
        $options = get_option('floating_whatsapp_settings', []);
        $value = isset($options[$args['id']]) ? esc_attr($options[$args['id']]) : $args['default'];
        echo "<input type='color' name='floating_whatsapp_settings[{$args['id']}]' value='$value' />";
    }
}

new WCO_FloatingIconWhatsAppSettings();

