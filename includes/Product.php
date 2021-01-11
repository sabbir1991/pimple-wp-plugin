<?php
namespace rtCamp\DI;

use WP_Error;

/**
 * Product factory / Manager class
 *
 * @since 1.0.0
 */
class Product {

    /**
     * Get all products
     *
     * @since 1.0.0
     *
     * @return array
     **/
    public function all( $args = [] ) {
        global $wpdb;

        $results = array();
        $products = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}rt_products WHERE 1=%d", 1 ), ARRAY_A );

        if ( ! empty( $products ) ) {
            foreach ( $products as $key => $product ) {
                $class = 'simple' === $product['type'] ? SimpleProduct::class : VirtualProduct::class;
                $results[] = new $class( $product );
            }
        }

        return $results;
    }

    /**
     * Get a single product object
     *
     * @since 1.0.0
     *
     * @return Object
     **/
    public function get( $id ) {
        global $wpdb;

        if ( empty( $id ) ) {
            return false;
        }

        $product = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}rt_products WHERE `id`=%d", $id ), ARRAY_A );

        if ( empty( $product ) ) {
            return false;
        }

        $class = 'simple' === $product['type'] ? SimpleProduct::class : VirtualProduct::class;

        return new $class( $product );
    }

    /**
     * Create a new product
     *
     * @since 1.0.0
     *
     * @return Object
     **/
    public function create( $args = array() ) {
        global $wpdb;

        $defaults = array(
            'user_id'     => get_current_user_id(),
            'title'       => '',
            'description' => '',
            'price'       => '',
            'sku'         => '',
            'type'        => '',
        );

        $params = wp_parse_args( $args, $defaults );

        if ( empty( $params['title'] ) ) {
            return new WP_Error( 'no-title', __( 'No title found', 'rtcamp-di' ), array( 'status' => 401 ) );
        }

        if ( empty( $params['description'] ) ) {
            return new WP_Error( 'no-description', __( 'No description found', 'rtcamp-di' ), array( 'status' => 401 ) );
        }

        $wpdb->insert( $wpdb->prefix . 'rt_products',
            $params,
            array( '%d', '%s', '%s', '%d', '%s', '%s' ) );

        if ( ! $wpdb->insert_id ) {
            return new WP_Error( 'no-product-created', __( 'Something wrong, please try again', 'rtcamp-di' ), array( 'status' => 401 ) );
        }

        return $this->get( $wpdb->insert_id );
    }
}