<?php
/**
 * The Template for displaying all deafult pages
 */

get_header(); ?>
<article id="featured" class="header-static no-image">
    <h2><?php the_title(); ?></h2>
</article>
<?php $sidebar_position = (function_exists('fw_ext_sidebars_get_current_position')) ? fw_ext_sidebars_get_current_position() : 'right'; ?>
    <section id="content" class="cols-a <?php echo $sidebar_position === 'left' ? 'news-e-left' : ''; ?> <?php echo ($sidebar_position == null || $sidebar_position == 'full') ? 'news-e-full' : ''; ?>">
        <div class="news-a">
            <?php
            while ( have_posts() ) : the_post();?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php the_content();?>
                </article>

             <?php   // If comments are open, load up the comment template.
                /*if ( comments_open() ) {
                    comments_template();
                }*/
            endwhile;?>
        </div>
        <?php get_sidebar(); ?>
    </section>
<?php get_footer(); ?>