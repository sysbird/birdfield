<?php
/**
 * The template for displaying search results pages.
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

			<header class="entry-header">
			<h1 class="entry-title"><?php printf( __( 'Search Results: %s', 'birdfield' ), esc_html( $s ) ); ?></h1>
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
				<p><?php printf( __( 'Sorry, no posts matched &#8216;%s&#8217;', 'birdfield' ), esc_html( $s ) ); ?>
			<?php endif; ?>

		</article>
	</div>

	<?php birdfield_content_footer(); ?>
</div>

<?php get_footer(); ?>
