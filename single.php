<?php
/*
The Template for displaying all single posts.
*/
get_header(); ?>

<div id="content">
	<div class="container">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'content', get_post_format() ); ?>
		<?php comments_template( '', true ); ?>
	</article>

	<nav id="nav-below">
		<span class="nav-next"><?php next_post_link('%link', '%title'); ?></span>
		<span class="nav-previous"><?php previous_post_link('%link', '%title'); ?></span>
	</nav>

<?php endwhile; ?>
	</div>
</div>

<?php get_footer(); ?>
