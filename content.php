<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage BirdFILED
 * @since BirdFILED 1.0
 */
?>

<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdfield' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
	<header class="entry-header">
		<h2 class="entry-title"><?php the_title(); ?></h2>
		<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( get_option( 'date_format' ) ); ?></time>
		<?php if ( comments_open() ) : ?>
			<span class="icon comment"><?php comments_number('0', '1', '%'); ?></span>
		<?php endif; ?>
	</header>
	<?php the_post_thumbnail( 'thumbnail' ); ?>
	<div class="entry-content"><?php the_excerpt(); ?></div>
	</a>
</li>
