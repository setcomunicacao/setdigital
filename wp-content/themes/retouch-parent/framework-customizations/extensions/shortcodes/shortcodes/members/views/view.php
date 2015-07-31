<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$style_shortcodes = '';
$title = $atts['title'];
$subtitle = $atts['subtitle'];
$desc = $atts['desc'];
$member_type = $atts['team'];

$header_image = $atts['header_image'];
$header_color = $atts['header_color'];
$header_pattern = $atts['header_pattern'];
$text_color = $atts['text_color'];

$uniq_id = rand(1,1000);
?>
<?php if($member_type['icon-box-type'] == 'team1'):?>
    <article class="team-members members">
        <div class="member-container">
            <header class="heading-a">
                <?php if(!empty($title) || !empty($subtitle)):?>
                    <h3>
                        <span class="small"><?php echo esc_html($title);?></span>
                        <?php echo $subtitle; ?>
                    </h3>
                <?php endif; ?>
                <p><?php echo esc_html($desc);?></p>
            </header>
            <?php if(!empty($member_type['team1']['members'])):?>
                <ul class="gallery-b b">
                    <?php foreach($member_type['team1']['members'] as $member): ?>
                        <?php if(!empty($member['image'])):?>
                            <li>
                                <a href="<?php echo esc_url($member['url']);?>">
                                    <img src="<?php echo esc_url($member['image']['url']); ?>" alt="" width="300" height="300">
                                </a>
                                <div>
                                    <h4><span><?php echo esc_html($member['name']); ?></span> <?php echo esc_html($member['job']); ?></h4>
                                </div>
                            </li>
                        <?php endif;?>
                    <?php endforeach; ?>
                </ul>
            <?php endif;?>
        </div>
    </article>
<?php elseif($member_type['icon-box-type'] == 'team2'):?>
    <article class="members">
        <div class="member-container">
            <header class="heading-a">
                <?php if(!empty($title) || !empty($subtitle)):?>
                    <h3>
                        <span class="small"><?php echo esc_html($title);?></span>
                        <?php echo $subtitle; ?>
                    </h3>
                <?php endif; ?>
                <p><?php echo esc_html($desc);?></p>
            </header>
            <?php if(!empty($member_type['team2']['members'])):?>
                <ul class="gallery-b a">
                    <?php foreach($member_type['team2']['members'] as $member): ?>
                        <?php if(!empty($member['image'])):?>
                            <li><a href="<?php echo esc_url($member['url']);?>"><img src="<?php echo esc_url($member['image']['url']); ?>" alt="" width="300" height="300"> </a>
                                <div>
                                    <h4><span><?php echo esc_html($member['name']); ?></span> <?php echo esc_html($member['job']); ?></h4>
                                    <p><?php echo esc_html($member['desc']); ?></p>
                                </div>
                            </li>
                        <?php endif;?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </article>
<?php elseif($member_type['icon-box-type'] == 'team3'):?>
    <article class="team-members members">
        <div class="member-container">
            <header class="heading-a">
                <?php if(!empty($title) || !empty($subtitle)):?>
                    <h3>
                        <span class="small"><?php echo esc_html($title);?></span>
                        <?php echo $subtitle; ?>
                    </h3>
                <?php endif; ?>
                <p><?php echo esc_html($desc);?></p>
            </header>
            <?php if(!empty($member_type['team3']['members'])):?>
                <ul class="gallery-b">
                    <?php foreach($member_type['team3']['members'] as $member): ?>
                        <?php if(!empty($member['image'])):?>
                            <li><a href="<?php echo esc_url($member['url']);?>"><img src="<?php echo esc_url($member['image']['url']); ?>" alt="" width="300" height="300"> </a>
                                <div>
                                    <h4><span><?php echo esc_html($member['name']); ?></span> <?php echo esc_html($member['job']); ?></h4>

                                    <?php if(!empty($member['fb']) || !empty($member['tw']) || !empty($member['inst'])):?>
                                        <ul>
                                            <?php if(!empty($member['fb'])):?>
                                                <li><a rel="external" href="<?php echo esc_url($member['fb']);?>"><img src="<?php echo esc_url(get_template_directory_uri().'/images/icon-fb-a.png');?>" alt="Facebook" width="36" height="36"></a></li>
                                            <?php endif;?>
                                            <?php if(!empty($member['tw'])):?>
                                                <li><a rel="external" href="<?php echo esc_url($member['tw']);?>"><img src="<?php echo esc_url(get_template_directory_uri().'/images/icon-tw-a.png');?>" alt="Twitter" width="36" height="36"></a></li>
                                            <?php endif;?>
                                            <?php if(!empty($member['inst'])):?>
                                                <li><a rel="external" href="<?php echo esc_url($member['inst']);?>"><img src="<?php echo esc_url(get_template_directory_uri().'/images/icon-in-a.png');?>" alt="Instagram" width="36" height="36"></a></li>
                                            <?php endif;?>
                                        </ul>
                                    <?php endif;?>
                                </div>
                            </li>
                        <?php endif;?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </article>
<?php endif;?>

<?php if(!empty($header_image) || (!empty($header_color) && $header_color['primary'] != ' ' && $header_color['secondary'] != ' ') || !empty($header_pattern) || !empty($text_color)): ?>
    <?php
        ob_start();
    ?>
        <?php if(!empty($header_image) || !empty($header_color) ):?>
            .members{
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
            .members:before{
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
            .members .heading-a,
            .members .heading-a h3,
            .members .heading-a h3 .small,
            .members .gallery-b li > div h4,
            .members .gallery-b li > div p
            {
                color: <?php echo $text_color; ?>;
            }
            .members .heading-a h3:before
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