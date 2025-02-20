<?php
// print_r(plugin_dir_path(__DIR__).'whatsapp-chat-order.php');
register_activation_hook(plugin_dir_path(__DIR__).'whatsapp-chat-order.php', function() {
    $plugin_root = plugin_dir_path(__DIR__);
    $css_file = $plugin_root . 'assets/font-awesome/css/font-awesome.css';
    $output_file = $plugin_root . 'assets/icons.json';

    // die("File: {$css_file} Exists: ".file_exists($css_file).".");
    
    if (!file_exists($css_file)) return;
    
    $css_content = file_get_contents($css_file);
    // preg_match_all('/\.fa-([a-z0-9-]+):before\s*{\s*content:\s*"\\[^"\']+";\s*}/', $css_content, $matches);
    preg_match_all('/\.fa-([a-z0-9-]+):before\s*{\s*content:\s*"\\([a-f0-9]+)";\s*}/i', $css_content, $matches);

    // print_r($matches[1]); die();
    
    if (!empty($matches[1])) {
        file_put_contents($output_file, json_encode($matches[1]));
    }
});

add_action('wp_ajax_get_fa_icons', function() {
    $icons_file = plugin_dir_path(__DIR__) . 'assets/icons.json';
    if (file_exists($icons_file)) {
        wp_send_json(json_decode(file_get_contents($icons_file)));
    } else {
        wp_send_json([]);
    }
});

add_action('admin_menu', function() {
    add_options_page('FA Icon Picker', 'FA Icon Picker', 'manage_options', 'fa-icon-picker', 'render_fa_icon_picker');
});

function render_fa_icon_picker() {
    $selected_icon = get_option('fa_selected_icon', 'whatsapp');
    echo '<button id="select-icon">Select Icon</button>';
    echo '<span id="selected-icon" class="fa fa-' . esc_attr($selected_icon) . '"></span>';
    echo '<input type="hidden" id="fa-icon-input" name="fa_selected_icon" value="' . esc_attr($selected_icon) . '" />';
    echo '<div id="icon-modal" style="display:none;"><input type="text" id="search-icon" placeholder="Search Icons..."><div id="icon-list"></div></div>';
}

add_action('admin_enqueue_scripts', function() {
    wp_enqueue_script('fa-icon-picker', plugin_dir_path(__DIR__) . 'assets/icon-picker.js', ['jquery'], null, true);
    wp_localize_script('fa-icon-picker', 'faIconAjax', ['ajaxurl' => admin_url('admin-ajax.php')]);
    wp_enqueue_style('fa-style', plugin_dir_path(__DIR__) . 'assets/font-awesome/css/font-awesome.min.css');
});
