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
                            $menu_primary = wp_get_nav_menu_items('primary');
                            $print_primary  = '<ul id="nav-bar__menu" class="nav-bar__menu">';
                            foreach($menu_primary as $item){
                                if($item != end($menu_primary)){
                                    $print_primary .=   '<li class="menu-item">';
                                    $print_primary .=       '<a href="'.home_url() . $item->url.'" title="Ir a '.$item->title.'">'. $item->title .'</a>';
                                }else{
                                    $print_primary .=   '<li class="menu-item menu-item--special--current">';
                                    $print_primary .=       '<a href="'.get_permalink().'" title="Ir a '.$item->title.'">'. $item->title .'</a>';
                                } $item->title .'</a>';
                                $print_primary .=   '</li>';
                            }
                            $print_primary .= '</ul>';
                            echo $print_primary;
                        ?>
                            <div class="nav-bar__auxmenu" data-area-name="menu-top@tablet"></div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
