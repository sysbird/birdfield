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
	<?php birdfield_pre_content(); ?>

	<div class="container">

		<article class="hentry">
		<ul class="article">
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

		</article>
	</div>
</div>

<?php get_footer(); ?>
