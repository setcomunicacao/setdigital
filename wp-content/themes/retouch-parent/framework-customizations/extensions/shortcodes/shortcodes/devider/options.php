<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'height'       => array(
		'type'  => 'short-text',
		'label' => __( 'Height', 'fw' ),
		'desc'  => __( 'Devider height', 'fw' ),
        'value' => 113
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