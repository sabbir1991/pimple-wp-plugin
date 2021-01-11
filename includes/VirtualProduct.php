<?php
namespace rtCamp\DI;

use rtCamp\DI\ProductInterface;
use rtCamp\DI\AbstractProduct;

/**
 * Simple Product class
 *
 * @since 1.0.0
 */
class VirtualProduct extends AbstractProduct implements ProductInterface {

    /**
    * Load automatically when class loaded
    *
    * @since 1.0.0
    *
    * @return void
    */
    public function get_renderer_class() {
        return VirtualProductRenderer::class;
    }
}
