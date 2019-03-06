<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.saberser.com.pt/developers/
 * @since      1.0.0
 *
 * @package    So_Hydrogen
 * @subpackage So_Hydrogen/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    So_Hydrogen
 * @subpackage So_Hydrogen/includes
 * @author     Carlos Artur Matos <carlos.matos@saberser.com.pt>
 */
class So_Hydrogen_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'so-hydrogen',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
