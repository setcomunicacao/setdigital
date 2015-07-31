<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$template_directory = get_template_directory_uri();
$options = array(
    'header-type-picker' => array(
        'type'  => 'multi-picker',
        'label' => false,
        'desc'  => false,
        'picker' => array(
            'icon-box-type' => array(
                'label' => __('Header Type', 'fw'),
                'type'  => 'select',
                'value' => 'header-small',
                'desc'  => __('Select header type', 'fw'),
                'choices' => array(
                    'header-small' => __('Header Small','fw'),
                    'header-big' => __('Header Big','fw'),
                ),
            ),
        ),
        'choices' => array(
            'header-small' => array(
                'header-title'  => array(
                    'type'  => 'text',
                    'label' => __( 'Header Title', 'fw' ),
                    'desc'  => __( 'Add header title here.', 'fw' )
                )
            ),
            'header-big' => array(
                'header_image' => array(
                    'label' => __( 'Main Image', 'fw' ),
                    'desc'  => __( 'Upload main header image', 'fw' ),
                    'type'  => 'upload',
                    'value' => ''
                ),

                'align' => array(
                    'type'  => 'switch',
                    'value' => '',
                    'label' => __('Alignment', 'fw'),
                    'desc'  => __('Choose image alignment.', 'fw'),
                    'left-choice' => array(
                        'value' => 'left',
                        'label' => __('Left', 'fw'),
                    ),
                    'right-choice' => array(
                        'value' => 'Right',
                        'label' => __('Right', 'fw'),
                    ),
                ),

                'header-title'  => array(
                    'type'  => 'text',
                    'label' => __( 'Header Title', 'fw' ),
                    'desc'  => __( 'Add header title here.', 'fw' )
                ),
                'header-subtitle'  => array(
                    'type'  => 'text',
                    'label' => __( 'Header SubTitle', 'fw' ),
                    'desc'  => __( 'Add header subtitle here.', 'fw' )
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
            )
        )
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
        'desc'  => __( 'Choose section background color background', 'fw' ),
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

