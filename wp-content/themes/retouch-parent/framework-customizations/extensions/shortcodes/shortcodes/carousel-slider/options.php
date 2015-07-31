<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
    'title'   => array(
        'label' => __( 'Title', 'fw' ),
        'desc'  => __( 'Type section title here.', 'fw' ),
        'type'  => 'text',
        'value' => ''
    ),
    'subtitle'  => array(
        'label' => __( 'Subtitle', 'fw' ),
        'desc'  => __( 'Type section subtitle here.', 'fw' ),
        'type'  => 'text',
        'value' => ''
    ),
    'desc'  => array(
        'label' => __( 'Description', 'fw' ),
        'desc'  => __( 'Add a short description.', 'fw' ),
        'type'  => 'textarea',
        'value' => ''
    ),

    'slider' => array(
        'type'  => 'addable-box',
        'value' => array(
            array(
                'name' => '',
                'image' => '',
                'link' => ''
            )
        ),
        'label' => __('Slides', 'fw'),
        'desc'  => __('Add Slide', 'fw'),
        'template' => '{{=name}}',
        'box-options' => array(
            'name' => array(
                'label' => __('Name','fw'),
                'desc'  => __( 'Enter a name (it is for internal use and will not appear on the front end)', 'fw' ),
                'type' => 'text'
            ),
            'image' => array(
                'label' => __( 'Slide Image', 'fw' ),
                'desc'  => __( 'Upload slide image', 'fw' ),
                'type'  => 'upload',
            ),
            'link' => array(
                'label' => __( 'Slide Link', 'fw' ),
                'desc'  => __( 'Type slide link here', 'fw' ),
                'type'  => 'text'
            ),
        ),
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