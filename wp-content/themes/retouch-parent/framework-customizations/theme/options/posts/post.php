<?php if (!defined('FW')) die('Forbidden');

$options = array(
    'main' => array(
        'title' => false,
        'type'  => 'box',
        'priority' => 'high',
        'context' => 'normal',
        'options' => array(
            'settings' => array(
                'title' => __('Header Settings', 'fw'),
                'type'  => 'tab',
                'options' => array(
                    'header_post_color' => array(
                        'type'  => 'gradient',
                        'value' => array(
                            'primary'   => '#000000',
                            'secondary' => '#000000',
                        ),
                        'label' => __( 'Header Color', 'fw' ),
                        'desc'  => __( 'Choose header color background', 'fw' ),
                        'value' => fw_get_db_settings_option('header_post_color')
                    ),

                    'header_post_image' => array(
                        'label' => __( 'Header Image', 'fw' ),
                        'desc'  => __( 'Upload header image', 'fw' ),
                        'type'  => 'upload',
                        'value' => fw_get_db_settings_option('header_post_image')
                    ),

                    'header_post_pattern' => array(
                        'label' => __( 'Header Pattern', 'fw' ),
                        'desc'  => __( 'Upload header pattern', 'fw' ),
                        'type'  => 'upload',
                        'value' => fw_get_db_settings_option('header_post_pattern')
                    ),

                    'header_post_title' => array(
                        'label' => __( 'Header Title', 'fw' ),
                        'desc'  => __( 'Add header title here', 'fw' ),
                        'type'  => 'text',
                        'value' => fw_get_db_settings_option('header_post_title')
                    )
                ),
            ),
        ),
    ),
);