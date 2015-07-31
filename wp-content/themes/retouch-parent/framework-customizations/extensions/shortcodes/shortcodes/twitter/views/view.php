<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * @var array $atts
 */
$style_shortcodes = '';
$title = $atts['title'];
$username = $atts['username'];
$number = $atts['number'];

$header_image = $atts['header_image'];
$header_color = $atts['header_color'];
$header_pattern = $atts['header_pattern'];
$text_color = $atts['text_color'];

$uniq_id = rand(1,1000);
$connection = function_exists('fw_ext_social_twitter_get_connection') ? fw_ext_social_twitter_get_connection() : '';
$tweets     = (!empty($connection)) ? $connection->get( "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $username . "&count=" . $number ) : '';
?>
<div class="border-white-top"></div>
<article id="twitter" class="vb tweets">
    <header class="heading-a tw">
        <?php if(!empty($title)):?>
            <h3>
                <?php echo $title;?>
            </h3>
        <?php endif; ?>
    </header>

    <?php if(!empty($tweets)):?>
        <?php
            // Some reformatting
            $pattern = array(
                '/[^(:\/\/)](www\.[^ \n\r]+)/',
                '/(https?:\/\/[^ \n\r]+)/',
                '/@(\w+)/',
                '/^'.$username.':\s*/i'
            );
            $replace = array(
                '<a href="http://$1" rel="nofollow"  target="_blank">$1</a>',
                '<a href="$1" rel="nofollow" target="_blank">$1</a>',
                '<a href="http://twitter.com/$1" rel="nofollow"  target="_blank">@$1</a>'.
                ''
            );

        ?>
        <ul class="slider-a">
            <?php foreach($tweets as $tweet):?>
                <?php //fw_print($tweet);?>
                <li>
                    <img src="<?php echo esc_url(str_replace('_normal.png','.png',$tweet->user->profile_image_url));?>" alt="">
                    <span class="title">
                        <span><?php echo $tweet->user->name;?></span>
                        <a href="<?php echo esc_url('https://twitter.com/'.$username);?>" target="_blank">@<?php echo $tweet->user->screen_name;?></a>
                        <span class="date"><?php echo date('F j, Y', strtotime($tweet->created_at)); ?></span>
                    </span>
                    <?php echo preg_replace($pattern, $replace, $tweet->text);?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif;?>
</article>

<?php if(!empty($header_image) || (!empty($header_color) && $header_color['primary'] != ' ' && $header_color['secondary'] != ' ') || !empty($header_pattern) || !empty($text_color)): ?>
    <?php
        ob_start();
    ?>
        <?php if(!empty($header_image) || !empty($header_color) ):?>
            #content.a #twitter.vb{

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
            #content.a #twitter.vb:before{
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
            #content.a #twitter.vb .heading-a *,
            #content.a #twitter.vb .heading-a h3,
            #content.a #twitter.vb .heading-a h3 .small,
            #content.a #twitter.vb .slider-a li,
            #content.a #twitter.vb .slider-a a
            {
                color: <?php echo $text_color; ?>;
            }
            #content.a #twitter.vb .heading-a h3:before
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