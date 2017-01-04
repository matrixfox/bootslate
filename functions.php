<?php
add_filter('excerpt_more', 'new_excerpt_more');
// Replaces the excerpt "Read More" text by a link
function new_excerpt_more($more)
{
global $post;
return ' <a class="moretag" href="'. get_permalink($post->ID) . '">Read more...</a>';
}
add_action( 'after_setup_theme', 'bootslate_setup' );
function bootslate_setup()
{
load_theme_textdomain( 'bootslate', get_template_directory() . '/languages' );
add_theme_support( 'title-tag' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
global $content_width;
if ( ! isset( $content_width ) ) $content_width = 640;
register_nav_menus(
array( 'main-menu' => __( 'Main Menu', 'bootslate' ) )
);
}
add_action( 'wp_enqueue_scripts', 'bootslate_load_scripts' );
function bootslate_load_scripts()
{
wp_enqueue_script( 'jquery' );
wp_enqueue_script( 'bootstrap-min', get_template_directory_uri() . '/javascripts/bootstrap.min.js', array(), null, true );
}
add_action( 'comment_form_before', 'bootslate_enqueue_comment_reply_script' );
function bootslate_enqueue_comment_reply_script()
{
if ( get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
}
add_filter( 'the_title', 'bootslate_title' );
function bootslate_title( $title ) {
if ( $title == '' ) {
return '&rarr;';
} else {
return $title;
}
}
add_filter( 'wp_title', 'bootslate_filter_wp_title' );
function bootslate_filter_wp_title( $title )
{
return $title . esc_attr( get_bloginfo( 'name' ) );
}
add_action( 'widgets_init', 'bootslate_widgets_init' );
function bootslate_widgets_init()
{
register_sidebar( array (
'name' => __( 'Sidebar Widget Area', 'bootslate' ),
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => "</li>",
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
function bootslate_custom_pings( $comment )
{
$GLOBALS['comment'] = $comment;
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php
}
add_filter( 'get_comments_number', 'bootslate_comments_number' );
function bootslate_comments_number( $count )
{
if ( !is_admin() ) {
global $id;
$comments_by_type = &separate_comments( get_comments( 'status=approve&post_id=' . $id ) );
return count( $comments_by_type['comment'] );
} else {
return $count;
}
}
