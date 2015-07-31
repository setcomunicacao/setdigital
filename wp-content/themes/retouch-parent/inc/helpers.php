<?php if ( ! defined( 'ABSPATH' ) ) die( 'Direct access forbidden.' );
/**
 * Helper functions and classes with static methods for usage in theme
 */

/**
 * Register Lato Google font.
 *
 * @return string
 */
function fw_theme_font_url() {
    $font_url = '';
    /*
     * Translators: If there are characters in your language that are not supported
     * by Lato, translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Lato font: on or off', 'fw' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ), "//fonts.googleapis.com/css" );
    }

    return $font_url;
}

/**
 * Getter function for Featured Content Plugin.
 *
 * @return array An array of WP_Post objects.
 */
function fw_theme_get_featured_posts() {
    /**
     * @param array|bool $posts Array of featured posts, otherwise false.
     */
    return apply_filters( 'fw_theme_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @return bool Whether there are featured posts.
 */
function fw_theme_has_featured_posts() {
    return ! is_paged() && (bool) fw_theme_get_featured_posts();
}

if ( ! function_exists( 'fw_theme_the_attached_image' ) ) :
    /**
     * Print the attached image with a link to the next attached image.
     */
    function fw_theme_the_attached_image() {
        $post = get_post();
        /**
         * Filter the default attachment size.
         *
         * @param array $dimensions {
         *     An array of height and width dimensions.
         *
         *     @type int $height Height of the image in pixels. Default 810.
         *     @type int $width  Width of the image in pixels. Default 810.
         * }
         */
        $attachment_size     = apply_filters( 'fw_theme_attachment_size', array( 810, 810 ) );
        $next_attachment_url = esc_url(wp_get_attachment_url());

        /*
         * Grab the IDs of all the image attachments in a gallery so we can get the URL
         * of the next adjacent image in a gallery, or the first image (if we're
         * looking at the last image in a gallery), or, in a gallery of one, just the
         * link to that image file.
         */
        $attachment_ids = get_posts( array(
            'post_parent'    => $post->post_parent,
            'fields'         => 'ids',
            'numberposts'    => -1,
            'post_status'    => 'inherit',
            'post_type'      => 'attachment',
            'post_mime_type' => 'image',
            'order'          => 'ASC',
            'orderby'        => 'menu_order ID',
        ) );

        // If there is more than 1 attachment in a gallery...
        if ( count( $attachment_ids ) > 1 ) {
            foreach ( $attachment_ids as $attachment_id ) {
                if ( $attachment_id == $post->ID ) {
                    $next_id = current( $attachment_ids );
                    break;
                }
            }

            // get the URL of the next image attachment...
            if ( $next_id ) {
                $next_attachment_url = get_attachment_link( $next_id );
            }

            // or get the URL of the first image attachment.
            else {
                $next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
            }
        }

        printf( '<a href="%1$s" rel="attachment">%2$s</a>',
            esc_url( $next_attachment_url ),
            wp_get_attachment_image( $post->ID, $attachment_size )
        );
    }
endif;

if ( ! function_exists( 'fw_theme_list_authors' ) ) :
    /**
     * Print a list of all site contributors who published at least one post.
     */
    function fw_theme_list_authors() {
        $contributor_ids = get_users( array(
            'fields'  => 'ID',
            'orderby' => 'post_count',
            'order'   => 'DESC',
            'who'     => 'authors',
        ) );

        foreach ( $contributor_ids as $contributor_id ) :
            $post_count = count_user_posts( $contributor_id );

            // Move on if user has not published a post (yet).
            if ( ! $post_count ) {
                continue;
            }
            ?>

            <div class="contributor">
                <div class="contributor-info">
                    <div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 132 ); ?></div>
                    <div class="contributor-summary">
                        <h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name', $contributor_id ); ?></h2>
                        <p class="contributor-bio">
                            <?php echo get_the_author_meta( 'description', $contributor_id ); ?>
                        </p>
                        <a class="button contributor-posts-link" href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
                            <?php printf( _n( '%d Article', '%d Articles', $post_count, 'fw' ), $post_count ); ?>
                        </a>
                    </div><!-- .contributor-summary -->
                </div><!-- .contributor-info -->
            </div><!-- .contributor -->

        <?php
        endforeach;
    }
endif;

/**
 * Custom template tags
 */
{
    if ( ! function_exists( 'fw_theme_paging_nav' ) ) :
        /**
         * Display navigation to next/previous set of posts when applicable.
         */
        function fw_theme_paging_nav($args = array(), $query = '' ) {

            global $wp_rewrite, $wp_query;
            if ( $query ) {

                $wp_query = $query;

            } // End IF Statement
            /* If there's not more than one page, return nothing. */
            if ( 1 >= $wp_query->max_num_pages )
                return false;

            /* Get the current page. */
            $current = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );

            /* Get the max number of pages. */
            $max_num_pages = intval( $wp_query->max_num_pages );

            /* Set up some default arguments for the paginate_links() function. */
            $defaults = array(
                'base' => add_query_arg( 'paged', '%#%' ),
                'format' => '',
                'total' => $max_num_pages,
                'current' => $current,
                'prev_next' => false,
                'show_all' => false,
                'end_size' => 2,
                'mid_size' => 1,
                'add_fragment' => '',
                'type' => 'array',
                'before' => '<li>',
                'after' => '</li>',
                'echo' => true,
            );

            /* Add the $base argument to the array if the user is using permalinks. */
            if( $wp_rewrite->using_permalinks() )
                $defaults['base'] = user_trailingslashit( trailingslashit( get_pagenum_link() ) . 'page/%#%' );

            /* If we're on a search results page, we need to change this up a bit. */
            if ( is_search() ) {
                $search_permastruct = $wp_rewrite->get_search_permastruct();
                if ( !empty( $search_permastruct ) )
                    $defaults['base'] = user_trailingslashit( trailingslashit( get_search_link() ) . 'page/%#%' );
            }

            /* Merge the arguments input with the defaults. */
            $args = wp_parse_args( $args, $defaults );

            /* Don't allow the user to set this to an array. */
            /*if ( 'array' == $args['type'] )
                $args['type'] = 'plain';*/

            /* Get the paginated links. */
            $page_links = paginate_links( $args );

            /* Remove 'page/1' from the entire output since it's not needed. */
            //$page_links = str_replace( array( '&#038;paged=1\'', '/page/1\'' ), '\'', $page_links );

            ?>
            <nav class="pagination-a">
                <ol>
                    <?php echo '<li class="prev">'.get_previous_posts_link(__('Previous','fw')).'</li>';?>

                    <?php if(!empty($page_links)):?>
                        <?php foreach($page_links as $key => $page_link):?>
                            <li><?php echo ($key == 0) ? str_replace( array( '&#038;paged=1\'', '/page/1\'' ), '\'', $page_link ) : $page_link;?></li>
                        <?php endforeach;?>
                    <?php endif;?>

                    <?php echo '<li class="next">'.get_next_posts_link(__('Next','fw')).'</li>'; ?>
                </ol>
            </nav>
        <?php
        }
    endif;

    if ( ! function_exists( 'fw_theme_post_nav' ) ) :
        /**
         * Display navigation to next/previous post when applicable.
         */
        function fw_theme_post_nav() {
            // Don't print empty markup if there's nowhere to navigate.
            $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
            $next     = get_adjacent_post( false, '', false );

            if ( ! $next && ! $previous ) {
                return;
            }

            ?>
            <nav class="navigation post-navigation" role="navigation">
                <h1 class="screen-reader-text"><?php _e( 'Post navigation', 'fw' ); ?></h1>
                <div class="nav-links">
                    <?php
                    if ( is_attachment() ) :
                        previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'fw' ) );
                    else :
                        previous_post_link( '%link', __( '<span class="meta-nav">Previous Post</span>%title', 'fw' ) );
                        next_post_link( '%link', __( '<span class="meta-nav">Next Post</span>%title', 'fw' ) );
                    endif;
                    ?>
                </div><!-- .nav-links -->
            </nav><!-- .navigation -->
        <?php
        }
    endif;

    if ( ! function_exists( 'fw_theme_posted_on' ) ) :
        /**
         * Print HTML with meta information for the current post-date/time and author.
         */
        function fw_theme_posted_on() {
            if ( is_sticky() && is_home() && ! is_paged() ) {
                echo '<span class="featured-post">' . __( 'Sticky', 'fw' ) . '</span>';
            }

            // Set up and print post meta information.
            printf( '<span class="entry-date"><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span> <span class="byline"><span class="author vcard"><a class="url fn n" href="%4$s" rel="author">%5$s</a></span></span>',
                esc_url( get_permalink() ),
                esc_attr( get_the_date( 'c' ) ),
                esc_html( get_the_date() ),
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                get_the_author()
            );
        }
    endif;

    /**
     * Find out if blog has more than one category.
     *
     * @return boolean true if blog has more than 1 category
     */
    function fw_theme_categorized_blog() {
        if ( false === ( $all_the_cool_cats = get_transient( 'fw_theme_category_count' ) ) ) {
            // Create an array of all the categories that are attached to posts
            $all_the_cool_cats = get_categories( array(
                'hide_empty' => 1,
            ) );

            // Count the number of categories that are attached to the posts
            $all_the_cool_cats = count( $all_the_cool_cats );

            set_transient( 'fw_theme_category_count', $all_the_cool_cats );
        }

        if ( 1 !== (int) $all_the_cool_cats ) {
            // This blog has more than 1 category so fw_theme_categorized_blog should return true
            return true;
        } else {
            // This blog has only 1 category so fw_theme_categorized_blog should return false
            return false;
        }
    }

    /**
     * Display an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index
     * views, or a div element when on single views.
     */
    function fw_theme_post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }

        if ( is_singular() ) :
            ?>

            <div class="post-thumbnail">
                <div class="post-thumbnail-image">
                    <?php
                    if ( ( in_array(fw_ext_sidebars_get_current_position(), array('full', 'left')) || is_page_template( 'page-templates/full-width.php' ) ) ) {
                        the_post_thumbnail( 'fw-theme-full-width' );
                    } else {
                        the_post_thumbnail();
                    }
                    ?>
                </div>
            </div>

        <?php else : ?>
            <div class="post-thumbnail">
                <a class="post-thumbnail-image" href="<?php the_permalink(); ?>">
                    <?php
                    if ( ( in_array(fw_ext_sidebars_get_current_position(), array('full', 'left')) || is_page_template( 'page-templates/full-width.php' ) ) ) {
                        the_post_thumbnail( 'fw-theme-full-width' );
                    } else {
                        the_post_thumbnail();
                    }
                    ?>
                </a>
            </div>

        <?php endif; // End is_singular()
    }
}


