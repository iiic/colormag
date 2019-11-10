<?php
/**
 * Class to include Footer customize options.
 *
 * Class ColorMag_Customize_Footer_Options
 *
 * @package    ThemeGrill
 * @subpackage ColorMag
 * @since      ColorMag 2.0.0
 */

/**
 * Class to include Footer customize option.
 *
 * Class ColorMag_Customize_Footer_Options
 */
class ColorMag_Customize_Footer_Options extends ColorMag_Customize_Base_Option {

	/**
	 * Include customize options.
	 *
	 * @param array                 $options
	 * @param \WP_Customize_Manager $wp_customize
	 *
	 * @return mixed|void
	 */
	public function customizer_options( $options, $wp_customize ) {

		// Transport postMessage variable set
		$customizer_selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

		$wp_customize->add_panel( 'colormag_footer_options', array(
			'capability'  => 'edit_theme_options',
			'description' => esc_html__( 'Change the Footer Settings from here as you want', 'colormag' ),
			'priority'    => 515,
			'title'       => esc_html__( 'Footer Options', 'colormag' ),
		) );

		// Footer display type option
		$wp_customize->add_section( 'colormag_main_footer_layout_display_type_section', array(
			'priority' => 1,
			'title'    => esc_html__( 'Footer Main Area Display Type', 'colormag' ),
			'panel'    => 'colormag_footer_options',
		) );

		$wp_customize->add_setting( 'colormag_main_footer_layout_display_type', array(
			'default'           => 'type_one',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'colormag_radio_select_sanitize',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'colormag_main_footer_layout_display_type', array(
			'type'    => 'radio',
			'label'   => esc_html__( 'Choose the main total footer area display type that you want', 'colormag' ),
			'section' => 'colormag_main_footer_layout_display_type_section',
			'choices' => array(
				'type_one' => esc_html__( 'Type 1 (Default)', 'colormag' ),
				'type_two' => esc_html__( 'Type 2', 'colormag' ),
			),
		) );

	}

}

return new ColorMag_Customize_Footer_Options();
