<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$style_shortcodes = '';
$title = $atts['title'];
$subtitle = $atts['subtitle'];
$desc = $atts['desc'];
$term_id = (int)$atts['category'];
$blog_view = $atts['blog_view'];
$posts_per_page = (int)$atts['posts_number'];

$header_image = $atts['header_image'];
$header_color = $atts['header_color'];
$header_pattern = $atts['header_pattern'];
$text_color = $atts['text_color'];

$uniq_id = rand(1,1000);

$term_id = (int)$atts['category'];
$blog_view = $atts['blog_view'];

$posts_per_page = (int)$atts['posts_number'];
if( $posts_per_page == 0 ) {
    $posts_per_page = -1;
}

if($term_id == 0) {
    $args = array(
        'posts_per_page' => $posts_per_page,
        'post_type' => 'post',
        'orderby' => 'date'
    );
}
else{
    $args = array(
        'posts_per_page' => $posts_per_page,
        'post_type' => 'post',
        'orderby' => 'date',
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $term_id
            )
        )
    );
}

$query = new WP_Query( $args );
?>
<?php if($blog_view == 'blog1'):?>
    <div id="blog" class="blog_posts">
        <header class="heading-a">
            <?php if(!empty($title) || !empty($subtitle)):?>
                <h3>
                    <span class="small"><?php echo esc_html($title);?></span>
                    <?php echo $subtitle; ?>
                </h3>
            <?php endif; ?>
            <p><?php echo esc_html($desc);?></p>
        </header>
        <div class="news-c">
            <header>
                <h4><?php echo ($term_id == 0) ? __('Latest Posts','fw') : get_cat_name($term_id) ;?></h4>
            </header>
            <div>
                <?php if ( $query->have_posts() ) : ?>

                    <?php
                    // Start the Loop.
                    while ( $query->have_posts() ) : $query->the_post(); global $post;?>
                        <?php
                            $permalink = get_permalink();
                            $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID),'post-thumbnails');
                        ?>
                        <?php if(!empty($image)):?>
                            <article>
                                <figure><img src="<?php echo esc_url(fw_resize($image, 500, 460)); ?>" alt="<?php the_title(); ?>"></figure>
                                <h5>
                                    <a href="<?php echo esc_url($permalink);?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h5>
                                <?php the_excerpt(); ?>
                            </article>
                        <?php endif;?>
                    <?php endwhile;
                endif;?>
            </div>
            <?php wp_reset_query(); ?>
        </div>
    </div>
<?php elseif($blog_view == 'blog2'):?>
    <div id="blog" class="blog_posts">
        <header class="heading-a">
            <?php if(!empty($title) || !empty($subtitle)):?>
                <h3>
                    <span class="small"><?php echo esc_html($title);?></span>
                    <?php echo $subtitle; ?>
                </h3>
            <?php endif; ?>
            <p><?php echo esc_html($desc);?></p>
        </header>
        <div class="news-d">
            <?php if ( $query->have_posts() ) : ?>

                <?php
                // Start the Loop.
                while ( $query->have_posts() ) : $query->the_post(); global $post;?>
                    <?php
                        $permalink = get_permalink();
                        $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID),'post-thumbnails');
                    ?>
                    <?php if(!empty($image)):?>
                        <article>
                            <header>
                                <figure><img src="<?php echo esc_url(fw_resize($image, 310, 215)); ?>" alt="" width="310" height="215"></figure>
                                <h4><a href="<?php echo esc_url($permalink);?>"><?php the_title(); ?></a></h4>
                            </header>
                            <?php the_excerpt(); ?>
                            <p class="link-a a"><a href="<?php echo esc_url($permalink);?>"><?php _e('View more','fw');?></a></p>
                        </article>
                    <?php endif; ?>
                <?php endwhile;
            endif;?>
        </div>
        <?php wp_reset_query(); ?>
    </div>
