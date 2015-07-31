<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$style_shortcodes = '';
$title = $atts['title'];
$subtitle = $atts['subtitle'];
$testimonials = $atts['testimonials'];

$header_image = $atts['header_image'];
$header_color = $atts['header_color'];
$header_pattern = $atts['header_pattern'];
$text_color = $atts['text_color'];

$uniq_id = rand(1,1000);
?>
<article id="testimonials" class="vb">
    <header class="heading-a">
        <?php if(!empty($title) || !empty($subtitle)):?>
            <h3>
                <span class="small"><?php echo esc_html($title);?></span>
                <?php echo $subtitle; ?>
            </h3>
        <?php endif; ?>
    </header>
    <ul class="slider-a testimonials-slider">
        <?php foreach($testimonials as $testimonial):?>
            <li>
                <?php if($testimonial['image']):?>
                    <img src="<?php echo esc_url($testimonial['image']['url']);?>" alt="" width="157" height="157">
                <?php endif;?>
                <span class="title">
                    <span><?php echo esc_html($testimonial['name']);?></span> <?php echo esc_html($testimonial['position']);?>
                </span>
                <?php echo $testimonial['text'];?>
            </li>
        <?php endforeach;?>
    </ul>
</article>

<?php if(!empty($header_image) || (!empty($header_color) && $header_color['primary'] != ' ' && $header_color['secondary'] != ' ') || !empty($header_pattern) || !empty($text_color)): ?>
    <?php
        ob_start();
    ?>
        <?php if(!empty($header_image) || !empty($header_color) ):?>
        #content.a #testimonials.vb{
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
            #content.a #testimonials.vb:before{
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
            #content.a #testimonials.vb .heading-a h3,
            #content.a #testimonials.vb .heading-a *,
            #content.a #testimonials.vb .heading-a h3 .small,
            #content.a #testimonials.vb .slider-a.testimonials-slider li
            {
                color: <?php echo $text_color; ?>;
            }
            #content.a #testimonials.vb .heading-a h3:before
            {
                background: <?php echo $text_color; ?>;
            }
        <?php endif?>
    <?php $style_shortcodes .= ob_get_clean();?>
<?php endif;?>

<?php if(trim($style_shortcodes) != ''):?>
    <style>
        <?php echo $style_shortcodes; ?>
    </style>
<?php endif;?>