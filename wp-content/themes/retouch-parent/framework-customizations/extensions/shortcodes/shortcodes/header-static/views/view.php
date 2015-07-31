<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * @var array $atts
 */

$style_shortcodes = '';
$header_type_picker = $atts['header_type_picker'];
$header_type = $header_type_picker['icon-box-type'];

$header_image = $atts['header_image'];
$header_color = $atts['header_color'];
$header_pattern = $atts['header_pattern'];
$text_color = $atts['text_color'];
?>
<?php if($header_type == 'header-small'):
    $header_title = $header_type_picker['header-small']['header-title'];

    if(!empty($header_image) || !empty($header_color) || !empty($header_pattern)):?>
        <article id="featured" class="header-static">
            <h2><?php echo fw_theme_translate($header_title); ?></h2>
        </article>

        <?php ob_start();?>

        <?php if(!empty($header_image) || (!empty($header_color) && $header_color['primary'] != ' ' && $header_color['secondary'] != ' ') ):?>
            #content.page-template.a article#featured{
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
            #content.page-template.a article#featured:before{
                background: url(<?php echo esc_url($header_pattern['url']); ?>);
            }
        <?php endif;?>
        <?php $style_shortcodes .= ob_get_clean(); ?>

    <?php endif;

    if(!empty($text_color)): ?>
        <?php ob_start(); ?>
            #featured h2
            {
                color: <?php echo $text_color; ?>;
            }
            #featured h2:before
            {
                background: <?php echo $text_color; ?>;
            }
        <?php $style_shortcodes .= ob_get_clean(); ?>
    <?php endif;

else: ?>
    <?php
        $image = $header_type_picker['header-big']['header_image'];
        $align = $header_type_picker['header-big']['align'] == 'Right' ? 'header-static-right' : '';
    ?>
    <article id="welcome" class="header-static <?php echo $align;?>">

        <?php if(!empty($image)):?>
            <figure class="mobile-a"><img src="<?php echo esc_url($image['url']) ;?>" alt=""></figure>
        <?php endif;?>

        <h2><?php echo $header_type_picker['header-big']['header-title']?></h2>
        <p><?php echo esc_html($header_type_picker['header-big']['header-subtitle'])?></p>

        <?php
            $app_link = $header_type_picker['header-big']['apple_link'];
            $play_link = $header_type_picker['header-big']['play_link'];
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
    </article>


    <?php if(!empty($header_image) || (!empty($header_color) && $header_color['primary'] != ' ' && $header_color['secondary'] != ' ') || !empty($header_pattern) || !empty($text_color)): ?>
        <?php ob_start();?>
            <?php if(!empty($header_image) || !empty($header_color) ):?>
                #content.page-template.a article#welcome{
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
                #content.page-template.a article#welcome:before{
                    background: url(<?php echo esc_url($header_pattern['url']); ?>);
                }
            <?php endif;?>

            <?php if(!empty($text_color)):?>
                #welcome h2, #welcome p
                {
                    color: <?php echo $text_color; ?>;
                }
            <?php endif?>
        <?php $style_shortcodes .= ob_get_clean(); ?>
    <?php endif;?>

<?php endif;?>

<?php if(trim($style_shortcodes) != ''):?>
    <style>
        <?php echo $style_shortcodes; ?>
    </style>
<?php endif;?>