/*vlad*/
if ( !function_exists('fw_theme_get_posts')):
    /**
     *  Generate array with: recent/popular/most commented posts
     * @param string $sort Sort type (recent/popular/most commented)
     * @param integer $items Number of items to be extracted
     * @param boolean $image_post Extract or no post image
     * @param integer $image_width Set width of post image
     * @param integer $image_height Set height of post image
     * @param string $image_class Set class of post image
     * @param boolean $date_post Extract or no post date
     * @param string $date_format Set date format
     * @param string $post_type Set post type
     * @param string $category Set category from where posts would be extracted
     */
    function fw_theme_get_posts($args = null)
    {
        $defaults = array(
            'sort' => 'recent',
            'items' => 5,
            'image_post' => true,
            'return_image_tag' => true,
            'image_width' => 54,
            'image_height' => 54,
            'image_class' => 'thumbnail',
            'date_post' => true,
            'date_format' => 'F jS, Y',
            'post_type' => 'post',
            'category' => '',
            'excerpt_length' => 40
        );

        extract(wp_parse_args($args, $defaults));
        global $post;
        $fw_cat_ID = ( !empty($category)) ? get_cat_ID( $category ) : '';

        if($sort == 'recent')
        {
            $query = new WP_Query( array ( 'post_type' => $post_type, 'orderby' => 'post_date',  'order '=>'DESC', 'cat'=> $fw_cat_ID, 'posts_per_page'=>$items ) );
            $posts  = $query->get_posts();
        }
        elseif($sort == 'popular')
        {
            $query = new WP_Query( array ( 'post_type' => $post_type, 'orderby' => 'meta_value', 'meta_key' => 'fw_post_views', 'order '=>'DESC', 'cat'=> $fw_cat_ID, 'posts_per_page'=>$items ) );
            $posts  = $query->get_posts();
        }
        elseif($sort == 'commented')
        {
            $query = new WP_Query( array ( 'post_type' => $post_type,  'orderby' => 'comment_count', 'order '=>'DESC','cat'=> $fw_cat_ID, 'posts_per_page'=>$items ) );
            $posts  = $query->get_posts();

        }
        else
            return false;

        $fw_post_option = array();
        $count = 0;
        if( !empty($posts) )
        {

            foreach($posts as $post_elm)
            {
                setup_postdata($post_elm);
                $img = '';

                if ( $image_post == true )
                {
                    $post_thumbnail_id = get_post_thumbnail_id( $post_elm->ID );
                    $post_thumbnail = wp_get_attachment_image_src( $post_thumbnail_id, 'large' );

                    if ( !empty($post_thumbnail) )
                    {
                        $image = fw_resize($post_thumbnail[0], $image_width, $image_height, true);
                        $img = $image;
                        if($return_image_tag){
                            $img = '<img src="'.$image.'" class="'.$image_class.'" alt="'.get_the_title($post_thumbnail_id).'" width="'.$image_width.'" height="'.$image_height.'" />';
                        }
                    }
                }

                if ( !empty($img) )
                    $fw_post_option[$count]['post_img'] = $img;
                else
                    $fw_post_option[$count]['post_img'] =  '';

                if ( $date_post ) {
                    $time_format = apply_filters('_filter_widget_time_format',$date_format);
                    $fw_post_option[$count]['post_date_post'] =  get_the_time($time_format, $post_elm->ID);
                }
                else
                    $fw_post_option[$count]['post_date_post'] = '';

                $fw_post_option[$count]['post_class']        = ( is_singular() && $post->ID == $post_elm->ID ) ? 'current-menu-item post_'.$sort : 'post_'.$sort;
                $fw_post_option[$count]['post_title']        = get_the_title($post_elm->ID);
                $fw_post_option[$count]['post_link']         = esc_url(get_permalink($post_elm->ID));
                $fw_post_option[$count]['post_author_link']  = get_author_posts_url(get_the_author_meta('ID' ));
                $fw_post_option[$count]['post_author_name']  = get_the_author();
                $fw_post_option[$count]['post_comment_numb'] = get_comments_number($post_elm->ID);
                $fw_post_option[$count]['post_excerpt']      = ( isset($post) ) ? get_the_excerpt() : '';
                $count++;
            }
            wp_reset_postdata();
        }

        return $fw_post_option;
    }
endif;


if ( ! function_exists( 'fw_theme_get_the_favicon' ) ) :
    /**
     * Print the favicon
     */
    function fw_theme_get_the_favicon($return = false) {
        $favicon = defined('FW') ? fw_get_db_settings_option('favicon') : '';
        if($return){
            return (!empty($favicon)) ? $favicon['url'] : '';
        }
        else{
            if( !empty( $favicon ) ) :
                ?>
                <link rel="icon" type="image/png" href="<?php echo $favicon['url']; ?>">
            <?php endif;
        }
    }
endif;

if ( ! function_exists( 'fw_theme_get_content_class' ) ) :
    /**
     * Print the analytics code
     */
    function fw_theme_get_content_class($parameter, $sidebar_position) {
        $class = '';
        if($parameter == 'content'){
            if($sidebar_position == 'right'){
                $class = 'col-sm-8';
            }
            elseif($sidebar_position == 'left'){
                $class = 'col-sm-8';
            }
            else{
                $class = 'col-sm-12';
            }
        }
        return $class;
    }
endif;

if ( ! function_exists( 'fw_theme_get_parent_sidebar_class' ) ) :
    /**
     * get parent sidebar class
     */
    function fw_theme_get_parent_sidebar_class($parameter, $sidebar_position) {
        $class = '';
        if($parameter == 'content'){
            if($sidebar_position == 'left'){
                $class = 'sidebar-left';
            }
            else{
                $class = '';
            }
        }
        return $class;
    }
endif;


//display logo
if (!function_exists('fw_theme_type_logo')) :
    function fw_theme_type_logo() {
        $logo_upload = fw_get_db_settings_option('logo');
        $logo = !empty($logo_upload) ?  esc_attr($logo_upload['attachment_id']) : '';
        if(!empty($logo))
        {
            ?>
            <a href="<?php echo esc_url(home_url()); ?>" accesskey="h">
                <img src="<?php echo esc_url(wp_get_attachment_url( $logo)); ?>" alt="">
            </a>
        <?php }

    }
endif;

if ( !function_exists('fw_theme_cat_links')):
    function fw_theme_cat_links($post_type,$id){
        if($post_type == 'post')
            return get_the_term_list($id,'category', '', ', ' );
    }
endif;


if (!function_exists('fw_theme_list_portfolios')) :
    function fw_theme_list_portfolios() {
        $args = array(
            'hide_empty'    => false,
        );
        $terms = get_terms('fw-portfolio-category', $args);
        $result = array();
        $result[0] = __('All','fw');

        if(!empty($terms))
            foreach ( $terms as $term ) {
                $result[$term->term_id] = $term->name;
            }
        return $result;
    }
endif;

if (!function_exists('fw_show_header')) :
    function fw_show_header($header_image = '', $header_color = '', $header_pattern = '', $header_title = '') {

        if(!empty($header_image) || (!empty($header_color)  && $header_color['primary'] != '#000000' && $header_color['secondary'] != '#000000') || !empty($header_pattern)):?>
            <article id="featured" class="header-static">
                <h2><?php echo fw_theme_translate($header_title); ?></h2>
            </article>

            <style>
                <?php if(!empty($header_image) || (!empty($header_color)  && $header_color['primary'] != '#000000' && $header_color['secondary'] != '#000000') ):?>
                    #featured, #content.page-template.a article#featured{
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
                    #featured:before, #content.page-template.a article#featured:before{
                        background: url(<?php echo esc_url($header_pattern['url']); ?>);
                    }
                <?php endif;?>
            </style>

        <?php else:?>
            <article id="featured" class="header-static no-image">
                <h2><?php echo fw_theme_translate($header_title); ?></h2>
            </article>
        <?php endif;
    }
endif;

if (!function_exists('fw_get_category_term_list')) :
    function fw_get_category_term_list(){
        /**
         * Return array of categories
         */
        $taxonomy = 'category';
        $args = array(
            'hide_empty' => true,
        );



        $terms = get_terms($taxonomy, $args);
        $result = array();
        $result[0] = __('All Categories','fw');

        if(!empty($terms))
            foreach ( $terms as $term ) {
                $result[ $term->term_id ] = $term->name;
            }
        return $result;


    }
endif;



