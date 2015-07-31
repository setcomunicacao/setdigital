<?php
get_header();
global $wp_query;

$ext_portfolio_instance = fw()->extensions->get( 'portfolio' );
$ext_portfolio_settings = $ext_portfolio_instance->get_settings();

$taxonomy        = $ext_portfolio_settings['taxonomy_name'];
$post_type        = $ext_portfolio_settings['post_type'];
$term            = get_term_by( 'slug', get_query_var( 'term' ), $taxonomy );
$term_id         = ( ! empty( $term->term_id ) ) ? $term->term_id : 0;
?>
<?php
    $header_image = fw_get_db_term_option($term_id, $taxonomy, 'header_portf_image', fw_get_db_settings_option('header_portf_image'));
    $header_color = fw_get_db_term_option($term_id, $taxonomy, 'header_portf_color', fw_get_db_settings_option('header_portf_color'));
    $header_pattern = fw_get_db_term_option($term_id, $taxonomy, 'header_portf_pattern', fw_get_db_settings_option('header_portf_pattern'));

    //show header image
    fw_show_header($header_image, $header_color, $header_pattern, $term->name);
?>

<article id="content">
    <header class="heading-a">
        <h3><span class="small"><?php echo $term->name; ?></span>
            <?php echo fw_theme_translate(fw_get_db_term_option($term_id, $taxonomy, 'portf-description', fw_get_db_settings_option('portf-description')));?>
        </h3>
        <p><?php echo fw_theme_translate(esc_html(fw_get_db_term_option($term_id, $taxonomy, 'portf-subtitle', fw_get_db_settings_option('portf-subtitle'))));?></p>
    </header>

    <ul class="gallery-a">

        <?php if ( have_posts() ) : ?>

            <?php
            // Start the Loop.
            while ( have_posts() ) : the_post();

                get_template_part( 'framework-customizations/extensions' . $ext_portfolio_instance->get_rel_path() . '/views/loop', 'item' ); //fixme hardcoded 'framework-customizations/extensions'

            endwhile;

        else :
            // If no content, include the "No posts found" template.
            get_template_part( 'content', 'none' );

        endif; ?>
    </ul>
    <?php fw_theme_paging_nav(); ?>
</article>
<?php get_footer();
