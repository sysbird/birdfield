<?php
/**
 * The template for displaying pages
 *
 * @package WordPress
 * @subpackage BirdFILED
 * @since BirdFILED 1.0
 */
get_header(); ?>

<div id="content">
	<?php birdfield_content_header(); ?>

	<div class="container">

	<?php while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'content', 'singular' ); ?>
		<?php comments_template( '', true ); ?>
	</article>
	<?php endwhile; ?>

	</div>

	<?php birdfield_content_footer(); ?>
</div>

<?php get_footer(); ?>
