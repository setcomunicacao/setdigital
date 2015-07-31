<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * @var array $atts
 */
$style_shortcodes = '';
$title = $atts['title'];
$subtitle = $atts['subtitle'];
$contact = $atts['contact'];

$mappicker = $atts['map_picker'];

if($mappicker['map_enable'] == 'bg')
{
    $header_image = $mappicker['bg']['header_image'];
    $header_color = $mappicker['bg']['header_color'];
    $header_pattern = $mappicker['bg']['header_pattern'];

    $zoom = $lat = $long ='';
}
else{
    $header_image = $header_color = $header_pattern = '';

    $zoom = (int)$mappicker['map']['zoom'];
    $lat = $mappicker['map']['contact_map']['coordinates']['lat'];
    $long = $mappicker['map']['contact_map']['coordinates']['lng'];
}

$text_color = $atts['text_color'];

$uniq_id = rand(1,1000);
?>
<article id="contact" class="contact-form"
         data-zoom="<?php echo $zoom; ?>"
         data-lat="<?php echo $lat ;?>"
         data-long="<?php echo $long ;?>"
         data-src="<?php echo esc_url(get_template_directory_uri());?>
 ">
    <header class="heading-a">
        <?php if(!empty($title) || !empty($subtitle)):?>
            <h3>
                <span class="small"><?php echo esc_html($title); ?></span>
                <?php echo $subtitle; ?>
            </h3>
        <?php endif;?>
    </header>
    <?php if(!empty($contact)):?>
        <?php echo do_shortcode($contact);?>
    <?php endif;?>
</article>

<?php if(!empty($header_image) || !empty($header_color) || !empty($header_pattern)): ?>
    <?php
        ob_start();
    ?>
        <?php if(!empty($header_image) || (!empty($header_color) && $header_color['primary'] != ' ' && $header_color['secondary'] != ' ') || !empty($header_pattern) || !empty($text_color) ):?>
            #contact.contact-form{
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
            #contact.contact-form:before{
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
            #contact.contact-form .heading-a h3,
            #contact.contact-form .heading-a h3 .small,
            .js #contact.contact-form label,
            #contact.contact-form .semantic-select .input,
            #contact.contact-form .semantic-select ul li a,
            #contact.contact-form .wpcf7-submit
            {
                color: <?php echo $text_color; ?>;
            }
            #contact.contact-form .heading-a h3:before
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