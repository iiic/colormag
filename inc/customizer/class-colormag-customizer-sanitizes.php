<?php
/**
 * ColorMag customizer class for theme customize sanitizes.
 *
 * Class ColorMag_Customizer_Sanitizes
 *
 * @package    ThemeGrill
 * @subpackage ColorMag
 * @since      ColorMag 2.0.0
 */

/**
 * ColorMag customizer class for theme customize callbacks.
 *
 * Class ColorMag_Customizer_Sanitizes
 */
class ColorMag_Customizer_Sanitizes {

	/**
	 * Sanitize the checkbox options set within customizer controls.
	 *
	 * @param int $input Input from the customize controls.
	 *
	 * @return int|string
	 */
	public static function sanitize_checkbox( $input ) {

		if ( $input == 1 ) {
			return 1;
		} else {
			return '';
		}

	}

	/**
	 * Sanitize the text editor strings set within customizer controls.
	 *
	 * @param string $input Input from the customize controls.
	 *
	 * @return string
	 */
	public static function sanitize_text_editor( $input ) {

		if ( isset( $input ) ) {
			$input = stripslashes( wp_filter_post_kses( addslashes( $input ) ) );
		}

		return $input;

	}

	/**
	 * Sanitize the radio as well as select options set within customizer controls.
	 *
	 * @param string               $input   Input from the customize controls.
	 * @param WP_Customize_Setting $setting Setting instance.
	 *
	 * @return string
	 */
	public static function sanitize_radio_select( $input, $setting ) {

		// Ensuring that the input is a slug.
		$input = sanitize_key( $input );

		// Get the list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it, else, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

	}

	/**
	 * Sanitize the hex color set within customizer controls.
	 *
	 * @param string $color Input from the customize controls.
	 *
	 * @return string
	 */
	public static function sanitize_hex_color( $color ) {

		if ( '' === $color ) {
			return '';
		}

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}

	}

	/**
	 * Sanitize the alpha color set within customizer controls.
	 *
	 * @param string $color Input from the customize controls.
	 *
	 * @return string
	 */
	public static function sanitize_alpha_color( $color ) {

		if ( '' === $color ) {
			return '';
		}

		// Hex sanitize if no rgba color option is chosen.
		if ( false === strpos( $color, 'rgba' ) ) {
			return self::sanitize_hex_color( $color );
		}

		// Sanitize the rgba color provided via customize option.
		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

		return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';

	}

	/**
	 * Sanitize false values within customizer controls, which user does not have to input by their own.
	 *
	 * @return bool
	 */
	public static function sanitize_false_values() {

		return false;

	}

	/**
	 * Sanitize the slider value set within customizer controls.
	 *
	 * @param number $val     Customizer setting input number.
	 * @param object $setting Setting object.
	 *
	 * @return int
	 */
	public static function sanitize_slider( $val, $setting ) {

		$input_attrs = $setting->manager->get_control( $setting->id )->input_attrs;

		if ( isset( $input_attrs ) ) {

			$input_attrs['min']  = isset( $input_attrs['min'] ) ? $input_attrs['min'] : 0;
			$input_attrs['step'] = isset( $input_attrs['step'] ) ? $input_attrs['step'] : 1;

			if ( isset( $input_attrs['max'] ) && $val > $input_attrs['max'] ) {
				$val = $input_attrs['max'];
			} elseif ( $val < $input_attrs['min'] ) {
				$val = $input_attrs['min'];
			}

			if ( $val ) {
				$val = (int) $val;
			}
		}

		return is_numeric( $val ) ? $val : 0;

	}

	/**
	 * Sanitize the dropdown categories value set within customizer controls.
	 *
	 * @param number $cat_id  Customizer setting input category id.
	 * @param object $setting Setting object.
	 *
	 * @return int
	 */
	public static function sanitize_dropdown_categories( $cat_id, $setting ) {

		// Ensure input is an absolute integer.
		$cat_id = absint( $cat_id );

		// If $cat_id is an ID of a published category, return it, otherwise, return the default value.
		return ( term_exists( $cat_id, 'category' ) ? $cat_id : $setting->default );

	}

}
