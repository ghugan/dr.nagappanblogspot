<?php
/**
 * Single post colors metabox
 *
 * @package Oblique
 */

/**
 * Single metabox init.
 */
function oblique_pro_single_mb_init() {
	new Oblique_Pro_Single_Metabox();
}

if ( is_admin() ) {
	add_action( 'load-post.php', 'oblique_pro_single_mb_init' );
	add_action( 'load-post-new.php', 'oblique_pro_single_mb_init' );
}

/**
 * Class Oblique_Pro_Single_Metabox
 */
class Oblique_Pro_Single_Metabox {

	/**
	 * Oblique_Pro_Single_Metabox constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

	/**
	 * Add metabox.
	 *
	 * @param $post_type
	 */
	public function add_meta_box( $post_type ) {
		$post_types = array( 'post', 'page' );
		if ( in_array( $post_type, $post_types ) ) {
			add_meta_box(
				'oblique_pro_single_metabox', __( 'Oblique Pro settings', 'oblique' ), array( $this, 'render_meta_box_content' ), $post_type, 'normal', 'low'
			);
		}
	}

	/**
	 * Save.
	 *
	 * @param $post_id
	 * @return mixed
	 */
	public function save( $post_id ) {

		if ( ! isset( $_POST['oblique_pro_single_mb_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['oblique_pro_single_mb_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'oblique_pro_box' ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		$field_bodybg = isset( $_POST['oblique_pro_body_background'] ) ? strip_tags( $_POST['oblique_pro_body_background'] ) : '';
		$field_postbg = isset( $_POST['oblique_pro_background'] ) ? strip_tags( $_POST['oblique_pro_background'] ) : '';
		$field_text   = isset( $_POST['oblique_pro_text_color'] ) ? strip_tags( $_POST['oblique_pro_text_color'] ) : '';

		update_post_meta( $post_id, '_oblique_pro_body_background_key', $field_bodybg );
		update_post_meta( $post_id, '_oblique_pro_post_background_key', $field_postbg );
		update_post_meta( $post_id, '_oblique_pro_text_color_key', $field_text );
	}

	/**
	 * Render metabox Content.
	 *
	 * @param $post
	 */
	public function render_meta_box_content( $post ) {

		wp_nonce_field( 'oblique_pro_box', 'oblique_pro_single_mb_nonce' );

		$body_bg    = get_post_meta( $post->ID, '_oblique_pro_body_background_key', true );
		$post_bg    = get_post_meta( $post->ID, '_oblique_pro_post_background_key', true );
		$text_color = get_post_meta( $post->ID, '_oblique_pro_text_color_key', true );

	?>

	<div class="oblique-pro-colors-metabox">
		<p><em><?php echo __( 'Note that these color settings apply only for this post.', 'oblique' ); ?></em>.</p>
		<p><label><?php echo __( 'Body Background Color: ', 'oblique' ); ?></label><br/>
		<input class="color-field" type="text" name="oblique_pro_body_background" value="<?php echo $body_bg; ?>"/></p>
		<hr>
		<p><label><?php echo __( 'Post Background Color: ', 'oblique' ); ?></label><br/>
		<input class="color-field" type="text" name="oblique_pro_background" value="<?php echo $post_bg; ?>"/></p>
		<hr>			
		<p><label><?php echo __( 'Text Color: ', 'oblique' ); ?></label><br/>
		<input class="color-field" type="text" name="oblique_pro_text_color" value="<?php echo $text_color; ?>"/></p>
	</div>

	<script>
	(function( $ ) {
		$(function() {
		$('.color-field').wpColorPicker();
		});
	})( jQuery );
	</script>

	<?php
	}
}

/**
 * Color picker.
 */
function oblique_pro_colorpicker() {
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'oblique_pro_colorpicker' );
