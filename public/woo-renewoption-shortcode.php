<?php 
/**
 * @package woo-renewoption
 * @subpackage inc/woo-renewoption-notices 
 * @since 1.0.0
 * 
 * @uses shortcode [woorenewoption]
 * 
 */  
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Get values of woorenewoption options .
 * $parent_prdct Int Product ID of parent product.
 * $subtitle     Int Product ID of subscription pre-pay product.
 * @return product_id and convert to url link
 */
function woorenewoption_shortcode_prepaid_shipments()
{
    global $product;
    // Defaults
    $suburl  = $sub_product = $parent_prdct = $parent_pg = $subtitle='';
    $default  = sanitize_text_field('More info on shipments on FAQ page.');

    // Parameters
    $options  = get_option('woorenewoption_admin'); 
    $woorenewoption_textfield_cart = (empty($options['woorenewoption_textfield_cart'])) 
        ? sanitize_text_field( $default ) : $options['woorenewoption_textfield_cart'];
    
    $woorenewoption_textfield_single = 'Instead of paying each time we send a box, you can also pre-pay for up to 12 months up front.
    To pre-pay click below. If you DO NOT want to pre-pay, use the ADD TO BASKET button above.';
    
    $parent_page = ( empty( $options['woorenewoption_textfield_5pnt'])) 
            ? '' : $options['woorenewoption_textfield_5pnt']; 
    $subtitle_page = ( empty( $options['woorenewoption_textfield_5'])) 
                  ? '' : $options['woorenewoption_textfield_5']; 
    $parent_page6 = ( empty( $options['woorenewoption_textfield_6pnt'])) 
                     ? '' : $options['woorenewoption_textfield_6pnt']; 
    $subtitle_page6 = ( empty( $options['woorenewoption_textfield_6'])) 
                        ? '' : $options['woorenewoption_textfield_6'];
    $parent_page7 = ( empty( $options['woorenewoption_textfield_7pnt'])) 
                      ? '' : $options['woorenewoption_textfield_7pnt']; 
    $subtitle_page7 = ( empty( $options['woorenewoption_textfield_7'])) 
                        ? '' : $options['woorenewoption_textfield_7'];
    $parent_page8 = ( empty( $options['woorenewoption_textfield_8pnt'])) 
                      ? '' : $options['woorenewoption_textfield_8pnt']; 
    $subtitle_page8 = ( empty( $options['woorenewoption_textfield_8'])) 
                        ? '' : $options['woorenewoption_textfield_8'];
    
    if ( is_single($parent_page) ) {
    $parent_prdct = $parent_page;
    $subtitle = $subtitle_page;
    } 
    elseif ( is_single($parent_page6) ) {
        $parent_prdct = $parent_page6;
        $subtitle = $subtitle_page6;
    }
    elseif ( is_single($parent_page7) ) {
        $parent_prdct = $parent_page7;
        $subtitle = $subtitle_page7;
    }
    elseif ( is_single($parent_page8) ) {
        $parent_prdct = $parent_page8;
        $subtitle = $subtitle_page8;
    }
    else {
        $parent_prdct = ''; // no parent page
        $subtitle = ''; // no prepaid page
    }

    if ( is_single($subtitle_page) ) {
        $parent_pg = $parent_page;
        $subpay = $subtitle_page;
        } 
        elseif ( is_single($subtitle_page6) ) {
            $parent_pg = $parent_page6;
            $subpay = $subtitle_page6;
        }
        elseif ( is_single($subtitle_page7) ) {
            $parent_pg = $parent_page7;
            $subpay = $subtitle_page7;
        }
        elseif ( is_single($subtitle_page8) ) {
            $parent_pg = $parent_page8;
            $subpay = $subtitle_page8;
        }
        else {
            $parent_pg = ''; // no parent page
            $subpay = ''; // no prepaid page
        }
   
    /* Set urls to return */
    $suburl         = get_permalink( $subtitle );
    $parent_url     = get_permalink($parent_pg);

    if ( is_single( $parent_prdct ) ) : 
    // Output shortcode 

    if ( is_single( $subtitle ) ) { $styl= 'block'; } else { $styl = 'none'; }
    if ( is_single( $subtitle ) ) { $styl_2= 'none'; } else { $styl_2 = 'block'; }
    echo '<div class="woorenew-prepay">
	<div class="parent-woorenew" style="display:'.$styl.'">
        <div class="woorenewoption_textfield">
        <h4>'. esc_html__( 'Prefer a standard pay-as-you-go subscription?', 
                'woocommerce' ) .'</h4>
            <p>' . trim( $woorenewoption_textfield_cart ) . '</p>
            <span class="woorenew-back">
                <a class="button alt normal-case"   
                   href="' . esc_url($parent_url) .'" 
                   title="return to">'. esc_attr__( 'Standard Subscriptions', 'woocommerce' ) .'</a>
            </span>
        </div>
    </div>
        <div class="parent-woorenew" style="display:' . $styl_2 . '">
            <h4>'. esc_html__( 'Prefer to pre-pay for your subscription?', 
                'woocommerce' ) .'</h4>
            <p>' . $woorenewoption_textfield_single . '</p>
            <a class="button alt" href="' . esc_url( $suburl ) . '" 
            title="' . esc_attr__( 'Pre-pay for shipments', 'woocommerce' ) . '">'
            . esc_html__( 'SELECT PRE-PAY OPTIONS', 'woocommerce' ) .'</a>
        </div>
    </div>';
    else:
        echo '<div class="woorenew-prepay">
        <div class="woorenewoption_textfield">
        <ul>
        <li>This product does not have any prepayment options.</li>
        </ul>
        </div></div>';
    endif;
    //$suburl = $sub_product = $parent_prdct = $parent_pg = $subtitle=null;
}
/**
 * wpdb to get ID from page name
 */
