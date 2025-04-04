<?php

add_action('after_setup_theme', 'blankslate_setup');
function blankslate_setup() {
    load_theme_textdomain('blankslate', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', ['search-form', 'navigation-widgets']);
    add_theme_support('appearance-tools');
    add_theme_support('woocommerce');
    
    global $content_width;
    if (!isset($content_width)) { $content_width = 1920; }

    register_nav_menus(['main-menu' => esc_html__('Main Menu', 'blankslate')]);
}

// Admin Notice (Fixed esc_url() issue)
add_action('admin_notices', 'blankslate_notice');
function blankslate_notice() {
    $user_id = get_current_user_id();
    if (!get_user_meta($user_id, 'blankslate_notice_dismissed_11') && current_user_can('manage_options')) {
        echo '<div class="notice notice-info">';
        echo '<p><strong>' . esc_html__('🏆 Thank you for using BlankSlate!', 'blankslate') . '</strong></p>';
        echo '<a href="https://opencollective.com/blankslate" class="button-primary" target="_blank">' . esc_html__('Donate', 'blankslate') . '</a>';
        echo '</div>';
    }
}

// Dismiss Notice
add_action('admin_init', 'blankslate_notice_dismissed');
function blankslate_notice_dismissed() {
    if (isset($_GET['dismiss'])) {
        add_user_meta(get_current_user_id(), 'blankslate_notice_dismissed_11', 'true', true);
    }
}

// Enqueue Styles and Scripts (Fixed duplicate)
function blankslate_enqueue() {
    wp_enqueue_style('blankslate-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
    wp_enqueue_style('blankslate-custom-block', get_template_directory_uri() . '/assets/css/custom-block.css', [], '1.0');
    wp_enqueue_script('blankslate-custom-block-js', get_template_directory_uri() . '/assets/js/custom-block.js', ['jquery'], '1.0', true);
}
add_action('wp_enqueue_scripts', 'blankslate_enqueue');

// Carbon Fields Setup
use Carbon_Fields\Carbon_Fields;
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Block;

function crb_load() {
    require_once get_template_directory() . '/vendor/autoload.php';
    Carbon_Fields::boot();
}
add_action('after_setup_theme', 'crb_load');

function register_custom_block() {
    Block::make('Custom Block')
        ->add_fields([
            Field::make('text', 'custom_text', 'Text Field'),
            Field::make('image', 'custom_image', 'Image Field'),
            Field::make('color', 'custom_color', 'Background Color')
        ])
        ->set_render_callback(function ($fields, $attributes, $inner_blocks) {
            $image_url = wp_get_attachment_image_url($fields['custom_image'], 'full');
            $background_color = !empty($fields['custom_color']) ? $fields['custom_color'] : '#ffffff';
            ?>
            <div class="custom-block-container" style="--block-bg-color: <?php echo esc_attr($background_color); ?>;">
                <?php if ($image_url): ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="" class="custom-block-image">
                <?php endif; ?>
                <p class="custom-block-text"><?php echo esc_html($fields['custom_text']); ?></p>
            </div>
            <?php
        });
}
add_action('carbon_fields_register_fields', 'register_custom_block');


// Enqueue Custom Block Styles (Fixed file existence check)
function custom_block_styles() {
    $css_file = get_template_directory() . '/styles/custom-block.css';
    if (file_exists($css_file)) {
        wp_enqueue_style('custom-block-styles', get_template_directory_uri() . '/styles/custom-block.css', [], filemtime($css_file));
    }
}



function custom_block_enqueue_scripts() {
    $js_file = get_template_directory() . '/blocks/custom-block.js';
    if (file_exists($js_file)) {
        wp_enqueue_script('custom-block-js', get_template_directory_uri() . '/blocks/custom-block.js', ['wp-blocks', 'wp-editor', 'wp-components'], filemtime($js_file), true);
    }
}

add_action('wp_enqueue_scripts', 'custom_block_styles');
add_action('enqueue_block_editor_assets', 'custom_block_enqueue_scripts');

// Footer Scripts
add_action('wp_footer', 'blankslate_footer');
function blankslate_footer() {
?>
<script>
jQuery(document).ready(function($) {
    var deviceAgent = navigator.userAgent.toLowerCase();
    if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
        $("html").addClass("ios mobile");
    } else if (deviceAgent.match(/(android)/)) {
        $("html").addClass("android mobile");
    } else if (navigator.userAgent.search("MSIE") >= 0) {
        $("html").addClass("ie");
    } else if (navigator.userAgent.search("Chrome") >= 0) {
        $("html").addClass("chrome");
    } else if (navigator.userAgent.search("Firefox") >= 0) {
        $("html").addClass("firefox");
    } else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
        $("html").addClass("safari");
    } else if (navigator.userAgent.search("Opera") >= 0) {
        $("html").addClass("opera");
    }
});
</script>
<?php
}
?>
