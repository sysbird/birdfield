<?php
/*
The template for displaying the footer.
*/
?>
	<footer id="footer">
		<section id="widget-area">
			<div class="container">
				<?php dynamic_sidebar( 'widget-area-footer' ); ?>
			</div>
		</section>

		<div class="container">
			<div class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ) ; ?>"><?php bloginfo(); ?></a>
				<span class="generator"><a href="http://wordpress.org/" target="_blank"><?php _e( 'Proudly powered by WordPress', 'birdfield' ); ?></a></span>. <?php _e('Theme by','birdfield'); ?> <a href="http://www.sysbird.jp/wptips/" target="_blank">Sysbird</a>.
			</div>
		</div>
		<p id="back-top"><a href="#top"><span><?php _e( 'Go Top', 'birdfield' ); ?></span></a></p>
	</footer>

</div><!-- wrapper -->

<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js" type="text/javascript"></script>
<![endif]-->
<?php wp_footer(); ?>

</body>
</html>