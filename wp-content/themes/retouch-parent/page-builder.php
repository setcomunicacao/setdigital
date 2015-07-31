<?php
/**
 * Template Name: Visual Builder Template
 */
get_header(); ?>
    <section id="content" class="page-template a">
        <?php
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;

        // If comments are open, load up the comment template.
        if ( comments_open() ) {
            ?>
            <div class="comment-page-full">
                <?php comments_template(); ?>
            </div>
        <?php
        }
        ?>
    </section>
<?php get_footer();?>