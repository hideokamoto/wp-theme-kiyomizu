<?php

//init
kiyomizu_widget_settings();

//hooks
add_filter( 'the_content'         , 'kiyomizu_the_content_filter' );
add_action('twentyfifteen_credits', 'kiyomizu_declare_copyright');
add_action( 'after_setup_theme'   , 'kiyomizu_i18n' );
add_action( 'wp_enqueue_scripts'  , 'kiyomizu_theme_enqueue_styles' );


function kiyomizu_i18n(){
  $theme_uri = get_stylesheet_directory(). "/languages";
  load_child_theme_textdomain( 'kiyomizu', $theme_uri );
}

function kiyomizu_the_content_filter( $content ) {
    if ( is_home() || is_archive() ){
        $content = kiyomizu_make_excerpt($content);
    } elseif(is_page() || is_single()){
        if(is_dynamic_sidebar('Kiyomizu Content Widget')){
          echo "<ul class='kiyomizu-content-top-widget'>";
          dynamic_sidebar('Kiyomizu Content Widget');
          echo "</ul>";
        }
    }
    return $content;
}

function kiyomizu_make_excerpt($content){
    global $post;
    $length = 110;
    $content = mb_substr( strip_tags( $post -> post_content ), 0, $length );
    $content = $content . "...";
    return $content;
}

function kiyomizu_declare_copyright(){
    $theme_link = esc_url( __( 'http://hideokamoto.github.io/wp-theme-kiyomizu', 'kiyomizu' ) );
    $theme_attr = esc_attr(__( 'This theme was made by', 'kiyomizu' ));
    $author = __("Hidetaka Okamoto", 'kiyomizu' );
    $credit = "<a href='{$theme_link}' title='{$theme_attr}'>{$author}</a><br/>";
    printf(__( 'Theme: %1$s by %2$s', 'kiyomizu' ), 'kiyomizu', $credit);
}

function kiyomizu_widget_settings(){
    register_sidebar(array(
	      'name' => __('Kiyomizu Content Widget', 'kiyomizu'),
	      'id'   => 'Kiyomizu-content_widget'
      )
    );
}

function kiyomizu_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}
