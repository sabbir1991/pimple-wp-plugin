<?php
namespace rtCamp\DI;

use Pimple\Container;
use rtCamp\DI\SimpleProduct;
use rtCamp\DI\Product;

/**
 * Container class
 *
 * Hold all instance objects
 *
 * @since 1.0.0
 */
class ContainerWrapper {

    /**
     * Hold Container array
     */
    private $container;

    /**
    * Load automatically when class loaded
    *
    * @since 1.0.0
    *
    * @return void
    */
    public function __construct() {
        $this->container = new Container();

        /* If you need to initialize also DB class as container then comment out it */
        // $this->container['wpdb'] = function ($c) {
        //     global $wpdb;
        //     return $wpdb;
        // };

        $this->container['product'] = function ($c) {
            return new Product();
        };
    }

    /**
     * Get all container arrays
     *
     * @return array
     */
    public function get_container() {
        return $this->container;
    }
}
