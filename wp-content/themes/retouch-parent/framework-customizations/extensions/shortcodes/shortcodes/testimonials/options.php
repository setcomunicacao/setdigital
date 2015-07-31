<?php if ( ! defined( 'FW' ) ) {
    die( 'Forbidden' );
}

$options = array(
    'title'   => array(
        'label' => __( 'Title', 'fw' ),
        'desc'  => __( 'Type title here.', 'fw' ),
        'type'  => 'text',
        'value' => ''
    ),
    'subtitle'  => array(
        'label' => __( 'Subtitle', 'fw' ),
        'desc'  => __( 'Type subtitle here.', 'fw' ),
        'type'  => 'text',
        'value' => ''
    ),

    'testimonials' => array(
        'type'  => 'addable-box',
        'value' => array(
            array(
                'image' => '',
                'name' => '',
                'company' => '',
                'text' => ''
            )
        ),
        'label' => __('Testimonial', 'fw'),
        'desc'  => __('Add Testimonial', 'fw'),
        'template' => '{{=name}}',
        'box-options' => array(
            'image' => array(
                'label' => __( 'Avatar', 'fw' ),
                'desc'  => __( 'Add image avatar', 'fw' ),
                'type'  => 'upload',
            ),
            'name' => array(
                'label' => __( 'Name', 'fw' ),
                'desc'  => __( 'Add a name', 'fw' ),
                'type'  => 'text',
            ),
            'position' => array(
                'label' => __( 'Position', 'fw' ),
                'desc'  => __( 'Add position', 'fw' ),
                'type'  => 'text'
            ),
            'text' => array(
                'label' => __( 'Text', 'fw' ),
                'desc'  => __( 'Add testimonial text here', 'fw' ),
                'type'  => 'textarea'
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