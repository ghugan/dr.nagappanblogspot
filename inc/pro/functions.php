<?php
/**
 * Oblique Pro functions
 *
 * @package Oblique
 */

/**
 * Extra widget area
 */
function oblique_pro_extra_widget_area() {
	// Below header widget area
	if ( get_theme_mod( 'activate_bh_widgets' ) ) {
		register_sidebar(
			array(
				'name'          => __( 'Below header area', 'oblique' ),
				'id'            => 'header-sidebar',
				'description'   => '',
				'before_widget' => '<aside id="%1$s" class="col-sm-12 col-md-4 widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}
}
add_action( 'widgets_init', 'oblique_pro_extra_widget_area' );

/**
 * Extra widget area
 */
function oblique_pro_extra_widget_area_output() {

	if ( is_active_sidebar( 'header-sidebar' ) && get_theme_mod( 'activate_bh_widgets' ) ) { ?>
	<div class="svg-container svg-block bh-widgets-svg">
		<?php oblique_svg_1(); ?>
	</div>
	<div id="header-widgets" class="header-widgets">
			<?php dynamic_sidebar( 'header-sidebar' ); ?>
	</div>
	<div class="svg-container svg-block bh-widgets-svg">
			<?php echo oblique_svg_3(); ?>
	</div>          
	<?php
	}
}

/**
 * Footer menu
 */
function oblique_pro_register_footer_menu() {
	register_nav_menus(
		array(
			'footer' => __( 'Footer Menu', 'oblique' ),
		)
	);
}
add_action( 'after_setup_theme', 'oblique_pro_register_footer_menu' );

/**
 * Footer menu
 */
function oblique_pro_footer_menu() {
?>
	<nav id="footernav" class="footer-navigation col-md-6 col-xs-12" role="navigation">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'footer',
				'depth'          => '1',
				'menu_id'        => 'footer-menu',
			)
		);
		?>
	</nav><!-- #site-navigation -->
<?php
}
add_action( 'oblique_footer', 'oblique_pro_footer_menu' );

/**
 * Slider shortcode support
 */
function oblique_pro_slider() {

	$show_slider = get_theme_mod( 'show_slider', '0' );

	if ( ! $show_slider ) {
		return;
	}

	$shortcode = get_theme_mod( 'slider_shortcode' );

	echo do_shortcode( $shortcode );
}

/**
 * Masonry alt layout
 */
function oblique_pro_body_classes( $classes ) {

	$alt_layout = get_theme_mod( 'oblique_alt_layout', 0 );

	if ( $alt_layout ) {
		$classes[] = 'masonry-2cols';
	}

	return $classes;
}
add_filter( 'body_class', 'oblique_pro_body_classes' );
