<?php if (!defined('FW')) die('Forbidden');
$template_directory = get_template_directory_uri();
$options = array(
    'header_portf_color' => array(
        'type'  => 'gradient',
        'value' => array(
            'primary'   => '#000000',
            'secondary' => '#000000',
        ),
        'label' => __( 'Header Color', 'fw' ),
        'desc'  => __( 'Choose header color background', 'fw' ),
        'value' => fw_get_db_settings_option('header_portf_color')
    ),

    'header_portf_image' => array(
        'label' => __( 'Header Image', 'fw' ),
        'desc'  => __( 'Upload header image', 'fw' ),
        'type'  => 'upload',
        'value' => fw_get_db_settings_option('header_portf_image')
    ),

    'header_portf_pattern' => array(
        'label' => __( 'Header Pattern', 'fw' ),
        'desc'  => __( 'Upload header pattern', 'fw' ),
        'type'  => 'upload',
        'value' => fw_get_db_settings_option('header_portf_pattern')
    ),

    'portf-subtitle' => array(
        'label' => __( 'Subtitle', 'fw' ),
        'desc'  => __( 'Type subtitle', 'fw' ),
        'type'  => 'text',
        'value' => fw_get_db_settings_option('portf-subtitle')
    ),
    'portf-description' => array(
        'label' => __( 'Short Description', 'fw' ),
        'desc'  => __( 'Add a short description', 'fw' ),
        'type'  => 'textarea',
        'value' => fw_get_db_settings_option('portf-description')
    )
);