<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(

    'title'    => array(
        'type'  => 'text',
        'label' => __( 'Title', 'fw' ),
        'desc'  => __( 'Write the contact section title', 'fw' ),
    ),
    'subtitle' => array(
        'type'  => 'text',
        'label' => __( 'Subtitle', 'fw' ),
        'desc'  => __( 'Write the contact section subtitle', 'fw' ),
    ),

    'contact' => array(
        'type'  => 'textarea',
        'label' => __( 'Contact Shortcode', 'fw' ),
        'desc'  => __( 'Insert here contact shortcode (contact form 7 used)', 'fw' ),
    ),

    'text_color' => array(
        'type'  => 'color-picker',
        'value' => '',
        'label' => __( 'Text Color', 'fw' ),
        'desc'  => __( 'Choose section text color', 'fw' ),
    ),

    'map_picker' => array(
        'type'  => 'multi-picker',
        'label' => false,
        'desc'  => false,
        'picker' => array(
            'map_enable' =>array(
                'type'  => 'switch',
                'value' => '',
                'label' => __('Enable Map', 'fw'),
                'desc'  => __('Enable Google Map', 'fw'),
                'left-choice' => array(
                    'value' => 'map',
                    'label' => __('Yes', 'fw'),
                ),
                'right-choice' => array(
                    'value' => 'bg',
                    'label' => __('No', 'fw'),
                ),
            ),
        ),
        'choices' => array(
            'map' => array(
                'contact_map' => array(
                    'type'  => 'map',
                    'value' => array(
                        'coordinates' => array(
                            'lat'   => -34,
                            'lng'   => 150,
                        )
                    ),
                    'label' => __('Location', 'fw'),
                    'desc'  => __('Choose location on map', 'fw'),
                ),
                'zoom' => array(
                    'type'  => 'text',
                    'value' => 16,
                    'label' => __( 'Map Zoom', 'fw' ),
                    'desc'  => __( 'Type map zoom', 'fw' ),
                ),
            ),
            'bg' => array(
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
            )
        )
    )

);	