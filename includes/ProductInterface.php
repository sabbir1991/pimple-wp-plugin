<?php
namespace rtCamp\DI;

/**
 * Base class interface
 *
 * @since 1.0.0
 */
interface ProductInterface {

    public function get_renderer_class();
    public function get_title();
    public function get_description();
    public function get_sku();
    public function get_type();

    public function set_title( $title );
    public function set_description( $description );
    public function set_sku( $sku );
    public function set_type( $type );
}