<?php
namespace rtCamp\DI;

/**
 * Abstruct of product class
 *
 * @since 1.0.0
 */
abstract class AbstractProduct {

    protected $data = [];

    /**
     * undocumented function
     *
     * @since 1.0.0
     *
     * @return void
     **/
    public function __construct( $product ) {
        $this->data = $product; // Apply any kind of sanitizations
    }

    /**
     * Get title
     */
    public function get_title() {
        return $this->data['title'];
    }


    /**
     * Gets the description.
     */
    public function get_description() {
        return $this->data['description'];
    }

    /**
     * Gets the sku.
     */
    public function get_sku() {
        return $this->data['sku'];
    }

    /**
     * Gets the type.
     */
    public function get_type() {
        return $this->data['type'];
    }

    /**
     * Gets the price.
     */
    public function get_price() {
        return $this->data['price'];
    }

    /**
     * Sets the title.
     */
    public function set_title( $title ) {
        $this->data['title'] = $title;
    }

    /**
     * Sets the description.
     */
    public function set_description( $descrption ) {
        $this->data['description'] = $description;
    }

    /**
     * Sets the sku.
     */
    public function set_sku( $sku ) {
        $this->data['sku'] = $sku;
    }

    /**
     * Sets the type.
     */
    public function set_type( $type ) {
        $this->data['type'] = $type;
    }

    /**
     * Sets the type.
     */
    public function set_price( $price ) {
        $this->data['type'] = $price;
    }

    /**
     * Get rendererd class
     *
     * @since 1.0.0
     *
     * @return void
     **/
    public function get_renderer() {
        $renderer_class = $this->get_renderer_class();
        return new $renderer_class( $this );
    }
}