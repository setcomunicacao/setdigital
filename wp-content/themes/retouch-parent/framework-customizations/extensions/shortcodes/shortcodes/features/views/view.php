<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * @var array $atts
 */
$style_shortcodes = '';
$section = $atts['header_type_picker'];

$header_image = $atts['header_image'];
$header_color = $atts['header_color'];
$header_pattern = $atts['header_pattern'];
$text_color = $atts['text_color'];

$uniq_id = rand(1,1000);
?>

<?php if($section['icon-box-type'] == 'feature1'):?>
    <?php $feature1 = $section['feature1'];?>
    <article id="features">
        <header class="heading-a">
            <?php if(!empty($feature1['title']) || !empty($feature1['subtitle'])):?>
                <h3>
                    <span class="small"><?php echo esc_html($feature1['title']);?></span>
                    <?php echo $feature1['subtitle']; ?>
                </h3>
            <?php endif; ?>
        </header>
        <ol class="list-b">
            <?php if(!empty($feature1['features'])):?>
                <?php foreach($feature1['features'] as $feature):?>
                    <li>
                        <span class="title"><?php echo esc_html($feature['title']);?></span>
                        <?php echo esc_html($feature['desc']);?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if(!empty($feature1['image'])):?>
                <li class="mobile-b"><img src="<?php echo esc_url(fw_resize($feature1['image']['url'],344,703));?>" alt="" width="344" height="703"></li>
            <?php endif; ?>
        </ol>
    </article>
<?php elseif($section['icon-box-type'] == 'feature2'):?>
    <?php $feature2 = $section['feature2'];?>
    <article id="features">
        <header class="heading-a">
            <?php if(!empty($feature2['title']) || !empty($feature2['subtitle'])):?>
                <h3>
                    <span class="small"><?php echo esc_html($feature2['title']);?></span>
                    <?php echo $feature2['subtitle']; ?>
                </h3>
            <?php endif; ?>
        </header>
        <ol class="list-b b">
            <?php if(!empty($feature2['image'])):?>
                <li class="mobile-g"><img src="<?php echo esc_url(fw_resize($feature2['image']['url'],675,372));?>" alt="" width="675" height="372"></li>
            <?php endif; ?>

            <?php if(!empty($feature2['features'])):?>
                <?php foreach($feature2['features'] as $feature):?>
                    <li>
                        <span class="title"><?php echo esc_html($feature['title']);?></span>
                        <?php echo esc_html($feature['desc']);?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ol>
    </article>
<?php else:?>
    <?php $feature3 = $section['feature3'];?>
    <article id="features">
        <header class="heading-a">
            <?php if(!empty($feature3['title']) || !empty($feature3['subtitle'])):?>
                <h3>
                    <span class="small"><?php echo esc_html($feature3['title']);?></span>
                    <?php echo $feature3['subtitle']; ?>
                </h3>
            <?php endif; ?>
        </header>
        <ol class="list-b a">
            <?php if(!empty($feature3['features'])):?>
                <?php foreach($feature3['features'] as $feature):?>
                    <li>
                        <span class="title"><?php echo esc_html($feature['title']);?></span>
                        <?php echo esc_html($feature['desc']);?>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if(!empty($feature3['image'])):?>
                <li class="mobile-f"><img src="<?php echo esc_url($feature3['image']['url']);?>" alt="Placeholder" width="738" height="681"></li>
            <?php endif; ?>

        </ol>
    </article>
<?php endif;?>

<?php if(!empty($header_image) || !empty($header_color) || !empty($header_pattern)): ?>
    <?php
        ob_start();
    ?>
        <?php if(!empty($header_image) || (!empty($header_color) && $header_color['primary'] != ' ' && $header_color['secondary'] != ' ') || !empty($text_color)):?>
            #features{
                <?php if((!empty($header_color) && $header_color['primary'] != ' ' && $header_color['secondary'] != ' ')) : ?>
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
            #features:before{
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
            #features .heading-a,
            #features .heading-a h3,
            #features .heading-a h3 .small,
            #features .list-b li .title,
            #features .list-b li,
            #features .list-b li .no
            {
                color: <?php echo $text_color; ?>;
            }
            #features .heading-a h3:before
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