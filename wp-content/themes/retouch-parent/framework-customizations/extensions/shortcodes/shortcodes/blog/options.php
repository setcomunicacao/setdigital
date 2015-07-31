<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

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

    'blog_view' => array(
        'label' => __('Blog View', 'fw'),
        'type'  => 'select',
        'desc'  => 'Select view type',
        'choices' => array(
            'blog1' => __('Type 1','fw'),
            'blog2' => __('Type 2','fw'),
            'blog3' => __('Type 3','fw'),
        ),
    ),

    'category'  => array(
        'label'   => __( 'Display From', 'fw' ),
        'desc'    => __( 'Select a blog category', 'fw' ),
        'type'    => 'select',
        'value' => '',
        'choices' => fw_get_category_term_list(),
    ),

    'posts_number'   => array(
        'label' => __( 'No of Posts', 'fw' ),
        'desc'  => __( 'Enter the number of posts to display. Ex: 3, 6, maximum of 50', 'fw' ),
        'type'  => 'short-text',
        'value' => get_option('posts_per_page')
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