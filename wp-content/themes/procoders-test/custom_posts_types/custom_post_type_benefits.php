<?php
// Register Custom Post Type Benefits
function procoders_register_benefits_post_type() {
    $labels = array(
        'name'                  => _x('Benefits', 'Post Type General Name', 'procoders-test'),
        'singular_name'         => _x('Benefit', 'Post Type Singular Name', 'procoders-test'),
        'menu_name'             => __('Benefits', 'procoders-test'),
        'name_admin_bar'        => __('Benefit', 'procoders-test'),
        'add_new_item'          => __('Add New Benefit', 'procoders-test'),
        'new_item'              => __('New Benefit', 'procoders-test'),
        'edit_item'             => __('Edit Benefit', 'procoders-test'),
        'view_item'             => __('View Benefit', 'procoders-test'),
        'all_items'             => __('All Benefits', 'procoders-test'),
        'search_items'          => __('Search Benefits', 'procoders-test'),
    );
    $args = array(
        'label'                 => __('Benefit', 'procoders-test'),
        'description'           => __('A custom post type for Benefits', 'procoders-test'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'taxonomies'            => array(),
        'public'                => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-awards',
        'has_archive'           => true,
        'rewrite'               => array('slug' => 'benefits'),
    );
    register_post_type('benefits', $args);
}
add_action('init', 'procoders_register_benefits_post_type');


// Register Custom Taxonomy for Benefits
function procoders_register_benefit_categories() {
    $labels = array(
        'name'              => _x('Benefit Categories', 'taxonomy general name', 'procoders-test'),
        'singular_name'     => _x('Benefit Category', 'taxonomy singular name', 'procoders-test'),
        'search_items'      => __('Search Benefit Categories', 'procoders-test'),
        'all_items'         => __('All Benefit Categories', 'procoders-test'),
        'edit_item'         => __('Edit Benefit Category', 'procoders-test'),
        'update_item'       => __('Update Benefit Category', 'procoders-test'),
        'add_new_item'      => __('Add New Benefit Category', 'procoders-test'),
        'new_item_name'     => __('New Benefit Category Name', 'procoders-test'),
    );
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'benefit-category'),
    );
    register_taxonomy('benefit_category', array('benefits'), $args);
}
add_action('init', 'procoders_register_benefit_categories');



// Register Shortcode for Benefits Category Tabs
function procoders_benefits_category_tabs() {
    // Enqueue necessary script for AJAX functionality
    wp_enqueue_script('benefits-ajax-script', get_template_directory_uri() . '/js/benefits-ajax.js', array('jquery'), null, true);
    wp_localize_script('benefits-ajax-script', 'benefits_ajax_obj', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));

    // Fetch all benefit categories
    $categories = get_terms(array(
        'taxonomy' => 'benefit_category',
        'hide_empty' => true,
    ));

    if (empty($categories)) {
        return '<p>No categories found.</p>';
    }

    ob_start();

    // Tabs for each category
    echo '<div class="benefits-tabs container">';
    echo '<ul class="tabs-nav">';
        foreach ($categories as $category) {
            echo '<li class="tab" data-tab="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</li>';
        }
    echo '</ul>';

    // Content for each category
    echo '<div class="tabs-content">';
 
    foreach ($categories as $category) {
        echo '<div class="tab-content" id="tab-' . esc_attr($category->term_id) . '">';
            echo procoders_get_benefits_posts($category->term_id, 6);
            echo '<div class="load-more-wrapper">';
                if($category->count > 6) {
                    echo '<button class="load-more" data-category="' . esc_attr($category->term_id) . '" data-offset="6">Load More</button>';
                }
            echo '</div>';
        echo '</div>';
    }
    echo '</div></div>';

    return ob_get_clean();
}
add_shortcode('benefits_category_tabs', 'procoders_benefits_category_tabs');



// Helper function to get Benefits posts by category
function procoders_get_benefits_posts($category_id, $posts_per_page, $offset = 0) {
    $query = new WP_Query(array(
        'post_type' => 'benefits',
        'posts_per_page' => $posts_per_page,
        'offset' => $offset,
        'tax_query' => array(
            array(
                'taxonomy' => 'benefit_category',
                'field' => 'term_id',
                'terms' => $category_id,
            ),
        ),
    ));

    if (!$query->have_posts()) {
        return '<div style="text-align:center">No posts found.</div>';
    }

    ob_start(); // Start output buffering
    echo '<div class="benefits-posts">';
    while ($query->have_posts()) {
        $query->the_post();
        $icon_post = get_field('icon');
        echo '<div class="benefit-item">';
            echo '<div class="icon-post">';
                echo '<img src="'. $icon_post . '"/>';
            echo '</div>';
            echo '<h3>' . get_the_title() . '</h3>';
        echo '</div>';
    }
    echo '</div>';
    wp_reset_postdata();
    return ob_get_clean(); // Return the buffered content
}



// AJAX handler for loading more posts
function procoders_load_more_benefits_posts() {
    $category_id = intval($_POST['category']);
    $offset = intval($_POST['offset']);
    
    // Output more posts starting from the offset
    echo procoders_get_benefits_posts($category_id, 3, $offset);

    wp_die(); // End AJAX response
}
add_action('wp_ajax_nopriv_procoders_load_more_benefits_posts', 'procoders_load_more_benefits_posts');
add_action('wp_ajax_procoders_load_more_benefits_posts', 'procoders_load_more_benefits_posts');



function procoders_enqueue_scripts() {
    wp_enqueue_script('benefits-ajax-script', get_template_directory_uri() . '/assets/js/benefits-ajax.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'procoders_enqueue_scripts');