function woorenewoption_get_page_id($page_name){
    global $wpdb;
    $page_name = $wpdb->get_var("SELECT ID FROM $wpdb->posts 
                    WHERE post_name = '".$page_name."'");
    return $page_name;
}


/**
 * getter
 * @param string $in_cart Cart item data->productID
 * @return Bool
 */
function woorenewoption_options_product_getter()
{

    $options = get_option('woorenewoption_admin'); 

    $ppsub_page5 = ( empty( $options['woorenewoption_textfield_5']) ) 
                     ? '' : $options['woorenewoption_textfield_5']; 
    $ppsub_page6 = ( empty( $options['woorenewoption_textfield_6']) ) 
                     ? '' : $options['woorenewoption_textfield_6'];   
    $ppsub_page7 = ( empty( $options['woorenewoption_textfield_7']) ) 
                     ? '' : $options['woorenewoption_textfield_7'];
    $ppsub_page8 = ( empty( $options['woorenewoption_textfield_8']) ) 
                     ? '' : $options['woorenewoption_textfield_8'];
    
        return array($ppsub_page5, $ppsub_page6, $ppsub_page7, $ppsub_page8);
}

/**
 * Need to get order ID of cart item to quash recurring total.
 * @param string $cart Check cart items to find a matching ID of Subscription
 * https://www.liquidweb.com/kb/way-conditionally-show-hide-checkout-fields-specific-products-product-categories-store/
 */
add_filter( 'woocommerce_cart_calculate_fees', 'woorenewoption_remove_recurring_fees', 10, 1 );

function woorenewoption_remove_recurring_fees( $cart ) 
{
    global $woocommerce;         
    // Products currently in the cart
    $cart_ids = array();
    $ids = array();
    $ids  = woorenewoption_options_product_getter();
    
    // Find each product in the cart and add it to the $cart_ids array
	foreach( WC()->cart->get_cart() as $cart_item_key => $values ) {
		$cart_product = $values['data'];
		$cart_ids[]   = $cart_product->id;
	}
	// If one of the special products are in the cart, return true.
	if ( ! empty( array_intersect( $ids, $cart_ids ) ) ) {
		$is_subs = true;
	} else {
		$is_subs = false;
    }  
    
    if ( $is_subs == true ) :
        if ( ! empty( $cart->recurring_cart_key ) ) {

            remove_action( 'woocommerce_cart_totals_after_order_total', 
            array( 'WC_Subscriptions_Cart', 'display_recurring_totals' ), 10 );
            remove_action( 'woocommerce_review_order_after_order_total', 
            array( 'WC_Subscriptions_Cart', 'display_recurring_totals' ), 10 );
        } 
        add_action( 'woocommerce_cart_totals_before_shipping', 'woorenewoptions_maybe_display_shipping_text', 20 );
    endif;
    return false;

} 

// add_action( 'woorenewoptions_display_shipping_text', 'woorenewoptions_maybe_display_shipping_text' );

function woorenewoptions_maybe_display_shipping_text()
{
    ob_start();

    echo '<tr class="shipping recurring-total monthly_custom_position">
		<th>Shipping via Standard Shipping</th>
        <td data-title="Shipping via Standard Shipping">
        <span style="font-size:larger">'. esc_html__( 'Free', 'woocommerce' ) .'</span></td></tr>';   

    $html = ob_get_clean();                    
        
        echo $html;

}
//add_action( 'woocommerce_proceed_to_checkout', 'woorenewoptions_maybe_display_shipping_text', 10 );