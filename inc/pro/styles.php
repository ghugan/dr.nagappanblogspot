<?php
/**
 * Styles
 *
 * @package Oblique
 */

/**
 * Dynamic styles
 *
 * @param $custom
 */
function oblique_pro_custom_styles( $custom ) {

	$custom = '';

	// Below header widget area
	$center_bh_widgets = get_theme_mod( 'center_bh_widgets', '0' );
	if ( $center_bh_widgets ) {
		$custom .= '.header-widgets {text-align: center;}' . "\n";
	}
	$bg_bh_widgets    = get_theme_mod( 'bg_bh_widgets', '#ffffff' );
	$custom          .= '.header-widgets {background-color:' . esc_attr( $bg_bh_widgets ) . ';}' . "\n";
	$custom          .= '.bh-widgets-svg svg {fill:' . esc_attr( $bg_bh_widgets ) . ';}' . "\n";
	$color_bh_widgets = get_theme_mod( 'color_bh_widgets', '#50545C' );
	$custom          .= '.header-widgets, .header-widgets a, .header-widgets .widget-title {color:' . esc_attr( $color_bh_widgets ) . ';}' . "\n";

	// Slider
	$show_slider = get_theme_mod( 'show_slider', '0' );
	if ( $show_slider ) {
		$custom .= '.site-header {background-image: none !important;}' . "\n";
	}

	// Single options
	global $post;
	$single_body_background = get_post_meta( get_the_ID(), '_oblique_pro_body_background_key', true );
	$single_post_background = get_post_meta( get_the_ID(), '_oblique_pro_post_background_key', true );
	$single_text_color      = get_post_meta( get_the_ID(), '_oblique_pro_text_color_key', true );

	if ( is_single() ) {
		$custom .= '.postid-' . $post->ID . ' .hentry { background-color:' . esc_attr( $single_post_background ) . ' ;}' . "\n";
		$custom .= '.postid-' . $post->ID . ' .single-post-svg { fill:' . esc_attr( $single_post_background ) . ' !important;}' . "\n";
		$custom .= '.postid-' . $post->ID . ' .hentry { color:' . esc_attr( $single_text_color ) . ' ;}' . "\n";
	} elseif ( is_page() ) {
		$custom .= '.page-id-' . $post->ID . ' .hentry { background-color:' . esc_attr( $single_post_background ) . ' ;}' . "\n";
		$custom .= '.page-id-' . $post->ID . ' .single-post-svg { fill:' . esc_attr( $single_post_background ) . ' !important;}' . "\n";
		$custom .= '.page-id-' . $post->ID . ' .hentry { color:' . esc_attr( $single_text_color ) . ' ;}' . "\n";
	}
	if ( is_single() && $single_body_background ) {
		$custom .= '.postid-' . $post->ID . ' { background-color:' . esc_attr( $single_body_background ) . ' !important; background-image: none !important;}' . "\n";
		$custom .= '.postid-' . $post->ID . ' .header-svg.svg-block {fill:' . esc_attr( $single_body_background ) . ' !important; background-image: none !important;}' . "\n";
		$custom .= '.postid-' . $post->ID . ' .nav-svg {fill:' . esc_attr( $single_body_background ) . ' !important; background-image: none !important;}' . "\n";
	} elseif ( is_page() && $single_body_background ) {
		$custom .= '.page-id-' . $post->ID . ' { background-color:' . esc_attr( $single_body_background ) . ' !important; background-image: none !important;}' . "\n";
		$custom .= '.page-id-' . $post->ID . ' .header-svg.svg-block {fill:' . esc_attr( $single_body_background ) . ' !important; background-image: none !important;}' . "\n";
		$custom .= '.page-id-' . $post->ID . ' .nav-svg {fill:' . esc_attr( $single_body_background ) . ' !important; background-image: none !important;}' . "\n";
	}

	// Typography
	$body_font_weight        = get_theme_mod( 'body_font_weight', '400' );
	$headings_font_weight    = get_theme_mod( 'headings_font_weight', '500' );
	$custom                 .= 'body {font-weight:' . intval( $body_font_weight ) . ';}' . "\n";
	$custom                 .= 'h1,h2,h3,h4,h5,h6 {font-weight:' . intval( $headings_font_weight ) . ';}' . "\n";
	$body_line_height        = get_theme_mod( 'body_line_height', '1.55' );
	$headings_line_height    = get_theme_mod( 'headings_line_height', '1.1' );
	$custom                 .= 'body {line-height:' . esc_attr( $body_line_height ) . ';}' . "\n";
	$custom                 .= 'h1,h2,h3,h4,h5,h6 {line-height:' . esc_attr( $headings_line_height ) . ';}' . "\n";
	$body_letter_spacing     = get_theme_mod( 'body_letter_spacing', '0' );
	$headings_letter_spacing = get_theme_mod( 'headings_letter_spacing', '0' );
	$custom                 .= 'body {letter-spacing:' . esc_attr( $body_letter_spacing ) . 'px;}' . "\n";
	$custom                 .= 'h1,h2,h3,h4,h5,h6 {letter-spacing:' . esc_attr( $headings_letter_spacing ) . 'px;}' . "\n";

	// Extra colors
	$social_icons_color = get_theme_mod( 'social_icons_color', '#ffffff' );
	if ( ! empty( $social_icons_color ) ) {
		$custom .= '.social-navigation li a {color: ' . esc_attr( $social_icons_color ) . ' ;}';
	}
	$social_icons_hover = get_theme_mod( 'social_icons_hover', '#23b6b6' );
	if ( ! empty( $social_icons_hover ) ) {
		$custom .= '.social-navigation li a:hover {color: ' . esc_attr( $social_icons_hover ) . ' ;}';
	}
	$widget_bg = get_theme_mod( 'widgets_background', '#17191B' );
	if ( ! empty( $widget_bg ) ) {
		$custom .= '#secondary .widget {background-color: ' . esc_attr( $widget_bg ) . ' ;}';
	}
	$widget_color = get_theme_mod( 'widgets_color', '#ffffff' );
	if ( ! empty( $widget_color ) ) {
		$custom .= '#secondary .widget, #secondary .widget ul li a {color: ' . esc_attr( $widget_color ) . ' ;}';
	}
	$footer_menu = get_theme_mod( 'footer_menu_color', '#8b8b8b' );
	if ( ! empty( $footer_menu ) ) {
		$custom .= '.footer-navigation li a {color: ' . esc_attr( $footer_menu ) . ' ;}';
	}
	$footer_menu_hover = get_theme_mod( 'footer_menu_hover', '#9FA7AF' );
	if ( ! empty( $footer_menu_hover ) ) {
		$custom .= '.footer-navigation li a:hover {color: ' . esc_attr( $footer_menu_hover ) . ' ;}';
	}
	$entry_title_color = get_theme_mod( 'entry_title_color', '#2B2D3A' );
	if ( ! empty( $entry_title_color ) ) {
		$custom .= '.entry-title a {color: ' . esc_attr( $entry_title_color ) . ' ;}';
	}
	$entry_title_hover = get_theme_mod( 'entry_title_hover', '#23b6b6' );
	if ( ! empty( $entry_title_hover ) ) {
		$custom .= '.entry-title a:hover {color: ' . esc_attr( $entry_title_hover ) . ' ;}';
	}

	// Output all the styles
	wp_add_inline_style( 'oblique-style', $custom );
}
add_action( 'wp_enqueue_scripts', 'oblique_pro_custom_styles' );
