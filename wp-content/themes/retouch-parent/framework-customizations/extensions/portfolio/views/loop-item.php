<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

//get post thumbnail
$thumbnail_id = get_post_thumbnail_id();
if( !empty( $thumbnail_id ) ) {
    $thumbnail    = get_post( $thumbnail_id );
    $image        = wp_get_attachment_image_src($thumbnail->ID,array(1440,960));
    $thumbnail_title = $thumbnail->post_title;
} else {
    $image = '';
    $thumbnail_title = '';
}
?>
<li>
    <a href="<?php the_permalink() ?>">
        <?php if(!empty($image)):?>
            <img src="<?php echo esc_url(fw_resize($image[0],328,311)); ?>" alt="<?php echo $thumbnail_title; ?>" width="328" height="311">
        <?php endif; ?>
        <span>
            <span class="strong"><?php the_title(); ?></span>
            <span class="date"><?php echo get_the_date();?></span>
        </span>
    </a>
</li>