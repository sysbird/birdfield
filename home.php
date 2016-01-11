<?php
/**
 * The home template file.
 *
 * @package WordPress
 * @subpackage BirdFILED
 * @since BirdFILED 1.0
 */
get_header();
$birdfield_has_news = 0; ?>

<div id="content">
	<?php $birdfarm_header_image = get_header_image(); ?>
	<?php if( ! is_paged() && ! empty( $birdfarm_header_image ) ): ?>
		<section id="wall">
			<div class="headerimage">
				<img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" >
			</div>
			<?php dynamic_sidebar( 'widget-area-header' ); ?>
		</section>
	<?php endif; ?>

	<?php if ( is_front_page() && birdfield_has_news_posts() ): ?>
		<?php get_template_part( 'news-content' ); ?>
		<?php $birdfield_has_news = 1; ?>
	<?php endif; ?>

	<?php if ( have_posts() ) : ?>
		<section id="blog">
			<div class="container">
				<?php if( ! is_paged() && $birdfield_has_news ): ?>
					<h2><?php _e('RECENT', 'birdfield') ?></h2>
				<?php endif; ?>

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

			</div>
		</section>
	<?php endif; ?>

</div>

<?php get_footer(); ?>
