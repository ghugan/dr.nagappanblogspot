<?php
/**
 * Template for displaying posts in the Video Post Format
 *
 * @package Oblique
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="svg-container post-svg svg-block">
		<?php echo oblique_svg_3(); ?>
	</div>	

	<?php $video = get_post_meta( get_the_id(), '_oblique_pro_video_field_key', true ); ?>

	<?php if ( $video ) : ?>
		<div class="entry-video">
			<?php echo wp_oembed_get( $video ); ?>
		</div>	
	<?php endif; ?>	

	<div class="post-inner">
		<header class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

			<?php if ( 'post' == get_post_type() && ! get_theme_mod( 'meta_index' ) ) : ?>
			<div class="entry-meta">
				<?php oblique_posted_on(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_excerpt(); ?>

			<?php
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . __( 'Pages:', 'oblique' ),
						'after'  => '</div>',
					)
				);
			?>
		</div><!-- .entry-content -->
	</div>
	<?php if ( ! get_theme_mod( 'read_more' ) ) : ?>
		<a href="<?php the_permalink(); ?>">
			<div class="read-more">
				<?php echo __( 'Continue reading &hellip;', 'oblique' ); ?>
			</div>
		</a>
	<?php endif; ?>
	<div class="svg-container post-bottom-svg svg-block">
		<?php echo oblique_svg_1(); ?>
	</div>	
</article><!-- #post-## -->
