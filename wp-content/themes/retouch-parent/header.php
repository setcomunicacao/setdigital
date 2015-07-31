<!DOCTYPE html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><html lang="en" class="no-js" <?php language_attributes(); ?>> <![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <meta name="HandheldFriendly" content="true">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=0.9, maximum-scale=0.9, user-scalable=no, target-densitydpi=device-dpi">
    <?php if (defined('FW')) fw_theme_get_the_favicon(); ?>
    <?php wp_head();?>
</head>
<body <?php body_class(); ?>>
<div id="root" class="theme-b has-gradient has-pattern">
    <header id="top">
        <?php if(defined('FW')): ?>
            <h1>
                <?php fw_theme_type_logo();?>
            </h1>
        <?php endif;?>
        <nav id="skip">
            <ul>
                <li><a href="#nav" accesskey="n"><?php _e('Skip to navigation','fw');?> (n)</a></li>
                <li><a href="#content" accesskey="c"><?php _e('Skip to content','fw');?> (c)</a></li>
                <li><a href="#footer" accesskey="f"><?php _e('Skip to footer','fw');?> (f)</a></li>
            </ul>
        </nav>
            <?php
                if(defined('FW'))
                    fw_theme_nav_menu('primary');
                else
                {
                    $menus = array(
                        'primary' => array(
                            'depth'           => 2,
                            'container'       => 'nav',
                            'container_id'    => 'nav',
                            'theme_location'  => 'primary',
                            'fallback_cb'     => 'fw_theme_select_menu_message',
                        )
                    );
                    wp_nav_menu($menus['primary']);
                }
            ?>
    </header>