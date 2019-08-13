<?php 
/**
 * @package woo-renewoption
 * @subpackage inc/woo-renewoption-notices 
 * @since 1.0.0
 * 
 */  
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Retrieve value of agreal to renew from order.
 * @since 1.0.3
 */
function woorenewoption_get_agreed_value($order_id)
{

    $agree_renew = get_post_meta( $order_id, 'woorenewoption_select_agree', true );
    $agree_value =  (empty ($agree_renew ) ) ? '0' : $agree_renew;
    
        return sanitize_text_field( $agree_value );
}

/**
 * a.)
 * Add the field to order emails
 * 
 * @since 1.0.1
 */
//add_filter('woocommerce_email_order_meta_keys', 'woorenewoption_custom_checkout_field_order_meta_keys' );

function woorenewoption_custom_checkout_field_order_meta_keys( $keys ) {
    $keys[] = 'Subscription Auto Renewal Agreement May Apply';
    return $keys;
} 


add_action( 'woocommerce_customer_changed_subscription_to_cancelled', 'woorenewoption_customer_skip_pending_cancellation' );
/**
 * Change 'pending-cancel' status directly to 'cancelled'.
 *
 * @param WC_Subscription $subscription
 */
function woorenewoption_customer_skip_pending_cancellation( $subscription ) {
	if ( 'pending-cancel' === $subscription->get_status() ) {
		$subscription->update_status( 'cancelled', 'Your subscription has been cancelled.' );
	}
}

/**
 * Cancel Subscription without any admin action
 * 
 * @param WC_Subscription $subscription
 */
add_action( 'woocommerce_subscription_status_pending-cancel', 'woorenewoption_admin_cancel_subscription', 10, 1 );

function woorenewoption_admin_cancel_subscription( $subscription ) 
{

	$subscription->update_status( 'cancelled', 'Moved from "pending cancellation" to "cancelled" by a custom function' );
} 
