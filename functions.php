<?php

function my_theme_enqueue_styles() {
	wp_enqueue_style( 'child-style',
					 get_stylesheet_uri(),
					 array( 'hello-elementor-theme-style' ),
					 wp_get_theme()->get ( 'Version' )
					);
	
	wp_enqueue_script('add_to_menu',
					 get_stylesheet_directory_uri() . '/add_to_menu.js',
					  array(),
					  wp_get_theme()->get ('Version'),
					  true
					  );
}

add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles', 11 );

function my_remove_description_tab($tabs)
{
    unset($tabs['description']);
    unset($tabs['reviews']);       // Remove the reviews tab
    unset($tabs['additional_information']);
    return $tabs;
}

function woocommerce_add_to_cart_button_text_single()
{
		function my_button_add_to_cart_text()
	{
	?>
		<span class="elementor-button-content-wrapper">
			<span class="elementor-button-icon elementor-align-icon-left carrinho-checkout">
				<svg aria-hidden="true" class="e-font-icon-svg e-fas-shopping-cart carrinho-checkout" viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
					<path d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"></path>
				</svg></span>
			<span class="elementor-button-text">Adicionar ao carrinho</span>
		</span>
	<? php;
	}
    return __(my_button_add_to_cart_text(), 'woocommerce');
}

function woocommerce_add_to_cart_button_text_archives()
{
    return __('Ver mais', 'woocommerce');
}

add_filter('woocommerce_product_tabs', 'my_remove_description_tab', 11);
add_filter('woocommerce_product_single_add_to_cart_text', 'woocommerce_add_to_cart_button_text_single');
// Change add to cart text on product archives page
add_filter('woocommerce_product_add_to_cart_text', 'woocommerce_add_to_cart_button_text_archives');
add_filter('woocommerce_product_variation_title_include_attributes', '__return_false', 1);

/* não funcionando
add_action( 'wp_head', 'remove_add_to_cart', 11 );
function remove_add_to_cart() {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 0);
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart');
}*/


