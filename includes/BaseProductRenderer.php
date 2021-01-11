<?php
namespace rtCamp\DI;

/**
 * Simple product renderer
 *
 * @since 1.0.0
 */
abstract class BaseProductRenderer {

    /**
     * Hold product object
     */
    protected $product;

    /**
     * undocumented function
     *
     * @since 1.0.0
     *
     * @return void
     **/
    public function __construct( $product ) {
        $this->product = $product;
    }
}
