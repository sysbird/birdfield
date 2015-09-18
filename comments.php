<?php
/**
 * The template for displaying comments
 *
 * @package WordPress
 * @subpackage BirdFILED
 * @since BirdFILED 1.0
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments">
<?php if ( have_comments() ) : ?>
	<h2>
		<?php
		printf( _n( 'One Comment', '%1$s Comments', get_comments_number(), 'birdfield' ),
		number_format_i18n( get_comments_number() ));
		?>
	</h2>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<div class="navigation top">
			<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'birdfield' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'birdfield' ) ); ?></div>
		</div>
	<?php endif;  ?>

		<ol class="commentlist">
		<?php
			wp_list_comments( array(
				'style'		=> 'ol',
				'avatar_size'	=> 40,
			) );
		?>
		</ol>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<div class="navigation bottom">
			<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'birdfield' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'birdfield' ) ); ?></div>
		</div>
	<?php endif; ?>

<?php endif; ?>

<?php comment_form(); ?>

</div>