<?php
//init
kiyomizu_widget_settings();

//hooks
add_filter( 'the_content', 'kiyomizu_the_content_filter' );
add_action( 'twentyfifteen_credits', 'kiyomizu_declare_copyright' );
add_action( 'after_setup_theme'   , 'kiyomizu_i18n' );
add_action( 'wp_enqueue_scripts'  , 'kiyomizu_theme_enqueues' );
add_action( 'admin_init', 'kiyomizu_check_rest_api' );

function kiyomizu_i18n() {
	$theme_uri = get_stylesheet_directory(). '/languages';
	load_child_theme_textdomain( 'kiyomizu', $theme_uri );
}

function kiyomizu_check_rest_api() {
	if( ! is_plugin_active( 'rest-api/plugin.php' ) ) {
		$message = __( 'Kiyomizu Theme need WP REST API(Version2) Plugin.' , 'kiyomizu' );
		$html  = "<div class='notice updated'><ul>";
		$html .= "<li>{$message}</li>";
		$html .= '</ul></div>';
		echo $html;
	}
}

function kiyomizu_the_content_filter( $content ) {
	if ( is_home() || is_archive() ) {
		$content = kiyomizu_make_excerpt( $content );
	} elseif ( is_page() || is_single() ) {
		if ( is_dynamic_sidebar( 'Kiyomizu Content Widget' ) ) {
			echo "<ul class='kiyomizu-content-top-widget'>";
			dynamic_sidebar( 'Kiyomizu Content Widget' );
			echo '</ul>';
		}
		$content .= kiyomizu_related_post();
	}
	return $content;
}

function kiyomizu_related_post() {
	$content  = '';
	$data = kiyomizu_get_api_data();
	$content .= "<div class='kiyumizu-related-post-row'>";
	$content .= "<h2 class='entry-title'>". __( 'Similar Category Post' , 'kiyomizu' ) . '</h2>';
	$content .= "<div id='kiyomizu-related-post' {$data}></div>";
	$content .= '</div>';
	return $content;
}

function kiyomizu_get_api_data() {
	$category = get_the_category( get_the_ID() );
	$query  = '?filter[category_name]=' . $category[0]->slug;
	$query .= '&filter[posts_per_page]=5';

	$api_url = home_url( '/' ). 'wp-json/wp/v2/posts' . $query ;
	$api_url = apply_filters( 'rest-widgets-postlist-query' , $api_url );
	$api_url = esc_url( $api_url );
	$fail_text = __( 'Fail to get POST Data.', 'kiyomizu' );
	$data = "data-postlist-url='{$api_url}' data-fail-text='{$fail_text}'";
	return $data;
}

function kiyomizu_make_excerpt( $content ) {
	global $post;
	$length = 110;
	$content = mb_substr( strip_tags( $post -> post_content ), 0, $length );
	$content = $content . '...';
	return $content;
}

function kiyomizu_declare_copyright() {
	$theme_link = esc_url( __( 'http://hideokamoto.github.io/wp-theme-kiyomizu', 'kiyomizu' ) );
	$theme_attr = esc_attr( __( 'This theme was made by', 'kiyomizu' ) );
	$author = __( 'Hidetaka Okamoto', 'kiyomizu' );
	$credit = "<a href='{$theme_link}' title='{$theme_attr}'>{$author}</a><br/>";
	printf( __( 'Theme: %1$s by %2$s', 'kiyomizu' ), 'kiyomizu', $credit );
}

function kiyomizu_widget_settings() {
	register_sidebar(array(
		'name' => __( 'Kiyomizu Content Widget', 'kiyomizu' ),
		'id'   => 'Kiyomizu-content_widget',
		)
	);
}

function kiyomizu_theme_enqueues() {
	wp_enqueue_script( 'kiyomizu-scripts', get_stylesheet_directory_uri() .'/app.js' , array(), '20160130', true );
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
