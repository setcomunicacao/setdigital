<?php
/**
 * The default template for displaying post details
 */
?>
<?php
    $permalink = get_permalink();
    $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID),'post-thumbnails');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header>
        <h3><?php the_title(); ?></h3>
        <ul>
            <li>
                <a href="<?php echo esc_url(get_author_posts_url( get_the_author_meta( 'ID' ) )); ?>">
                    <?php echo get_avatar(get_the_author_meta('user_email'), $size = '40'); ?>
                    <?php _e('by','fw'); ?> <?php echo get_the_author();?>
                </a>
            </li>
            <li><i class="icon-basic" data-icon="x"></i> <?php echo get_the_date(); ?></li>
            <li><a href="<?php echo esc_url($permalink); ?>#commentform"><i class="icon-basic" data-icon=","></i> <?php comments_number( __( '0', 'fw' ), __( '1', 'fw' ), __( '%', 'fw' ) ); ?></a></li>
        </ul>
    </header>
    <?php if(!empty($image)):?>
        <figure><img src="<?php echo esc_url($image); ?>" alt=""  width="700" /></figure>
    <?php endif; ?>
    <?php the_content();
    wp_link_pages( array(
        'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'fw' ) . '</span>',
        'after'       => '</div>',
        'link_before' => '<span>',
        'link_after'  => '</span>',
    ) );
    ?>
</article>

<?php
    $post_categories = get_the_terms( $post->ID, 'fw-portfolio-category' );
    $cats = "";
    foreach ($post_categories as $c) {
        $cats .= '<a href="'.esc_url(get_term_link( $c->term_id , 'fw-portfolio-category' )).'">'.$c->name . '</a>,' ;
    }
?>
<div class="post_categories"><?php _e('Categories','fw');?>: <?php echo substr($cats, 0,  strlen($cats)-1) ?> </div>
