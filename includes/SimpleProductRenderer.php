<?php
namespace rtCamp\DI;

use rtCamp\DI\BaseProductRenderer;

/**
 * Simple product renderer
 *
 * @since 1.0.0
 */
class SimpleProductRenderer extends BaseProductRenderer {

    /**
     * Render function
     *
     * @since 1.0.0
     *
     * @return void
     **/
    public function render() {
        ?>
            <li>
                <p><?php echo esc_html( $this->product->get_title() ); ?></p>
                <p><?php echo esc_html( 'Simple' ); ?></p>
                <p><?php echo esc_html( $this->product->get_price() ); ?></p>
            </li>
        <?php
    }
}
