<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$style_shortcodes = '';
$title = $atts['title'];
$subtitle = $atts['subtitle'];
$image = $atts['image'];
$alignment = $atts['alignment'];
$numbers = $atts['numbers'];
$text = $atts['text'];

$header_image = $atts['header_image'];
$header_color = $atts['header_color'];
$header_pattern = $atts['header_pattern'];
$text_color = $atts['text_color'];

$uniq_id = rand(1,1000);
?>
<div class="border-white-top"></div>
<article id="numbers" class="vb">
    <header class="heading-a b">
        <?php if(!empty($title)):?>
            <h3><?php echo $title;?></h3>
        <?php endif;?>
        <?php if(!empty($subtitle)):?>
            <p><?php echo esc_html($subtitle); ?></p>
        <?php endif; ?>
    </header>

    <?php
        $app_link = $atts['apple_link'];
        $play_link = $atts['play_link'];
    ?>
    <?php if(!empty($app_link) || !empty($play_link)):?>
        <ul class="download-a a">
            <?php if(!empty($app_link)):?>
                <li class="as"><a rel="external" target="_blank" href="<?php echo esc_url($app_link); ?>"></a></li>
            <?php endif; ?>
            <?php if(!empty($play_link)):?>
                <li class="gp"><a rel="external" target="_blank" href="<?php echo esc_url($play_link); ?>"></a></li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>

    <?php if(!empty($image)):?>
        <figure class="<?php echo $alignment; ?>"><img src="<?php echo esc_url($image['url']);?>" alt=""></figure>
    <?php endif; ?>

    <?php if(!empty($numbers)):?>
        <p class="counter"><span><?php echo $numbers; ?></span> <?php echo esc_html($text);?></p>
    <?php endif;?>
</article>

<?php if(!empty($header_image) || (!empty($header_color) && $header_color['primary'] != ' ' && $header_color['secondary'] != ' ') || !empty($header_pattern)): ?>
    <?php
        ob_start();
    ?>
        <?php if(!empty($header_image) || !empty($header_color) || !empty($text_color) ):?>
            #content.a #numbers.vb{

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
            #content.a #numbers.vb:before{
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
            #content.a #numbers.vb .heading-a h3,
            #content.a #numbers.vb .heading-a h3 .small,
            #content.a #numbers.vb .heading-a *,
            #content.a #numbers.vb .counter > span span,
            #content.a #numbers.vb .counter
            {
                color: <?php echo $text_color; ?>;
            }
            #content.a #numbers.vb .heading-a h3:before,
            #content.a #numbers.vb .counter > span span:before
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