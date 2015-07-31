<?php
if ( ! function_exists( 'fw_theme_comment' ) ) :
    /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own fw_theme_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     */
    function fw_theme_comment($comment, $args, $depth) {
        $GLOBALS['comment'] = $comment;

        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
            ?>
    <li class="post pingback">
        <article id="li-comment-<?php comment_ID() ?>" class="comment-body">
            <p><?php _e( 'Pingback:', 'fw' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'fw' ), '<span class="edit-link">', '</span>' ); ?></p>
            <div class="comment-entry">
                <?php comment_text(); ?>
                <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
            </div>
        </article>
        <?php
            break;
            default : ?>
                <li <?php comment_class(); ?>>
                    <a name="comment-<?php comment_ID() ?>"></a>

                    <span id="li-comment-<?php comment_ID() ?>" class="comment-body">

                        <?php echo get_avatar( $comment, 81);?>

                        <span class="title">
                            <?php comment_author_link(); ?>
                            <?php _e('said','fw'); ?> :
                        </span>

                        <?php echo esc_textarea($comment->comment_content); ?>

                        <span class="date">
                            <?php comment_date(); ?>
                            |
                            <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                        </span>

                        <?php if ( $comment->comment_approved == '0' ) : ?>
                            <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'fw' ); ?></em>
                            <br />
                        <?php endif; ?>

                        <div class="clear"></div>
                        <div id="comment-<?php comment_ID(); ?>"></div>
                        <div class="clearfix"></div>
                    </span><!-- /.comment-container -->
                <?php
                break;
        endswitch;
    }
endif; // ends check for fw_theme_comment()