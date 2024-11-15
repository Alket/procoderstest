<?php
// Enqueue styles and scripts
function my_custom_theme_scripts() {
    wp_enqueue_style( 'main-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'my_custom_theme_scripts' );


// Enqueues the external CSS and JS File
function procoders_css() {
    wp_enqueue_style( 'custom-css', get_template_directory_uri().'/assets/css/custom.css' );
}
add_action( 'wp_enqueue_scripts', 'procoders_css' );

// Enqueues external JS File
function procoders_js() {
    wp_enqueue_script( 'custom-script', get_template_directory_uri() . '/assets/js/custom.js', array('jquery'), false, true );
}
add_action( 'wp_enqueue_scripts', 'procoders_js' );

// Allow SVG Upload
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


// Include Custom Post Type Templates
require_once get_template_directory() . '/custom_posts_types/custom_post_type_benefits.php';
require_once get_template_directory() . '/custom_posts_types/custom_post_type_events.php';
require_once get_template_directory() . '/custom_posts_types/custom_post_type_learning.php';


// Register Main Menu
function register_custom_menu() {
    register_nav_menu('custom-header-menu', __('Custom Header Menu'));
}
add_action('init', 'register_custom_menu');


// Add custom fields for diferent leveles of menus
function custom_nav_menu_item_fields($item_id, $item, $depth, $args, $id) {

    //Show Url Icon only for level 2
    if ($depth == 2) {
        ?>
        <p class="description description-wide">
            <label for="edit-menu-item-icon-<?php echo $item_id; ?>">
                Icon URL<br />
                <input type="text" id="edit-menu-item-icon-<?php echo $item_id; ?>" class="widefat code edit-menu-item-custom" name="menu-item-icon[<?php echo $item_id; ?>]" value="<?php echo esc_attr(get_post_meta($item_id, '_menu_item_icon', true)); ?>" />
                <span class="description">URL for the icon image</span>
            </label>
        </p>
        <?php
    }

    //Show Additional Text only for level > 2
    if ($depth > 2) {
        ?>
            <p class="description description-wide">
                <label for="edit-menu-item-additional-text-<?php echo $item_id; ?>">
                    Additional Text<br />
                    <input type="text" id="edit-menu-item-additional-text-<?php echo $item_id; ?>" class="widefat code edit-menu-item-custom" name="menu-item-additional-text[<?php echo $item_id; ?>]" value="<?php echo esc_attr(get_post_meta($item_id, '_menu_item_additional_text', true)); ?>" />
                    <span class="description">Text displayed below the menu item</span>
                </label>
            </p>
        <?php
    }

    //Add Check Box to control Mega Menu
    $is_mega_menu = get_post_meta($item_id, '_menu_item_is_mega_menu', true);
    ?>
    <p class="field-mega-menu description description-wide">
        <label for="edit-menu-item-is-mega-menu-<?php echo $item_id; ?>">
            <input type="checkbox" id="edit-menu-item-is-mega-menu-<?php echo $item_id; ?>" 
                   name="menu-item-is-mega-menu[<?php echo $item_id; ?>]" 
                   value="1" <?php checked($is_mega_menu, '1'); ?> />
            Enable Mega Menu
        </label>
    </p>
    <?php

    // Apply only to top-level items
    if ($depth === 0) {
        // CTA Heading
        $cta_text = get_post_meta($item_id, '_menu_item_cta_text', true);
        ?>
        <p class="description description-wide">
            <label for="edit-menu-item-cta-text-<?php echo $item_id; ?>">
                Mega Menu CTA Text (only for Mega Menus)<br>
                <input type="text" id="edit-menu-item-cta-text-<?php echo $item_id; ?>" class="widefat edit-menu-item-cta-text" name="menu-item-cta-text[<?php echo $item_id; ?>]" value="<?php echo esc_attr($cta_text); ?>" />
            </label>
        </p>
        <?php

        // CTA Subheading
        $cta_subheading = get_post_meta($item_id, '_menu_item_cta_subheading', true);
        ?>
        <p class="description description-wide">
            <label for="edit-menu-item-cta-subheading-<?php echo $item_id; ?>">
                Mega Menu CTA Subheading<br>
                <input type="text" id="edit-menu-item-cta-subheading-<?php echo $item_id; ?>" class="widefat edit-menu-item-cta-subheading" name="menu-item-cta-subheading[<?php echo $item_id; ?>]" value="<?php echo esc_attr($cta_subheading); ?>" />
            </label>
        </p>
        <?php

        // CTA Button Link
        $cta_link = get_post_meta($item_id, '_menu_item_cta_link', true);
        ?>
        <p class="description description-wide">
            <label for="edit-menu-item-cta-link-<?php echo $item_id; ?>">
                Mega Menu CTA Link URL<br>
                <input type="url" id="edit-menu-item-cta-link-<?php echo $item_id; ?>" class="widefat edit-menu-item-cta-link" name="menu-item-cta-link[<?php echo $item_id; ?>]" value="<?php echo esc_attr($cta_link); ?>" />
            </label>
        </p>
        <?php
    }
}
add_action('wp_nav_menu_item_custom_fields', 'custom_nav_menu_item_fields', 10, 5);


// Save the custom fields for submenu items
function save_custom_nav_menu_item_fields($menu_id, $menu_item_db_id) {

    //Icon
    if (isset($_POST['menu-item-icon'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_icon', sanitize_text_field($_POST['menu-item-icon'][$menu_item_db_id]));
    }

    //Additional Text
    if (isset($_POST['menu-item-additional-text'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_additional_text', sanitize_text_field($_POST['menu-item-additional-text'][$menu_item_db_id]));
    }

    //Check Box Mega Menu
    if (isset($_POST['menu-item-is-mega-menu'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_is_mega_menu', 1);
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_is_mega_menu');
    }

    //CTA Heading
    if (isset($_POST['menu-item-cta-text'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_cta_text', sanitize_text_field($_POST['menu-item-cta-text'][$menu_item_db_id]));
    }

    //CTA Subheading
    if (isset($_POST['menu-item-cta-subheading'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_cta_subheading', sanitize_text_field($_POST['menu-item-cta-subheading'][$menu_item_db_id]));
    }

    //CTA Link
    if (isset($_POST['menu-item-cta-link'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_cta_link', esc_url_raw($_POST['menu-item-cta-link'][$menu_item_db_id]));
    }
}
add_action('wp_update_nav_menu_item', 'save_custom_nav_menu_item_fields', 10, 2);


class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    private $is_mega_menu = false;

    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $level_class = 'level-' . str_pad($depth + 1, 2, '0', STR_PAD_LEFT);

        // Set Mega menu class to check if this level should be maga menu
        if ($depth === 0 && $this->is_mega_menu) {
            $submenu_class = 'submenu submenu-main mega-menu';
        } else {
            $submenu_class = ($depth === 0) ? 'submenu submenu-main flyout-menu' : 'submenu-secondary';
        }

        $style = $depth < 1 ? ' style="display: none;"' : '';

        $output .= "\n$indent<ul class=\"$submenu_class $level_class\"$style>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $level_class = 'level-' . str_pad($depth + 1, 2, '0', STR_PAD_LEFT);

        // Set mega menu flag for top-level items
        if ($depth === 0) {
            // Check if this item should be a mega menu
            $this->is_mega_menu = (bool) get_post_meta($item->ID, '_menu_item_is_mega_menu', true);
            
            // Store the top-level menu item ID for use in end_lvl
            $this->mega_menu_item_id = $item->ID;
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($item->classes), $item, $args, $depth));
        
        // Add mega menu class to top-level items if enabled
        if ($depth === 0 && $this->is_mega_menu) {
            $class_names .= ' has-megamenu';
        }

        $class_names = ' class="' . esc_attr($class_names) . '"';

        // Link attributes and custom fields for submenu items
        $icon = $depth > 0 ? get_post_meta($item->ID, '_menu_item_icon', true) : '';
        $additional_text = $depth > 0 ? get_post_meta($item->ID, '_menu_item_additional_text', true) : '';

        $attributes  = !empty($item->url) ? ' href="' . esc_url($item->url) . '"' : '';
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . $class_names . '>';
        
        // Add icon if available
        if (!empty($icon)) {
            $item_output .= '<img src="' . esc_url($icon) . '" class="menu-icon" alt=""> ';
        }
        
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';

        // Add additional text if available
        if (!empty($additional_text)) {
            $item_output .= '<p class="menu-item-description">' . esc_html($additional_text) . '</p>';
        }

        $item_output .= $args->after;
        $output .= $indent . '<li' . $class_names . '>';
        $output .= $item_output;
    }

    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = null) {
        if ($depth === 0 && $this->is_mega_menu) {
            // Fetch the CTA values from the stored top-level menu item ID
            $cta_text = get_post_meta($this->mega_menu_item_id, '_menu_item_cta_text', true) ?: '';
            $cta_subheading = get_post_meta($this->mega_menu_item_id, '_menu_item_cta_subheading', true) ?: '';
            $cta_link = get_post_meta($this->mega_menu_item_id, '_menu_item_cta_link', true) ?: '#';
    
            // Generate the CTA output only if CTA text is available
            if (!empty($cta_text)) {
                $cta_output = '<li class="menu-item custom-cta-row">';
                $cta_output .= '<div class="cta-container">';
                $cta_output .= '<div class="cta-container-text">';
                $cta_output .= '<h3 class="cta-heading">' . esc_html($cta_text) . '</h3>';
                $cta_output .= '<p class="cta-subheading">' . esc_html($cta_subheading) . '</p>';
                $cta_output .= '</div>';
                $cta_output .= '<a href="' . esc_url($cta_link) . '" class="cta-button">Watch Demo</a>';
                $cta_output .= '</div>';
                $cta_output .= '</li>';
    
                $output .= $cta_output;
            }
        }
    
        if ($depth === 0) {
            // Reset is_mega_menu and mega_menu_item_id for the next top-level item
            $this->is_mega_menu = false;
            $this->mega_menu_item_id = null;
        }
    
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
}



