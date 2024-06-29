<?php

/*
	Plugin Name: Dokaani Cart Plugin
	Plugin URI: https://dokaani.com/
	Description: Dokaani Cart Plugin.
	Version: 1.0.3
	Text Domain: dokaani-cart
	Author: dokaani
	License: GPLv2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) || exit;

function dokaani_cart_get_sample_products() {
	return array(
		1 => array( 'title' => 'Sample Product 1', 'price' => 10 ),
		2 => array( 'title' => 'Sample Product 2', 'price' => 20 ),
		3 => array( 'title' => 'Sample Product 3', 'price' => 30 ),
		4 => array( 'title' => 'Sample Product 4', 'price' => 30 ),
		5 => array( 'title' => 'Sample Product 5', 'price' => 70 ),
	);
}

function dokaani_cart_add_item( $product_id ) {
	$cart = isset( $_COOKIE['dokaani_cart'] ) ? json_decode( stripslashes( $_COOKIE['dokaani_cart'] ), true ) : array();

	if ( isset( $cart[ $product_id ] ) ) {
		$cart[ $product_id ] ++;
	} else {
		$cart[ $product_id ] = 1;
	}

	setcookie( 'dokaani_cart', json_encode( $cart ), time() + ( 86400 * 30 ), "/" );
}

function dokaani_cart_remove_item( $product_id ) {
	$cart = isset( $_COOKIE['dokaani_cart'] ) ? json_decode( stripslashes( $_COOKIE['dokaani_cart'] ), true ) : array();

	if ( isset( $cart[ $product_id ] ) ) {
		unset( $cart[ $product_id ] );
	}

	setcookie( 'dokaani_cart', json_encode( $cart ), time() + ( 86400 * 30 ), "/" );
}

function dokaani_cart_clear() {
	setcookie( 'dokaani_cart', '', time() - 3600, "/" );
}

function dokaani_cart_display() {
	$cart     = isset( $_COOKIE['dokaani_cart'] ) ? json_decode( stripslashes( $_COOKIE['dokaani_cart'] ), true ) : array();
	$products = dokaani_cart_get_sample_products();

	if ( ! empty( $cart ) ) {
		echo '<ul>';
		foreach ( $cart as $product_id => $quantity ) {
			if ( isset( $products[ $product_id ] ) ) {
				$product = $products[ $product_id ];
				?>
                <div class="product-carts">
                    <div class="product-cart">
                        <div class="name"><?php echo $product['title']; ?></div>
                        <div class="price"><?php echo 'Price - ' . $product['price']; ?></div>
                        <div class="price"><?php echo 'Quantity - ' . $quantity; ?></div>
                        <div class="cart-btn"><a href="?remove_item=<?php echo $product_id; ?>">Remove</a></div>
                    </div>
                </div>
			<?php }
		}
		echo '</ul>';
		echo '<a href="?clear_cart=true">Clear Cart</a>';
	}
}

function dokaani_cart_handle_actions() {
	if ( isset( $_GET['add_to_cart'] ) ) {
		dokaani_cart_add_item( $_GET['add_to_cart'] );
		wp_redirect( remove_query_arg( 'add_to_cart' ) );
		exit;
	}

	if ( isset( $_GET['remove_item'] ) ) {
		dokaani_cart_remove_item( $_GET['remove_item'] );
		wp_redirect( remove_query_arg( 'remove_item' ) );
		exit;
	}

	if ( isset( $_GET['clear_cart'] ) ) {
		dokaani_cart_clear();
		wp_redirect( remove_query_arg( 'clear_cart' ) );
		exit;
	}
}

add_action( 'template_redirect', 'dokaani_cart_handle_actions' );

function dokaani_cart_shortcode() {
	ob_start();
	dokaani_cart_display();

	return ob_get_clean();
}

add_shortcode( 'dokaani_cart', 'dokaani_cart_shortcode' );

function dokaani_cart_display_products() {
	$products = dokaani_cart_get_sample_products();
	$cart     = isset( $_COOKIE['dokaani_cart'] ) ? json_decode( stripslashes( $_COOKIE['dokaani_cart'] ), true ) : array();

	echo '<pre>';
	print_r( $cart );
	echo '</pre>';

	echo '<ul>';
	foreach ( $products as $product_id => $product ) { ?>
        <div class="product-carts">
            <div class="product-cart">
                <div class="name"><?php echo $product['title']; ?></div>
                <div class="price"><?php echo 'Price - ' . $product['price']; ?></div>
				<?php if ( in_array(  $product_id ,$cart) ) { ?>
                    <div class="cart-btn"><a href="?add_to_cart=<?php echo $product_id; ?>">Added</a></div>
				<?php } else { ?>
                    <div class="cart-btn"><a href="?add_to_cart=<?php echo $product_id; ?>">Add to Cart</a></div>
				<?php }; ?>

            </div>
        </div>
	<?php }
	echo '</ul>';
}

function dokaani_cart_products_shortcode() {
	ob_start();
	dokaani_cart_display_products();

	return ob_get_clean();
}

add_shortcode( 'dokaani_cart_products', 'dokaani_cart_products_shortcode' );

add_action( 'wp_footer', 'stylesheet' );

function stylesheet() {
	?>
    <style>
        .product-carts {
            width: 30%;
            height: 106px;
            border: 1px solid #ccc;
            margin-bottom: 10px;
            border-radius: 5px;
            padding: 10px;
        }
    </style>
	<?php
}
