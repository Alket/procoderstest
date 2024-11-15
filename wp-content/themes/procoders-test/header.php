<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <div class="container">
            <div class="header-logo">
                <div class="logo">
                    <h1>Logo</h1>
                </div>
            </div>
            <div class="header-navigation">
                <nav>
                    <?php
                        wp_nav_menu(array(
                            'theme_location' => 'custom-header-menu',
                            'menu_class'     => 'custom-nav-menu',
                            'walker'         => new Custom_Walker_Nav_Menu(),
                        ));
                    ?>
                </nav>
            </div>
        </div>
    </header>
