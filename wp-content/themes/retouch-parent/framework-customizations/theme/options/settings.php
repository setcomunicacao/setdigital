<?php if ( ! defined( 'FW' ) ) {
    die( 'Forbidden' );
}
$template_directory = get_template_directory_uri();
$options = array(
    'general' => array(
        'title'   => __( 'General', 'fw' ),
        'type'    => 'tab',
        'options' => array(

            'general-box' => array(
                'title'   => __( 'General Settings', 'fw' ),
                'type'    => 'box',
                'options' => array(
                    'logo' => array(
                        'label' => __( 'Logo', 'fw' ),
                        'desc'  => __( 'Upload logo image', 'fw' ),
                        'type'  => 'upload'
                    ),
                    'logo-3' => array(
                        'label' => __( 'Footer Logo', 'fw' ),
                        'desc'  => __( 'Upload footer logo image', 'fw' ),
                        'type'  => 'upload'
                    ),

                    'favicon' => array(
                        'label' => __( 'Favicon', 'fw' ),
                        'desc'  => __( 'Upload favicon image', 'fw' ),
                        'type'  => 'upload',
                        'images_only' => false
                    )
                )
            ),

        )
    ),

    'homepage' => array(
        'title'   => __( 'Home Page', 'fw' ),
        'type'    => 'tab',
        'options' => array(

            'home_settings' => array(
                'title'   => __( 'HomePage Settings', 'fw' ),
                'type'    => 'box',
                'options' => array(
                    'header_home_color' => array(
                        'type'  => 'gradient',
                        'value' => array(
                            'primary'   => '#000000',
                            'secondary' => '#000000',
                        ),
                        'label' => __( 'Header Color', 'fw' ),
                        'desc'  => __( 'Choose header color background for homepage', 'fw' ),
                    ),
                    'header_home_image' => array(
                        'label' => __( 'Header Image', 'fw' ),
                        'desc'  => __( 'Upload header image for homepage', 'fw' ),
                        'type'  => 'upload'
                    ),
                    'header_home_pattern' => array(
                        'label' => __( 'Header Pattern', 'fw' ),
                        'desc'  => __( 'Upload header pattern for homepage', 'fw' ),
                        'type'  => 'upload'
                    ),

                    'header_home_title' => array(
                        'label' => __( 'Header Title', 'fw' ),
                        'desc'  => __( 'Type header title for homepage', 'fw' ),
                        'type'  => 'text'
                    ),

                    'home-subtitle' => array(
                        'label' => __( 'Subtitle', 'fw' ),
                        'desc'  => __( 'Type subtitle for homepage', 'fw' ),
                        'type'  => 'text'
                    ),

                    'home-description' => array(
                        'label' => __( 'Short Description', 'fw' ),
                        'desc'  => __( 'Add a short description for homepage', 'fw' ),
                        'type'  => 'textarea'
                    ),
                )
            ),

        )
    ),

    'blogpage' => array(
        'title'   => __( 'Blog Page', 'fw' ),
        'type'    => 'tab',
        'options' => array(

            'blogpage_settings' => array(
                'title'   => __( 'BlogPage Settings', 'fw' ),
                'type'    => 'box',
                'options' => array(
                    'header_blogpage_color' => array(
                        'type'  => 'gradient',
                        'value' => array(
                            'primary'   => '#000000',
                            'secondary' => '#000000',
                        ),
                        'label' => __( 'Header Color', 'fw' ),
                        'desc'  => __( 'Choose header color background for blogpage', 'fw' ),
                    ),
                    'header_blogpage_image' => array(
                        'label' => __( 'Header Image', 'fw' ),
                        'desc'  => __( 'Upload header image for blogpage', 'fw' ),
                        'type'  => 'upload'
                    ),
                    'header_blogpage_pattern' => array(
                        'label' => __( 'Header Pattern', 'fw' ),
                        'desc'  => __( 'Upload header pattern for blogpage', 'fw' ),
                        'type'  => 'upload'
                    ),

                    'header_blogpage_title' => array(
                        'label' => __( 'Header Title', 'fw' ),
                        'desc'  => __( 'Type header title for blogpage', 'fw' ),
                        'type'  => 'text'
                    ),

                    'blogpage-subtitle' => array(
                        'label' => __( 'Subtitle', 'fw' ),
                        'desc'  => __( 'Type subtitle for blogpage', 'fw' ),
                        'type'  => 'text'
                    ),

                    'blogpage-description' => array(
                        'label' => __( 'Short Description', 'fw' ),
                        'desc'  => __( 'Add a short description for blogpage', 'fw' ),
                        'type'  => 'textarea'
                    ),
                )
            ),

        )
    ),

    'search-settings' => array(
        'title'   => __( 'Search Page', 'fw' ),
        'type'    => 'tab',
        'options' => array(

            'search-box' => array(
                'title'   => __( 'Search Page Settings', 'fw' ),
                'type'    => 'box',
                'options' => array(
                    'header_search_color' => array(
                        'type'  => 'gradient',
                        'value' => array(
                            'primary'   => '#000000',
                            'secondary' => '#000000',
                        ),
                        'label' => __( 'Header Color', 'fw' ),
                        'desc'  => __( 'Choose header color background for search page', 'fw' ),
                    ),
                    'header_search_image' => array(
                        'label' => __( 'Header Image', 'fw' ),
                        'desc'  => __( 'Upload header image for search page', 'fw' ),
                        'type'  => 'upload'
                    ),
                    'header_search_pattern' => array(
                        'label' => __( 'Header Pattern', 'fw' ),
                        'desc'  => __( 'Upload header pattern for search page', 'fw' ),
                        'type'  => 'upload'
                    ),

                    'header_search_title' => array(
                        'label' => __( 'Header Title', 'fw' ),
                        'desc'  => __( 'Type title for search page', 'fw' ),
                        'type'  => 'text'
                    ),

                    'search-subtitle' => array(
                        'label' => __( 'Subtitle', 'fw' ),
                        'desc'  => __( 'Type subtitle for search page', 'fw' ),
                        'type'  => 'text'
                    ),

                    'search-description' => array(
                        'label' => __( 'Short Description', 'fw' ),
                        'desc'  => __( 'Add a short description for search page', 'fw' ),
                        'type'  => 'textarea'
                    ),
                )
            ),

        )
    ),

    '404-settings' => array(
        'title'   => __( '404 Page', 'fw' ),
        'type'    => 'tab',
        'options' => array(

            '404-box' => array(
                'title'   => __( '404 Page Settings', 'fw' ),
                'type'    => 'box',
                'options' => array(
                    'header_404_color' => array(
                        'type'  => 'gradient',
                        'value' => array(
                            'primary'   => '#000000',
                            'secondary' => '#000000',
                        ),
                        'label' => __( 'Header Color', 'fw' ),
                        'desc'  => __( 'Choose header color background for page 404', 'fw' ),
                    ),
                    'header_404_image' => array(
                        'label' => __( 'Header Image', 'fw' ),
                        'desc'  => __( 'Upload header image for page 404', 'fw' ),
                        'type'  => 'upload'
                    ),
                    'header_404_pattern' => array(
                        'label' => __( 'Header Pattern', 'fw' ),
                        'desc'  => __( 'Upload header pattern for page 404', 'fw' ),
                        'type'  => 'upload'
                    ),

                    'header_404_title' => array(
                        'label' => __( 'Header Title', 'fw' ),
                        'desc'  => __( 'Type header title for page 404', 'fw' ),
                        'type'  => 'text'
                    ),

                    '404-subtitle' => array(
                        'label' => __( 'Subtitle', 'fw' ),
                        'desc'  => __( 'Type subtitle for page 404', 'fw' ),
                        'type'  => 'text'
                    ),

                    '404-description' => array(
                        'label' => __( 'Short Description', 'fw' ),
                        'desc'  => __( 'Add a short description for page 404', 'fw' ),
                        'type'  => 'textarea'
                    ),
                )
            )

        )
    ),

    'blog' => array(
        'title'   => __( 'Blog', 'fw' ),
        'type'    => 'tab',
        'options' => array(
            'blog_settings' => array(
                'title'   => __( 'Blog Settings', 'fw' ),
                'type'    => 'box',
                'options' => array(
                    'header_blog_color' => array(
                        'type'  => 'gradient',
                        'value' => array(
                            'primary'   => '#000000',
                            'secondary' => '#000000',
                        ),
                        'label' => __( 'Header Color', 'fw' ),
                        'desc'  => __( 'Choose header color background for categories. You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=category">category</a> ' .__( 'individually', 'fw' ),
                    ),
                    'header_blog_image' => array(
                        'label' => __( 'Header Image', 'fw' ),
                        'desc'  => __( 'Upload header image for categories. You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=category">category</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'upload'
                    ),
                    'header_blog_pattern' => array(
                        'label' => __( 'Header Pattern', 'fw' ),
                        'desc'  => __( 'Upload header pattern for categories. You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=category">category</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'upload'
                    ),

                    'blog_view'  => array(
                        'label'   => __( 'Blog View', 'fw' ),
                        'desc'    => __( 'Select the blog view', 'fw' ),
                        'type'  => 'select',
                        'value' => '',
                        'choices' => array(
                            'blog1' => __('Default Blog','fw'),
                            'blog2' => __('Full Blog','fw'),
                        ),
                    ),

                    'blog-subtitle' => array(
                        'label' => __( 'Subtitle', 'fw' ),
                        'desc'  => __( 'Type subtitle for categories. You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=category">category</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'text'
                    ),
                    'blog-description' => array(
                        'label' => __( 'Short Description', 'fw' ),
                        'desc'  => __( 'Add a short description for categories. You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=category">category</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'textarea'
                    ),
                )
            ),
        )
    ),

    'posts' => array(
        'title'   => __( 'Blog Posts', 'fw' ),
        'type'    => 'tab',
        'options' => array(
            'post_settings' => array(
                'title'   => __( 'Posts Settings', 'fw' ),
                'type'    => 'box',
                'options' => array(
                    'header_post_color' => array(
                        'type'  => 'gradient',
                        'value' => array(
                            'primary'   => '#000000',
                            'secondary' => '#000000',
                        ),
                        'label' => __( 'Header Color', 'fw' ),
                        'desc'  => __( 'Choose header color background for posts. You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit.php">post</a> ' .__( 'individually', 'fw' ),
                    ),

                    'header_post_image' => array(
                        'label' => __( 'Header Image', 'fw' ),
                        'desc'  => __( 'Upload header image for posts. You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit.php">post</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'upload'
                    ),

                    'header_post_pattern' => array(
                        'label' => __( 'Header Pattern', 'fw' ),
                        'desc'  => __( 'Upload header pattern for posts. You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit.php">post</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'upload'
                    ),

                    'header_post_title' => array(
                        'label' => __( 'Header Title', 'fw' ),
                        'desc'  => __( 'Add title for posts. You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit.php">post</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'text'
                    ),
                )
            ),
        )
    ),

    'portfolio' => array(
        'title'   => __( 'Portfolio Categories', 'fw' ),
        'type'    => 'tab',
        'options' => array(

            'portfolio-box' => array(
                'title'   => __( 'Portfolio Settings', 'fw' ),
                'type'    => 'box',
                'options' => array(
                    'header_portf_color' => array(
                        'type'  => 'gradient',
                        'value' => array(
                            'primary'   => '#000000',
                            'secondary' => '#000000',
                        ),
                        'label' => __( 'Header Color', 'fw' ),
                        'desc'  => __( 'Choose header color background for portfolio categories.  You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=fw-portfolio-category">portfolio category</a> ' .__( 'individually', 'fw' ),
                    ),

                    'header_portf_image' => array(
                        'label' => __( 'Header Image', 'fw' ),
                        'desc'  => __( 'Upload header image for portfolio categories.  You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=fw-portfolio-category">portfolio category</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'upload'
                    ),

                    'header_portf_pattern' => array(
                        'label' => __( 'Header Pattern', 'fw' ),
                        'desc'  => __( 'Upload header pattern for portfolio categories.  You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=fw-portfolio-category">portfolio category</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'upload'
                    ),

                    'portf-subtitle' => array(
                        'label' => __( 'Subtitle', 'fw' ),
                        'desc'  => __( 'Type subtitle for portfolio categories.  You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=fw-portfolio-category">portfolio category</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'text'
                    ),
                    'portf-description' => array(
                        'label' => __( 'Short Description', 'fw' ),
                        'desc'  => __( 'Add a short description for portfolio categories.  You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit-tags.php?taxonomy=fw-portfolio-category">portfolio category</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'textarea'
                    ),
                )
            ),


        )
    ),

    'portf_posts' => array(
        'title'   => __( 'Portfolio Posts', 'fw' ),
        'type'    => 'tab',
        'options' => array(
            'portf_post_settings' => array(
                'title'   => __( 'Portfolio Posts Settings', 'fw' ),
                'type'    => 'box',
                'options' => array(
                    'header_portf_post_color' => array(
                        'type'  => 'gradient',
                        'value' => array(
                            'primary'   => '#000000',
                            'secondary' => '#000000',
                        ),
                        'label' => __( 'Header Color', 'fw' ),
                        'desc'  => __( 'Choose header color background for portfolio posts. You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit.php?post_type=fw-portfolio">portfolio post</a> ' .__( 'individually', 'fw' ),
                    ),

                    'header_portf_post_image' => array(
                        'label' => __( 'Header Image', 'fw' ),
                        'desc'  => __( 'Upload header image for portfolio posts. You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit.php?post_type=fw-portfolio">portfolio post</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'upload'
                    ),

                    'header_portf_post_pattern' => array(
                        'label' => __( 'Header Pattern', 'fw' ),
                        'desc'  => __( 'Upload header pattern for portfolio posts. You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit.php?post_type=fw-portfolio">portfolio post</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'upload'
                    ),

                    'header_portf_post_title' => array(
                        'label' => __( 'Header Title', 'fw' ),
                        'desc'  => __( 'Add title for portfolio posts. You can rewrite it in each', 'fw' ) . ' <a target="_new" href="' . get_admin_url() . 'edit.php?post_type=fw-portfolio">portfolio post</a> ' .__( 'individually', 'fw' ),
                        'type'  => 'text'
                    ),
                )
            ),
        )
    ),

    'footer' => array(
        'title'   => __( 'Footer', 'fw' ),
        'type'    => 'tab',
        'options' => array(
            'copyright' => array(
                'title'   => __( 'Footer Copyright', 'fw' ),
                'type'    => 'box',
                'options' => array(
                    'copyright' => array(
                        'label' => __( 'Copyright', 'fw' ),
                        'desc'  => __( 'Footer Copyright', 'fw' ),
                        'type'  => 'text',
                        'value' => ''
                    )
                )
            ),
            'socials-box' => array(
                'title'   => __( 'Footer Socials', 'fw' ),
                'type'    => 'box',
                'options' => array(
                    'facebook' => array(
                        'label' => __( 'Facebook', 'fw' ),
                        'desc'  => __( 'Facebook Link', 'fw' ),
                        'type'  => 'text',
                        'value' => ''
                    ),
                    'twitter' => array(
                        'label' => __( 'Twitter', 'fw' ),
                        'desc'  => __( 'Twitter Link', 'fw' ),
                        'type'  => 'text',
                        'value' => ''
                    ),
                    'instagram' => array(
                        'label' => __( 'Instagram', 'fw' ),
                        'desc'  => __( 'Instagram Link', 'fw' ),
                        'type'  => 'text',
                        'value' => ''
                    )
                )
            ),
            'footer-downloads' => array(
                'title'   => __( 'Footer Downloads', 'fw' ),
                'type'    => 'box',
                'options' => array(
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
        )
    ),

    'styling-options' => array(
        'title'   => __( 'Styling', 'fw' ),
        'type'    => 'tab',
        'options' => array(

            'styling-box' => array(
                'title'   => __( 'Styling Options', 'fw' ),
                'type'    => 'box',
                'options' => array(

                    'color_schemes' => array(
                        'type'  => 'multi-picker',
                        'label' => false,
                        'desc'  => false,
                        'picker' => array(
                            'schemes' => array(
                                'label' => __('Color Schemes', 'fw'),
                                'type'  => 'select',
                                'desc'  => 'Select available color schemes',
                                'choices' => array(
                                    'default' =>  __('Default','fw'),
                                    'blue' => __('Blue','fw'),
                                    'cyan' => __('Cyan','fw'),
                                    'green' => __('Green','fw'),
                                    'magenta' => __('Magenta','fw'),
                                    'red' => __('Red','fw'),
                                    'custom' => __('Custom','fw'),
                                ),
                            ),
                        ),
                        'choices' => array(
                            'custom' => array(
                                'styling' => array(
                                    'label' => __( 'Custom Color', 'fw' ),
                                    'desc'  => __( 'Choose custom color scheme.', 'fw' ),
                                    'type'  => 'color-picker'
                                ),
                            )
                        )
                    ),

                    'enable_headings_font' => array(
                        'type'  => 'multi-picker',
                        'label' => false,
                        'desc'  => false,
                        'picker' => array(
                            'enable_headings' => array(
                                'type'  => 'switch',
                                'value' => 'no',
                                'attr'  => array(),
                                'label' => __('Headings Typography', 'fw'),
                                'desc'  => __('Add headings typography?', 'fw'),
                                'left-choice' => array(
                                    'value' => 'yes',
                                    'label' => __('Yes', 'fw'),
                                ),
                                'right-choice' => array(
                                    'value' => 'no',
                                    'label' => __('No', 'fw'),
                                ),
                            ),
                        ),
                        'choices' => array(
                            'yes' => array(
                                'headings_typography'=> array(
                                    'label' => '',
                                    'attr' => array('class' => 'fw_typography_class'),
                                    'type'  => 'typography',
                                    'value' => array(
                                        'family' => 'Open Sans',
                                        'style'  => '300italic'
                                    ),
                                    'components' => array('size' => false, 'color' => false),
                                    'desc'  => __( 'Choose headings fonts and color','fw' ),
                                ),
                            )
                        )
                    ),
                    'enable_body_font' => array(
                        'type'  => 'multi-picker',
                        'label' => false,
                        'desc'  => false,
                        'picker' => array(
                            'enable_body' => array(
                                'type'  => 'switch',
                                'value' => 'no',
                                'attr'  => array(),
                                'label' => __('Body Typography', 'fw'),
                                'desc'  => __('Add body typography?', 'fw'),
                                'left-choice' => array(
                                    'value' => 'yes',
                                    'label' => __('Yes', 'fw'),
                                ),
                                'right-choice' => array(
                                    'value' => 'no',
                                    'label' => __('No', 'fw'),
                                ),
                            ),
                        ),
                        'choices' => array(
                            'yes' => array(
                                'body_typography'=> array(
                                    'label' => '',
                                    'attr' => array('class' => 'fw_typography_class'),
                                    'type'  => 'typography',
                                    'value' => array(
                                        'family' => 'Open Sans',
                                        'style'  => '300italic',
                                    ),
                                    'components' => array('size' => false, 'color' => false),
                                    'desc'  => __( 'Choose body fonts and color','fw' ),
                                ),
                            )
                        )
                    ),

                    'menu_text_color' => array(
                        'label' => __( 'Menu Text Color', 'fw' ),
                        'desc'  => __( 'Choose text menu color.', 'fw' ),
                        'type'  => 'color-picker'
                    ),
                    'menu_bg' => array(
                        'label' => __( 'Menu Bg Color', 'fw' ),
                        'desc'  => __( 'Choose menu background color.', 'fw' ),
                        'type'  => 'color-picker'
                    ),
                    'menu_sticky_bg' => array(
                        'label' => __( 'Sticky Menu Bg Color', 'fw' ),
                        'desc'  => __( 'Choose sticky menu background color.', 'fw' ),
                        'type'  => 'color-picker'
                    ),
                    'menu_sticky_text' => array(
                        'label' => __( 'Sticky Menu Text Color', 'fw' ),
                        'desc'  => __( 'Choose sticky menu text color.', 'fw' ),
                        'type'  => 'color-picker'
                    ),
                )
            ),
        )
    ),

);