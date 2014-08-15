<?php
/*
The Template for displaying all single posts.
*/
get_header(); ?>

<div id="content">
	<div class="container">

	<?php while ( have_posts() ) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( get_option( 'date_format' ) ); ?></time>
				<span class="icon author"><?php the_author(); ?></span>
				<span class="parent-post-link"><a href="<?php echo get_permalink( $post->post_parent ); ?>" rel="gallery"><?php echo get_the_title( $post->post_parent ); ?></a></span>
			</header>

			<div class="entry-content">

				<div class="entry-attachment">
					<div class="attachment">
<?php

	$post                = get_post();
	$attachment_size     = apply_filters( 'birdfield', array( 930, 930 ) );
	$next_attachment_url = wp_get_attachment_url();
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);

?>

						<?php if ( has_excerpt() ) : ?>
							<div class="wp-caption">
								<?php the_excerpt(); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<?php the_content(); ?>
				<?php wp_link_pages( array(
					'before'		=> '<div class="page-links">' . __( 'Pages:', 'birdfield' ),
					'after'			=> '</div>',
					'link_before'	=> '<span>',
					'link_after'	=> '</span>'
					) ); ?>

			</div>

			<?php comments_template(); ?>

		</article>

		<nav id="nav-below">
			<span class="nav-previous"><?php next_image_link( false, __( 'Next Image' , 'birdfield' ) ); ?></span>
			<span class="nav-next"><?php previous_image_link( false, __( 'Previous Image' , 'birdfield' ) ); ?></span>
		</nav>

	<?php endwhile; ?>
	</div>
</div>

<?php get_footer(); ?>
x