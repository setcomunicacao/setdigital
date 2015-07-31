<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 */
?>
<?php $footer_logo = defined('FW') ? fw_get_db_settings_option('logo-3') : '';?>
<footer id="footer">

    <?php if(!empty($footer_logo)):?>
        <figure><img src="<?php echo esc_url($footer_logo['url']);?>" alt="" width="174" height="55"></figure>
    <?php endif;?>

    <?php
        $twitter = defined('FW') ? fw_get_db_settings_option('twitter') : '';
        $facebook = defined('FW') ? fw_get_db_settings_option('facebook') : '';
        $instagram = defined('FW') ? fw_get_db_settings_option('instagram') : '';
    ?>
    <?php if(!empty($twitter) || !empty($facebook) ||!empty($instagram)):?>
        <h3><?php _e('Follow us','fw'); ?></h3>

        <ul class="social-a">
            <?php if(!empty($facebook)):?>
                <li class="fb"><a rel="external" target="_blank" href="<?php echo esc_url($facebook); ?>">Facebook</a></li>
            <?php endif; ?>
            <?php if(!empty($twitter)):?>
                <li class="tw"><a rel="external" target="_blank" href="<?php echo esc_url($twitter); ?>">Twitter</a></li>
            <?php endif;?>
            <?php if(!empty($instagram)):?>
                <li class="in"><a rel="external" target="_blank" href="<?php echo esc_url($instagram); ?>">Instagram</a></li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>

    <?php
        $app_link = defined('FW') ? fw_get_db_settings_option('apple_link') : '';
        $play_link = defined('FW') ? fw_get_db_settings_option('play_link') : '';
    ?>
    <?php if(!empty($app_link) || !empty($play_link)):?>
        <ul class="download-a">
            <?php if(!empty($app_link)):?>
                <li class="as"><a rel="external" target="_blank" href="<?php echo esc_url($app_link); ?>"></a></li>
            <?php endif; ?>
            <?php if(!empty($play_link)):?>
                <li class="gp"><a rel="external" target="_blank" href="<?php echo esc_url($play_link); ?>"></a></li>
            <?php endif; ?>
        </ul>
    <?php endif; ?>

    <p><?php echo defined('FW') ? fw_theme_translate(fw_get_db_settings_option('copyright')) : ''; ?></p>

</footer>

</div>
<?php wp_footer(); ?>
</body>
</html>