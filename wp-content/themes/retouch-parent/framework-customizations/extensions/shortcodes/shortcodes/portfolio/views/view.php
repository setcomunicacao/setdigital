<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$style_shortcodes = '';
$title = $atts['title'];
$subtitle = $atts['subtitle'];
$desc = $atts['desc'];

$portfolio = (int)$atts['portfolio'];
$posts_per_page = (int)$atts['posts_per_page'];

$header_image = $atts['header_image'];
$header_color = $atts['header_color'];
$header_pattern = $atts['header_pattern'];
$text_color = $atts['text_color'];

$uniq_id = rand(1,1000);

if($portfolio == 0)
{
    $the_query = new WP_Query(array(
        'posts_per_page' => $posts_per_page,
        'post_type' => 'fw-portfolio',
        'orderby' => 'date'
    ));

    $count = wp_count_posts( 'fw-portfolio' )->publish;
}
else{
    $the_query = new WP_Query(array(
        'posts_per_page' => $posts_per_page,
        'post_type' => 'fw-portfolio',
        'tax_query' => array(
            array(
                'taxonomy' => 'fw-portfolio-category',
                'field'    => 'id',
                'terms'    => $portfolio,
            ),
        ),
    ));

    $term = get_term( $portfolio , 'fw-portfolio-category');
    $count = $term->count;
}

$ext_portfolio_instance = fw()->extensions->get( 'portfolio' );
$ext_portfolio_settings = $ext_portfolio_instance->get_settings();
?>
<article id="portfolio">
    <header class="heading-a">
        <?php if(!empty($title) || !empty($subtitle)):?>
            <h3>
                <span class="small"><?php echo esc_html($title);?></span>
                <?php echo $subtitle; ?>
            </h3>
        <?php endif; ?>
        <p><?php echo esc_html($desc);?></p>
    </header>

    <?php if ( $the_query->have_posts() ) : ?>
        <ul class="gallery-a">
            <?php while ( $the_query->have_posts() ) : $the_query->the_post();
                get_template_part( 'framework-customizations/extensions' . $ext_portfolio_instance->get_rel_path() . '/views/loop', 'item' ); //fixme hardcoded 'framework-customizations/extensions'
            endwhile;?>
        </ul>
    <?php endif; wp_reset_query();?>

</article>

<?php if(!empty($header_image) || (!empty($header_color) && $header_color['primary'] != ' ' && $header_color['secondary'] != ' ') || !empty($header_pattern) || !empty($text_color)): ?>
    <?php
        ob_start();
    ?>
        <?php if(!empty($header_image) || !empty($header_color) ):?>
        #portfolio{
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
        #portfolio:before{
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
            #portfolio .heading-a,
            #portfolio .heading-a h3,
            #portfolio .heading-a h3 .small,
            #portfolio .gallery-a li a:hover > span
            {
                color: <?php echo $text_color; ?>;
            }
            #portfolio .heading-a h3:before,
            #portfolio .gallery-a li a .date:before
            {
                background: <?php echo $text_color; ?>;
            }
        <?php endif?>
    <?php $style_shortcodes .= ob_get_clean(); ?>
<?php endif;?>

<?php if(trim($style_shortcodes) != ''):?>
    <style>
        <?php echo $style_shortcodes; ?>
    </style>
<?php endif;?>