<?php if ( ! defined( 'FW' ) ) {
    die( 'Forbidden' );
}
$template_directory = get_template_directory_uri();
$options = array(

    'title'    => array(
        'type'  => 'text',
        'label' => __( 'Title', 'fw' ),
        'desc'  => __( 'Section title', 'fw' ),
    ),
    'subtitle' => array(
        'type'  => 'text',
        'label' => __( 'Subtitle', 'fw' ),
        'desc'  => __( 'Section subtitle', 'fw' ),
    ),

    'image' => array(
        'type'  => 'upload',
        'label' => __( 'Image', 'fw' ),
        'desc'  => __( 'Upload section image', 'fw' ),
    ),

    'alignment' => array(
        'label' => __( 'Alignment', 'fw' ),
        'desc'  => __( 'Choose image alignment', 'fw' ),
        'type'  => 'select',
        'value' => '',
        'choices' => array(
            'sticky-a' => __('Position 1','fw'),
            'sticky-b' => __('Position 2','fw'),
            'sticky-b a' => __('Position 3','fw'),
            'sticky-b b' => __('Position 4','fw'),
            'sticky-c' => __('Position 5','fw'),
            'sticky-d' => __('Position 6','fw')
        ),
    ),

    'numbers' => array(
        'type'  => 'text',
        'label' => __( 'Number', 'fw' ),
        'desc'  => __( 'Add a number ( it will be displayed as a counter)', 'fw' ),
        'value' => '0238'
    ),

    'text' => array(
        'type'  => 'text',
        'label' => __( 'Short Text', 'fw' ),
        'desc'  => __( 'After number text', 'fw' ),
        'value' => 'Downloads'
    ),
    'apple_link' => array(
        'label' => __( 'App Store URL', 'fw' ),
        'desc'  => __( 'Add App Store button URL', 'fw' ),
        'type'  => 'text',
        'value' => ''
    ),
    'play_link' => array(
        'label' => __( 'Google Play URL', 'fw' ),
        'desc'  => __( 'Add Google Play button URL', 'fw' ),
        'type'  => 'text',
        'value' => ''
    ),

    'text_color' => array(
        'type'  => 'color-picker',
        'value' => '',
        'label' => __( 'Text Color', 'fw' ),
        'desc'  => __( 'Choose section text color', 'fw' ),
    ),

    'header_color' => array(
        'type'  => 'gradient',
        'value' => array(
            'primary'   => ' ',
            'secondary' => ' ',
        ),
        'label' => __( 'Bg Color', 'fw' ),
        'desc'  => __( 'Choose section background color', 'fw' ),
    ),

    'header_image' => array(
        'label' => __( 'Bg Image', 'fw' ),
        'desc'  => __( 'Upload section background image', 'fw' ),
        'type'  => 'upload',
        'value' => ''
    ),

    'header_pattern' => array(
        'label' => __( 'Bg Pattern', 'fw' ),
        'desc'  => __( 'Upload section background image pattern', 'fw' ),
        'type'  => 'upload',
        'value' => ''
    ),

);