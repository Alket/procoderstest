<?php
// Register Custom Post Type "Learning"
function procoders_register_learning_post_type() {
    $labels = array(
        'name'                  => _x('Learning', 'Post Type General Name', 'procoders-test'),
        'singular_name'         => _x('Learning', 'Post Type Singular Name', 'procoders-test'),
        'menu_name'             => __('Learning', 'procoders-test'),
        'name_admin_bar'        => __('Learning', 'procoders-test'),
        'add_new_item'          => __('Add New Learning', 'procoders-test'),
        'new_item'              => __('New Learning', 'procoders-test'),
        'edit_item'             => __('Edit Learning', 'procoders-test'),
        'view_item'             => __('View Learning', 'procoders-test'),
        'all_items'             => __('All Learning', 'procoders-test'),
        'search_items'          => __('Search Learning', 'procoders-test'),
    );
    $args = array(
        'label'                 => __('Learning', 'procoders-test'),
        'description'           => __('A custom post type for learning', 'procoders-test'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies'            => array(), // Leave empty; taxonomies added below
        'public'                => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-welcome-learn-more',
        'has_archive'           => true,
        'rewrite'               => array('slug' => 'learning'),
    );
    register_post_type('learning', $args);
}
add_action('init', 'procoders_register_learning_post_type');