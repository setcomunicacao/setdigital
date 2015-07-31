<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(

    'title'    => array(
        'type'  => 'text',
        'label' => __( 'Title', 'fw' ),
        'desc'  => __( 'Zoom section title', 'fw' ),
    ),

    'subtitle' => array(
        'type'  => 'text',
        'label' => __( 'Subtitle', 'fw' ),
        'desc'  => __( 'Zoom section subtitle', 'fw' ),
    ),

    'image' => array(
        'type'  => 'upload',
        'label' => __( 'Image', 'fw' ),
        'desc'  => __( 'Upload zoom image', 'fw' ),
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