//color theme
if (!function_exists('fw_theme_change_style')) :
    function fw_theme_change_style()
    {
        if(!defined('FW')) return;
        $styles = $headings = $body = $html = '';
        $fonts_links = array();
        //colors
        $color = fw_get_db_settings_option('color_schemes');
        $menu_text_color = fw_get_db_settings_option('menu_text_color');
        $menu_bg = fw_get_db_settings_option('menu_bg');
        $menu_sticky_bg = fw_get_db_settings_option('menu_sticky_bg');
        $menu_sticky_text = fw_get_db_settings_option('menu_sticky_text');

        //fonts
        $headings_typography = fw_get_db_settings_option('enable_headings_font');
        $body_typography = fw_get_db_settings_option('enable_body_font');

        $url = get_template_directory_uri();

        if ($headings_typography['enable_headings'] == 'yes')
        {
            //add/get heading font
            if (!empty($headings_typography['yes']['headings_typography']) && isset($headings_typography['yes']['headings_typography']['family'])) {
                $fonts_links[$headings_typography['yes']['headings_typography']['family']][] = $headings_typography['yes']['headings_typography']['style'];

                $headings = fw_theme_css_fonts($headings_typography['yes']['headings_typography'],
                    'h1,h2,h3,h4,h5,h6,h1 a, h2 a,
                    h3 a, h4 a, h5 a, h6 a, .list-a li .title, .list-b li .title, .slider-a li .title span,
                    .slider-a li .title, .list-c > li > span, .gallery-a li a > span');
            }
        }

        if ($body_typography['enable_body'] == 'yes') {
            //add/get body font
            if (!empty($body_typography['yes']['body_typography']['family']) && isset($body_typography['yes']['body_typography']['family'])) {
                if (!array_key_exists($body_typography['yes']['body_typography']['family'], $fonts_links)) {
                    $fonts_links[$body_typography['yes']['body_typography']['family']][] = $body_typography['yes']['body_typography']['style'];

                    $body = fw_theme_css_fonts($body_typography['yes']['body_typography'],
                        'body, textarea,
                        input, select, option, button, .download-a li.as, .nav-a > ul li.has-span a,
                        .js .search-a label, .news-a header ul li a, .news-a header ul li
                        ');
                }
            }
        }

        //google font link
        if(!empty($fonts_links))
        {
            $html .= "<link href='http://fonts.googleapis.com/css?family=";

            //get each font
            foreach ( $fonts_links as $font => $style ) {
                $html .= str_replace( ' ', '+', $font ) . ':' . implode( ',', $style ) . '|';
            }

            $html = substr($html, 0, -1);
            $html .= "' rel='stylesheet' type='text/css'>";
        }

        if(isset($_GET['color']) && !empty($_GET['color'])){
            $color_scheme = $_GET['color'];
        }
        elseif(isset($color['schemes']))
        {
            $color_scheme = $color['schemes'];
        }
        else
        {
            $color_scheme = '';
        }

        if(!empty($color_scheme))
        {
            if($color_scheme == 'custom')
            {
                $styles .='
                    #contact input:focus, #contact select:focus, #contact textarea:focus,
                    #contact .semantic-select.focus .input, #contact .semantic-select.active .input,
                    input:focus, select:focus, textarea:focus, .semantic-select.focus .input, .semantic-select.active .input,
                    .mc4wp-form .form-b input:focus
                    { border-color: '.$color['custom']['styling'].'; }

                    .comments-a .date, .counter > span span, .gallery-c ul li > div .link,
                    .heading-a h1 .small, .heading-a h2 .small, .heading-a h3 .small,.nav-a h1 em,
                     .nav-a h2 em, .nav-a h3 em, .nav-a h4 em, .nav-a > ul, .nav-a.widget_nav_menu div > ul,
                    .nav-a > ul li p.link-a, .nav-a.widget_nav_menu div > ul li p.link-a,
                    .nav-a > ul li p.link-a a, .nav-a.widget_nav_menu div > ul li p.link-a a,
                    .nav-a > ul li p.link-a em, .nav-a > ul li p.link-a i, .nav-a.widget_nav_menu div > ul li p.link-a em,
                    .nav-a.widget_nav_menu div > ul li p.link-a i, .nav-a > ul li a span.scheme-a,
                    .nav-a.widget_nav_menu div > ul li a span.scheme-a, .nav-a > ul li a:hover span, .nav-a > ul li.active a span ,
                    .nav-a.widget_nav_menu div > ul li a:hover span, .nav-a.widget_nav_menu div > ul li.active a span,
                    #root .nav-a > ul.sub-menu li a:hover, #root .nav-a.widget_nav_menu > ul.sub-menu li.active a, #root .nav-a div > ul.sub-menu li a:hover,
                    #root .nav-a div > ul.sub-menu li.active a, .nav-a > ul.sub-menu li i:before, .nav-a.widget_nav_menu div > ul.sub-menu li i:before,
                    .nav-a b, #root .widget_recent_comments > ul li a:hover, #root .widget_recent_comments > ul li.active a,
                    .nav-a.aside-cal h1 + h2, .nav-a.aside-cal h2 + h3, .nav-a.aside-cal h3 + h4, .nav-a.aside-cal h4 + h5,
                    #root .nav-a.aside-cal ul li a:hover, #root .nav-a.aside-cal ul li.active a, .news-a header ul li a:hover,
                    .news-a header ul li i, .news-a header ul li i:before, .news-b article header p span, ins, mark, .scheme-a, a,
                    .list-a li i, #root .search-a button, .is-sticky, aside .widget_calendar caption, aside .widget_calendar thead th,
                    .nav-a.widget_nav_menu ul li ul.sub-menu li  a:hover, .nav-a.widget_categories ul li ul.children li  a:hover,
                    #clone nav > ul > li.active > a, #clone nav > ul > li:hover > a, #clone nav > ul > li > a:hover
                    { color: '.$color['custom']['styling'].'; }

                    .counter > span span:before, .gallery-a li a:before, .gallery-a li.plain a .date:before,
                    .gallery-b li:before, .gallery-c ul li:before, .gallery-b.b > li > div:before,
                    #root .gallery-b li > .fit-a:before, #root .gallery-b li > .fit-a:after,
                    .gallery-c .bx-pager .bx-pager-item a.active, .news-d .bx-pager-item a.active,
                    .gallery-a .bx-pager-item a.active, .gallery-b .bx-pager-item a.active,.heading-a h1:before,
                    .heading-a h2:before, .heading-a h3:before, .nav-a > ul li a:hover, .nav-a > ul li.active a,
                    .nav-a div.widget_nav_menu > ul li a:hover, .nav-a.widget_nav_menu div > ul li.active a,
                    news-b article h1:before, .news-b article h2:before, .news-b article h3:before, .news-b article h5:before,
                    #content.page-template.a .news-c article, .news-d article h1:before, .news-d article h2:before, .news-d article h3:before,
                    .news-d article h4:before, .news-d article h5:before, .news-d article h6:before, .news-e header figure:before,
                    .news-e h1:before, .news-e h2:before, .news-e h3:before, .pagination-a li a:hover, .pagination-a li .current,.slider-ba,
                    .link-a a:hover, .list-a li a:hover i, .list-b li .no, .list-c  li  span span, .list-c  li  a:hover,
                    button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, #root .semantic-select ul li a:hover,
                    #root .semantic-select ul li.active a, .fancybox-title-over-wrap, #fancybox-thumbs ul li a, #contact .wpcf7-submit:hover,
                    #featured, #root #clone nav > ul > li.sub:hover > a, #clone nav > ul > li.a > a, #clone nav > ul > li > ul
                    {background:  '.$color['custom']['styling'].'; }

                    #clone nav > ul > li:hover.a > a{color: #fff;}

                    #fancybox-buttons ul { border: 1px solid '.$color['custom']['styling'].'; }
                    #fancybox-buttons a.btnToggle, #fancybox-buttons a.btnClose { border-left: 1px solid '.$color['custom']['styling'].'; }

                    ::selection { background: '.$color['custom']['styling'].'; }
                    ::-moz-selection { background: '.$color['custom']['styling'].';}

                    .download-a li a:hover, .social-a li a:hover, .nav-a.widget_nav_menu ul li a:hover,
                    .nav-a.widget_nav_menu ul li.active a,.nav-a.widget_nav_menu div > ul li a:hover span.scheme-a,
                    .nav-a.widget_nav_menu div > ul li.active a span.scheme-a,#root .widget_tag_cloud > div a:hover
                    { background-color: '.$color['custom']['styling'].'; }

                    #root .gallery-b li > .fit-a {border: 1px solid '.$color['custom']['styling'].';}

                    .pagination-a li a, .pagination-a li span { border: 1px solid '.$color['custom']['styling'].'; color: '.$color['custom']['styling'].';}

                    .link-a a {border: 1px solid '.$color['custom']['styling'].'; color: '.$color['custom']['styling'].';}
                    .link-a.a a { border: 2px solid '.$color['custom']['styling'].'; }
                    .list-c  li  a {border: 2px solid '.$color['custom']['styling'].'; color: '.$color['custom']['styling'].';}
                    button, input[type="button"], input[type="reset"], input[type="submit"] { border: 1px solid '.$color['custom']['styling'].';color: '.$color['custom']['styling'].';}
                    .semantic-select ul {border: 1px solid '.$color['custom']['styling'].';}

                    #contact .wpcf7-submit {
                        border: 1px solid '.$color['custom']['styling'].';
                        color: '.$color['custom']['styling'].';
                    }

                    #top > .fit-a:before, #top > .fit-a:after, #clone > .fit-a:before, #clone > .fit-a:after {
                        border-bottom: 3px solid '.$color['custom']['styling'].';
                    }

                    #top > .fit-a:before, #clone > .fit-a:before {
                        border-top: 3px solid '.$color['custom']['styling'].';
                    }

                    #top.active > .fit-a:after, #clone.active > .fit-a:after,
                     #top.active > .fit-a:before, #clone.active > .fit-a:before{
                        background: '.$color['custom']['styling'].';
                    }

                    @media only screen and (max-width: 47.5em) {
                        #root #nav > ul > li > ul li a:hover, #root #nav > ul > li > ul li.active { color: '.$color['custom']['styling'].'; }
                    }
                ';
            }
            elseif($color_scheme == 'blue'){
                $styles .= '
                    #contact input:focus, #contact select:focus, #contact textarea:focus,
                    #contact .semantic-select.focus .input, #contact .semantic-select.active .input,
                    input:focus, select:focus, textarea:focus, .semantic-select.focus .input, .semantic-select.active .input,
                    .mc4wp-form .form-b input:focus
                    { border-color: #00aae6; }
                    
                    .comments-a .date, .counter > span span, .gallery-c ul li > div .link,
                    .heading-a h1 .small, .heading-a h2 .small, .heading-a h3 .small,.nav-a h1 em,
                    .nav-a h2 em, .nav-a h3 em, .nav-a h4 em, .nav-a > ul, .nav-a.widget_nav_menu div > ul,
                    .nav-a > ul li p.link-a, .nav-a.widget_nav_menu div > ul li p.link-a,
                    .nav-a > ul li p.link-a a, .nav-a.widget_nav_menu div > ul li p.link-a a,
                    .nav-a > ul li p.link-a em, .nav-a > ul li p.link-a i, .nav-a.widget_nav_menu div > ul li p.link-a em,
                    .nav-a.widget_nav_menu div > ul li p.link-a i, .nav-a > ul li a span.scheme-a,
                    .nav-a.widget_nav_menu div > ul li a span.scheme-a, .nav-a > ul li a:hover span, .nav-a > ul li.active a span ,
                    .nav-a.widget_nav_menu div > ul li a:hover span, .nav-a.widget_nav_menu div > ul li.active a span,
                    #root .nav-a > ul.sub-menu li a:hover, #root .nav-a.widget_nav_menu > ul.sub-menu li.active a, #root .nav-a div > ul.sub-menu li a:hover,
                    #root .nav-a div > ul.sub-menu li.active a, .nav-a > ul.sub-menu li i:before, .nav-a.widget_nav_menu div > ul.sub-menu li i:before,
                    .nav-a b, #root .widget_recent_comments > ul li a:hover, #root .widget_recent_comments > ul li.active a,
                    .nav-a.aside-cal h1 + h2, .nav-a.aside-cal h2 + h3, .nav-a.aside-cal h3 + h4, .nav-a.aside-cal h4 + h5,
                    #root .nav-a.aside-cal ul li a:hover, #root .nav-a.aside-cal ul li.active a, .news-a header ul li a:hover,
                    .news-a header ul li i, .news-a header ul li i:before, .news-b article header p span, ins, mark, .scheme-a, a,
                    .list-a li i, #root .search-a button, .is-sticky, aside .widget_calendar caption, aside .widget_calendar thead th,
                    .nav-a.widget_nav_menu ul li ul.sub-menu li  a:hover, .nav-a.widget_categories ul li ul.children li  a:hover,
                    #clone nav > ul > li.active > a, #clone nav > ul > li:hover > a, #clone nav > ul > li > a:hover
                    { color: #00aae6; }
                    
                    .counter > span span:before, .gallery-a li a:before, .gallery-a li.plain a .date:before,
                    .gallery-b li:before, .gallery-c ul li:before, .gallery-b.b > li > div:before,
                    #root .gallery-b li > .fit-a:before, #root .gallery-b li > .fit-a:after,
                    .gallery-c .bx-pager .bx-pager-item a.active, .news-d .bx-pager-item a.active,
                    .gallery-a .bx-pager-item a.active, .gallery-b .bx-pager-item a.active,.heading-a h1:before,
                    .heading-a h2:before, .heading-a h3:before, .nav-a > ul li a:hover, .nav-a > ul li.active a,
                    .nav-a div.widget_nav_menu > ul li a:hover, .nav-a.widget_nav_menu div > ul li.active a,
                    news-b article h1:before, .news-b article h2:before, .news-b article h3:before, .news-b article h5:before,
                    #content.page-template.a .news-c article, .news-d article h1:before, .news-d article h2:before, .news-d article h3:before,
                    .news-d article h4:before, .news-d article h5:before, .news-d article h6:before, .news-e header figure:before,
                    .news-e h1:before, .news-e h2:before, .news-e h3:before, .pagination-a li a:hover, .pagination-a li .current,.slider-ba,
                    .link-a a:hover, .list-a li a:hover i, .list-b li .no, .list-c  li  span span, .list-c  li  a:hover,
                    button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, #root .semantic-select ul li a:hover,
                    #root .semantic-select ul li.active a, .fancybox-title-over-wrap, #fancybox-thumbs ul li a, #contact .wpcf7-submit:hover,
                    #featured, #root #clone nav > ul > li.sub:hover > a, #clone nav > ul > li.a > a, #clone nav > ul > li > ul
                    {background:  #00aae6; }
                    
                    #clone nav > ul > li:hover.a > a{color: #fff;}
                    
                    #fancybox-buttons ul { border: 1px solid #00aae6; }
                    #fancybox-buttons a.btnToggle, #fancybox-buttons a.btnClose { border-left: 1px solid #00aae6; }
                    
                    ::selection { background: #00aae6 !important; }
                    ::-moz-selection { background: #00aae6 !important;}
                    
                    .download-a li a:hover, .social-a li a:hover, .nav-a.widget_nav_menu ul li a:hover,
                    .nav-a.widget_nav_menu ul li.active a,.nav-a.widget_nav_menu div > ul li a:hover span.scheme-a,
                    .nav-a.widget_nav_menu div > ul li.active a span.scheme-a,#root .widget_tag_cloud > div a:hover
                    { background-color: #00aae6; }
                    
                    #root .gallery-b li > .fit-a {border: 1px solid #00aae6;}
                    
                    .pagination-a li a, .pagination-a li span { border: 1px solid #00aae6; color: #00aae6;}
                    
                    .link-a a {border: 1px solid #00aae6; color: #00aae6;}
                    .link-a.a a { border: 2px solid #00aae6; }
                    .list-c  li  a {border: 2px solid #00aae6; color: #00aae6;}
                    button, input[type="button"], input[type="reset"], input[type="submit"] { border: 1px solid #00aae6;color: #00aae6;}
                    .semantic-select ul {border: 1px solid #00aae6;}
                    
                    #contact .wpcf7-submit {
                        border: 1px solid #00aae6;
                        color: #00aae6;
                    }
                    
                    #top > .fit-a:before, #top > .fit-a:after, #clone > .fit-a:before, #clone > .fit-a:after {
                        border-bottom: 3px solid #00aae6;
                    }
                    
                    #top > .fit-a:before, #clone > .fit-a:before {
                        border-top: 3px solid #00aae6;
                    }
                    
                    #top.active > .fit-a:after, #clone.active > .fit-a:after,
                    #top.active > .fit-a:before, #clone.active > .fit-a:before{
                        background: #00aae6;
                    }
                    
                    @media only screen and (max-width: 47.5em) {
                        #root #nav > ul > li > ul li a:hover, #root #nav > ul > li > ul li.active { color: #00aae6; }
                    }
                    
                    #content.page-template.a article#welcome{
                        background: -moz-linear-gradient(-45deg, #47c4f0 0%, #9fe3fd 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#47c4f0), color-stop(100%,#9fe3fd));
                        background: -webkit-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                        background: -o-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                        background: -ms-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                        background: linear-gradient(135deg, #47c4f0 0%,#9fe3fd 100%);
                    }
                    
                    #content.page-template.a article#welcome:before{
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #services{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #about.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    
                    #features{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #testimonials.vb{
                        background: -moz-linear-gradient(-45deg, #47c4f0 0%, #9fe3fd 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#47c4f0), color-stop(100%,#9fe3fd));
                        background: -webkit-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                        background: -o-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                        background: -ms-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                        background: linear-gradient(135deg, #47c4f0 0%,#9fe3fd 100%);
                    }
                    
                    #content.a #testimonials.vb:before{
                        content: "";
                        display: block;
                        position: absolute;
                        left: 0;
                        top: 0;
                        z-index: 1;
                        width: 100%;
                        height: 100%;
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #carousel3d{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #zoom.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    #content.a #video_bg.vid{
                        background: -moz-linear-gradient(-45deg, #523035 0%, #523035 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#523035), color-stop(100%,#523035));
                        background: -webkit-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: -o-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: -ms-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: linear-gradient(135deg, #523035 0%,#523035 100%);
                    }
                    
                    
                    
                    #blog{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #newsletter.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    #content.a #twitter.vb{
                    
                        background: -moz-linear-gradient(-45deg, #47c4f0 0%, #9fe3fd 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#47c4f0), color-stop(100%,#9fe3fd));
                        background: -webkit-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                        background: -o-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                        background: -ms-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                        background: linear-gradient(135deg, #47c4f0 0%,#9fe3fd 100%);
                    }
                    
                    #content.a #twitter.vb:before{
                        content: "";
                        display: block;
                        position: absolute;
                        left: 0;
                        top: 0;
                        z-index: 1;
                        width: 100%;
                        height: 100%;
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #content.a #pricing.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    #content.a #numbers.vb{
                    
                        background: -moz-linear-gradient(-45deg, #47c4f0 0%, #9fe3fd 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#47c4f0), color-stop(100%,#9fe3fd));
                        background: -webkit-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                        background: -o-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                        background: -ms-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                        background: linear-gradient(135deg, #47c4f0 0%,#9fe3fd 100%);
                    }
                    
                    #content.a #numbers.vb:before{
                        content: "";
                        display: block;
                        position: absolute;
                        left: 0;
                        top: 0;
                        z-index: 1;
                        width: 100%;
                        height: 100%;
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    #content.page-template.a article#featured, #featured{
                        background: -moz-linear-gradient(-45deg, #47c4f0 0%, #9fe3fd 100%);
                          background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#47c4f0), color-stop(100%,#9fe3fd));
                          background: -webkit-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                          background: -o-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                          background: -ms-linear-gradient(-45deg, #47c4f0 0%,#9fe3fd 100%);
                          background: linear-gradient(135deg, #47c4f0 0%,#9fe3fd 100%);
                    }
                ';
            }
            elseif($color_scheme == 'cyan'){
                $styles .='
                    #contact input:focus, #contact select:focus, #contact textarea:focus,
                    #contact .semantic-select.focus .input, #contact .semantic-select.active .input,
                    input:focus, select:focus, textarea:focus, .semantic-select.focus .input, .semantic-select.active .input,
                    .mc4wp-form .form-b input:focus
                    { border-color: #5fcac1; }
                    
                    .comments-a .date, .counter > span span, .gallery-c ul li > div .link,
                    .heading-a h1 .small, .heading-a h2 .small, .heading-a h3 .small,.nav-a h1 em,
                    .nav-a h2 em, .nav-a h3 em, .nav-a h4 em, .nav-a > ul, .nav-a.widget_nav_menu div > ul,
                    .nav-a > ul li p.link-a, .nav-a.widget_nav_menu div > ul li p.link-a,
                    .nav-a > ul li p.link-a a, .nav-a.widget_nav_menu div > ul li p.link-a a,
                    .nav-a > ul li p.link-a em, .nav-a > ul li p.link-a i, .nav-a.widget_nav_menu div > ul li p.link-a em,
                    .nav-a.widget_nav_menu div > ul li p.link-a i, .nav-a > ul li a span.scheme-a,
                    .nav-a.widget_nav_menu div > ul li a span.scheme-a, .nav-a > ul li a:hover span, .nav-a > ul li.active a span ,
                    .nav-a.widget_nav_menu div > ul li a:hover span, .nav-a.widget_nav_menu div > ul li.active a span,
                    #root .nav-a > ul.sub-menu li a:hover, #root .nav-a.widget_nav_menu > ul.sub-menu li.active a, #root .nav-a div > ul.sub-menu li a:hover,
                    #root .nav-a div > ul.sub-menu li.active a, .nav-a > ul.sub-menu li i:before, .nav-a.widget_nav_menu div > ul.sub-menu li i:before,
                    .nav-a b, #root .widget_recent_comments > ul li a:hover, #root .widget_recent_comments > ul li.active a,
                    .nav-a.aside-cal h1 + h2, .nav-a.aside-cal h2 + h3, .nav-a.aside-cal h3 + h4, .nav-a.aside-cal h4 + h5,
                    #root .nav-a.aside-cal ul li a:hover, #root .nav-a.aside-cal ul li.active a, .news-a header ul li a:hover,
                    .news-a header ul li i, .news-a header ul li i:before, .news-b article header p span, ins, mark, .scheme-a, a,
                    .list-a li i, #root .search-a button, .is-sticky, aside .widget_calendar caption, aside .widget_calendar thead th,
                    .nav-a.widget_nav_menu ul li ul.sub-menu li  a:hover, .nav-a.widget_categories ul li ul.children li  a:hover,
                    #clone nav > ul > li.active > a, #clone nav > ul > li:hover > a, #clone nav > ul > li > a:hover
                    { color: #5fcac1; }
                    
                    .counter > span span:before, .gallery-a li a:before, .gallery-a li.plain a .date:before,
                    .gallery-b li:before, .gallery-c ul li:before, .gallery-b.b > li > div:before,
                    #root .gallery-b li > .fit-a:before, #root .gallery-b li > .fit-a:after,
                    .gallery-c .bx-pager .bx-pager-item a.active, .news-d .bx-pager-item a.active,
                    .gallery-a .bx-pager-item a.active, .gallery-b .bx-pager-item a.active,.heading-a h1:before,
                    .heading-a h2:before, .heading-a h3:before, .nav-a > ul li a:hover, .nav-a > ul li.active a,
                    .nav-a div.widget_nav_menu > ul li a:hover, .nav-a.widget_nav_menu div > ul li.active a,
                    news-b article h1:before, .news-b article h2:before, .news-b article h3:before, .news-b article h5:before,
                    #content.page-template.a .news-c article, .news-d article h1:before, .news-d article h2:before, .news-d article h3:before,
                    .news-d article h4:before, .news-d article h5:before, .news-d article h6:before, .news-e header figure:before,
                    .news-e h1:before, .news-e h2:before, .news-e h3:before, .pagination-a li a:hover, .pagination-a li .current,.slider-ba,
                    .link-a a:hover, .list-a li a:hover i, .list-b li .no, .list-c  li  span span, .list-c  li  a:hover,
                    button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, #root .semantic-select ul li a:hover,
                    #root .semantic-select ul li.active a, .fancybox-title-over-wrap, #fancybox-thumbs ul li a, #contact .wpcf7-submit:hover,
                    #featured, #root #clone nav > ul > li.sub:hover > a, #clone nav > ul > li.a > a, #clone nav > ul > li > ul
                    {background:  #5fcac1; }
                    
                    #clone nav > ul > li:hover.a > a{color: #fff;}
                    
                    #fancybox-buttons ul { border: 1px solid #5fcac1; }
                    #fancybox-buttons a.btnToggle, #fancybox-buttons a.btnClose { border-left: 1px solid #5fcac1; }
                    
                    ::selection { background: #5fcac1; }
                    ::-moz-selection { background: #5fcac1;}
                    
                    .download-a li a:hover, .social-a li a:hover, .nav-a.widget_nav_menu ul li a:hover,
                    .nav-a.widget_nav_menu ul li.active a,.nav-a.widget_nav_menu div > ul li a:hover span.scheme-a,
                    .nav-a.widget_nav_menu div > ul li.active a span.scheme-a,#root .widget_tag_cloud > div a:hover
                    { background-color: #5fcac1; }
                    
                    #root .gallery-b li > .fit-a {border: 1px solid #5fcac1;}
                    
                    .pagination-a li a, .pagination-a li span { border: 1px solid #5fcac1; color: #5fcac1;}
                    
                    .link-a a {border: 1px solid #5fcac1; color: #5fcac1;}
                    .link-a.a a { border: 2px solid #5fcac1; }
                    .list-c  li  a {border: 2px solid #5fcac1; color: #5fcac1;}
                    button, input[type="button"], input[type="reset"], input[type="submit"] { border: 1px solid #5fcac1;color: #5fcac1;}
                    .semantic-select ul {border: 1px solid #5fcac1;}
                    
                    #contact .wpcf7-submit {
                        border: 1px solid #5fcac1;
                        color: #5fcac1;
                    }
                    
                    #top > .fit-a:before, #top > .fit-a:after, #clone > .fit-a:before, #clone > .fit-a:after {
                        border-bottom: 3px solid #5fcac1;
                    }
                    
                    #top > .fit-a:before, #clone > .fit-a:before {
                        border-top: 3px solid #5fcac1;
                    }
                    
                    #top.active > .fit-a:after, #clone.active > .fit-a:after,
                    #top.active > .fit-a:before, #clone.active > .fit-a:before{
                        background: #5fcac1;
                    }
                    
                    @media only screen and (max-width: 47.5em) {
                        #root #nav > ul > li > ul li a:hover, #root #nav > ul > li > ul li.active { color: #5fcac1; }
                    }
                    #content.page-template.a article#welcome{
                        background: -moz-linear-gradient(-45deg, #35b8b0 0%, #1c799d 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#35b8b0), color-stop(100%,#1c799d));
                        background: -webkit-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                        background: -o-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                        background: -ms-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                        background: linear-gradient(135deg, #35b8b0 0%,#1c799d 100%);
                    }
                    
                    #content.page-template.a article#welcome:before{
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #services{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    .members{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    .members{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #about.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    
                    #features{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #testimonials.vb{
                        background: -moz-linear-gradient(-45deg, #35b8b0 0%, #1c799d 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#35b8b0), color-stop(100%,#1c799d));
                        background: -webkit-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                        background: -o-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                        background: -ms-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                        background: linear-gradient(135deg, #35b8b0 0%,#1c799d 100%);
                    }
                    
                    #content.a #testimonials.vb:before{
                        content: "";
                        display: block;
                        position: absolute;
                        left: 0;
                        top: 0;
                        z-index: 1;
                        width: 100%;
                        height: 100%;
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #carousel3d{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #zoom.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    #content.a #video_bg.vid{
                        background: -moz-linear-gradient(-45deg, #523035 0%, #523035 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#523035), color-stop(100%,#523035));
                        background: -webkit-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: -o-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: -ms-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: linear-gradient(135deg, #523035 0%,#523035 100%);
                    }
                    #portfolio{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    #content.a #newsletter.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    #content.a #twitter.vb{
                    
                        background: -moz-linear-gradient(-45deg, #35b8b0 0%, #1c799d 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#35b8b0), color-stop(100%,#1c799d));
                        background: -webkit-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                        background: -o-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                        background: -ms-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                        background: linear-gradient(135deg, #35b8b0 0%,#1c799d 100%);
                    }
                    #content.a #twitter.vb:before{
                        content: "";
                        display: block;
                        position: absolute;
                        left: 0;
                        top: 0;
                        z-index: 1;
                        width: 100%;
                        height: 100%;
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #content.a #pricing.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    #content.a #numbers.vb{
                    
                        background: -moz-linear-gradient(-45deg, #35b8b0 0%, #1c799d 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#35b8b0), color-stop(100%,#1c799d));
                        background: -webkit-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                        background: -o-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                        background: -ms-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                        background: linear-gradient(135deg, #35b8b0 0%,#1c799d 100%);
                    }
                    #content.a #numbers.vb:before{
                        content: "";
                        display: block;
                        position: absolute;
                        left: 0;
                        top: 0;
                        z-index: 1;
                        width: 100%;
                        height: 100%;
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #content.page-template.a article#featured, #featured{
                          background: -moz-linear-gradient(-45deg, #35b8b0 0%, #1c799d 100%);
                          background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#35b8b0), color-stop(100%,#1c799d));
                          background: -webkit-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                          background: -o-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                          background: -ms-linear-gradient(-45deg, #35b8b0 0%,#1c799d 100%);
                          background: linear-gradient(135deg, #35b8b0 0%,#1c799d 100%);
                    }
                ';
            }
            elseif($color_scheme == 'green'){
                $styles .='
                    #contact input:focus, #contact select:focus, #contact textarea:focus,
                    #contact .semantic-select.focus .input, #contact .semantic-select.active .input,
                    input:focus, select:focus, textarea:focus, .semantic-select.focus .input, .semantic-select.active .input,
                    .mc4wp-form .form-b input:focus
                    { border-color: #afc625; }
                    
                    .comments-a .date, .counter > span span, .gallery-c ul li > div .link,
                    .heading-a h1 .small, .heading-a h2 .small, .heading-a h3 .small,.nav-a h1 em,
                    .nav-a h2 em, .nav-a h3 em, .nav-a h4 em, .nav-a > ul, .nav-a.widget_nav_menu div > ul,
                    .nav-a > ul li p.link-a, .nav-a.widget_nav_menu div > ul li p.link-a,
                    .nav-a > ul li p.link-a a, .nav-a.widget_nav_menu div > ul li p.link-a a,
                    .nav-a > ul li p.link-a em, .nav-a > ul li p.link-a i, .nav-a.widget_nav_menu div > ul li p.link-a em,
                    .nav-a.widget_nav_menu div > ul li p.link-a i, .nav-a > ul li a span.scheme-a,
                    .nav-a.widget_nav_menu div > ul li a span.scheme-a, .nav-a > ul li a:hover span, .nav-a > ul li.active a span ,
                    .nav-a.widget_nav_menu div > ul li a:hover span, .nav-a.widget_nav_menu div > ul li.active a span,
                    #root .nav-a > ul.sub-menu li a:hover, #root .nav-a.widget_nav_menu > ul.sub-menu li.active a, #root .nav-a div > ul.sub-menu li a:hover,
                    #root .nav-a div > ul.sub-menu li.active a, .nav-a > ul.sub-menu li i:before, .nav-a.widget_nav_menu div > ul.sub-menu li i:before,
                    .nav-a b, #root .widget_recent_comments > ul li a:hover, #root .widget_recent_comments > ul li.active a,
                    .nav-a.aside-cal h1 + h2, .nav-a.aside-cal h2 + h3, .nav-a.aside-cal h3 + h4, .nav-a.aside-cal h4 + h5,
                    #root .nav-a.aside-cal ul li a:hover, #root .nav-a.aside-cal ul li.active a, .news-a header ul li a:hover,
                    .news-a header ul li i, .news-a header ul li i:before, .news-b article header p span, ins, mark, .scheme-a, a,
                    .list-a li i, #root .search-a button, .is-sticky, aside .widget_calendar caption, aside .widget_calendar thead th,
                    .nav-a.widget_nav_menu ul li ul.sub-menu li  a:hover, .nav-a.widget_categories ul li ul.children li  a:hover,
                    #clone nav > ul > li.active > a, #clone nav > ul > li:hover > a, #clone nav > ul > li > a:hover
                    { color: #afc625; }
                    
                    .counter > span span:before, .gallery-a li a:before, .gallery-a li.plain a .date:before,
                    .gallery-b li:before, .gallery-c ul li:before, .gallery-b.b > li > div:before,
                    #root .gallery-b li > .fit-a:before, #root .gallery-b li > .fit-a:after,
                    .gallery-c .bx-pager .bx-pager-item a.active, .news-d .bx-pager-item a.active,
                    .gallery-a .bx-pager-item a.active, .gallery-b .bx-pager-item a.active,.heading-a h1:before,
                    .heading-a h2:before, .heading-a h3:before, .nav-a > ul li a:hover, .nav-a > ul li.active a,
                    .nav-a div.widget_nav_menu > ul li a:hover, .nav-a.widget_nav_menu div > ul li.active a,
                    news-b article h1:before, .news-b article h2:before, .news-b article h3:before, .news-b article h5:before,
                    #content.page-template.a .news-c article, .news-d article h1:before, .news-d article h2:before, .news-d article h3:before,
                    .news-d article h4:before, .news-d article h5:before, .news-d article h6:before, .news-e header figure:before,
                    .news-e h1:before, .news-e h2:before, .news-e h3:before, .pagination-a li a:hover, .pagination-a li .current,.slider-ba,
                    .link-a a:hover, .list-a li a:hover i, .list-b li .no, .list-c  li  span span, .list-c  li  a:hover,
                    button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, #root .semantic-select ul li a:hover,
                    #root .semantic-select ul li.active a, .fancybox-title-over-wrap, #fancybox-thumbs ul li a, #contact .wpcf7-submit:hover,
                    #featured, #root #clone nav > ul > li.sub:hover > a, #clone nav > ul > li.a > a, #clone nav > ul > li > ul
                    {background:  #afc625; }
                    
                    #clone nav > ul > li:hover.a > a{color: #fff;}
                    
                    #fancybox-buttons ul { border: 1px solid #afc625; }
                    #fancybox-buttons a.btnToggle, #fancybox-buttons a.btnClose { border-left: 1px solid #afc625; }
                    
                    ::selection { background: #afc625; }
                    ::-moz-selection { background: #afc625;}
                    
                    .download-a li a:hover, .social-a li a:hover, .nav-a.widget_nav_menu ul li a:hover,
                    .nav-a.widget_nav_menu ul li.active a,.nav-a.widget_nav_menu div > ul li a:hover span.scheme-a,
                    .nav-a.widget_nav_menu div > ul li.active a span.scheme-a,#root .widget_tag_cloud > div a:hover
                    { background-color: #afc625; }
                    
                    #root .gallery-b li > .fit-a {border: 1px solid #afc625;}
                    
                    .pagination-a li a, .pagination-a li span { border: 1px solid #afc625; color: #afc625;}
                    
                    .link-a a {border: 1px solid #afc625; color: #afc625;}
                    .link-a.a a { border: 2px solid #afc625; }
                    .list-c  li  a {border: 2px solid #afc625; color: #afc625;}
                    button, input[type="button"], input[type="reset"], input[type="submit"] { border: 1px solid #afc625;color: #afc625;}
                    .semantic-select ul {border: 1px solid #afc625;}
                    
                    #contact .wpcf7-submit {
                        border: 1px solid #afc625;
                        color: #afc625;
                    }
                    
                    #top > .fit-a:before, #top > .fit-a:after, #clone > .fit-a:before, #clone > .fit-a:after {
                        border-bottom: 3px solid #afc625;
                    }
                    
                    #top > .fit-a:before, #clone > .fit-a:before {
                        border-top: 3px solid #afc625;
                    }
                    
                    #top.active > .fit-a:after, #clone.active > .fit-a:after,
                    #top.active > .fit-a:before, #clone.active > .fit-a:before{
                        background: #afc625;
                    }
                    
                    @media only screen and (max-width: 47.5em) {
                        #root #nav > ul > li > ul li a:hover, #root #nav > ul > li > ul li.active { color: #afc625; }
                    }
                    #content.page-template.a article#welcome{
                        background: -moz-linear-gradient(-45deg, #8ec64e 0%, #41aba0 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#8ec64e), color-stop(100%,#41aba0));
                        background: -webkit-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: -o-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: -ms-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: linear-gradient(135deg, #8ec64e 0%,#41aba0 100%);
                    }
                    
                    #content.page-template.a article#welcome:before{
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #services{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    .members{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #about.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    
                    #features{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #testimonials.vb{
                        background: -moz-linear-gradient(-45deg, #8ec64e 0%, #41aba0 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#8ec64e), color-stop(100%,#41aba0));
                        background: -webkit-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: -o-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: -ms-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: linear-gradient(135deg, #8ec64e 0%,#41aba0 100%);
                    }
                    
                    #content.a #testimonials.vb:before{
                        content: "";
                        display: block;
                        position: absolute;
                        left: 0;
                        top: 0;
                        z-index: 1;
                        width: 100%;
                        height: 100%;
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #carousel3d{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #zoom.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    #content.a #video_bg.vid{
                        background: -moz-linear-gradient(-45deg, #523035 0%, #523035 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#523035), color-stop(100%,#523035));
                        background: -webkit-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: -o-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: -ms-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: linear-gradient(135deg, #523035 0%,#523035 100%);
                    }
                    
                    
                    
                    #blog{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #newsletter.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    #content.a #twitter.vb{
                    
                        background: -moz-linear-gradient(-45deg, #8ec64e 0%, #41aba0 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#8ec64e), color-stop(100%,#41aba0));
                        background: -webkit-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: -o-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: -ms-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: linear-gradient(135deg, #8ec64e 0%,#41aba0 100%);
                    }
                    
                    #content.a #twitter.vb:before{
                        content: "";
                        display: block;
                        position: absolute;
                        left: 0;
                        top: 0;
                        z-index: 1;
                        width: 100%;
                        height: 100%;
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #content.a #pricing.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    #content.a #numbers.vb{
                    
                        background: -moz-linear-gradient(-45deg, #8ec64e 0%, #41aba0 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#8ec64e), color-stop(100%,#41aba0));
                        background: -webkit-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: -o-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: -ms-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: linear-gradient(135deg, #8ec64e 0%,#41aba0 100%);
                    }
                    
                    #content.a #numbers.vb:before{
                        content: "";
                        display: block;
                        position: absolute;
                        left: 0;
                        top: 0;
                        z-index: 1;
                        width: 100%;
                        height: 100%;
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #content.page-template.a article#featured, #featured{
                          background: -moz-linear-gradient(-45deg, #8ec64e 0%, #41aba0 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#8ec64e), color-stop(100%,#41aba0));
                        background: -webkit-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: -o-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: -ms-linear-gradient(-45deg, #8ec64e 0%,#41aba0 100%);
                        background: linear-gradient(135deg, #8ec64e 0%,#41aba0 100%);
                    }

                ';
            }
            elseif($color_scheme == 'magenta'){
                $styles .='
                    #contact input:focus, #contact select:focus, #contact textarea:focus,
                    #contact .semantic-select.focus .input, #contact .semantic-select.active .input,
                    input:focus, select:focus, textarea:focus, .semantic-select.focus .input, .semantic-select.active .input,
                    .mc4wp-form .form-b input:focus
                    { border-color: #f1435e; }
                    
                    .comments-a .date, .counter > span span, .gallery-c ul li > div .link,
                    .heading-a h1 .small, .heading-a h2 .small, .heading-a h3 .small,.nav-a h1 em,
                    .nav-a h2 em, .nav-a h3 em, .nav-a h4 em, .nav-a > ul, .nav-a.widget_nav_menu div > ul,
                    .nav-a > ul li p.link-a, .nav-a.widget_nav_menu div > ul li p.link-a,
                    .nav-a > ul li p.link-a a, .nav-a.widget_nav_menu div > ul li p.link-a a,
                    .nav-a > ul li p.link-a em, .nav-a > ul li p.link-a i, .nav-a.widget_nav_menu div > ul li p.link-a em,
                    .nav-a.widget_nav_menu div > ul li p.link-a i, .nav-a > ul li a span.scheme-a,
                    .nav-a.widget_nav_menu div > ul li a span.scheme-a, .nav-a > ul li a:hover span, .nav-a > ul li.active a span ,
                    .nav-a.widget_nav_menu div > ul li a:hover span, .nav-a.widget_nav_menu div > ul li.active a span,
                    #root .nav-a > ul.sub-menu li a:hover, #root .nav-a.widget_nav_menu > ul.sub-menu li.active a, #root .nav-a div > ul.sub-menu li a:hover,
                    #root .nav-a div > ul.sub-menu li.active a, .nav-a > ul.sub-menu li i:before, .nav-a.widget_nav_menu div > ul.sub-menu li i:before,
                    .nav-a b, #root .widget_recent_comments > ul li a:hover, #root .widget_recent_comments > ul li.active a,
                    .nav-a.aside-cal h1 + h2, .nav-a.aside-cal h2 + h3, .nav-a.aside-cal h3 + h4, .nav-a.aside-cal h4 + h5,
                    #root .nav-a.aside-cal ul li a:hover, #root .nav-a.aside-cal ul li.active a, .news-a header ul li a:hover,
                    .news-a header ul li i, .news-a header ul li i:before, .news-b article header p span, ins, mark, .scheme-a, a,
                    .list-a li i, #root .search-a button, .is-sticky, aside .widget_calendar caption, aside .widget_calendar thead th,
                    .nav-a.widget_nav_menu ul li ul.sub-menu li  a:hover, .nav-a.widget_categories ul li ul.children li  a:hover,
                    #clone nav > ul > li.active > a, #clone nav > ul > li:hover > a, #clone nav > ul > li > a:hover
                    { color: #f1435e; }
                    
                    .counter > span span:before, .gallery-a li a:before, .gallery-a li.plain a .date:before,
                    .gallery-b li:before, .gallery-c ul li:before, .gallery-b.b > li > div:before,
                    #root .gallery-b li > .fit-a:before, #root .gallery-b li > .fit-a:after,
                    .gallery-c .bx-pager .bx-pager-item a.active, .news-d .bx-pager-item a.active,
                    .gallery-a .bx-pager-item a.active, .gallery-b .bx-pager-item a.active,.heading-a h1:before,
                    .heading-a h2:before, .heading-a h3:before, .nav-a > ul li a:hover, .nav-a > ul li.active a,
                    .nav-a div.widget_nav_menu > ul li a:hover, .nav-a.widget_nav_menu div > ul li.active a,
                    news-b article h1:before, .news-b article h2:before, .news-b article h3:before, .news-b article h5:before,
                    #content.page-template.a .news-c article, .news-d article h1:before, .news-d article h2:before, .news-d article h3:before,
                    .news-d article h4:before, .news-d article h5:before, .news-d article h6:before, .news-e header figure:before,
                    .news-e h1:before, .news-e h2:before, .news-e h3:before, .pagination-a li a:hover, .pagination-a li .current,.slider-ba,
                    .link-a a:hover, .list-a li a:hover i, .list-b li .no, .list-c  li  span span, .list-c  li  a:hover,
                    button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, #root .semantic-select ul li a:hover,
                    #root .semantic-select ul li.active a, .fancybox-title-over-wrap, #fancybox-thumbs ul li a, #contact .wpcf7-submit:hover,
                    #featured, #root #clone nav > ul > li.sub:hover > a, #clone nav > ul > li.a > a, #clone nav > ul > li > ul
                    {background:  #f1435e; }
                    
                    #clone nav > ul > li:hover.a > a{color: #fff;}
                    
                    #fancybox-buttons ul { border: 1px solid #f1435e; }
                    #fancybox-buttons a.btnToggle, #fancybox-buttons a.btnClose { border-left: 1px solid #f1435e; }
                    
                    ::selection { background: #f1435e; }
                    ::-moz-selection { background: #f1435e;}
                    
                    .download-a li a:hover, .social-a li a:hover, .nav-a.widget_nav_menu ul li a:hover,
                    .nav-a.widget_nav_menu ul li.active a,.nav-a.widget_nav_menu div > ul li a:hover span.scheme-a,
                    .nav-a.widget_nav_menu div > ul li.active a span.scheme-a,#root .widget_tag_cloud > div a:hover
                    { background-color: #f1435e; }
                    
                    #root .gallery-b li > .fit-a {border: 1px solid #f1435e;}
                    
                    .pagination-a li a, .pagination-a li span { border: 1px solid #f1435e; color: #f1435e;}
                    
                    .link-a a {border: 1px solid #f1435e; color: #f1435e;}
                    .link-a.a a { border: 2px solid #f1435e; }
                    .list-c  li  a {border: 2px solid #f1435e; color: #f1435e;}
                    button, input[type="button"], input[type="reset"], input[type="submit"] { border: 1px solid #f1435e;color: #f1435e;}
                    .semantic-select ul {border: 1px solid #f1435e;}
                    
                    #contact .wpcf7-submit {
                        border: 1px solid #f1435e;
                        color: #f1435e;
                    }
                    
                    #top > .fit-a:before, #top > .fit-a:after, #clone > .fit-a:before, #clone > .fit-a:after {
                        border-bottom: 3px solid #f1435e;
                    }
                    
                    #top > .fit-a:before, #clone > .fit-a:before {
                        border-top: 3px solid #f1435e;
                    }
                    
                    #top.active > .fit-a:after, #clone.active > .fit-a:after,
                    #top.active > .fit-a:before, #clone.active > .fit-a:before{
                        background: #f1435e;
                    }
                    
                    @media only screen and (max-width: 47.5em) {
                        #root #nav > ul > li > ul li a:hover, #root #nav > ul > li > ul li.active { color: #f1435e; }
                    }
                    #content.page-template.a article#welcome{
                        background: -moz-linear-gradient(-45deg, #f1435e 0%, #f1435e 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f1435e), color-stop(100%,#f1435e));
                        background: -webkit-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: -o-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: -ms-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: linear-gradient(135deg, #f1435e 0%,#f1435e 100%);
                        background-image: url('.get_template_directory_uri().'/images/pattern.jpg);                }
                    
                    
                    #services{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #about.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    
                    #features{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #testimonials.vb{
                        background: -moz-linear-gradient(-45deg, #f1435e 0%, #f1435e 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f1435e), color-stop(100%,#f1435e));
                        background: -webkit-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: -o-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: -ms-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: linear-gradient(135deg, #f1435e 0%,#f1435e 100%);
                        background-image: url('.get_template_directory_uri().'/images/pattern.jpg);        }
                    
                    
                    #carousel3d{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #zoom.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    #content.a #video_bg.vid{
                        background: -moz-linear-gradient(-45deg, #523035 0%, #523035 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#523035), color-stop(100%,#523035));
                        background: -webkit-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: -o-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: -ms-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: linear-gradient(135deg, #523035 0%,#523035 100%);
                    }
                    
                    
                    
                    #blog{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #newsletter.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    #content.a #twitter.vb{
                    
                        background: -moz-linear-gradient(-45deg, #f1435e 0%, #f1435e 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f1435e), color-stop(100%,#f1435e));
                        background: -webkit-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: -o-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: -ms-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: linear-gradient(135deg, #f1435e 0%,#f1435e 100%);
                        background-image: url('.get_template_directory_uri().'/images/pattern.jpg);            }
                    
                    
                    #content.a #pricing.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    #content.a #numbers.vb{
                    
                        background: -moz-linear-gradient(-45deg, #f1435e 0%, #f1435e 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f1435e), color-stop(100%,#f1435e));
                        background: -webkit-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: -o-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: -ms-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: linear-gradient(135deg, #f1435e 0%,#f1435e 100%);
                        background-image: url('.get_template_directory_uri().'/images/pattern.jpg);            }
                    

                    #content.page-template.a article#featured, #featured{
                        background: -moz-linear-gradient(-45deg, #f1435e 0%, #f1435e 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f1435e), color-stop(100%,#f1435e));
                        background: -webkit-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: -o-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: -ms-linear-gradient(-45deg, #f1435e 0%,#f1435e 100%);
                        background: linear-gradient(135deg, #f1435e 0%,#f1435e 100%);
                        background-image: url('.get_template_directory_uri().'/images/pattern.jpg); 
                    }
                ';
            }
            elseif($color_scheme == 'red'){
                $styles .= '
                    #contact input:focus, #contact select:focus, #contact textarea:focus,
                    #contact .semantic-select.focus .input, #contact .semantic-select.active .input,
                    input:focus, select:focus, textarea:focus, .semantic-select.focus .input, .semantic-select.active .input,
                    .mc4wp-form .form-b input:focus
                    { border-color: #f43c43; }
                    
                    .comments-a .date, .counter > span span, .gallery-c ul li > div .link,
                    .heading-a h1 .small, .heading-a h2 .small, .heading-a h3 .small,.nav-a h1 em,
                    .nav-a h2 em, .nav-a h3 em, .nav-a h4 em, .nav-a > ul, .nav-a.widget_nav_menu div > ul,
                    .nav-a > ul li p.link-a, .nav-a.widget_nav_menu div > ul li p.link-a,
                    .nav-a > ul li p.link-a a, .nav-a.widget_nav_menu div > ul li p.link-a a,
                    .nav-a > ul li p.link-a em, .nav-a > ul li p.link-a i, .nav-a.widget_nav_menu div > ul li p.link-a em,
                    .nav-a.widget_nav_menu div > ul li p.link-a i, .nav-a > ul li a span.scheme-a,
                    .nav-a.widget_nav_menu div > ul li a span.scheme-a, .nav-a > ul li a:hover span, .nav-a > ul li.active a span ,
                    .nav-a.widget_nav_menu div > ul li a:hover span, .nav-a.widget_nav_menu div > ul li.active a span,
                    #root .nav-a > ul.sub-menu li a:hover, #root .nav-a.widget_nav_menu > ul.sub-menu li.active a, #root .nav-a div > ul.sub-menu li a:hover,
                    #root .nav-a div > ul.sub-menu li.active a, .nav-a > ul.sub-menu li i:before, .nav-a.widget_nav_menu div > ul.sub-menu li i:before,
                    .nav-a b, #root .widget_recent_comments > ul li a:hover, #root .widget_recent_comments > ul li.active a,
                    .nav-a.aside-cal h1 + h2, .nav-a.aside-cal h2 + h3, .nav-a.aside-cal h3 + h4, .nav-a.aside-cal h4 + h5,
                    #root .nav-a.aside-cal ul li a:hover, #root .nav-a.aside-cal ul li.active a, .news-a header ul li a:hover,
                    .news-a header ul li i, .news-a header ul li i:before, .news-b article header p span, ins, mark, .scheme-a, a,
                    .list-a li i, #root .search-a button, .is-sticky, aside .widget_calendar caption, aside .widget_calendar thead th,
                    .nav-a.widget_nav_menu ul li ul.sub-menu li  a:hover, .nav-a.widget_categories ul li ul.children li  a:hover,
                    #clone nav > ul > li.active > a, #clone nav > ul > li:hover > a, #clone nav > ul > li > a:hover
                    { color: #f43c43; }
                    
                    .counter > span span:before, .gallery-a li a:before, .gallery-a li.plain a .date:before,
                    .gallery-b li:before, .gallery-c ul li:before, .gallery-b.b > li > div:before,
                    #root .gallery-b li > .fit-a:before, #root .gallery-b li > .fit-a:after,
                    .gallery-c .bx-pager .bx-pager-item a.active, .news-d .bx-pager-item a.active,
                    .gallery-a .bx-pager-item a.active, .gallery-b .bx-pager-item a.active,.heading-a h1:before,
                    .heading-a h2:before, .heading-a h3:before, .nav-a > ul li a:hover, .nav-a > ul li.active a,
                    .nav-a div.widget_nav_menu > ul li a:hover, .nav-a.widget_nav_menu div > ul li.active a,
                    news-b article h1:before, .news-b article h2:before, .news-b article h3:before, .news-b article h5:before,
                    #content.page-template.a .news-c article, .news-d article h1:before, .news-d article h2:before, .news-d article h3:before,
                    .news-d article h4:before, .news-d article h5:before, .news-d article h6:before, .news-e header figure:before,
                    .news-e h1:before, .news-e h2:before, .news-e h3:before, .pagination-a li a:hover, .pagination-a li .current,.slider-ba,
                    .link-a a:hover, .list-a li a:hover i, .list-b li .no, .list-c  li  span span, .list-c  li  a:hover,
                    button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, #root .semantic-select ul li a:hover,
                    #root .semantic-select ul li.active a, .fancybox-title-over-wrap, #fancybox-thumbs ul li a, #contact .wpcf7-submit:hover,
                    #featured, #root #clone nav > ul > li.sub:hover > a, #clone nav > ul > li.a > a, #clone nav > ul > li > ul
                    {background:  #f43c43; }
                    
                    #clone nav > ul > li:hover.a > a{color: #fff;}
                    
                    #fancybox-buttons ul { border: 1px solid #f43c43; }
                    #fancybox-buttons a.btnToggle, #fancybox-buttons a.btnClose { border-left: 1px solid #f43c43; }
                    
                    ::selection { background: #f43c43; }
                    ::-moz-selection { background: #f43c43;}
                    
                    .download-a li a:hover, .social-a li a:hover, .nav-a.widget_nav_menu ul li a:hover,
                    .nav-a.widget_nav_menu ul li.active a,.nav-a.widget_nav_menu div > ul li a:hover span.scheme-a,
                    .nav-a.widget_nav_menu div > ul li.active a span.scheme-a,#root .widget_tag_cloud > div a:hover
                    { background-color: #f43c43; }
                    
                    #root .gallery-b li > .fit-a {border: 1px solid #f43c43;}
                    
                    .pagination-a li a, .pagination-a li span { border: 1px solid #f43c43; color: #f43c43;}
                    
                    .link-a a {border: 1px solid #f43c43; color: #f43c43;}
                    .link-a.a a { border: 2px solid #f43c43; }
                    .list-c  li  a {border: 2px solid #f43c43; color: #f43c43;}
                    button, input[type="button"], input[type="reset"], input[type="submit"] { border: 1px solid #f43c43;color: #f43c43;}
                    .semantic-select ul {border: 1px solid #f43c43;}
                    
                    #contact .wpcf7-submit {
                        border: 1px solid #f43c43;
                        color: #f43c43;
                    }
                    
                    #top > .fit-a:before, #top > .fit-a:after, #clone > .fit-a:before, #clone > .fit-a:after {
                        border-bottom: 3px solid #f43c43;
                    }
                    
                    #top > .fit-a:before, #clone > .fit-a:before {
                        border-top: 3px solid #f43c43;
                    }
                    
                    #top.active > .fit-a:after, #clone.active > .fit-a:after,
                    #top.active > .fit-a:before, #clone.active > .fit-a:before{
                        background: #f43c43;
                    }
                    
                    @media only screen and (max-width: 47.5em) {
                        #root #nav > ul > li > ul li a:hover, #root #nav > ul > li > ul li.active { color: #f43c43; }
                    }
                    
                    #content.page-template.a article#welcome{
                        background: -moz-linear-gradient(-45deg, #fe2d58 0%, #ff5132 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#fe2d58), color-stop(100%,#ff5132));
                        background: -webkit-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: -o-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: -ms-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: linear-gradient(135deg, #fe2d58 0%,#ff5132 100%);
                    }
                    
                    #content.page-template.a article#welcome:before{
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #services{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    .members{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #about.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    
                    #features{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #testimonials.vb{
                        background: -moz-linear-gradient(-45deg, #fe2d58 0%, #ff5132 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#fe2d58), color-stop(100%,#ff5132));
                        background: -webkit-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: -o-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: -ms-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: linear-gradient(135deg, #fe2d58 0%,#ff5132 100%);
                    }
                    
                    #content.a #testimonials.vb:before{
                        content: "";
                        display: block;
                        position: absolute;
                        left: 0;
                        top: 0;
                        z-index: 1;
                        width: 100%;
                        height: 100%;
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #carousel3d{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #zoom.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    #content.a #video_bg.vid{
                        background: -moz-linear-gradient(-45deg, #523035 0%, #523035 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#523035), color-stop(100%,#523035));
                        background: -webkit-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: -o-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: -ms-linear-gradient(-45deg, #523035 0%,#523035 100%);
                        background: linear-gradient(135deg, #523035 0%,#523035 100%);
                    }
                    
                    
                    
                    #blog{
                        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(100%,#ffffff));
                        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 100%);
                        background: linear-gradient(135deg, #ffffff 0%,#ffffff 100%);
                    }
                    
                    
                    #content.a #newsletter.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    
                    #content.a #twitter.vb{
                    
                        background: -moz-linear-gradient(-45deg, #fe2d58 0%, #ff5132 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#fe2d58), color-stop(100%,#ff5132));
                        background: -webkit-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: -o-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: -ms-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: linear-gradient(135deg, #fe2d58 0%,#ff5132 100%);
                    }
                    
                    #content.a #twitter.vb:before{
                        content: "";
                        display: block;
                        position: absolute;
                        left: 0;
                        top: 0;
                        z-index: 1;
                        width: 100%;
                        height: 100%;
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }
                    
                    #content.a #pricing.va{
                        background: -moz-linear-gradient(-45deg, #f4f4f4 0%, #f4f4f4 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#f4f4f4), color-stop(100%,#f4f4f4));
                        background: -webkit-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -o-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: -ms-linear-gradient(-45deg, #f4f4f4 0%,#f4f4f4 100%);
                        background: linear-gradient(135deg, #f4f4f4 0%,#f4f4f4 100%);
                    }
                    
                    #content.a #numbers.vb{
                    
                        background: -moz-linear-gradient(-45deg, #fe2d58 0%, #ff5132 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#fe2d58), color-stop(100%,#ff5132));
                        background: -webkit-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: -o-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: -ms-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: linear-gradient(135deg, #fe2d58 0%,#ff5132 100%);
                    }
                    
                    #content.a #numbers.vb:before{
                        content: "";
                        display: block;
                        position: absolute;
                        left: 0;
                        top: 0;
                        z-index: 1;
                        width: 100%;
                        height: 100%;
                        background: url('.get_template_directory_uri().'/images/pattern.png);
                    }

                    #content.page-template.a article#featured, #featured{
                        background: -moz-linear-gradient(-45deg, #fe2d58 0%, #ff5132 100%);
                        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#fe2d58), color-stop(100%,#ff5132));
                        background: -webkit-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: -o-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: -ms-linear-gradient(-45deg, #fe2d58 0%,#ff5132 100%);
                        background: linear-gradient(135deg, #fe2d58 0%,#ff5132 100%);
                    }
                ';
            }
        }


        //menut text color
        if(!empty($menu_text_color))
            $styles .='
                #nav > ul > li.current-menu-item > a, #nav > ul > li > a,
                #nav > ul > li > a:hover, #nav > ul > li.active > a, #nav > ul > li:hover > a
                { color: '.$menu_text_color.'; }
                #nav > ul > li > ul li a{
                  color: '.$menu_text_color.';
                }
            ';

        if(!empty($menu_bg))
        {
            $styles .='
                #nav > ul > li > a:hover, #nav > ul > li.active > a, #nav > ul > li:hover > a,
                #nav > ul > li > ul
                {background: '.$menu_bg.';}
            ';
        }

        //sticky menu bg color
        if(!empty($menu_sticky_bg))
            $styles .='
                #clone {background: '.$menu_sticky_bg.'}
            ';

        //sticky menu text color
        if(!empty($menu_sticky_text))
            $styles .='
                #clone nav > ul > li > a, #root #clone nav > ul > li.sub:hover > a,
                #clone nav > ul > li:hover > a, #clone nav > ul > li > a:hover,
                #clone nav > ul > li > ul li a, #clone nav > ul > li > ul > li > ul a,
                #clone nav > ul > li:hover.a > a, #clone nav > ul > li.a > a
                 {color: '.$menu_sticky_text.'}
            ';

        //output theme color styles


        echo $html;

        if(!empty($body) || !empty($headings) || !empty($styles))
            echo '<style type="text/css">
                    '.$body.'
                    '.$headings.'
                    '.$styles.'
                 </style>';
    }
    add_action('wp_head','fw_theme_change_style',99);
endif;


if (!function_exists('fw_theme_css_fonts')) :
    function fw_theme_css_fonts($settings,$selectors){
        $current_family = $settings['family'];

        $current_style = $settings['style'];

        $color = (!empty($settings['color'])) ? "color:".$settings['color'].' !important;' : '';

        if ( $current_style === 'regular' ) {
            $current_style = '400';
        }
        if ( $current_style == 'italic' ) {
            $current_style = '400italic';
        }

        $font_style  = ( strpos( $current_style, 'italic' ) ) ? 'font-style: italic !important;' : '';
        $font_weight = 'font-weight: ' . intval( $current_style ) . ' !important;';

        $css =  $selectors . "{
                        $color
                        font-family: '" . $current_family . "';"
            . $font_style . "" . $font_weight . "

                 }\n";

        return $css;
    }
endif;

if (!function_exists('fw_theme_translate')) :
    function fw_theme_translate($content){
        /**
         * Return the content for translations plugins
         * @param string $content
         */
        $content = html_entity_decode($content, ENT_QUOTES, 'UTF-8');

        if(function_exists('icl_object_id') && strpos($content,'wpml_translate') == true){
            $content = do_shortcode($content);
        }
        elseif(function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage')){
            $content = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($content);
        }

        return $content;
    }
endif;
