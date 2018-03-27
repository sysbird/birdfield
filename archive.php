<?php
/**
 * The template for displaying archive pages
 *
 * @package WordPress
 * @subpackage BirdFILED
 * @since BirdFILED 1.0
 */
get_header(); ?>

<div id="content">
	<?php birdfield_content_header(); ?>

	<div class="container">
		<article class="hentry">
			<header class="content-header">
				<?php
					the_archive_title( '<h1 class="content-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header>

			<?php if ( have_posts() ) : ?>
				<ul class="list">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
				</ul>

				<?php $birdfield_pagination = get_the_posts_pagination( array(
						'mid_size'	=> 3,
						'screen_reader_text'	=> 'pagination',
					) );

					$birdfield_pagination = str_replace( '<h2 class="screen-reader-text">pagination</h2>', '', $birdfield_pagination );
					echo $birdfield_pagination; ?>

			<?php else: ?>
				<p><?php _e( 'Sorry, no posts matched your criteria.', 'birdfield' ); ?></p>
			<?php endif; ?>
		</article>
	</div>
</div>

<?php get_footer(); ?>
