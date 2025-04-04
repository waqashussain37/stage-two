<?php
/**
 * Plugin Name: Simple Case Studies Plugin
 * Description: Registers a custom post type for case studies.
 * Version: 1.0.0
 * Author: Waqas Hussain
 * Text Domain: simple-case-studies
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Registers the Case Study custom post type.
 */
function simple_case_studies_register_post_type() {
    $labels = array(
        'name'               => _x('Case Studies', 'post type general name', 'simple-case-studies'),
        'singular_name'      => _x('Case Study', 'post type singular name', 'simple-case-studies'),
        'menu_name'          => _x('Case Studies', 'admin menu', 'simple-case-studies'),
        'name_admin_bar'     => _x('Case Study', 'add new on admin bar', 'simple-case-studies'),
        'add_new'            => _x('Add New', 'case study', 'simple-case-studies'),
        'add_new_item'       => __('Add New Case Study', 'simple-case-studies'),
        'new_item'           => __('New Case Study', 'simple-case-studies'),
        'edit_item'          => __('Edit Case Study', 'simple-case-studies'),
        'view_item'          => __('View Case Study', 'simple-case-studies'),
        'all_items'          => __('All Case Studies', 'simple-case-studies'),
        'search_items'       => __('Search Case Studies', 'simple-case-studies'),
        'parent_item_colon'  => __('Parent Case Studies:', 'simple-case-studies'),
        'not_found'          => __('No case studies found.', 'simple-case-studies'),
        'not_found_in_trash' => __('No case studies found in Trash.', 'simple-case-studies'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'case-study'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'editor', 'thumbnail'),
        'menu_icon'          => 'dashicons-analytics',
    );

    register_post_type('case_study', $args);
}
add_action('init', 'simple_case_studies_register_post_type');


function simple_case_studies_load_textdomain() {
    load_plugin_textdomain('simple-case-studies', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'simple_case_studies_load_textdomain');

?>