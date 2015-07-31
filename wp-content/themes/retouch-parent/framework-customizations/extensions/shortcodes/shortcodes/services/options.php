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

    'desc' => array(
        'type'  => 'textarea',
        'label' => __( 'Short Description', 'fw' ),
        'desc'  => __( 'Add a short description', 'fw' ),
    ),

    'slider' => array(
        'type'  => 'addable-box',
        'value' => array(
            array(
                'title' => '',
                'desc' => '',
                'icon' => '',
                'link' => ''
            )
        ),
        'label' => __('Services', 'fw'),
        'desc'  => __('Add Services', 'fw'),
        'template' => '{{=title}}',
        'box-options' => array(
            'title' => array(
                'label' => __('Title','fw'),
                'desc'  => __( 'Add service title', 'fw' ),
                'type' => 'text'
            ),
            'desc' => array(
                'label' => __( 'Description', 'fw' ),
                'desc'  => __( 'Add service short description', 'fw' ),
                'type'  => 'textarea',
            ),
            'icon' => array(
                'label' => __( 'Icon', 'fw' ),
                'desc'  => __( 'Add linea icon ( see all icons ', 'fw' ). '<a href="'.$template_directory.'/linea/index.html" target="_blank">'.__('here','fw').'</a> )',
                'type'  => 'text',
                'value' => 'basic-elaboration-document-note'
            ),
            'link' => array(
                'label' => __( 'URL', 'fw' ),
                'desc'  => __( 'Add service URL', 'fw' ),
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