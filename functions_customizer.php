<?php
/**
 * birdfield Theme Customizer
 *
 * @package WordPress
 * @subpackage BirdFILED
 * @since BirdFILED 1.10
 */
//////////////////////////////////////////////////////
// Theme Customizer for Header Slider
function birdfield_customize_headerslider( $wp_customize ) {

	// preview
	for( $birdfield_count = 1; $birdfield_count <= 5; $birdfield_count++ ) {
		$wp_customize->selective_refresh->add_partial( 'slider_image_' .strval( $birdfield_count ),
			array( 'selector' => '#slideitem_' .strval( $birdfield_count ) . ' .fixedimage',
			));

		$wp_customize->selective_refresh->add_partial( 'slider_title_' .strval( $birdfield_count ),
			array( 'selector' => '#slideitem_' .strval( $birdfield_count ) . ' strong',
			));

		$wp_customize->selective_refresh->add_partial( 'slider_description_' .strval( $birdfield_count ),
			array( 'selector' => '#slideitem_' .strval( $birdfield_count ) . ' span',
			));

		$wp_customize->selective_refresh->add_partial( 'slider_link_' .strval( $birdfield_count ),
			array( 'selector' => '#slideitem_' .strval( $birdfield_count ) . ' a',
			));
	}

	$wp_customize->selective_refresh->add_partial( 'slide_interval',
		array( 'selector' => '.slide-interval',
		));

	// separation
	class birdfield_Info extends WP_Customize_Control {
		public $type = 'info';
		public $label = '';
		public function render_content() {
	?>

		<h4 style="font-size: 1.2em; margin-top:16.em; padding:0.8em 0; color:#000; background:#cbcbcb ;text-align:center; "><?php echo esc_html( $this->label ); ?></h4>
	<?php
		}
	}

	// slider section
	$wp_customize->add_section(
		'birdfield_slider',
		array(
			'title'		=> __('Header Slider', 'birdfield' ),
			'description'	=> __( 'You can add up to 5 images in the header slider. also you can add title, description, link URL for each image.', 'birdfield' ),
			'priority'	=> 61,
		));

	// use slider
	$wp_customize->add_setting( 'use_slider',
		array(
			'default'  => false,
			'sanitize_callback' => 'birdfield_sanitize_checkbox',
		));

	$wp_customize->add_control( 'use_slider',
		array(
			'label'		=> __( 'Use Header Slider', 'birdfield' ),
			'section'	=> 'birdfield_slider',
			'type'		=> 'checkbox',
			'settings'	=> 'use_slider',
		));

	// Interval
	$wp_customize->add_setting( 'slide_interval',
		array(
			'default'		=> 7000,
			'sanitize_callback'	=> 'absint',
			'transport'		=> 'postMessage'
		));

	$wp_customize->add_control( 'slide_interval',
		array(
			'label'		=> __( 'Slide Interval (1/1000 second)', 'birdfield' ),
			'section'	=> 'birdfield_slider',
			'type'		=> 'text',
			'settings'	=> 'slide_interval',
		));

	// Slider 1 - 5
	for( $birdfield_count = 1; $birdfield_count <= 5; $birdfield_count++ ) {

		// Label
		$wp_customize->add_setting( 'birdfield_options[info]',
			array(
				'type'			=> 'info_control',
				'capability'		=> 'edit_theme_options',
				'sanitize_callback'	=> 'esc_attr',
			));

		$birdfield_label = '';
		if( 1 == $birdfield_count ){
			$birdfield_label = __( '1st slide', 'birdfield' );
		}
		else if( 2 == $birdfield_count ){
			$birdfield_label = __( '2nd slide', 'birdfield' );
		}
		else if( 3 == $birdfield_count ){
			$birdfield_label = __( '3rd slide', 'birdfield' );
		}
		else if( 4 == $birdfield_count ){
			$birdfield_label = __( '4th slide', 'birdfield' );
		}
		else if( 5 == $birdfield_count ){
			$birdfield_label = __( '5th slide', 'birdfield' );
		}

		$wp_customize->add_control(
			new birdfield_Info( $wp_customize,
				's' .strval( $birdfield_count ),
				array(
					'label'		=> $birdfield_label,
					'section'	=> 'birdfield_slider',
					'settings'	=> 'birdfield_options[info]',
					'priority'	=> ( $birdfield_count *10 ),
				)));

		// Upload image
		$birdfield_default_text = '';
		if( 1 == $birdfield_count ){
			$birdfield_default_text = get_template_directory_uri() . '/images/header.jpg';
		}

		$wp_customize->add_setting( 'slider_image_' .strval( $birdfield_count ),
			array(
				'default'		=> $birdfield_default_text,
				'sanitize_callback'	=> 'esc_url_raw',
				'transport'		=> 'postMessage'
			));

			$wp_customize->add_control(
				new WP_Customize_Image_Control( $wp_customize, 'slider_image_' .strval( $birdfield_count ),
					array(
						'label'		=> __( 'Upload image', 'birdfield' ) .' ' .strval( $birdfield_count ),
						'type'		=> 'image',
						'section'	=> 'birdfield_slider',
						'settings'	=> 'slider_image_' .strval( $birdfield_count ),
						'priority'	=> ( $birdfield_count *10 ) + 1,
					)));

		// Title
		$birdfield_default_text = '';
		if( 1 == $birdfield_count ){
			$birdfield_default_text = __( 'Hello world!','birdfield' );
		}

		$wp_customize->add_setting( 'slider_title_' .strval( $birdfield_count ),
			array(
				'default'		=> $birdfield_default_text,
				'sanitize_callback'	=> 'birdfield_sanitize_text',
				'transport'		=> 'postMessage'
			));

		$wp_customize->add_control( 'slider_title_' .strval( $birdfield_count ),
			array(
				'label'		=> __( 'Title', 'birdfield' ) .' ' .strval( $birdfield_count ),
				'section'	=> 'birdfield_slider',
				'type'		=> 'text',
				'priority'	=> ( $birdfield_count *10 ) + 2
			));

		// Description
		$birdfield_default_text = '';
		if( 1 == $birdfield_count ){
			$birdfield_default_text = __( 'Begin your website.','birdfield' );
		}

		$wp_customize->add_setting( 'slider_description_' .strval( $birdfield_count ),
			array(
				'default'		=> $birdfield_default_text,
				'sanitize_callback'	=> 'birdfield_sanitize_text',
				'transport'		=> 'postMessage'
			));

		$wp_customize->add_control(
			'slider_description_' .strval( $birdfield_count ),
			array(
				'label'		=> __( 'Description', 'birdfield' ) .' ' .strval( $birdfield_count ),
				'section'	=> 'birdfield_slider',
				'type'		=> 'text',
				'priority'	=> ( $birdfield_count *10 ) + 3
			));

		// Link URL
		$birdfield_default_text = '';
		if( 1 == $birdfield_count ){
			$birdfield_default_text = '#';
		}

		$wp_customize->add_setting( 'slider_link_' .strval( $birdfield_count ),
			array(
				'default'		=> $birdfield_default_text,
				'sanitize_callback'	=> 'esc_url_raw',
				'transport'		=> 'postMessage'
			));

		$wp_customize->add_control(
			'slider_link_' .strval( $birdfield_count ),
			array(
				'label'		=> __( 'Link URL', 'birdfield' ) .' ' .strval( $birdfield_count ),
				'section'	=> 'birdfield_slider',
				'type'		=> 'url',
				'priority'	=> ( $birdfield_count *10 ) + 4
			));
	}
}
add_action( 'customize_register', 'birdfield_customize_headerslider' );
