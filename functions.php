<?php

function my_pagseguro_css()
{
	wp_register_style('my-pagseguro-css', get_stylesheet_directory_uri() . '/my-transparent-checkout.css');
	wp_enqueue_style('my-pagseguro-css');
}

function my_theme_enqueue_styles()
{
	wp_enqueue_style(
		'child-style',
		get_stylesheet_uri(),
		array('hello-elementor-theme-style'),
		wp_get_theme()->get('Version')
	);

	wp_enqueue_script(
		'add_to_menu',
		get_stylesheet_directory_uri() . '/add_to_menu.js',
		array(),
		wp_get_theme()->get('Version'),
		true
	);
}

function yikes_hide_tab_title(){
    // Hide our custom tab's title.
    add_filter( 
        'yikes_woocommerce_custom_repeatable_product_tabs_heading', 
        '__return_false', 
        99 
    );

    // Hide the description tab's title.
    add_filter( 'woocommerce_product_description_heading', '__return_false', 99 );

    // Hide the additional information tab's title.
    add_filter( 'woocommerce_product_additional_information_heading', '__return_false', 99 );
}

function addGoogleanalytics() { ?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-TR4962Q');</script>
	<!-- End Google Tag Manager -->
<?php };

function addGoogleanalyticsBody() { ?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TR4962Q"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (nooscript) -->
<?php };

add_action('wp_enqueue_scripts', 'my_pagseguro_css', 11);
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles', 11);
add_action( 'init', 'yikes_hide_tab_title', 10 );
add_action('wp_head', 'addGoogleanalytics');
add_action('wp_body_open', 'addGoogleanalyticsBody');



function my_woocommerce_product_tabs($tabs)
{
	unset($tabs['description']);
	unset($tabs['reviews']);       // Remove the reviews tab
	unset($tabs['additional_information']);
	return $tabs;
}

function my_woocommerce_add_to_cart_button_text_single()
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
<?php
	}
	return __(my_button_add_to_cart_text(), 'woocommerce');
}

function my_woocommerce_product_add_to_cart_text()
{
	return __('Ver mais', 'woocommerce');
}

/**
 * Function for `woocommerce_format_price_range` filter-hook.
 * 
 * @param  $price 
 * @param  $from  
 * @param  $to    
 *
 * @return 
 */
function my_woocommerce_format_price_range($price, $from, $to)
{
	$price = sprintf(_x('Valores de %1$s ?? %2$s', 'Price range: from-to', 'woocommerce'), is_numeric($from) ? wc_price($from) : $from, is_numeric($to) ? wc_price($to) : $to);
	return $price;
}

function my_woocommerce_billing_fields($fields)
{
	## ---- 1.  Sort billing email and phone fields ---- ##
	$fields['billing_number']['priority'] = 62;
	## $fields['billing_number_field']['class'] = array('form-row-first');
	return $fields;
}

function my_custom_add_to_cart_redirect($url)
{
	$url = get_permalink('636');
	## get_permalink(wc_get_page_id('Produtos'));
	return $url;
}


add_filter('woocommerce_product_tabs', 'my_woocommerce_product_tabs', 11);
add_filter('woocommerce_product_single_add_to_cart_text', 'my_woocommerce_add_to_cart_button_text_single');
// Change add to cart text on product archives page
add_filter('woocommerce_product_add_to_cart_text', 'my_woocommerce_product_add_to_cart_text');
add_filter('woocommerce_product_variation_title_include_attributes', '__return_false', 1);
add_filter('woocommerce_format_price_range', 'my_woocommerce_format_price_range', 10, 3);
add_filter('woocommerce_billing_fields', 'my_woocommerce_billing_fields', 20, 1);
add_filter('woocommerce_add_to_cart_redirect', 'my_custom_add_to_cart_redirect');

/* n??o funcionando
add_action( 'wp_head', 'remove_add_to_cart', 11 );
function remove_add_to_cart() {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 0);
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart');
}*/
