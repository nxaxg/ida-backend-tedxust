<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php bloginfo(name); ?></title>
    <meta name="description" content="<?php bloginfo('description'); ?>" />
    <?php wp_head(); ?>
</head>

<body>
    <?php echo get_field("google_analytics","options"); ?>
    <header class="header-bar">
        <nav class="nav-bar" data-module="nav-bar">
            <div class="container">
                <div class="nav-bar__holder">
                    <div class="nav-bar__brand">
                        <a class="app-brand app-brand--inline" href="<?php echo home_url(); ?>">
                            <img class="app-brand__logo" src="<?php echo get_bloginfo('template_directory'); ?>/images/logos/ted-logo-header.svg" alt="Logo">
                        </a>
                    </div>
                    <div class="nav-bar__body" data-role="nav-body">
                        <button class="nav-bar__deploy-button" aria-label="Ver menú" data-role="nav-deployer">
							<span></span>
						</button>
                        <div class="nav-bar__menu-holder">
                                <?php
                                    $settings = array(
                                        'theme_location'  => '',
                                        'menu'            => 'primary',
                                        'container'       => 'ul',
                                        'container_class' => 'nav-bar__menu',
                                        'container_id'    => 'nav-bar__menu',
                                        'menu_class'      => 'nav-bar__menu-holder',
                                        'menu_id'         => '',
                                        'echo'            => true,
                                        'fallback_cb'     => 'false',
                                        'before'          => '',
                                        'after'           => '',
                                        'link_before'     => '',
                                        'link_after'      => '',
                                        'items_wrap'      => '<ul id="nav-bar__menu" class="nav-bar__menu">%3$s</ul>',
                                        'depth'           => 0,
                                        'walker'          => '');
                                    wp_nav_menu($settings);
                                ?>
                            <div class="nav-bar__auxmenu" data-area-name="menu-top@tablet"></div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
