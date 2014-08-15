<?php
/*
The template for displaying 404 pages (Not Found).
*/
get_header(); ?>

<div id="content">
	<div class="container">
		<article class="hentry">

	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'Error 404 - Not Found', 'birdfield' ); ?></h1>
	</header>

	<div class="entry-content">
		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'birdfield' ); ?></p>
	</div>

		</article>
	</div>
</div>

<?php get_footer(); ?>
