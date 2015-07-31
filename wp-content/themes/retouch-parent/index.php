<?php
/**
 * The template for displaying index page
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 */
get_header(); ?>

<?php
    if ( is_front_page() && is_home() ) {
        $header_image = defined('FW') ? fw_get_db_settings_option('header_home_image') : '';
        $header_color = defined('FW') ? fw_get_db_settings_option('header_home_color') : '';
        $header_pattern = defined('FW') ? fw_get_db_settings_option('header_home_pattern') : '';
        $header_title = (defined('FW') && fw_get_db_settings_option('header_home_title') ) ? esc_attr(fw_get_db_settings_option('header_home_title')) : __('Homepage','fw');
        $header_subtitle = defined('FW') ? esc_html(fw_get_db_settings_option('home-subtitle')) : '';
        $header_descr = defined('FW') ? esc_html(fw_get_db_settings_option('home-description')) : '';
    }
    else
    {
        $header_image = defined('FW') ? fw_get_db_settings_option('header_blogpage_image') : '';
        $header_color = defined('FW') ? fw_get_db_settings_option('header_blogpage_color') : '';
        $header_pattern = defined('FW') ? fw_get_db_settings_option('header_blogpage_pattern') : '';
        $header_title = (defined('FW') && fw_get_db_settings_option('header_blogpage_title') ) ? esc_attr(fw_get_db_settings_option('header_blogpage_title')) : __('Blogpage','fw');
        $header_subtitle = defined('FW') ? esc_html(fw_get_db_settings_option('blogpage-subtitle')) : '';
        $header_descr = defined('FW') ? esc_html(fw_get_db_settings_option('blogpage-description')) : '';
    }

    //show header image
    fw_show_header($header_image, $header_color, $header_pattern, $header_title);
    //get blog view type
    $blog_view = defined('FW') ? fw_get_db_settings_option('blog_view') : 'blog1';
?>

<?php $sidebar_position = (function_exists('fw_ext_sidebars_get_current_position')) ? fw_ext_sidebars_get_current_position() : 'right';?>
    <section id="content" <?php echo ($blog_view == 'blog2') ? 'class="news-b"' : '';?>>

        <header class="heading-a">
            <h3><span class="small"><?php echo fw_theme_translate($header_title); ?></span>
                <?php echo fw_theme_translate($header_descr);?>
            </h3>
            <p><?php echo fw_theme_translate($header_subtitle); ?></p>
        </header>

        <?php if($blog_view == 'blog1'):?>
        <div class="cols-a <?php echo $sidebar_position === 'left' ? 'news-e-left' : ''; ?> <?php echo ($sidebar_position == null || $sidebar_position == 'full') ? 'news-e-full' : ''; ?>">
            <div class="news-e">
                <?php endif; ?>

                <?php if ( have_posts() ) : ?>

                    <?php
                    // Start the Loop.
                    while ( have_posts() ) : the_post();

                        if($blog_view == 'blog1')
                            get_template_part( 'listing', 'blog1' );
                        else
                            get_template_part( 'listing', 'blog2' );

                    endwhile;
                    // archive pagination
                    fw_theme_paging_nav();

                else :
                    // If no content, include the "No posts found" template.
                    get_template_part( 'content', 'none' );

                endif; ?>
                <?php if($blog_view == 'blog1'):?>
            </div>
            <?php get_sidebar();?>
        </div>
    <?php endif; ?>
    </section>
<?php
get_footer();