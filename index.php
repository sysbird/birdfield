<?php
/*
The main template file.
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
		<div class="tablenav"><?php birdfield_the_pagenation(); ?></div>
		</article>
	</div>
</div>

<?php get_footer(); ?>
