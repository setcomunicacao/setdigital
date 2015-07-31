<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$style_shortcodes = '';
$height = $atts['height'];

$header_image = $atts['header_image'];
$header_color = $atts['header_color'];
$header_pattern = $atts['header_pattern'];

$uniq_id = rand(1,1000);
?>
<div id="devider" class="vb" <?php echo (!empty($height)) ? 'style="height:'.$height.'px;"' : 'style="height:113px;"';?>></div>

<?php if(!empty($header_image) || (!empty($header_color) && $header_color['primary'] != ' ' && $header_color['secondary'] != ' ') || !empty($header_pattern)): ?>
    <?php
        ob_start();
    ?>
        <?php if(!empty($header_image) || !empty($header_color) ):?>
            #content.a #devider.vb{
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
            #content.a #devider.vb:before{
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
    <?php $style_shortcodes .= ob_get_clean(); ?>
<?php endif;?>

<?php if(trim($style_shortcodes) != ''):?>
    <style>
        <?php echo $style_shortcodes; ?>
    </style>
<?php endif;?>