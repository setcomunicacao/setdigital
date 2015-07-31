<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
    'title'   => array(
        'label' => __( 'Twitter Title', 'fw' ),
        'desc'  => __( 'Type twitter title here.', 'fw' ),
        'type'  => 'text',
        'value' => ''
    ),

    'username'   => array(
        'label' => __( 'Twitter User', 'fw' ),
        'desc'  => __( 'Enter your twitter user here.', 'fw' ),
        'type'  => 'text',
        'value' => 'darwinthemes'
    ),

    'number'   => array(
        'label' => __( 'Tweets Number', 'fw' ),
        'desc'  => __( 'Enter tweets number here.', 'fw' ),
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