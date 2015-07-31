<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$template_directory = get_template_directory_uri();
$options = array(
    'title'       => array(
        'type'  => 'text',
        'label' => __( 'Title', 'fw' ),
        'desc'  => __( 'Type section title', 'fw' )
    ),
    'subtitle'       => array(
        'type'  => 'text',
        'label' => __( 'Subtitle', 'fw' ),
        'desc'  => __( 'Type section subtitle', 'fw' )
    ),
    'desc'       => array(
        'type'  => 'textarea',
        'label' => __( 'Description', 'fw' ),
        'desc'  => __( 'Add a short description', 'fw' )
    ),

    'team' => array(
        'type'  => 'multi-picker',
        'label' => false,
        'desc'  => false,
        'picker' => array(
            'icon-box-type' => array(
                'label' => __('Team View', 'fw'),
                'type'  => 'select',
                'value' => 'header-small',
                'desc'  => __('Select team section view type', 'fw'),
                'choices' => array(
                    'team1' => __('View 1', 'fw'),
                    'team2' => __('View 2', 'fw'),
                    'team3' => __('View 3', 'fw'),
                ),
            ),
        ),
        'choices' => array(
            'team1' => array(
                'members' => array(
                    'type'  => 'addable-box',
                    'value' => array(
                        array(
                            'image' => '',
                            'name' => '',
                            'job' => '',
                            'url' => ''
                        )
                    ),
                    'label' => __('Members', 'fw'),
                    'desc'  => __('Add team members', 'fw'),
                    'template' => '{{=name}}',
                    'box-options' => array(
                        'image' => array(
                            'label' => __( 'Team Member Image', 'fw' ),
                            'desc'  => __( 'Either upload a new, or choose an existing image from your media library', 'fw' ),
                            'type'  => 'upload'
                        ),
                        'name'   => array(
                            'label' => __( 'Name', 'fw' ),
                            'desc'  => __( 'Member name here.', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        ),
                        'job'   => array(
                            'label' => __( 'Team Member Job Title', 'fw' ),
                            'desc'  => __( 'Job title of the person.', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        ),
                        'url'  => array(
                            'label' => __( 'Member URL', 'fw' ),
                            'desc'  => __( 'Add member URL', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        )
                    ),
                )
            ),
            'team2' => array(
                'members' => array(
                    'type'  => 'addable-box',
                    'value' => array(
                        array(
                            'image' => '',
                            'name' => '',
                            'job' => '',
                            'desc' => '',
                            'url' => ''
                        )
                    ),
                    'label' => __('Members', 'fw'),
                    'desc'  => __('Add team members', 'fw'),
                    'template' => '{{=name}}',
                    'box-options' => array(
                        'image' => array(
                            'label' => __( 'Team Member Image', 'fw' ),
                            'desc'  => __( 'Either upload a new, or choose an existing image from your media library', 'fw' ),
                            'type'  => 'upload'
                        ),
                        'name'   => array(
                            'label' => __( 'Name', 'fw' ),
                            'desc'  => __( 'Member name here.', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        ),
                        'job'   => array(
                            'label' => __( 'Team Member Job Title', 'fw' ),
                            'desc'  => __( 'Job title of the person.', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        ),
                        'desc'   => array(
                            'label' => __( 'Member Info', 'fw' ),
                            'desc'  => __( 'Add a short info.', 'fw' ),
                            'type'  => 'textarea',
                            'value' => ''
                        ),
                        'url'  => array(
                            'label' => __( 'Member URL', 'fw' ),
                            'desc'  => __( 'Add member URL', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        )
                    ),
                )
            ),
            'team3' => array(
                'members' => array(
                    'type'  => 'addable-box',
                    'value' => array(
                        array(
                            'image' => '',
                            'name' => '',
                            'job' => '',
                            'url' => '',
                            'fb' => '',
                            'tw' => '',
                            'inst' => '',
                        )
                    ),
                    'label' => __('Members', 'fw'),
                    'desc'  => __('Add team members', 'fw'),
                    'template' => '{{=name}}',
                    'box-options' => array(
                        'image' => array(
                            'label' => __( 'Team Member Image', 'fw' ),
                            'desc'  => __( 'Either upload a new, or choose an existing image from your media library', 'fw' ),
                            'type'  => 'upload'
                        ),
                        'name'   => array(
                            'label' => __( 'Name', 'fw' ),
                            'desc'  => __( 'Member name here.', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        ),
                        'job'   => array(
                            'label' => __( 'Team Member Job Title', 'fw' ),
                            'desc'  => __( 'Job title of the person.', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        ),
                        'url'  => array(
                            'label' => __( 'Member URL', 'fw' ),
                            'desc'  => __( 'Add member URL', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        ),
                        'fb'  => array(
                            'label' => __( 'Facebook Link', 'fw' ),
                            'desc'  => __( 'Member Facebook Link.', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        ),
                        'tw'  => array(
                            'label' => __( 'Twitter Link', 'fw' ),
                            'desc'  => __( 'Member Twitter Link.', 'fw' ),
                            'type'  => 'text',
                            'value' => ''
                        ),
                        'inst'  => array(
                            'label' => __( 'Instagram Link', 'fw' ),
                            'desc'  => __( 'Member Instagram Link.', 'fw' ),
                            'type'  => 'text',
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
    )
);