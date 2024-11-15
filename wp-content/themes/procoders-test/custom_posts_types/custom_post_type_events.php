<?php
// Register Custom Post Type "Events"
function procoders_register_events_post_type() {
    $labels = array(
        'name'                  => _x('Events', 'Post Type General Name', 'procoders-test'),
        'singular_name'         => _x('Event', 'Post Type Singular Name', 'procoders-test'),
        'menu_name'             => __('Events', 'procoders-test'),
        'name_admin_bar'        => __('Events', 'procoders-test'),
        'add_new_item'          => __('Add New Events', 'procoders-test'),
        'new_item'              => __('New Events', 'procoders-test'),
        'edit_item'             => __('Edit Events', 'procoders-test'),
        'view_item'             => __('View Events', 'procoders-test'),
        'all_items'             => __('All Events', 'procoders-test'),
        'search_items'          => __('Search Events', 'procoders-test'),
    );
    $args = array(
        'label'                 => __('Events', 'procoders-test'),
        'description'           => __('A custom post type for events', 'procoders-test'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies'            => array(), // Leave empty; taxonomies added below
        'public'                => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-sticky',
        'has_archive'           => true,
        'rewrite'               => array('slug' => 'events'),
    );
    register_post_type('events', $args);
}
add_action('init', 'procoders_register_events_post_type');