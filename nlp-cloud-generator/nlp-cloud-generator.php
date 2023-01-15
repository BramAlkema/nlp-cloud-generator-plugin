<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://none
 * @since             1.0.0
 * @package           Nlp_Cloud_Generator
 *
 * @wordpress-plugin
 * Plugin Name:       NLP Cloud Generator
 * Plugin URI:        https://none
 * Description:       Connect to NLP CLoud API to generate posts based on a title
 * Version:           1.0.0
 * Author:            Jopie
 * Author URI:        https://none
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nlp-cloud-generator
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NLP_CLOUD_GENERATOR_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nlp-cloud-generator-activator.php
 */
function activate_nlp_cloud_generator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nlp-cloud-generator-activator.php';
	Nlp_Cloud_Generator_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nlp-cloud-generator-deactivator.php
 */
function deactivate_nlp_cloud_generator() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nlp-cloud-generator-deactivator.php';
	Nlp_Cloud_Generator_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nlp_cloud_generator' );
register_deactivation_hook( __FILE__, 'deactivate_nlp_cloud_generator' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nlp-cloud-generator.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nlp_cloud_generator() {

	$plugin = new Nlp_Cloud_Generator();
	$plugin->run();

}
run_nlp_cloud_generator();
