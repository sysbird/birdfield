<?php
/*
 * The template for displaying news content
 */
?>

<section id="news">
	<div class="container">
		<h2><?php _e( 'NEWS', 'birdfield' ) ?></h2>
		<ul class="article">

<?php
	$birdfield_news_posts = birdfield_get_news_posts();
	foreach ( (array) $birdfield_news_posts as $order => $post ) :
		setup_postdata( $post ); ?>

		<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdfield' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
		<header class="entry-header">
			<time class="postdate" datetime="<?php echo get_the_time('Y-m-d') ?>"><?php echo get_post_time( get_option( 'date_format' ) ); ?></time>
			<h2 class="entry-title"><?php the_title(); ?></h2>
		</header>
		</a>
		</li>

<?php endforeach;
	wp_reset_postdata();
?>

		</ul>
	</div>
</section>
