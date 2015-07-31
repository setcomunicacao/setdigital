<?php
if ( ! defined( 'ABSPATH' ) ) die( 'Direct access forbidden.' );

/**
 * @var $instance
 * @var $before_widget
 * @var $after_widget
 * @var $title
 */

?>
<?php if ( ! empty( $instance ) ) :
    echo $before_widget;
    $search_value = $title;
    ?>

    <form action="<?php echo home_url( '/' ) ?>" method="get" class="search-a">
        <fieldset>
            <p>
                <label for="sa"><?php echo fw_theme_translate(esc_html($search_value)); ?></label>
                <input type="text" id="sa" name="s" value="<?php get_search_query();?>" required>
                <button type="submit">
                    <i class="icon-basic" data-icon="#"></i>
                    <span class="hidden"><?php _e('Submit','fw');?></span>
                </button>
            </p>
        </fieldset>
    </form>

    <?php echo $after_widget;
endif; ?>