<?php elseif($blog_view == 'blog3'):?>
    <article id="blog" class="gallery-c">

        <header class="heading-a">
            <?php if(!empty($title) || !empty($subtitle)):?>
                <h3>
                    <span class="small"><?php echo esc_html($title);?></span>
                    <?php echo $subtitle; ?>
                </h3>
            <?php endif; ?>
            <p><?php echo esc_html($desc);?></p>
        </header>
        <ul>
            <?php if ( $query->have_posts() ) : ?>

                <?php
                // Start the Loop.
                while ( $query->have_posts() ) : $query->the_post(); global $post;?>
                    <?php
                        $permalink = get_permalink();
                        $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID),'post-thumbnails');
                    ?>
                    <?php if(!empty($image)):?>
                        <li>
                            <a href="<?php echo esc_url($permalink);?>">
                                <img src="<?php echo esc_url(fw_resize($image, 540, 360)); ?>" alt="" width="540" height="360">
                                <span class="title">
                                    <?php the_title(); ?>
                                </span>
                                <span class="description"><?php echo get_the_excerpt(); ?></span>
                                <span class="link"><?php _e('View more','fw');?></span>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endwhile;
            endif;?>
        </ul>
    </article>
    <?php wp_reset_query(); ?>
<?php endif;?>

<?php if(!empty($header_image) || !empty($header_color) || !empty($header_pattern)): ?>
    <?php
        ob_start();
    ?>
        <?php if(!empty($header_image) || (!empty($header_color) && $header_color['primary'] != ' ' && $header_color['secondary'] != ' ') || !empty($text_color)):?>
            #blog{
                <?php if(!empty($header_color)) : ?>
                    background: -moz-linear-gradient(-45deg, <?php echo $header_color['primary']; ?> 0%, <?php echo $header_color['secondary']; ?> 100%);
                    background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,<?php echo $header_color['primary']; ?>), color-stop(100%,<?php echo $header_color['secondary']; ?>));
                    background: -webkit-linear-gradient(-45deg, <?php echo $header_color['primary']; ?> 0%,<?php echo $header_color['secondary']; ?> 100%);
                    background: -o-linear-gradient(-45deg, <?php echo $header_color['primary']; ?> 0%,<?php echo $header_color['secondary']; ?> 100%);
                    background: -ms-linear-gradient(-45deg, <?php echo $header_color['primary']; ?> 0%,<?php echo $header_color['secondary']; ?> 100%);
                    background: linear-gradient(135deg, <?php echo $header_color['primary']; ?> 0%,<?php echo $header_color['secondary']; ?> 100%);
                <?php endif;?>
                <?php echo !empty($header_image) ? 'background-image: url('.esc_url($header_image['url']).');' : ''; ?>
            }
        <?php endif;?>

        <?php if(!empty($header_pattern)):?>
            #blog:before{
                content: "";
                display: block;
                position: absolute;
                left: 0;
                top: 0;
                z-index: 1;
                width: 100%;
                height: 100%;
                background: url(<?php echo esc_url($header_pattern['url']); ?>);
            }
        <?php endif;?>

        <?php if(!empty($text_color)):?>
            #blog .heading-a h3 .small,
            #blog .heading-a,
            #blog .heading-a h3,
            #blog .news-c > header h4,
            #blog .news-c .bx-pager,
            #content.page-template.a #blog .news-c article h5 a,
            .js #content.page-template.a  #blog .news-c article,
            #blog .news-d article h4 a,
            #blog .news-d article p,
            #blog .link-a a,
            #blog.gallery-c ul li > a > span.title,
            #blog.gallery-c span.link,
            #blog.gallery-c ul li > div .title,
            #blog.gallery-c ul li > div span.description
            {
                color: <?php echo $text_color; ?>;
            }
            #blog .heading-a h3:before,
            #content.page-template.a #blog .news-c article h5:before,
            #blog .news-d article h4:before
            {
                background: <?php echo $text_color; ?>;
            }
            #blog.gallery-c span.link{
                border: 3px solid <?php echo $text_color; ?>;
            }
        <?php endif?>
    <?php $style_shortcodes .= ob_get_clean(); ?>
<?php endif;?>

<?php if(trim($style_shortcodes) != ''):?>
    <style>
        <?php echo $style_shortcodes; ?>
    </style>
<?php endif;?>