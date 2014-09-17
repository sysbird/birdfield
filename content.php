<?php
/*
The default template for displaying content. Used for both single and index/page/archive/search.
*/
?>

<?php if( is_home() ): // Display Excerpts for Home ?>
	<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdfield' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
	<?php if( has_post_thumbnail() ): ?>
		<div class="entry-eyecatch">
			<?php the_post_thumbnail( 'large' ); ?>
		</div>
	<?php endif; ?>

	<header class="entry-header">
		<h3 class="entry-title"><?php the_title(); ?></h3>
		<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( get_option( 'date_format' ) ); ?></time>
		<span class="icon author"><?php the_author(); ?></span>
		<?php if ( comments_open() ) : ?>
			<span class="icon comment"><?php comments_number( '0', '1', '%' ); ?></span>
		<?php endif; ?>
	</header>
	</a>
	<?php if(is_sticky()): ?>
		<i><span></span></i>
	<?php endif; ?>
	</li>

<?php elseif(is_singular()): // Display Excerpts for Single/Page ?>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<?php if( is_single() ) : ?>
			<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( get_option( 'date_format' ) ); ?></time>
			<span class="icon author"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span>
		<?php endif; ?>

	</header>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array(
			'before'		=> '<div class="page-links">' . __( 'Pages:', 'birdfield' ),
			'after'			=> '</div>',
			'link_before'	=> '<span>',
			'link_after'	=> '</span>'
			) ); ?>
	</div>

	<?php if( is_single() ): // Only Display Excerpts for Single ?>
		<footer class="entry-meta">
			
			<div class="category"><span><?php _e( 'Category', 'birdfield' ); ?></span><?php the_category( ' ' ) ?></div>
			<?php the_tags('<div class="tag"><span>' .__( 'Tags', 'birdfield' ) .'</span>', ' ', '</div>' ) ?>
		</footer>
	<?php endif; ?>

<?php else: // Display Excerpts for Search, Archiv ?>
	<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'birdfield' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
	<header class="entry-header">
		<h2 class="entry-title"><?php the_title(); ?></h2>
		<time class="postdate" datetime="<?php echo get_the_time( 'Y-m-d' ) ?>"><?php echo get_post_time( get_option( 'date_format' ) ); ?></time>
		<?php if ( comments_open() ) : ?>
			<span class="icon comment"><?php comments_number('0', '1', '%'); ?></span>
		<?php endif; ?>
	</header>
	<?php the_post_thumbnail( 'thumbnail' ); ?>
	<div class="entry-content"><?php the_excerpt(); ?></div>
	</a></li>
<?php endif; ?>
