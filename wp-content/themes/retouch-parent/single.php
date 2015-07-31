<?php
/**
 * The Template for displaying all single posts
 */

get_header(); ?>
<?php
    $header_image = defined('FW') ? fw_get_db_post_option($post->ID,'header_post_image',fw_get_db_settings_option('header_post_image')) : '';
    $header_color = defined('FW') ? fw_get_db_post_option($post->ID,'header_post_color',fw_get_db_settings_option('header_post_color')) : '';
    $header_pattern = defined('FW') ? fw_get_db_post_option($post->ID,'header_post_pattern',fw_get_db_settings_option('header_post_pattern')) : '';
    $header_title = defined('FW') ? esc_html(fw_get_db_post_option($post->ID,'header_post_title',fw_get_db_settings_option('header_post_title'))) : '';

    //show header image
    fw_show_header($header_image, $header_color, $header_pattern, $header_title);
?>


<?php $sidebar_position = (function_exists('fw_ext_sidebars_get_current_position')) ? fw_ext_sidebars_get_current_position() : 'right'; ?>
<section id="content" class="cols-a <?php echo $sidebar_position === 'left' ? 'news-e-left' : ''; ?> <?php echo ($sidebar_position == null || $sidebar_position == 'full') ? 'news-e-full' : ''; ?>">
    <div class="news-a">
        <?php
        while ( have_posts() ) : the_post();
            get_template_part( 'content', 'single' );

            // If comments are open, load up the comment template.
            if ( comments_open() ) {
                comments_template();
            }
        endwhile;?>
    </div>
    <?php get_sidebar(); ?>
</section>
<?php get_footer(); ?>