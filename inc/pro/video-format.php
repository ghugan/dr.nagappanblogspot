<?php
/**
 * Video post format metabox
 *
 * @package Oblique
 */


/**
 * Metabox init.
 */
function oblique_pro_mb_init() {
	new Oblique_Pro_Metabox();
}

if ( is_admin() ) {
	add_action( 'load-post.php', 'oblique_pro_mb_init' );
	add_action( 'load-post-new.php', 'oblique_pro_mb_init' );
}

/**
 * Class Oblique_Pro_Metabox
 */
class Oblique_Pro_Metabox {

	/**
	 * Oblique_Pro_Metabox constructor.
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
		$post_types = array( 'post', 'page', 'dslc_staff', 'dslc_projects' );
		if ( in_array( $post_type, $post_types ) ) {
			add_meta_box(
				'oblique_pro_metabox', __( 'Video Link', 'oblique' ), array( $this, 'render_meta_box_content' ), $post_type, 'normal', 'low'
			);
		}
	}

	/**
	 * Save
	 *
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public function save( $post_id ) {

		if ( ! isset( $_POST['oblique_pro_mb_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['oblique_pro_mb_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'oblique_pro_box' ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		$video = isset( $_POST['oblique_pro_video_field'] ) ? esc_url_raw( $_POST['oblique_pro_video_field'] ) : '';

		update_post_meta( $post_id, '_oblique_pro_video_field_key', $video );
	}

	/**
	 * Render metabox content.
	 *
	 * @param $post
	 */
	public function render_meta_box_content( $post ) {

		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'oblique_pro_box', 'oblique_pro_mb_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$video = get_post_meta( $post->ID, '_oblique_pro_video_field_key', true );

	?>

	<div class="oblique-pro-video-metabox" style="display:none;">
		<p><label><?php echo __( 'Link', 'oblique' ); ?></label></p>
		<p><em><?php echo __( 'Add your video link here for your Youtube, Vimeo etc. video', 'oblique' ); ?></em></p>
		<input class="widefat" type="text" name="oblique_pro_video_field" value="<?php echo esc_url( $video ); ?>"/></p>
	</div>

	<script>
	jQuery( function($) {
		$( "#oblique_pro_metabox" ).hide();

		if( $( "input#post-format-video" ).is(':checked') ){
			$( "#oblique_pro_metabox, .oblique-pro-video-metabox" ).show();
		}
		$( "input#post-format-video" ).change( function() {
			if( $(this).is(':checked') ) {
				$( "#oblique_pro_metabox, .oblique-pro-video-metabox" ).show();
			}
		} );
	});
	</script>

	<?php
	}
}
