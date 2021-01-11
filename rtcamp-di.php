<?php
/*
Plugin Name: rtCamp DIC
Plugin URI: http://rtcamp.com/
Description: Test project for di and logger implementation
Version: 1.0.0
Author: Sabbir Ahmed
Author URI: http://rtcamp.com/
License: GPL2
*/

/**
 * Copyright (c) YEAR Sabbir Ahmed (email: sabbir.ahmed@rtcamp.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * rtCamp_DI class
 *
 * @class rtCamp_DI The class that holds the entire rtCamp_DI plugin
 */
final class rtCamp_DI {

    /**
     * Hold the instance for singleton
     *
     * @var $instance
     */
    private static $instance = null;

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Plugin version
     *
     * @var string
     */
    private $container_array = array();

    /**
     * Constructor for the rtCamp_DI class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @uses register_activation_hook()
     * @uses register_deactivation_hook()
     * @uses is_admin()
     * @uses add_action()
     */
    private function __construct() {
        // Define all constant
        $this->define_constant();

        $this->includes();

        add_action( 'init', [ $this, 'init_plugin' ], 1 );

        do_action( 'rtcamp_di_loaded', $this );
    }

    /**
     * Magic getter to bypass referencing objects
     *
     * @since 1.0.0
     *
     * @param string $prop
     *
     * @return Class Instance
     */
    public function __get( $prop ) {
        if ( ! empty( $this->container->get_container()->keys( $prop ) ) ) {
            return $this->container->get_container()[ $prop ];
        }
    }

    /**
     * Initializes the rtCamp_DI() class
     *
     * Checks for an existing rtCamp_DI() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     */
    public static function activate() {
        global $wpdb;

        include_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $sql = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}rt_products` (
               `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
               `user_id` bigint(20) unsigned NOT NULL,
               `title` text NOT NULL,
               `description` text NOT NULL,
               `price` decimal(19,4) NOT NULL,
               `sku` varchar(30) NOT NULL,
               `type` varchar(30) NOT NULL,
              PRIMARY KEY (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public static function deactivate() {
        // Do any stuff if when you deactivate your plugin
    }

    /**
    * Defined constant
    *
    * @since 1.0.0
    *
    * @return void
    **/
    public function define_constant() {
        define( 'RTCAMP_DI_VERSION', $this->version );
        define( 'RTCAMP_DI_FILE', __FILE__ );
        define( 'RTCAMP_DI_PATH', dirname( RTCAMP_DI_FILE ) );
        define( 'RTCAMP_DI_ASSETS', plugins_url( '/assets', RTCAMP_DI_FILE ) );
    }

    /**
    * Includes all files
    *
    * @since 1.0.0
    *
    * @return void
    **/
    public function includes() {
        require_once RTCAMP_DI_PATH . '/vendor/autoload.php';
        $this->container = new rtCamp\DI\ContainerWrapper();
    }

    /**
    * Init all actions
    *
    * @since 1.0.0
    *
    * @return void
    **/
    public function init_plugin() {
        add_action( 'init', array( $this, 'localization_setup' ) );
        add_action( 'init', array( $this, 'init_classes' ) );
        add_shortcode( 'rt-products', array( $this, 'get_product_shortcode' ) );
    }

    /**
     * undocumented function
     *
     * @since 1.0.0
     *
     * @return void
     **/
    public function get_product_shortcode( $attr ) {
        $products = rtcamp_di()->product->all();

        foreach ( $products as $key => $product ) {
            $product->get_renderer()->render();
        }
    }

    /**
     * undocumented function
     *
     * @since 1.0.0
     *
     * @return void
     **/
    public function init_classes() {
        // Initialize custom class if needed
    }

    /**
     * Initialize plugin for localization
     *
     * @since 1.0.0
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'rtcamp-di', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

} // rtCamp_DI

function rtcamp_di() {
    return rtCamp_DI::init();
}

rtcamp_di();

register_activation_hook( __FILE__, array( 'rtCamp_DI', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'rtCamp_DI', 'deactivate' ) );
