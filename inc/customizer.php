<?php
/**
 * zerif Theme Customizer
 *
 * @package zerif
 */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function zerif_customize_register( $wp_customize ) {
	class Zerif_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() {
			?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
			<?php
		}
	}
	class Zerif_Customizer_Number_Control extends WP_Customize_Control {
		public $type = 'number';
		public function render_content() {
		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<input type="number" <?php $this->link(); ?> value="<?php echo intval( $this->value() ); ?>" />
			</label>
		<?php
		}
	}
	class Zerif_Theme_Support extends WP_Customize_Control
	{
		public function render_content()
		{
			echo __('Check out the <a href="http://themeisle.com/themes/zerif-pro-one-page-wordpress-theme/">PRO version</a> for full control over the frontpage SECTIONS ORDER and the COLOR SCHEME!','zerif-lite');
		}
	}

	class Zerif_Theme_Support_Videobackground extends WP_Customize_Control
	{
		public function render_content()
		{
			echo __('Check out the <a href="http://themeisle.com/themes/zerif-pro-one-page-wordpress-theme/">PRO version</a> to add a nice looking background video!','zerif-lite');
		}
	}

	class Zerif_Theme_Support_Googlemap extends WP_Customize_Control
	{
		public function render_content()
		{
			echo __('Check out the <a href="http://themeisle.com/themes/zerif-pro-one-page-wordpress-theme/">PRO version</a> to add a google maps section !','zerif-lite');
		}
	}

	class Zerif_Theme_Support_Pricing extends WP_Customize_Control
	{
		public function render_content()
		{
			echo __('Check out the <a href="http://themeisle.com/themes/zerif-pro-one-page-wordpress-theme/">PRO version</a> to add a pricing section !','zerif-lite');
		}
	}

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->remove_section('colors');

	/**********************************************/
	/*************** ORDER ************************/
	/**********************************************/

	$wp_customize->add_section( 'zerif_order_section' , array(
					'title'       => __( 'Sections order and Colors', 'zerif-lite' ),
					'priority'    => 28
	));

	$wp_customize->add_setting(
        'zerif_order_section',array('sanitize_callback' => 'zerif_sanitize_pro_version')
	);

	$wp_customize->add_control( new Zerif_Theme_Support( $wp_customize, 'zerif_order_section',
	    array(
	        'section' => 'zerif_order_section',
	   )
	));
	/***********************************************/
	/************** GENERAL OPTIONS  ***************/
	/***********************************************/
	if ( class_exists( 'WP_Customize_Panel' ) ):

		$wp_customize->add_panel( 'panel_general', array(
			'priority' => 30,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Options générales', 'zerif-lite' )
		) );

		$wp_customize->add_section( 'zerif_general_section' , array(
				'title'       => __( 'Général', 'zerif-lite' ),
				'priority'    => 30,
				'panel' => 'panel_general'
		));
		/* LOGO	*/
		$wp_customize->add_setting( 'zerif_logo', array('sanitize_callback' => 'esc_url_raw'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_logo', array(
				'label'    => __( 'Logo', 'zerif-lite' ),
				'section'  => 'title_tagline',
				'settings' => 'zerif_logo',
				'priority'    => 1,
		)));

		/* Disable preloader */
		$wp_customize->add_setting( 'zerif_disable_preloader', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control(
				'zerif_disable_preloader',
				array(
					'type' => 'checkbox',
					'label' => __('Désactiver pré-chargement?','zerif-lite'),
					'section' => 'zerif_general_section',
					'priority'    => 2,
				)
		);

		/* Disable smooth scroll */
		$wp_customize->add_setting( 'zerif_disable_smooth_scroll', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control(
				'zerif_disable_smooth_scroll',
				array(
					'type' 		=> 'checkbox',
					'label' 	=> __('Disable défilement doux','zerif-lite'),
					'section' 	=> 'zerif_general_section',
					'priority'	=> 3,
				)
		);

		/* Enable accessibility */
		$wp_customize->add_setting( 'zerif_accessibility', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control(
				'zerif_accessibility',
				array(
					'type' 		=> 'checkbox',
					'label' 	=> __('Activer accessibility?','zerif-lite'),
					'section' 	=> 'zerif_general_section',
					'priority'	=> 3,
				)
		);

		/* COPYRIGHT */
		$wp_customize->add_setting( 'zerif_copyright', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control( 'zerif_copyright', array(
				'label'    => __( 'Copyright', 'zerif-lite' ),
				'section'  => 'zerif_general_section',
				'settings' => 'zerif_copyright',
				'priority'    => 3,
		));

		$wp_customize->add_section( 'zerif_general_socials_section' , array(
				'title'       => __( 'Réseaux sociaux', 'zerif-lite' ),
				'priority'    => 31,
				'panel' => 'panel_general'
		));

		/* facebook */
		$wp_customize->add_setting( 'zerif_socials_facebook', array('sanitize_callback' => 'esc_url_raw','default' => '#'));
		$wp_customize->add_control( 'zerif_socials_facebook', array(
				'label'    => __( 'Facebook', 'zerif-lite' ),
				'section'  => 'zerif_general_socials_section',
				'settings' => 'zerif_socials_facebook',
				'priority'    => 4,
		));
		/* twitter */
		$wp_customize->add_setting( 'zerif_socials_twitter', array('sanitize_callback' => 'esc_url_raw','default' => '#'));
		$wp_customize->add_control( 'zerif_socials_twitter', array(
				'label'    => __( 'Twitter', 'zerif-lite' ),
				'section'  => 'zerif_general_socials_section',
				'settings' => 'zerif_socials_twitter',
				'priority'    => 5,
		));
		/* linkedin */
		$wp_customize->add_setting( 'zerif_socials_linkedin', array('sanitize_callback' => 'esc_url_raw','default' => '#'));
		$wp_customize->add_control( 'zerif_socials_linkedin', array(
				'label'    => __( 'Linkedin', 'zerif-lite' ),
				'section'  => 'zerif_general_socials_section',
				'settings' => 'zerif_socials_linkedin',
				'priority'    => 6,
		));
		/* behance */
		$wp_customize->add_setting( 'zerif_socials_behance', array('sanitize_callback' => 'esc_url_raw','default' => '#'));
		$wp_customize->add_control( 'zerif_socials_behance', array(
				'label'    => __( 'Behance', 'zerif-lite' ),
				'section'  => 'zerif_general_socials_section',
				'settings' => 'zerif_socials_behance',
				'priority'    => 7,
		));
		/* dribbble */
		$wp_customize->add_setting( 'zerif_socials_dribbble', array('sanitize_callback' => 'esc_url_raw','default' => '#'));
		$wp_customize->add_control( 'zerif_socials_dribbble', array(
				'label'    => __( 'Dribbble', 'zerif-lite' ),
				'section'  => 'zerif_general_socials_section',
				'settings' => 'zerif_socials_dribbble',
				'priority'    => 8,
		));

		$wp_customize->add_section( 'zerif_general_footer_section' , array(
				'title'       => __( 'Pied de page', 'zerif-lite' ),
				'priority'    => 32,
				'panel' => 'panel_general'
		));

		/* email - ICON */
		$wp_customize->add_setting( 'zerif_email_icon', array('sanitize_callback' => 'esc_url_raw','default' => get_template_directory_uri().'/images/envelope4-green.png'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zerif_email_icon', array(
					'label'    => __( 'Email - icone', 'zerif-lite' ),
					'section'  => 'zerif_general_footer_section',
					'settings' => 'zerif_email_icon',
					'priority'    => 9,
		)));

		/* email */
		$wp_customize->add_setting( 'zerif_email', array( 'sanitize_callback' => 'zerif_sanitize_text','default' => '<a href="mailto:contact@site.com">contact@site.com</a>') );
		$wp_customize->add_control( new Zerif_Customize_Textarea_Control( $wp_customize, 'zerif_email', array(
				'label'   => __( 'Email', 'zerif-lite' ),
				'section' => 'zerif_general_footer_section',
				'settings'   => 'zerif_email',
				'priority' => 10
		)) );

		/* phone number - ICON */
		$wp_customize->add_setting( 'zerif_phone_icon', array('sanitize_callback' => 'esc_url_raw','default' => get_template_directory_uri().'/images/telephone65-blue.png'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zerif_phone_icon', array(
					'label'    => __( 'Numéro téléphone - icon', 'zerif-lite' ),
					'section'  => 'zerif_general_footer_section',
					'settings' => 'zerif_phone_icon',
					'priority'    => 11,
		)));
		/* phone number */

		$wp_customize->add_setting( 'zerif_phone', array('sanitize_callback' => 'zerif_sanitize_number','default' => '<a href="tel:0 332 548 954">0 332 548 954</a>') );
		$wp_customize->add_control(new Zerif_Customize_Textarea_Control( $wp_customize, 'zerif_phone', array(
				'label'   => __( 'Numéro téléphone', 'zerif-lite' ),
				'section' => 'zerif_general_footer_section',
				'settings'   => 'zerif_phone',
				'priority' => 12
		)) );

		/* address - ICON */
		$wp_customize->add_setting( 'zerif_address_icon', array('sanitize_callback' => 'esc_url_raw','default' => get_template_directory_uri().'/images/map25-redish.png'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zerif_address_icon', array(
					'label'    => __( 'Addresse - icon', 'zerif-lite' ),
					'section'  => 'zerif_general_footer_section',
					'settings' => 'zerif_address_icon',
					'priority'    => 13,
		)));
		/* address */

		$wp_customize->add_setting( 'zerif_address', array( 'sanitize_callback' => 'zerif_sanitize_text', 'default' => __('Company address','zerif-lite') ) );
		$wp_customize->add_control( new Zerif_Customize_Textarea_Control( $wp_customize, 'zerif_address', array(
				'label'   => __( 'Addresse', 'zerif-lite' ),
				'section' => 'zerif_general_footer_section',
				'settings'   => 'zerif_address',
				'priority' => 14
		)) ) ;

	else: /* Old versions of WordPress */

		$wp_customize->add_section( 'zerif_general_section' , array(
				'title'       => __( 'General options', 'zerif-lite' ),
				'priority'    => 30,
				'description' => __('Zerif theme general options','zerif-lite'),
		));
		/* LOGO	*/
		$wp_customize->add_setting( 'zerif_logo', array('sanitize_callback' => 'esc_url_raw'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_logo', array(
				'label'    => __( 'Logo', 'zerif-lite' ),
				'section'  => 'zerif_general_section',
				'settings' => 'zerif_logo',
				'priority'    => 1,
		)));

		/* Disable preloader */
		$wp_customize->add_setting( 'zerif_disable_preloader', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control(
				'zerif_disable_preloader',
				array(
					'type' => 'checkbox',
					'label' => __('Disable preloader?','zerif-lite'),
					'section' => 'zerif_general_section',
					'priority'    => 2,
				)
		);

		/* Disable smooth scroll */
		$wp_customize->add_setting( 'zerif_disable_smooth_scroll', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control(
				'zerif_disable_smooth_scroll',
				array(
					'type' 		=> 'checkbox',
					'label' 	=> __('Disable smooth scroll?','zerif-lite'),
					'section' 	=> 'zerif_general_section',
					'priority'	=> 3,
				)
		);

		/* Enable accessibility */
		$wp_customize->add_setting( 'zerif_accessibility', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control(
				'zerif_accessibility',
				array(
					'type' 		=> 'checkbox',
					'label' 	=> __('Enable accessibility?','zerif-lite'),
					'section' 	=> 'zerif_general_section',
					'priority'	=> 3,
				)
		);

		/* COPYRIGHT */
		$wp_customize->add_setting( 'zerif_copyright', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control( 'zerif_copyright', array(
				'label'    => __( 'Copyright', 'zerif-lite' ),
				'section'  => 'zerif_general_section',
				'settings' => 'zerif_copyright',
				'priority'    => 3,
		));
		/* facebook */
		$wp_customize->add_setting( 'zerif_socials_facebook', array('sanitize_callback' => 'esc_url_raw','default' => '#'));
		$wp_customize->add_control( 'zerif_socials_facebook', array(
				'label'    => __( 'Facebook link', 'zerif-lite' ),
				'section'  => 'zerif_general_section',
				'settings' => 'zerif_socials_facebook',
				'priority'    => 4,
		));
		/* twitter */
		$wp_customize->add_setting( 'zerif_socials_twitter', array('sanitize_callback' => 'esc_url_raw','default' => '#'));
		$wp_customize->add_control( 'zerif_socials_twitter', array(
				'label'    => __( 'Twitter link', 'zerif-lite' ),
				'section'  => 'zerif_general_section',
				'settings' => 'zerif_socials_twitter',
				'priority'    => 5,
		));
		/* linkedin */
		$wp_customize->add_setting( 'zerif_socials_linkedin', array('sanitize_callback' => 'esc_url_raw','default' => '#'));
		$wp_customize->add_control( 'zerif_socials_linkedin', array(
				'label'    => __( 'Linkedin link', 'zerif-lite' ),
				'section'  => 'zerif_general_section',
				'settings' => 'zerif_socials_linkedin',
				'priority'    => 6,
		));
		/* behance */
		$wp_customize->add_setting( 'zerif_socials_behance', array('sanitize_callback' => 'esc_url_raw','default' => '#'));
		$wp_customize->add_control( 'zerif_socials_behance', array(
				'label'    => __( 'Behance link', 'zerif-lite' ),
				'section'  => 'zerif_general_section',
				'settings' => 'zerif_socials_behance',
				'priority'    => 7,
		));
		/* dribbble */
		$wp_customize->add_setting( 'zerif_socials_dribbble', array('sanitize_callback' => 'esc_url_raw','default' => '#'));
		$wp_customize->add_control( 'zerif_socials_dribbble', array(
				'label'    => __( 'Dribbble link', 'zerif-lite' ),
				'section'  => 'zerif_general_section',
				'settings' => 'zerif_socials_dribbble',
				'priority'    => 8,
		));
		/* email - ICON */
		$wp_customize->add_setting( 'zerif_email_icon', array('sanitize_callback' => 'esc_url_raw','default' => get_template_directory_uri().'/images/envelope4-green.png'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zerif_email_icon', array(
					'label'    => __( 'Email section - icon', 'zerif-lite' ),
					'section'  => 'zerif_general_section',
					'settings' => 'zerif_email_icon',
					'priority'    => 9,
		)));

		/* email */
		$wp_customize->add_setting( 'zerif_email', array( 'sanitize_callback' => 'zerif_sanitize_text','default' => __('support@codeinwp.com','zerif-lite')) );
		$wp_customize->add_control( new Zerif_Customize_Textarea_Control( $wp_customize, 'zerif_email', array(
				'label'   => __( 'Email', 'zerif-lite' ),
				'section' => 'zerif_general_section',
				'settings'   => 'zerif_email',
				'priority' => 10
		)) );

		/* phone number - ICON */
		$wp_customize->add_setting( 'zerif_phone_icon', array('sanitize_callback' => 'esc_url_raw','default' => get_template_directory_uri().'/images/telephone65-blue.png'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zerif_phone_icon', array(
					'label'    => __( 'Phone number section - icon', 'zerif-lite' ),
					'section'  => 'zerif_general_section',
					'settings' => 'zerif_phone_icon',
					'priority'    => 11,
		)));
		/* phone number */

		$wp_customize->add_setting( 'zerif_phone', array('sanitize_callback' => 'zerif_sanitize_number','default' => __('Phone number','zerif-lite')) );
		$wp_customize->add_control(new Zerif_Customize_Textarea_Control( $wp_customize, 'zerif_phone', array(
				'label'   => __( 'Phone number', 'zerif-lite' ),
				'section' => 'zerif_general_section',
				'settings'   => 'zerif_phone',
				'priority' => 12
		)) );

		/* address - ICON */
		$wp_customize->add_setting( 'zerif_address_icon', array('sanitize_callback' => 'esc_url_raw','default' => get_template_directory_uri().'/images/map25-redish.png'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zerif_address_icon', array(
					'label'    => __( 'Address section - icon', 'zerif-lite' ),
					'section'  => 'zerif_general_section',
					'settings' => 'zerif_address_icon',
					'priority'    => 13,
		)));
		/* address */

		$wp_customize->add_setting( 'zerif_address', array( 'sanitize_callback' => 'zerif_sanitize_text', 'default' => __('24B, Fainari Street, Bucharest, Romania','zerif-lite') ) );
		$wp_customize->add_control( new Zerif_Customize_Textarea_Control( $wp_customize, 'zerif_address', array(
				'label'   => __( 'Address', 'zerif-lite' ),
				'section' => 'zerif_general_section',
				'settings'   => 'zerif_address',
				'priority' => 14
		)) ) ;

	endif;

	/*****************************************************/
    /**************	BIG TITLE SECTION *******************/
	/****************************************************/
	if ( class_exists( 'WP_Customize_Panel' ) ):

		$wp_customize->add_panel( 'panel_big_title', array(
			'priority' => 31,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => 'Grand Titre'
		) );

		/****************************************************/
		/************	PARALLAX IMAGES *********************/
		/****************************************************/
		$wp_customize->add_section( 'zerif_parallax_section' , array(
			'title'       => "Image à la une",
			'priority'    => 2,
			'panel'       => 'panel_big_title'
		));
		/* show/hide */
		$wp_customize->add_setting( 'zerif_parallax_show', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control(
			'zerif_parallax_show',
			array(
				'type' 		=> 'checkbox',
				'label' 	=> __('Use parallax effect?','zerif-lite'),
				'section' 	=> 'zerif_parallax_section',
				'priority'	=> 1,
			)
		);
		/* IMAGE 1*/
		$wp_customize->add_setting( 'zerif_parallax_img1', array('sanitize_callback' => 'esc_url_raw', 'default' => get_template_directory_uri() . '/images/background1.jpg'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_parallax_img1', array(
			'label'    	=> __( 'Image 1', 'zerif-lite' ),
			'section'  	=> 'zerif_parallax_section',
			'settings' 	=> 'zerif_parallax_img1',
			'priority'	=> 1,
		)));
		/* IMAGE 2 */
		$wp_customize->add_setting( 'zerif_parallax_img2', array('sanitize_callback' => 'esc_url_raw', 'default' => get_template_directory_uri() . '/images/background2.png'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_parallax_img2', array(
			'label'    	=> __( 'Image 2', 'zerif-lite' ),
			'section'  	=> 'zerif_parallax_section',
			'settings' 	=> 'zerif_parallax_img2',
			'priority'	=> 2,
		)));

	else:

		$wp_customize->add_section( 'zerif_bigtitle_section' , array(
			'title'       => __( 'Big title section', 'zerif-lite' ),
			'priority'    => 31
		));
		/* show/hide */
		$wp_customize->add_setting( 'zerif_bigtitle_show', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control(
			'zerif_bigtitle_show',
			array(
				'type' => 'checkbox',
				'label' => __('Hide big title section?','zerif-lite'),
				'section' => 'zerif_bigtitle_section',
				'priority'    => 1,
			)
		);
		/* title */
		$wp_customize->add_setting( 'zerif_bigtitle_title', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('ONE OF THE TOP 10 MOST POPULAR THEMES ON WORDPRESS.ORG','zerif-lite')));
		$wp_customize->add_control( 'zerif_bigtitle_title', array(
			'label'    => __( 'Title', 'zerif-lite' ),
			'section'  => 'zerif_bigtitle_section',
			'settings' => 'zerif_bigtitle_title',
			'priority'    => 2,
		));
		/* red button */
		$wp_customize->add_setting( 'zerif_bigtitle_redbutton_label', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('Features','zerif-lite')));
		$wp_customize->add_control( 'zerif_bigtitle_redbutton_label', array(
			'label'    => __( 'Red button label', 'zerif-lite' ),
			'section'  => 'zerif_bigtitle_section',
			'settings' => 'zerif_bigtitle_redbutton_label',
			'priority'    => 3,
		));
		$wp_customize->add_setting( 'zerif_bigtitle_redbutton_url', array('sanitize_callback' => 'esc_url_raw','default' => esc_url( home_url( '/' ) ).'#focus'));
		$wp_customize->add_control( 'zerif_bigtitle_redbutton_url', array(
			'label'    => __( 'Red button link', 'zerif-lite' ),
			'section'  => 'zerif_bigtitle_section',
			'settings' => 'zerif_bigtitle_redbutton_url',
			'priority'    => 4,
		));
		/* green button */
		$wp_customize->add_setting( 'zerif_bigtitle_greenbutton_label', array('sanitize_callback' => 'zerif_sanitize_text','default' => __("What's inside",'zerif-lite')));
		$wp_customize->add_control( 'zerif_bigtitle_greenbutton_label', array(
			'label'    => __( 'Red button label', 'zerif-lite' ),
			'section'  => 'zerif_bigtitle_section',
			'settings' => 'zerif_bigtitle_greenbutton_label',
			'priority'    => 5,
		));
		$wp_customize->add_setting( 'zerif_bigtitle_greenbutton_url', array('sanitize_callback' => 'esc_url_raw','default' => esc_url( home_url( '/' ) ).'#focus'));
		$wp_customize->add_control( 'zerif_bigtitle_greenbutton_url', array(
			'label'    => __( 'Green button link', 'zerif-lite' ),
			'section'  => 'zerif_bigtitle_section',
			'settings' => 'zerif_bigtitle_greenbutton_url',
			'priority'    => 6,
		));

		/****************************************************/
		/************	PARALLAX IMAGES *********************/
		/****************************************************/
		$wp_customize->add_section( 'zerif_parallax_section' , array(
			'title'       => __( 'Parallax effect', 'zerif-lite' ),
			'priority'    => 60
		));
		/* show/hide */
		$wp_customize->add_setting( 'zerif_parallax_show', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control(
			'zerif_parallax_show',
			array(
				'type' 		=> 'checkbox',
				'label' 	=> __('Use parallax effect?','zerif-lite'),
				'section' 	=> 'zerif_parallax_section',
				'priority'	=> 1,
			)
		);
		/* IMAGE 1*/
		$wp_customize->add_setting( 'zerif_parallax_img1', array('sanitize_callback' => 'esc_url', 'default' => get_template_directory_uri() . '/images/background1.jpg'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_parallax_img1', array(
			'label'    	=> __( 'Image 1', 'zerif-lite' ),
			'section'  	=> 'zerif_parallax_section',
			'settings' 	=> 'zerif_parallax_img1',
			'priority'	=> 1,
		)));
		/* IMAGE 2 */
		$wp_customize->add_setting( 'zerif_parallax_img2', array('sanitize_callback' => 'esc_url', 'default' => get_template_directory_uri() . '/images/background2.png'));
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_parallax_img2', array(
			'label'    	=> __( 'Image 2', 'zerif-lite' ),
			'section'  	=> 'zerif_parallax_section',
			'settings' 	=> 'zerif_parallax_img2',
			'priority'	=> 2,
		)));

	endif;


	/************************************/
	/******* ABOUT US SECTION ***********/
	/************************************/
	if ( class_exists( 'WP_Customize_Panel' ) ):

		$wp_customize->add_panel( 'panel_about', array(
			'priority' => 34,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Section à propos', 'zerif-lite' )
		) );

		$wp_customize->add_section( 'zerif_aboutus_settings_section' , array(
				'title'       => __( 'Options', 'zerif-lite' ),
				'priority'    => 1,
				'panel' => 'panel_about'
		));
		/* about us show/hide */
		$wp_customize->add_setting( 'zerif_aboutus_show', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control(
			'zerif_aboutus_show',
			array(
				'type' => 'checkbox',
				'label' => __('Cacher la section?','zerif-lite'),
				'section' => 'zerif_aboutus_settings_section',
				'priority'    => 1,
			)
		);

		$wp_customize->add_section( 'zerif_aboutus_main_section' , array(
				'title'       => __( 'Contenu', 'zerif-lite' ),
				'priority'    => 2,
				'panel' => 'panel_about'
		));

		/* title */
		$wp_customize->add_setting( 'zerif_aboutus_title', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('About','zerif-lite')));
		$wp_customize->add_control( 'zerif_aboutus_title', array(
					'label'    => __( 'Titre', 'zerif-lite' ),
					'section'  => 'zerif_aboutus_main_section',
					'settings' => 'zerif_aboutus_title',
					'priority'    => 2,
		));
		/* subtitle */
		$wp_customize->add_setting( 'zerif_aboutus_subtitle', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('Use this section to showcase important details about your business.','zerif-lite')));
		$wp_customize->add_control( 'zerif_aboutus_subtitle', array(
				'label'    => __( 'Sous-titre', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_main_section',
				'settings' => 'zerif_aboutus_subtitle',
				'priority'    => 3,
		));
		/* big left title */
		$wp_customize->add_setting( 'zerif_aboutus_biglefttitle', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('Everything you see here is responsive and mobile-friendly.','zerif-lite')));
		$wp_customize->add_control( 'zerif_aboutus_biglefttitle', array(
				'label'    => __( 'Titre gauche', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_main_section',
				'settings' => 'zerif_aboutus_biglefttitle',
				'priority'    => 4,
		));
		/* text */
		$wp_customize->add_setting( 'zerif_aboutus_text', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec massa enim. Aliquam viverra at est ullamcorper sollicitudin. Proin a leo sit amet nunc malesuada imperdiet pharetra ut eros.<br><br> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec massa enim. Aliquam viverra at est ullamcorper sollicitudin. Proin a leo sit amet nunc malesuada imperdiet pharetra ut eros. <br><br>Mauris vel nunc at ipsum fermentum pellentesque quis ut massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas non adipiscing massa. Sed ut fringilla sapien. Cras sollicitudin, lectus sed tincidunt cursus, magna lectus vehicula augue, a lobortis dui orci et est.','zerif-lite')));
		$wp_customize->add_control( 'zerif_aboutus_text', array(
				'label'    => __( 'Texte', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_main_section',
				'settings' => 'zerif_aboutus_text',
				'priority'    => 5,
		));

	else:	/* Old versions of WordPress */
		$wp_customize->add_section( 'zerif_aboutus_section' , array(
				'title'       => __( 'About us section', 'zerif-lite' ),
				'priority'    => 34
		));
		/* about us show/hide */
		$wp_customize->add_setting( 'zerif_aboutus_show', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control(
			'zerif_aboutus_show',
			array(
				'type' => 'checkbox',
				'label' => __('Hide about us section?','zerif-lite'),
				'section' => 'zerif_aboutus_section',
				'priority'    => 1,
			)
		);
		/* title */
		$wp_customize->add_setting( 'zerif_aboutus_title', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('About','zerif-lite')));
		$wp_customize->add_control( 'zerif_aboutus_title', array(
					'label'    => __( 'Title', 'zerif-lite' ),
					'section'  => 'zerif_aboutus_section',
					'settings' => 'zerif_aboutus_title',
					'priority'    => 2,
		));
		/* subtitle */
		$wp_customize->add_setting( 'zerif_aboutus_subtitle', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('Use this section to showcase important details about your business.','zerif-lite')));
		$wp_customize->add_control( 'zerif_aboutus_subtitle', array(
				'label'    => __( 'Subtitle', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_section',
				'settings' => 'zerif_aboutus_subtitle',
				'priority'    => 3,
		));
		/* big left title */
		$wp_customize->add_setting( 'zerif_aboutus_biglefttitle', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('Everything you see here is responsive and mobile-friendly.','zerif-lite')));
		$wp_customize->add_control( 'zerif_aboutus_biglefttitle', array(
				'label'    => __( 'Big left side title', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_section',
				'settings' => 'zerif_aboutus_biglefttitle',
				'priority'    => 4,
		));
		/* text */
		$wp_customize->add_setting( 'zerif_aboutus_text', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec massa enim. Aliquam viverra at est ullamcorper sollicitudin. Proin a leo sit amet nunc malesuada imperdiet pharetra ut eros.<br><br> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec massa enim. Aliquam viverra at est ullamcorper sollicitudin. Proin a leo sit amet nunc malesuada imperdiet pharetra ut eros. <br><br>Mauris vel nunc at ipsum fermentum pellentesque quis ut massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Maecenas non adipiscing massa. Sed ut fringilla sapien. Cras sollicitudin, lectus sed tincidunt cursus, magna lectus vehicula augue, a lobortis dui orci et est.','zerif-lite')));
		$wp_customize->add_control( 'zerif_aboutus_text', array(
				'label'    => __( 'Text', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_section',
				'settings' => 'zerif_aboutus_text',
				'priority'    => 5,
		));
		/* feature no#1 */
		$wp_customize->add_setting( 'zerif_aboutus_feature1_title', array('sanitize_callback' => 'zerif_sanitize_text', 'default' => __('YOUR SKILL #1','zerif-lite')));
		$wp_customize->add_control( 'zerif_aboutus_feature1_title', array(
				'label'    => __( 'Feature no1 title', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_section',
				'settings' => 'zerif_aboutus_feature1_title',
				'priority'    => 6,
		));
		$wp_customize->add_setting( 'zerif_aboutus_feature1_text', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control( 'zerif_aboutus_feature1_text', array(
				'label'    => __( 'Feature no1 text', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_section',
				'settings' => 'zerif_aboutus_feature1_text',
				'priority'    => 7,
		));
		$wp_customize->add_setting( 'zerif_aboutus_feature1_nr', array('sanitize_callback' => 'zerif_sanitize_number', 'default' => '80'));
		$wp_customize->add_control(
			new Zerif_Customizer_Number_Control(
				$wp_customize,
				'zerif_aboutus_feature1_nr',
				array(
					'type' => 'number',
					'label' => __( 'Feature no1 percentage', 'zerif-lite' ),
					'section' => 'zerif_aboutus_section',
					'settings' => 'zerif_aboutus_feature1_nr',
					'priority'    => 8
				)
			)
		);
		/* feature no#2 */
		$wp_customize->add_setting( 'zerif_aboutus_feature2_title', array('sanitize_callback' => 'zerif_sanitize_text', 'default' => __('YOUR SKILL #2','zerif-lite')));
		$wp_customize->add_control( 'zerif_aboutus_feature2_title', array(
				'label'    => __( 'Feature no2 title', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_section',
				'settings' => 'zerif_aboutus_feature2_title',
				'priority'    => 9,
		));
		$wp_customize->add_setting( 'zerif_aboutus_feature2_text', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control( 'zerif_aboutus_feature2_text', array(
				'label'    => __( 'Feature no2 text', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_section',
				'settings' => 'zerif_aboutus_feature2_text',
				'priority'    => 10,
		));
		$wp_customize->add_setting( 'zerif_aboutus_feature2_nr', array('sanitize_callback' => 'zerif_sanitize_number','default' => '91'));
		$wp_customize->add_control(
			new Zerif_Customizer_Number_Control(
				$wp_customize,
				'zerif_aboutus_feature2_nr',
				array(
					'type' => 'number',
					'label' => __( 'Feature no2 percentage', 'zerif-lite' ),
					'section' => 'zerif_aboutus_section',
					'settings' => 'zerif_aboutus_feature2_nr',
					'priority'    => 11
				)
			)
		);
		/* feature no#3 */
		$wp_customize->add_setting( 'zerif_aboutus_feature3_title', array('sanitize_callback' => 'zerif_sanitize_text', 'default' => __('YOUR SKILL #3','zerif-lite')));
		$wp_customize->add_control( 'zerif_aboutus_feature3_title', array(
				'label'    => __( 'Feature no3 title', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_section',
				'settings' => 'zerif_aboutus_feature3_title',
				'priority'    => 12,
		));
		$wp_customize->add_setting( 'zerif_aboutus_feature3_text', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control( 'zerif_aboutus_feature3_text', array(
				'label'    => __( 'Feature no3 text', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_section',
				'settings' => 'zerif_aboutus_feature3_text',
				'priority'    => 13,
		));
		$wp_customize->add_setting( 'zerif_aboutus_feature3_nr', array('sanitize_callback' => 'zerif_sanitize_number','default' => '88'));
		$wp_customize->add_control(
			new Zerif_Customizer_Number_Control(
				$wp_customize,
				'zerif_aboutus_feature3_nr',
				array(
					'type' => 'number',
					'label' => __( 'Feature no3 percentage', 'zerif-lite' ),
					'section' => 'zerif_aboutus_section',
					'settings' => 'zerif_aboutus_feature3_nr',
					'priority'    => 14
				)
			)
		);
		/* feature no#4 */
		$wp_customize->add_setting( 'zerif_aboutus_feature4_title', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('YOUR SKILL #4','zerif-lite')));
		$wp_customize->add_control( 'zerif_aboutus_feature4_title', array(
				'label'    => __( 'Feature no4 title', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_section',
				'settings' => 'zerif_aboutus_feature4_title',
				'priority'    => 15,
		));
		$wp_customize->add_setting( 'zerif_aboutus_feature4_text', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control( 'zerif_aboutus_feature4_text', array(
				'label'    => __( 'Feature no4 text', 'zerif-lite' ),
				'section'  => 'zerif_aboutus_section',
				'settings' => 'zerif_aboutus_feature4_text',
				'priority'    => 16,
		));
		$wp_customize->add_setting( 'zerif_aboutus_feature4_nr', array('sanitize_callback' => 'zerif_sanitize_number','default' => '95'));
		$wp_customize->add_control(
			new Zerif_Customizer_Number_Control(
				$wp_customize,
				'zerif_aboutus_feature4_nr',
				array(
					'type' => 'number',
					'label' => __( 'Feature no4 percentage', 'zerif-lite' ),
					'section' => 'zerif_aboutus_section',
					'settings' => 'zerif_aboutus_feature4_nr',
					'priority'    => 17
				)
			)
		);
	endif;
	/******************************************/
    /**********	OUR TEAM SECTION **************/
	/******************************************/
	if ( class_exists( 'WP_Customize_Panel' ) ):

		$wp_customize->add_panel( 'panel_ourteam', array(
			'priority' => 35,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'Section équipe', 'zerif-lite' )
		) );

		$wp_customize->add_section( 'zerif_ourteam_section' , array(
				'title'       => __( 'Contenu', 'zerif-lite' ),
				'priority'    => 1,
				'panel'       => 'panel_ourteam'
		));
		/* our team show/hide */
		$wp_customize->add_setting( 'zerif_ourteam_show', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control(
			'zerif_ourteam_show',
			array(
				'type' => 'checkbox',
				'label' => __('Cacher la section ?','zerif-lite'),
				'section' => 'zerif_ourteam_section',
				'priority'    => 1,
			)
		);
		/* our team title */
		$wp_customize->add_setting( 'zerif_ourteam_title', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('YOUR TEAM','zerif-lite')));
		$wp_customize->add_control( 'zerif_ourteam_title', array(
					'label'    => __( 'Titre', 'zerif-lite' ),
					'section'  => 'zerif_ourteam_section',
					'settings' => 'zerif_ourteam_title',
					'priority'    => 2,
		));
		/* our team subtitle */
		$wp_customize->add_setting( 'zerif_ourteam_subtitle', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('Prove that you have real people working for you, with some nice looking profile pictures and links to social media.','zerif-lite')));
		$wp_customize->add_control( 'zerif_ourteam_subtitle', array(
				'label'    => __( 'Sous-titre', 'zerif-lite' ),
				'section'  => 'zerif_ourteam_section',
				'settings' => 'zerif_ourteam_subtitle',
				'priority'    => 3,
		));

	else:

		$wp_customize->add_section( 'zerif_ourteam_section' , array(
				'title'       => __( 'Section notre équipe', 'zerif-lite' ),
				'priority'    => 35,

				'description' => __( 'The main content of this section is customizable in: Customize -> Widgets -> Our team section. There you must add the "Zerif - Team member widget"', 'zerif-lite' )
		));
		/* our team show/hide */
		$wp_customize->add_setting( 'zerif_ourteam_show', array('sanitize_callback' => 'zerif_sanitize_text'));
		$wp_customize->add_control(
			'zerif_ourteam_show',
			array(
				'type' => 'checkbox',
				'label' => __('Hide our team section?','zerif-lite'),
				'section' => 'zerif_ourteam_section',
				'priority'    => 1,
			)
		);
		/* our team title */
		$wp_customize->add_setting( 'zerif_ourteam_title', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('YOUR TEAM','zerif-lite')));
		$wp_customize->add_control( 'zerif_ourteam_title', array(
					'label'    => __( 'Title', 'zerif-lite' ),
					'section'  => 'zerif_ourteam_section',
					'settings' => 'zerif_ourteam_title',
					'priority'    => 2,
		));
		/* our team subtitle */
		$wp_customize->add_setting( 'zerif_ourteam_subtitle', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('Prove that you have real people working for you, with some nice looking profile pictures and links to social media.','zerif-lite')));
		$wp_customize->add_control( 'zerif_ourteam_subtitle', array(
				'label'    => __( 'Our team subtitle', 'zerif-lite' ),
				'section'  => 'zerif_ourteam_section',
				'settings' => 'zerif_ourteam_subtitle',
				'priority'    => 3,
		));

	endif;

		/********************************************************************/
		/*************  OUR FOCUS SECTION **********************************/
		/********************************************************************/
		if ( class_exists( 'WP_Customize_Panel' ) ):
			$wp_customize->add_panel( 'panel_ourfocus', array(
				'priority' => 35,
				'capability' => 'edit_theme_options',
				'theme_supports' => '',
				'title' => __( 'Section compétences', 'zerif-lite' )
			) );
			$wp_customize->add_section( 'zerif_ourfocus_section' , array(
					'title'       => __( 'Contenu', 'zerif-lite' ),
					'priority'    => 1,
					'panel'       => 'panel_ourfocus'
			));
			/* show/hide */
			$wp_customize->add_setting( 'zerif_ourfocus_show', array('sanitize_callback' => 'zerif_sanitize_text'));
			$wp_customize->add_control(
				'zerif_ourfocus_show',
				array(
					'type' => 'checkbox',
					'label' => __('Cacher la section?','zerif-lite'),
					'section' => 'zerif_ourfocus_section',
					'priority'    => 1,
				)
			);
			/* our focus title */
			$wp_customize->add_setting( 'zerif_ourfocus_title', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('FEATURES','zerif-lite')));

				$wp_customize->add_control( 'zerif_ourfocus_title', array(
						'label'    => __( 'Titre', 'zerif-lite' ),
						'section'  => 'zerif_ourfocus_section',
						'settings' => 'zerif_ourfocus_title',
						'priority'    => 2,
			));
			/* our focus subtitle */
			$wp_customize->add_setting( 'zerif_ourfocus_subtitle', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('What makes this single-page WordPress theme unique.','zerif-lite')));
			$wp_customize->add_control( 'zerif_ourfocus_subtitle', array(
					'label'    => __( 'Sous-titre', 'zerif-lite' ),
					'section'  => 'zerif_ourfocus_section',
					'settings' => 'zerif_ourfocus_subtitle',
					'priority'    => 3,
			));

		else:

			$wp_customize->add_section( 'zerif_ourfocus_section' , array(
					'title'       => __( 'Our focus section', 'zerif-lite' ),
					'priority'    => 32,

					'description' => __( 'The main content of this section is customizable in: Customize -> Widgets -> Our focus section. There you must add the "Zerif - Our focus widget"', 'zerif-lite' )
			));
			/* show/hide */
			$wp_customize->add_setting( 'zerif_ourfocus_show', array('sanitize_callback' => 'zerif_sanitize_text'));
			$wp_customize->add_control(
				'zerif_ourfocus_show',
				array(
					'type' => 'checkbox',
					'label' => __('Hide our focus section?','zerif-lite'),
					'section' => 'zerif_ourfocus_section',
					'priority'    => 1,
				)
			);
			/* our focus title */
			$wp_customize->add_setting( 'zerif_ourfocus_title', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('FEATURES','zerif-lite')));

				$wp_customize->add_control( 'zerif_ourfocus_title', array(
						'label'    => __( 'Title', 'zerif-lite' ),
						'section'  => 'zerif_ourfocus_section',
						'settings' => 'zerif_ourfocus_title',
						'priority'    => 2,
			));
			/* our focus subtitle */
			$wp_customize->add_setting( 'zerif_ourfocus_subtitle', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('What makes this single-page WordPress theme unique.','zerif-lite')));
			$wp_customize->add_control( 'zerif_ourfocus_subtitle', array(
					'label'    => __( 'Our focus subtitle', 'zerif-lite' ),
					'section'  => 'zerif_ourfocus_section',
					'settings' => 'zerif_ourfocus_subtitle',
					'priority'    => 3,
			));
		endif;

	/**********************************************/
    /**********	LATEST NEWS SECTION **************/
	/**********************************************/
	$wp_customize->add_section( 'zerif_latestnews_section' , array(
			'title'       => __( 'Section actualité', 'zerif-lite' ),
    	  	'priority'    => 37
	));
	/* latest news show/hide */
	$wp_customize->add_setting( 'zerif_latestnews_show', array('sanitize_callback' => 'zerif_sanitize_text'));
    $wp_customize->add_control(
		'zerif_latestnews_show',
		array(
			'type' => 'checkbox',
			'label' => __('Cacher la section ?','zerif-lite'),
			'section' => 'zerif_latestnews_section',
			'priority'    => 1,
		)
	);
	/* latest news subtitle */
	$wp_customize->add_setting( 'zerif_latestnews_title', array('sanitize_callback' => 'zerif_sanitize_text'));
	$wp_customize->add_control( 'zerif_latestnews_title', array(
			'label'    		=> __( 'Titre', 'zerif-lite' ),
	      	'section'  		=> 'zerif_latestnews_section',
	      	'settings' 		=> 'zerif_latestnews_title',
			'priority'    	=> 2,
	));
	/* latest news subtitle */
	$wp_customize->add_setting( 'zerif_latestnews_subtitle', array('sanitize_callback' => 'zerif_sanitize_text'));
	$wp_customize->add_control( 'zerif_latestnews_subtitle', array(
			'label'    		=> __( 'Sous-titre', 'zerif-lite' ),
	      	'section'  		=> 'zerif_latestnews_section',
	      	'settings' 		=> 'zerif_latestnews_subtitle',
			'priority'   	=> 3,
	));

	/*******************************************************/
    /************	CONTACT US SECTION *********************/
	/*******************************************************/

	$zerif_contact_us_section_description = '';

	/* if Pirate Forms is installed */
	if( defined("PIRATE_FORMS_VERSION") ):
		$zerif_contact_us_section_description = __( 'For more advanced settings please go to Settings -> Pirate Forms','zerif-lite' );
	endif;

	$wp_customize->add_section( 'zerif_contactus_section' , array(
			'title'       => __( 'Section nous contacter', 'zerif-lite' ),
			'description' => $zerif_contact_us_section_description,
    	  	'priority'    => 38
	));
	/* contact us show/hide */
	$wp_customize->add_setting( 'zerif_contactus_show', array('sanitize_callback' => 'zerif_sanitize_text'));
    $wp_customize->add_control(
		'zerif_contactus_show',
		array(
			'type' => 'checkbox',
			'label' => __('Cacher la section ?','zerif-lite'),
			'section' => 'zerif_contactus_section',
			'priority'    => 1,
		)
	);
	/* contactus title */
	$wp_customize->add_setting( 'zerif_contactus_title', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('Get in touch','zerif-lite')));
	$wp_customize->add_control( 'zerif_contactus_title', array(
				'label'    => __( 'Titre', 'zerif-lite' ),
				'section'  => 'zerif_contactus_section',
				'settings' => 'zerif_contactus_title',
				'priority'    => 2,
	));
	/* contactus subtitle */
	$wp_customize->add_setting( 'zerif_contactus_subtitle', array('sanitize_callback' => 'zerif_sanitize_text'));
	$wp_customize->add_control( 'zerif_contactus_subtitle', array(
			'label'    => __( 'Sous-titre', 'zerif-lite' ),
	      	'section'  => 'zerif_contactus_section',
	      	'settings' => 'zerif_contactus_subtitle',
			'priority'    => 3,
	));

	/* contactus email */
	$wp_customize->add_setting( 'zerif_contactus_email', array('sanitize_callback' => 'zerif_sanitize_text'));

	$wp_customize->add_control( 'zerif_contactus_email', array(
				'label'    => __( 'Adresse e-mail', 'zerif-lite' ),
				'section'  => 'zerif_contactus_section',
				'settings' => 'zerif_contactus_email',
				'priority'    => 4,
	));

	/* contactus button label */
	$wp_customize->add_setting( 'zerif_contactus_button_label', array('sanitize_callback' => 'zerif_sanitize_text','default' => __('Send Message','zerif-lite')));

	$wp_customize->add_control( 'zerif_contactus_button_label', array(
				'label'    => __( 'Nom du boutton', 'zerif-lite' ),
				'section'  => 'zerif_contactus_section',
				'settings' => 'zerif_contactus_button_label',
				'priority'    => 5,
	));
	/* recaptcha */
	$wp_customize->add_setting( 'zerif_contactus_recaptcha_show', array('sanitize_callback' => 'zerif_sanitize_text'));
	$wp_customize->add_control(
		'zerif_contactus_recaptcha_show',
		array(
			'type' => 'checkbox',
			'label' => __('cacher reCaptcha?','zerif-lite'),
			'section' => 'zerif_contactus_section',
			'priority'    => 6,
		)
	);

	/* site key */
	$attribut_new_tab = (isset($zerif_accessibility) && ($zerif_accessibility != 1) ? ' target="_blank"' : '' );
	$wp_customize->add_setting( 'zerif_contactus_sitekey', array('sanitize_callback' => 'zerif_sanitize_text'));
	$wp_customize->add_control( 'zerif_contactus_sitekey', array(
				'label'    => __( 'Site key', 'zerif-lite' ),
				'description' => '<a'.$attribut_new_tab.' href="https://www.google.com/recaptcha/admin#list">'.__('Create an account here','zerif-lite').'</a> to get the Site key and the Secret key for the reCaptcha.',
				'section'  => 'zerif_contactus_section',
				'settings' => 'zerif_contactus_sitekey',
				'priority'    => 7,
	));
	/* secret key */
	$wp_customize->add_setting( 'zerif_contactus_secretkey', array('sanitize_callback' => 'zerif_sanitize_text'));
	$wp_customize->add_control( 'zerif_contactus_secretkey', array(
				'label'    => __( 'Secret key', 'zerif-lite' ),
				'section'  => 'zerif_contactus_section',
				'settings' => 'zerif_contactus_secretkey',
				'priority'    => 8,
	));
}
add_action( 'customize_register', 'zerif_customize_register' );
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function zerif_customize_preview_js() {
	wp_enqueue_script( 'zerif_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'zerif_customize_preview_js' );
function zerif_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
function zerif_sanitize_pro_version( $input ) {
    return $input;
}
function zerif_sanitize_number( $input ) {
    return force_balance_tags( $input );
}
