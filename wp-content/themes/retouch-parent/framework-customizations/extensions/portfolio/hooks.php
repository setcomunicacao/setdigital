<?php if ( ! defined( 'FW' ) ) { die( 'Forbidden' ); }

/**
 * Display existing portfolio with specific posts per page (is seted in theme settings)
 * If your theme displays portfolio posts in a different way, feel free to change or remove this function
 * @internal
 * @param WP_Query $query
 */

add_theme_support( 'post-thumbnails', array('fw-portfolio') );
add_post_type_support( 'fw-portfolio' , array('comments') );

if( !function_exists('_fw_ext_portfolio_theme_action_set_posts_per_page') ) :
    function _fw_ext_portfolio_theme_action_set_posts_per_page( $query ) {
        if ( !$query->is_main_query() || is_admin() ) {
            return;
        }
        $portfolio = fw()->extensions->get('portfolio');
        $posts_per_page = get_option('posts_per_page');
        $is_portfolio_taxonomy = $query->is_tax( $portfolio->get_taxonomy_name() );
        $is_portfolio_archive  = $query->is_archive()
            && isset( $query->query['post_type'] )
            && $query->query['post_type'] == $portfolio->get_post_type_name();

        if ($is_portfolio_taxonomy || $is_portfolio_archive) {
            $query->set( 'posts_per_page', $posts_per_page );
        }
    }
    add_action( 'pre_get_posts', '_fw_ext_portfolio_theme_action_set_posts_per_page' );
endif;

if (is_admin()) :
    function _action_remove_meta_boxes() {
        remove_meta_box( 'fw-options-box-general', 'fw-portfolio', 'side' );
    }
    add_action( 'do_meta_boxes', '_action_remove_meta_boxes', 10, 5 );
endif;
