<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage BirdFILED
 * @since BirdFILED 1.09
 */
?>

<header class="entry-header">
	<h1 class="entry-title"><?php the_title(); ?></h1>

	<?php if( is_single() ) : ?>
		<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( get_option( 'date_format' ) ); ?></time>
		<span class="icon author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span>
	<?php endif; ?>

</header>
<div class="entry-content">
	<?php the_content(); ?>
	<?php wp_link_pages( array(
		'before'		=> '<div class="page-links">' . __( 'Pages:', 'birdfield' ),
		'after'			=> '</div>',
		'link_before'	=> '<span>',
		'link_after'	=> '</span>'
		) ); ?>
</div>

<?php if( is_single() ): // Only Display Excerpts for Single ?>
	<footer class="entry-meta">

		<div class="category"><span><?php _e( 'Category', 'birdfield' ); ?></span><?php the_category( ' ' ) ?></div>
		<?php the_tags('<div class="tag"><span>' .__( 'Tags', 'birdfield' ) .'</span>', ' ', '</div>' ) ?>
	</footer>
<?php endif; ?>

