<?php
/*
The template for displaying all pages.
*/
get_header(); ?>

<div id="content">
	<div class="container">

<?php while ( have_posts() ) : the_post(); ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'content', get_post_format() ); ?>
		<?php comments_template( '', true ); ?>
	</article>
<?php endwhile; ?>

	</div>
</div>

<?php get_footer(); ?>
