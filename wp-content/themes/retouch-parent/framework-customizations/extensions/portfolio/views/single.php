<?php
/**
 * The template for displaying all portfolio posts
 *
 */
get_header(); ?>
<?php
    $ext_portfolio_instance = fw()->extensions->get( 'portfolio' );

    $header_image = defined('FW') ? fw_get_db_post_option($post->ID,'header_portf_post_image',fw_get_db_settings_option('header_portf_post_image')) : '';
    $header_color = defined('FW') ? fw_get_db_post_option($post->ID,'header_portf_post_color',fw_get_db_settings_option('header_portf_post_color')) : '';
    $header_pattern = defined('FW') ? fw_get_db_post_option($post->ID,'header_portf_post_pattern',fw_get_db_settings_option('header_portf_post_pattern')) : '';
    $header_title = defined('FW') ? esc_html(fw_get_db_post_option($post->ID,'header_portf_post_title',fw_get_db_settings_option('header_portf_post_title'))) : '';

    //show header image
    fw_show_header($header_image, $header_color, $header_pattern, $header_title);
?>


<section id="content" class="cols-a news-e-full">
    <div class="news-a">
        <?php
        while ( have_posts() ) : the_post();
            get_template_part( 'framework-customizations/extensions' . $ext_portfolio_instance->get_rel_path() . '/views/content', 'single' );

            // If comments are open, load up the comment template.
            if ( comments_open() ) {
                comments_template();
            }
        endwhile;?>
    </div>
</section>
<?php get_footer(); ?>