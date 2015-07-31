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
                'label' => __('Feature Type', 'fw'),
                'type'  => 'select',
                'value' => 'header-small',
                'desc'  => __('Select feature type', 'fw'),
                'choices' => array(
                    'feature1' => __('Type 1','fw'),
                    'feature2' => __('Type 2','fw'),
                    'feature3' => __('Type 3','fw'),
                ),
            ),
        ),
        'choices' => array(
            'feature1' => array(
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
                    'desc'  => __( 'Upload features image', 'fw' ),
                ),
                'features' => array(
                    'type'  => 'addable-box',
                    'value' => array(
                        array(
                            'title' => '',
                            'desc' => ''
                        )
                    ),
                    'label' => __('Features', 'fw'),
                    'desc'  => __('Add features (max 4)', 'fw'),
                    'limit' => 4,
                    'template' => '{{=title}}',
                    'box-options' => array(
                        'title'   => array(
                            'label' => __( 'Title', 'fw' ),
                            'desc'  => __( 'Feature title', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        ),
                        'desc'  => array(
                            'label' => __( 'Description', 'fw' ),
                            'desc'  => __( 'Feature short description', 'fw' ),
                            'type'  => 'textarea',
                            'value' => ''
                        )
                    ),
                )
            ),
            'feature2' => array(
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
                    'desc'  => __( 'Upload features image', 'fw' ),
                ),
                'features' => array(
                    'type'  => 'addable-box',
                    'value' => array(
                        array(
                            'title' => '',
                            'desc' => ''
                        )
                    ),
                    'label' => __('Features', 'fw'),
                    'desc'  => __('Add features (max 3)', 'fw'),
                    'limit' => 3,
                    'template' => '{{=title}}',
                    'box-options' => array(
                        'title'   => array(
                            'label' => __( 'Title', 'fw' ),
                            'desc'  => __( 'Feature title', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        ),
                        'desc'  => array(
                            'label' => __( 'Description', 'fw' ),
                            'desc'  => __( 'Feature short description', 'fw' ),
                            'type'  => 'textarea',
                            'value' => ''
                        )
                    ),
                )
            ),
            'feature3' => array(
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
                    'desc'  => __( 'Upload features image', 'fw' ),
                ),
                'features' => array(
                    'type'  => 'addable-box',
                    'value' => array(
                        array(
                            'title' => '',
                            'desc' => ''
                        )
                    ),
                    'label' => __('Features', 'fw'),
                    'desc'  => __('Add features (max 4)', 'fw'),
                    'limit' => 4,
                    'template' => '{{=title}}',
                    'box-options' => array(
                        'title'   => array(
                            'label' => __( 'Title', 'fw' ),
                            'desc'  => __( 'Feature title', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        ),
                        'desc'  => array(
                            'label' => __( 'Description', 'fw' ),
                            'desc'  => __( 'Feature short description', 'fw' ),
                            'type'  => 'textarea',
                            'value' => ''
                        )
                    ),
                )
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

