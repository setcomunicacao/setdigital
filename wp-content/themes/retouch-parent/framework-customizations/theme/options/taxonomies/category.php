<?php if (!defined('FW')) die('Forbidden');

$options = array(
    'header_blog_color' => array(
        'type'  => 'gradient',
        'value' => array(
            'primary'   => '#000000',
            'secondary' => '#000000',
        ),
        'label' => __( 'Header Color', 'fw' ),
        'desc'  => __( 'Choose header color background', 'fw' ),
        'value' => fw_get_db_settings_option('header_blog_color')
    ),
    'header_blog_image' => array(
        'label' => __( 'Header Image', 'fw' ),
        'desc'  => __( 'Upload header image.', 'fw' ) ,
        'type'  => 'upload',
        'value' => fw_get_db_settings_option('header_blog_image')
    ),
    'header_blog_pattern' => array(
        'label' => __( 'Header Pattern', 'fw' ),
        'desc'  => __( 'Upload header pattern.', 'fw' ) ,
        'type'  => 'upload',
        'value' => fw_get_db_settings_option('header_blog_pattern')
    ),

    'blog-subtitle' => array(
        'label' => __( 'Subtitle', 'fw' ),
        'desc'  => __( 'Add category subtitle.', 'fw' ),
        'type'  => 'text',
        'value' => fw_get_db_settings_option('blog-subtitle')
    ),
    'blog-description' => array(
        'label' => __( 'Short Description', 'fw' ),
        'desc'  => __( 'Add category short description.', 'fw'),
        'type'  => 'textarea',
        'value' => fw_get_db_settings_option('blog-description')
    ),
);