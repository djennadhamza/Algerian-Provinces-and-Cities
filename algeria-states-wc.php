<?php
/**
 * Plugin Name: Algerian Provinces for WooCommerce V2
 * Plugin URI: https://devrisemedia.com
 * Description: Integrates Algerian provinces (wilayas) and cities with WooCommerce checkout fields اضافة ولايات ومدن الجزائر للدفع عند الاستلام مجانية تماما
 * Version: 2.2.9
 * Author: Djennad Hamza
 * Author URI: https://devrisemedia.com
 * Text Domain: algeria-states-wc 2
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * WC requires at least: 3.0.0
 * WC tested up to: 8.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('ASWC_VERSION', '1.0.0');
define('ASWC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ASWC_PLUGIN_URL', plugin_dir_url(__FILE__));

// Declare HPOS compatibility
add_action('before_woocommerce_init', function() {
    if (class_exists(\Automattic\WooCommerce\Utilities\FeaturesUtil::class)) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility('custom_order_tables', __FILE__, true);
    }
});

// Check if WooCommerce is active
function aswc_check_woocommerce() {
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', function() {
            echo '<div class="error"><p>';
            echo __('Algeria States for WooCommerce requires WooCommerce to be installed and active.', 'algeria-states-wc');
            echo '</p></div>';
        });
        return false;
    }
    return true;
}

// Initialize plugin
function aswc_init() {
    if (!aswc_check_woocommerce()) {
        return;
    }
    
    // Load text domain
    load_plugin_textdomain('algeria-states-wc', false, dirname(plugin_basename(__FILE__)) . '/languages');
    
    // Include required files
    require_once ASWC_PLUGIN_DIR . 'includes/class-aswc-states.php';
    require_once ASWC_PLUGIN_DIR . 'includes/class-aswc-ajax.php';
    require_once ASWC_PLUGIN_DIR . 'includes/class-aswc-admin.php';

    // Initialize classes
    new ASWC_States();
    new ASWC_Ajax();
    if (is_admin()) {
        new ASWC_Admin();
    }
}
add_action('plugins_loaded', 'aswc_init');

// Higher priority to ensure WooCommerce loads first
function aswc_enqueue_scripts() {
    // Debugging info
    global $wp;
    //error_log('[Enqueue Scripts] Current page: ' . $_SERVER['REQUEST_URI']);
    //error_log('[Enqueue Scripts] is_checkout() check: ' . (function_exists('is_checkout') && is_checkout() ? 'true' : 'false'));

    // Primarily rely on is_checkout() now
    if (function_exists('is_checkout') && is_checkout()) {
        //error_log('[Enqueue Scripts] Checkout page detected, enqueuing script.');
        $version = time(); // Use time() for cache busting during development
        
        wp_enqueue_script(
            'aswc-checkout',
            ASWC_PLUGIN_URL . 'assets/js/checkout.js',
            array('jquery', 'wc-checkout'), // Ensure wc-checkout dependency
            $version,
            true
        );

        wp_localize_script('aswc-checkout', 'aswc_params', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('aswc-nonce'), // Ensure nonce matches AJAX handler check
            'statesTxt' => __('Select a state first', 'algeria-states-wc'),
            'citiesLoadingTxt' => __('Loading cities...', 'algeria-states-wc'),
            'citiesTxt' => __('Select a city...', 'algeria-states-wc'),
            'noCitiesTxt' => __('Error loading cities', 'algeria-states-wc'),
        ));
        
        //error_log('[Enqueue Scripts] Script enqueued.');
    } else {
       // error_log('[Enqueue Scripts] Not on checkout page.');
    }
}
// Ensure this action runs after WooCommerce scripts (priority 20 is usually good)
add_action('wp_enqueue_scripts', 'aswc_enqueue_scripts', 20);

add_filter('woocommerce_get_country_locale', function( $locale ) {

	$locale['DZ']['postcode']['required'] = false;
	$locale['DZ']['postcode']['hidden'] = true;

    $locale['DZ']['address_1'] = [
		'required' => false,
		'hidden'   => true,
	];

    $locale['DZ']['phone'] = [
		'required' => true,
	];

    $locale['DZ']['city']['type'] = "select";

	 return $locale;
});