<?php
/**
 * The template for displaying 404 page
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 */
get_header(); ?>

<?php
$header_image = defined('FW') ? fw_get_db_settings_option('header_404_image') : '';
$header_color = defined('FW') ? fw_get_db_settings_option('header_404_color') : '';
$header_pattern = defined('FW') ? fw_get_db_settings_option('header_404_pattern') : '';
$header_title = (defined('FW') && fw_get_db_settings_option('header_404_title') ) ? esc_attr(fw_get_db_settings_option('header_404_title')) : __('404 Page','fw');

//show header image
fw_show_header($header_image, $header_color, $header_pattern, $header_title);
//get blog view type
$blog_view = fw_get_db_settings_option('blog_view');
?>

<?php $sidebar_position = (function_exists('fw_ext_sidebars_get_current_position')) ? fw_ext_sidebars_get_current_position() : 'full';?>
    <section id="content" <?php echo ($blog_view == 'blog2') ? 'class="news-b"' : '';?>>

        <header class="heading-a">
            <h3><span class="small"><?php echo $header_title; ?></span>
                <?php echo defined('FW') ? fw_theme_translate(fw_get_db_settings_option('404-description')) : '';?>
            </h3>
            <p><?php echo defined('FW') ? fw_theme_translate(esc_html(fw_get_db_settings_option('404-subtitle'))) : '';?></p>
        </header>

        <div class="cols-a <?php echo $sidebar_position === 'left' ? 'news-e-left' : ''; ?> <?php echo ($sidebar_position == null || $sidebar_position == 'full') ? 'news-e-full' : ''; ?>">
            <div class="news-e">

                <header class="page-header">
                    <h1 class="page-title"><?php _e( 'Not Found', 'fw' ); ?></h1>
                </header>

                <div class="page-content">
                    <p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'fw' ); ?></p>

                    <?php get_template_part('search','form'); ?>
                </div><!-- .page-content -->

            </div>
            <?php get_sidebar();?>
        </div>
    </section>
<?php
get_footer();