<?php
add_filter( 'the_content', 'kiyomizu_the_content_filter' );
function kiyomizu_the_content_filter( $content ) {
    if ( is_home() || is_archive() ){
        global $post;
        $length = 110;
        $content = mb_substr( strip_tags( $post -> post_content ), 0, $length );
        $content = $content . "...";
    }
    return $content;
}

add_action('twentyfifteen_credits', 'kiyomizu_declare_copyright');
function kiyomizu_declare_copyright(){
    $theme_link = esc_url( __( 'http://hideokamoto.github.io/wp-theme-kiyomizu', 'kiyomizu' ) );
    $theme_attr = esc_attr(__( 'This theme was made by', 'kiyomizu' ));
    $author = __("Hidetaka Okamoto", 'kiyomizu' );
    $credit = "<a href='{$theme_link}' title='{$theme_attr}'>{$author}</a><br/>";
    printf(__( 'Theme: %1$s by %2$s', 'kiyomizu' ), 'Kiyomizu', $credit);
}