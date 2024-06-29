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

if ( ! class_exists( 'Cart_Main' ) ) {
	class Cart_Main {

		function __construct() {
			add_action( 'template_redirect', array( $this, 'cart_handle_actions' ) );
			add_shortcode( 'dokaani_cart_products', array( $this, 'cart_products_shortcode' ) );
			add_shortcode( 'dokaani_cart', array( $this, 'cart_shortcode' ) );


		}

		function cart_handle_actions() {
			if ( isset( $_GET['add_to_cart'] ) ) {
				$this->cart_add_item( $_GET['add_to_cart'] );
				wp_redirect( remove_query_arg( 'add_to_cart' ) );
				exit;
			}

			if ( isset( $_GET['remove_item'] ) ) {
				$this->cart_remove_item( $_GET['remove_item'] );
				wp_redirect( remove_query_arg( 'remove_item' ) );
				exit;
			}

			if ( isset( $_GET['clear_cart'] ) ) {
				$this->cart_clear();
				wp_redirect( remove_query_arg( 'clear_cart' ) );
				exit;
			}
		}


		function cart_add_item( $product_id ) {
			$cart = isset( $_COOKIE['dokaani_cart'] ) ? json_decode( stripslashes( $_COOKIE['dokaani_cart'] ), true ) : array();

			if ( isset( $cart[ $product_id ] ) ) {
				$cart[ $product_id ] ++;
			} else {
				$cart[ $product_id ] = 1;
			}

			setcookie( 'dokaani_cart', json_encode( $cart ), time() + ( 86400 * 30 ), "/" );
		}


		function cart_display_products() {
			$args = array(
				'post_type'      => 'product',
				'posts_per_page' => - 1,
			);

			$query = new WP_Query( $args );
			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();
					$thumb_url = get_post_meta( get_the_ID(), 'dokaani_product_thumb_url', true ) ?? ''; ?>

                    <div class="col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                        <div class="bg-gray-100 rounded-lg border border-gray-300 p-7">
                            <div class="">
                                <img src="<?php echo $thumb_url ?>" alt="Dual Antenna WiFi IP Camera" class="w-full h-auto rounded-md mb-4">
                            </div>
                            <div class="text-center">
                                <div class="flex justify-center gap-1 mb-3">
                                <span>
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.50009 11.6721L10.7855 13.6592C11.3872 14.0234 12.1234 13.485 11.9651 12.8042L11.0943 9.06752L13.9997 6.55002C14.5301 6.09085 14.2451 5.22002 13.5484 5.1646L9.72467 4.84002L8.22842 1.30918C7.95926 0.667935 7.04092 0.667935 6.77176 1.30918L5.2755 4.8321L1.45175 5.15669C0.755088 5.2121 0.470088 6.08294 1.0005 6.5421L3.90592 9.0596L3.03509 12.7963C2.87675 13.4771 3.613 14.0154 4.21467 13.6513L7.50009 11.6721Z" fill="#FE586E"></path>
                                    </svg>
                                </span>
                                    <span>
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.50009 11.6721L10.7855 13.6592C11.3872 14.0234 12.1234 13.485 11.9651 12.8042L11.0943 9.06752L13.9997 6.55002C14.5301 6.09085 14.2451 5.22002 13.5484 5.1646L9.72467 4.84002L8.22842 1.30918C7.95926 0.667935 7.04092 0.667935 6.77176 1.30918L5.2755 4.8321L1.45175 5.15669C0.755088 5.2121 0.470088 6.08294 1.0005 6.5421L3.90592 9.0596L3.03509 12.7963C2.87675 13.4771 3.613 14.0154 4.21467 13.6513L7.50009 11.6721Z" fill="#FE586E"></path>
                                    </svg>
                                </span>
                                    <span>
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.50009 11.6721L10.7855 13.6592C11.3872 14.0234 12.1234 13.485 11.9651 12.8042L11.0943 9.06752L13.9997 6.55002C14.5301 6.09085 14.2451 5.22002 13.5484 5.1646L9.72467 4.84002L8.22842 1.30918C7.95926 0.667935 7.04092 0.667935 6.77176 1.30918L5.2755 4.8321L1.45175 5.15669C0.755088 5.2121 0.470088 6.08294 1.0005 6.5421L3.90592 9.0596L3.03509 12.7963C2.87675 13.4771 3.613 14.0154 4.21467 13.6513L7.50009 11.6721Z" fill="#FE586E"></path>
                                    </svg>
                                </span>
                                    <span>
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.50009 11.6721L10.7855 13.6592C11.3872 14.0234 12.1234 13.485 11.9651 12.8042L11.0943 9.06752L13.9997 6.55002C14.5301 6.09085 14.2451 5.22002 13.5484 5.1646L9.72467 4.84002L8.22842 1.30918C7.95926 0.667935 7.04092 0.667935 6.77176 1.30918L5.2755 4.8321L1.45175 5.15669C0.755088 5.2121 0.470088 6.08294 1.0005 6.5421L3.90592 9.0596L3.03509 12.7963C2.87675 13.4771 3.613 14.0154 4.21467 13.6513L7.50009 11.6721Z" fill="#FE586E"></path>
                                    </svg>
                                </span>
                                    <span>
                                    <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.50009 11.6721L10.7855 13.6592C11.3872 14.0234 12.1234 13.485 11.9651 12.8042L11.0943 9.06752L13.9997 6.55002C14.5301 6.09085 14.2451 5.22002 13.5484 5.1646L9.72467 4.84002L8.22842 1.30918C7.95926 0.667935 7.04092 0.667935 6.77176 1.30918L5.2755 4.8321L1.45175 5.15669C0.755088 5.2121 0.470088 6.08294 1.0005 6.5421L3.90592 9.0596L3.03509 12.7963C2.87675 13.4771 3.613 14.0154 4.21467 13.6513L7.50009 11.6721Z" fill="#FE586E"></path>
                                    </svg>
                                </span>
                                </div>
                                <h6 class="text-lg font-semibold text-gray-950 mb-3"><?php echo get_post_meta( get_the_ID(), 'post_title', true ); ?></h6>
                                <div class="flex items-center justify-center space-x-2 mb-8">
                                    <span class="line-through text-base font-bold text-gray-300">$<?php echo get_post_meta( get_the_ID(), 'dokaani_product_regular_price', true ); ?></span>
                                    <span class="text-base font-bold text-gray-950">$<?php echo get_post_meta( get_the_ID(), 'dokaani_product_sale_price', true ); ?></span>
                                </div>
                                <button class="text-base font-roboto font-medium text-gray-950 hover:text-white px-8 py-2 rounded-full border border-primary-700 hover:bg-primary-700"><a href="?add_to_cart=<?php echo get_the_ID(); ?>"><?php echo esc_html__('Add to cart','dokaani-cart') ?></a></button>
                            </div>
                        </div>
                    </div>

				<?php }
				wp_reset_postdata();
			}
		}


		function cart_products_shortcode() {
			ob_start();
			$this->cart_display_products();

			return ob_get_clean();
		}


		function cart_display() {
			$product_ids = isset( $_COOKIE['dokaani_cart'] ) ? json_decode( stripslashes( $_COOKIE['dokaani_cart'] ), true ) : array();
			if ( $product_ids && is_array( $product_ids ) ) {
				foreach ( $product_ids as $product_id => $value ):
					$thumb_url = get_post_meta( $product_id, 'dokaani_product_thumb_url', true );
					?>
                    <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6">
                        <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                            <a href="#" class="shrink-0 md:order-1">
                                <img class="h-20 w-20 dark:hidden" src="<?php echo $thumb_url; ?>" alt="imac image">
                                <img class="hidden h-20 w-20 dark:block" src="https://flowbite.s3.amazonaws.com/blocks/e-commerce/imac-front-dark.svg" alt="imac image">
                            </a>

                            <label for="counter-input" class="sr-only"><?php echo esc_html__('Choose quantity:','dokaani-cart') ?></label>
                            <div class="flex items-center justify-between md:order-3 md:justify-end">
                                <div class="flex items-center">
                                    <button type="button" id="decrement-button" data-input-counter-decrement="counter-input" class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                        <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"></path>
                                        </svg>
                                    </button>
                                    <input type="text" id="counter-input" data-input-counter="" class="w-10 shrink-0 border-0 bg-transparent text-center text-sm font-medium text-gray-900 focus:outline-none focus:ring-0 dark:text-white" placeholder="" value="2" required="">
                                    <button type="button" id="increment-button" data-input-counter-increment="counter-input" class="inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-md border border-gray-300 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                                        <svg class="h-2.5 w-2.5 text-gray-900 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-end md:order-4 md:w-32">
                                    <p class="text-base font-bold text-gray-900 dark:text-white">$<?php echo get_post_meta( $product_id, 'dokaani_product_sale_price', true ); ?></p>
                                </div>
                            </div>

                            <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                                <a href="#" class="text-base font-medium text-gray-900 hover:underline dark:text-white hover:text-gray-900"><?php echo get_post_meta( $product_id, 'post_content', true ); ?></a>

                                <div class="flex items-center gap-4">
                                    <button type="button" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 hover:underline dark:text-gray-400 dark:hover:text-white">
                                        <svg class="me-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.01 6.001C6.5 1 1 8 5.782 13.001L12.011 20l6.23-7C23 8 17.5 1 12.01 6.002Z"></path>
                                        </svg>
                                       <?php echo esc_html__(' Add to Favorites','dokaani_cart') ?>
                                    </button>

                                    <button type="button" class="inline-flex items-center text-sm font-medium text-red-600 hover:underline dark:text-red-500">
                                        <svg class="me-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6"></path>
                                        </svg>
                                        <a href="?remove_item=<?php echo $product_id; ?>"><?php echo esc_html__( 'Remove','dokaani_cart' ) ?></a>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php endforeach;
			}
		}


		function cart_shortcode() {
			ob_start();
			$this->cart_display();

			return ob_get_clean();
		}


		function cart_remove_item( $product_id ) {
			$cart = isset( $_COOKIE['dokaani_cart'] ) ? json_decode( stripslashes( $_COOKIE['dokaani_cart'] ), true ) : array();

			if ( isset( $cart[ $product_id ] ) ) {
				unset( $cart[ $product_id ] );
			}

			setcookie( 'dokaani_cart', json_encode( $cart ), time() + ( 86400 * 30 ), "/" );
		}


		function cart_clear() {
			setcookie( 'dokaani_cart', '', time() - 3600, "/" );
		}


	}

	new Cart_Main();
}



