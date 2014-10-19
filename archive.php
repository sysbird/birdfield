<?php
/*
The template for displaying Archive pages
*/
get_header(); ?>

<div id="content">
	<div class="container">

		<article class="hentry">
			<header class="content-header">
				<h1 class="content-title"><?php
					if(is_category()) {
						printf(__( 'Category Archives: %s', 'birdfield' ), single_cat_title( '', false ) );
					}
					elseif( is_tag() ) {
						printf( __( 'Tag Archives: %s', 'birdfield' ), single_tag_title('', false) );
					}
					elseif (is_day()) {
						printf( __( 'Daily Archives: %s', 'birdfield' ), get_post_time( get_option( 'date_format' ) ) );
					}
					elseif (is_month()) {
						printf( __( 'Monthly Archives: %s', 'birdfield' ), get_post_time( __('F, Y', 'birdfield' ) ) );
					}
					elseif (is_year()) {
						printf( __( 'Yearly Archives: %s', 'birdfield' ), get_post_time( __( 'Y', 'birdfield' ) ) );
					}
					elseif (is_author()) {
						printf(__('Author Archives: %s', 'birdfield' ), get_the_author_meta( 'display_name', get_query_var( 'author' ) ) );
					}
					elseif ( isset($_GET['paged'] ) && !empty($_GET['paged'] ) ) {
						_e( 'Blog Archives', 'birdfield' );
					}
				?></h1>
			</header>

			<?php if ( have_posts() ) : ?>
				<ul class="list">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; ?>
				</ul>
				<?php birdfield_the_pagenation(); ?>
			<?php else: ?>
				<p><?php _e( 'Sorry, no posts matched your criteria.', 'birdfield' ); ?></p>
			<?php endif; ?>
		</article>
	</div>
</div>

<?php get_footer(); ?>
