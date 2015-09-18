<?php
/**
 * The main template file
 *
 * @package WordPress
 * @subpackage BirdFILED
 * @since BirdFILED 1.0
 */
get_header(); ?>

<div id="content">
	<div class="container">
		<article class="hentry">
		<ul class="article">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
		</ul>

		<?php the_posts_pagination( array(
				'mid_size' => 3,
				'prev_text'          => esc_html__( 'Previous page', 'birdfield' ),
				'next_text'          => esc_html__( 'Next page', 'birdfield' ),
			) ); ?>

		</article>
	</div>
</div>

<?php get_footer(); ?>
