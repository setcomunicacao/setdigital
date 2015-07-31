<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );

	/**
	 * @var array $atts
	 */
}
$style_shortcodes = '';
$title = $atts['title'];
$subtitle = $atts['subtitle'];
$desc = $atts['desc'];
$slider = $atts['slider'];

$header_image = $atts['header_image'];
$header_color = $atts['header_color'];
$header_pattern = $atts['header_pattern'];
$text_color = $atts['text_color'];

$uniq_id = rand(1,1000);
?>
<?php if(!empty($slider)):?>
    <article id="carousel3d" class="carousel-slider">
        <header class="heading-a">
            <?php if(!empty($title) || !empty($subtitle)):?>
                <h3>
                    <span class="small"><?php echo esc_html($title);?></span>
                    <?php echo $subtitle; ?>
                </h3>
            <?php endif; ?>
            <p><?php echo esc_html($desc);?></p>
        </header>
        <ul class="slider-b" data-carousel-3d>
            <?php foreach($slider as $slide):?>
                <?php if($slide['image']):?>
                    <li><a href="<?php echo esc_url($slide['link']);?>"><img src="<?php echo esc_url($slide['image']['url']);?>" alt="" width="320" height="568"></a></li>
                <?php endif;?>
            <?php endforeach;?>
        </ul>
    </article>
<?php endif;?>

<?php if(!empty($header_image) || !empty($header_color) || !empty($header_pattern)): ?>
    <?php
        ob_start();
    ?>
        <?php if(!empty($header_image) || (!empty($header_color) && $header_color['primary'] != ' ' && $header_color['secondary'] != ' ') || !empty($text_color) ):?>
            #carousel3d{
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
            #carousel3d:before{
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
            #carousel3d .heading-a,
            #carousel3d .heading-a h3,
            #carousel3d .heading-a h3 .small
            {
                color: <?php echo $text_color; ?>;
            }
            #carousel3d .heading-a h3:before
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