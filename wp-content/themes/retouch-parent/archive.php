<?php
/**
 * The template for displaying Archive pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 */
get_header();?>

<?php
    $header_image = defined('FW') ? fw_get_db_term_option(get_query_var('cat'), 'category', 'header_blog_image', fw_get_db_settings_option('header_blog_image')) : '';
    $header_color = defined('FW') ? fw_get_db_term_option(get_query_var('cat'), 'category', 'header_blog_color', fw_get_db_settings_option('header_blog_color')) : '';
    $header_pattern = defined('FW') ? fw_get_db_term_option(get_query_var('cat'), 'category', 'header_blog_pattern', fw_get_db_settings_option('header_blog_pattern')) : '';
    $header_title = (is_category() || is_tag()) ? single_cat_title(  '', false ) : __('Archive','fw');
    //show header image
    fw_show_header($header_image, $header_color, $header_pattern, $header_title);
    //get blog view type
    $blog_view = defined('FW') ? fw_get_db_settings_option('blog_view') : 'blog1';
?>

<?php $sidebar_position = (function_exists('fw_ext_sidebars_get_current_position')) ? fw_ext_sidebars_get_current_position() : 'right';?>
    <section id="content" <?php echo ($blog_view == 'blog2') ? 'class="news-b"' : '';?>>

        <?php if(is_category()):?>
            <header class="heading-a">
                <h3><span class="small"><?php echo $header_title; ?></span>
                    <?php echo defined('FW') ? fw_theme_translate(fw_get_db_term_option(get_query_var('cat'), 'category', 'blog-description', fw_get_db_settings_option('blog-description'))) : '';?>
                </h3>
                <p><?php echo defined('FW') ? fw_theme_translate(esc_html(fw_get_db_term_option(get_query_var('cat'), 'category', 'blog-subtitle', fw_get_db_settings_option('blog-subtitle')))) : '';?></p>
            </header>
        <?php endif;?>

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