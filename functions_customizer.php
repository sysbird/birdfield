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

	// partial
	for ($birdfield_count = 1; $birdfield_count < 5; $birdfield_count++) {
		$wp_customize->selective_refresh->add_partial( 'slider_title_' .strval( $birdfield_count ),
			array( 'selector'		=> '.slide-item-' .strval( $birdfield_count ) . ' .title',
				'render_callback'	=> function() {
					$birdfield_default_text = '';
					if( 1 == $birdfield_count ){
						$birdfield_default_text = __( 'Hello world!','birdfield' );
					}
					return get_theme_mod( 'slider_title_' .strval( $birdfield_count ), birdfield_default_text );
				}
			));

		$wp_customize->selective_refresh->add_partial( 'slider_description_' .strval( $birdfield_count ),
			array( 'selector'	=> '.slide-item-' .strval( $birdfield_count ) .' .description',
				'render_callback'	=> function() {
					$birdfield_default_text = '';
					if( 1 == $birdfield_count ){
						$birdfield_default_text = __( 'Begin your website.','birdfield' );
					}
					return get_theme_mod( 'slider_description_' .strval( $birdfield_count ), birdfield_default_text );
				}
			));

		$wp_customize->selective_refresh->add_partial( 'slider_link_' .strval( $birdfield_count ),
			array( 'selector'	=> '.slide-item-' .strval( $birdfield_count ) .' .link',
				'render_callback'	=> function() {
					$birdfield_default_text = '';
					if( 1 == $birdfield_count ){
						$birdfield_default_text = '#';
					}
					return get_theme_mod( 'slider_link_' .strval( $birdfield_count ), birdfield_default_text );
				}
			));
	}

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
			'title'			=> __('Header Slider', 'birdfield' ),
			'description'	=> __( 'You can add up to 5 images in the header slider. also you can add title, description, link URL for each image.', 'birdfield' ),
			'priority'		=> 999,
		));

	//////////////////////////////
	// 1st slide
	$wp_customize->add_setting( 'birdfield_options[info]',
		array(
			'type'				=> 'info_control',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'esc_attr',
		));

	$wp_customize->add_control(
		new birdfield_Info( $wp_customize,
			's1',
			array(
				'label' => __( '1st slide', 'birdfield' ),
				'section' => 'birdfield_slider',
				'settings' => 'birdfield_options[info]',
				'priority' => 10
			)));

	$wp_customize->add_setting( 'slider_image_1',
		array(
			'default'			=> get_template_directory_uri() . '/images/header.jpg',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'			=> 'postMessage'
		));

		$wp_customize->add_control(
			new WP_Customize_Image_Control( $wp_customize, 'slider_image_1',
				array(
					'label'		=> __( 'Upload image', 'birdfield' ) .' 1',
					'type'		=> 'image',
					'section'	=> 'birdfield_slider',
					'settings'	=> 'slider_image_1',
					'priority'	=> 11,
				)));

	// title 1
	$wp_customize->add_setting( 'slider_title_1',
		array(
			'default'			=> __( 'Hello world!', 'birdfield' ),
			'sanitize_callback'	=> 'birdfield_sanitize_text',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control( 'slider_title_1',
		array(
			'label'		=> __( 'Title', 'birdfield' ) .' 1',
			'section'	=> 'birdfield_slider',
			'type'		=> 'text',
			'priority'	=> 12
		));

	// description 1
	$wp_customize->add_setting( 'slider_description_1',
		array(
			'default'			=> __( 'Begin your website.', 'birdfield' ),
			'sanitize_callback'	=> 'birdfield_sanitize_text',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
		'slider_description_1',
		array(
			'label' => __( 'Description', 'birdfield' ) .' 1',
			'section' => 'birdfield_slider',
			'type' => 'text',
			'priority' => 13
		));

	// link 1
	$wp_customize->add_setting( 'slider_link_1',
		array(
			'default'			=> '#',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
		'slider_link_1',
		array(
			'label' => __( 'Link URL', 'birdfield' ) .' 1',
			'section' => 'birdfield_slider',
			'type' => 'text',
			'priority' => 14
		));

	//////////////////////////////
	// 2nd slide
	$wp_customize->add_setting( 'birdfield_options[info]',
		array(
			'type'				=> 'info_control',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'esc_attr',
		));

	$wp_customize->add_control( new birdfield_Info( $wp_customize,
		's2',
		array(
			'label'		=> __( '2nd slide', 'birdfield' ),
			'section'	=> 'birdfield_slider',
			'settings'	=> 'birdfield_options[info]',
			'priority'	=> 20
		)));

	$wp_customize->add_setting( 'slider_image_2',
		array(
			'default' => '',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
	new WP_Customize_Image_Control( $wp_customize, 'slider_image_2',
		array(
			'label'		=> __( 'Upload image', 'birdfield' ) .' 2',
			'type'		=> 'image',
			'section'	=> 'birdfield_slider',
			'settings'	=> 'slider_image_2',
			'priority'	=> 21,
		)));

	// title 2
	$wp_customize->add_setting( 'slider_title_2',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'birdfield_sanitize_text',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
		'slider_title_2',
		array(
			'label'		=> __( 'Title', 'birdfield' ) .' 2',
			'section'	=> 'birdfield_slider',
			'type'		=> 'text',
			'priority'	=> 22
		));

	// description 2
	$wp_customize->add_setting( 'slider_description_2',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'birdfield_sanitize_text',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
		'slider_description_2',
		array(
			'label'		=> __( 'Description', 'birdfield' ) .' 2',
			'section'	=> 'birdfield_slider',
			'type'		=> 'text',
			'priority'	=> 23
		));

	// link 2
	$wp_customize->add_setting( 'slider_link_2',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
	'slider_link_2',
		array(
			'label' => __( 'Link URL', 'birdfield' ) .' 2',
			'section' => 'birdfield_slider',
			'type' => 'text',
			'priority' => 24
		));

	//////////////////////////////
	// 3rd Slide
	$wp_customize->add_setting('birdfield_options[info]',
		array(
			'type'				=> 'info_control',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'esc_attr',
		));

	$wp_customize->add_control( new birdfield_Info( $wp_customize, 's3',
		array(
			'label'		=> __( '3rd slide', 'birdfield' ),
			'section'	=> 'birdfield_slider',
			'settings'	=> 'birdfield_options[info]',
			'priority'	=> 30
		)));

	$wp_customize->add_setting( 'slider_image_3',
		array(
			'default-image'		=> '',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
	new WP_Customize_Image_Control( $wp_customize, 'slider_image_3',
		array(
			'label'		=> __( 'Upload image', 'birdfield' ) .' 3',
			'type'		=> 'image',
			'section'	=> 'birdfield_slider',
			'settings'	=> 'slider_image_3',
			'priority'	=> 31,
		)));

	// title 3
	$wp_customize->add_setting( 'slider_title_3',
		array(
			'default' => '',
			'sanitize_callback'	=> 'birdfield_sanitize_text',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
		'slider_title_3',
		array(
			'label'		=> __( 'Title', 'birdfield' ) .' 3',
			'section'	=> 'birdfield_slider',
			'type'		=> 'text',
			'priority'	=> 32
		));

	// description 3
	$wp_customize->add_setting( 'slider_description_3',
		array(
		'default'			=> '',
		'sanitize_callback'	=> 'birdfield_sanitize_text',
		'transport'			=> 'postMessage'
	));

	$wp_customize->add_control(
		'slider_description_3',
		array(
			'label'		=> __( 'Description', 'birdfield' ) .' 3',
			'section'	=> 'birdfield_slider',
			'type'		=> 'text',
			'priority'	=> 33
		));

	// link 3
	$wp_customize->add_setting( 'slider_link_3',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
	'slider_link_3',
		array(
			'label' => __( 'Link URL', 'birdfield' ) .' 3',
			'section' => 'birdfield_slider',
			'type' => 'text',
			'priority' => 34
		));

	//////////////////////////////
	// 4th slide
	$wp_customize->add_setting('birdfield_options[info]',
		array(
			'type'				=> 'info_control',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'esc_attr',
		));

	$wp_customize->add_control( new birdfield_Info( $wp_customize, 's4',
		array(
			'label'		=> __('4th slide', 'birdfield'),
			'section'	=> 'birdfield_slider',
			'settings'	=> 'birdfield_options[info]',
			'priority'	=> 40
		)));

	$wp_customize->add_setting( 'slider_image_4',
		array(
			'default-image'		=> '',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
		new WP_Customize_Image_Control( $wp_customize, 'slider_image_4',
			array(
				'label'		=> __( 'Upload image', 'birdfield' ) .' 4',
				'type'		=> 'image',
				'section'	=> 'birdfield_slider',
				'settings'	=> 'slider_image_4',
				'priority'	=> 41,
			)));

	// title 4
	$wp_customize->add_setting( 'slider_title_4',
	array(
		'default'			=> '',
		'sanitize_callback'	=> 'birdfield_sanitize_text',
		'transport'			=> 'postMessage'
	));

	$wp_customize->add_control(
	'slider_title_4',
	array(
		'label'		=> __( 'Title', 'birdfield' ) .' 4',
		'section'	=> 'birdfield_slider',
		'type'		=> 'text',
		'priority'	=> 42
	));

	// description 4
	$wp_customize->add_setting( 'slider_description_4',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'birdfield_sanitize_text',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
		'slider_description_4',
		array(
			'label'		=> __( 'Description', 'birdfield' ) .' 4',
			'section'	=> 'birdfield_slider',
			'type'		=> 'text',
			'priority'	=> 43
		));

	// link 4
	$wp_customize->add_setting( 'slider_link_4',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
	'slider_link_4',
		array(
			'label' => __( 'Link URL', 'birdfield' ) .' 4',
			'section' => 'birdfield_slider',
			'type' => 'text',
			'priority' => 44
		));

	//////////////////////////////
	// 5th slide
	$wp_customize->add_setting('birdfield_options[info]',
		array(
			'type'				=> 'info_control',
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'esc_attr',
		));

	$wp_customize->add_control( new birdfield_Info( $wp_customize, 's5',
		array(
			'label'		=> __('5th slide', 'birdfield'),
			'section'	=> 'birdfield_slider',
			'settings'	=> 'birdfield_options[info]',
			'priority'	=> 50
		)));

	$wp_customize->add_setting( 'slider_image_5',
		array(
	'default-image'		=> '',
	'sanitize_callback'	=> 'esc_url_raw',
	 'transport'		=> 'postMessage'
		));

	$wp_customize->add_control(
		new WP_Customize_Image_Control( $wp_customize, 'slider_image_5',
		array(
			'label'		=> __( 'Upload image', 'birdfield' ) .' 5',
			'type'		=> 'image',
			'section'	=> 'birdfield_slider',
			'settings'	=> 'slider_image_5',
			'priority'	=> 51,
		)));

	// title 5
	$wp_customize->add_setting( 'slider_title_5',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'birdfield_sanitize_text' .' 5',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
		'slider_title_5',
		array(
			'label'		=> __( 'Title', 'birdfield' ).' 5',
			'section'	=> 'birdfield_slider',
			'type'		=> 'text',
			'priority'	=> 52
		));

	// description 5
	$wp_customize->add_setting( 'slider_description_5',
		array(
			'default' => '',
			'sanitize_callback'	=> 'birdfield_sanitize_text',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
		'slider_description_5',
		array(
			'label'		=>__( 'Description', 'birdfield' ) .' 5',
			'section'	=> 'birdfield_slider',
			'type'		=> 'text',
			'priority'	=> 53
		));

	// link 5
	$wp_customize->add_setting( 'slider_link_5',
		array(
			'default'			=> '',
			'sanitize_callback'	=> 'esc_url_raw',
			'transport'			=> 'postMessage'
		));

	$wp_customize->add_control(
	'slider_link_5',
		array(
			'label' => __( 'Link URL', 'birdfield' ) .' 5',
			'section' => 'birdfield_slider',
			'type' => 'text',
			'priority' => 54
		));
}
add_action( 'customize_register', 'birdfield_customize_headerslider' );
