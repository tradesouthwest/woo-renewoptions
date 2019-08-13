<?php 
/**
 * Agree to autorenewal checkout
 * 1. Render checkout field
 * 2. Validate answer
 * 3. Update to wpdb
 * 4. Add field to admin
 * 5. Save (again) if changed - disabled
 * 6. Add to members account page
 */
// Render checkout page dropdown.
add_action('woocommerce_after_checkout_billing_form','woorenewoption_add_agree_checkout_field', 9);
function woorenewoption_add_agree_checkout_field( $checkout ) 
{   

    if( woorenewoption_order_is_subscription() ) : 
    $renewoption_textfield_1 = get_option( 'woorenewoption_admin' )['woorenewoption_textfield_1'];
    ?>
    <div id="woorenewoption_checkout_field" class="woorenewoption-block">
    <label>
    <?php 
    $agyes = $agno = '';
    $agyes = get_option('woorenewoption_admin')['woorenewoption_textfield_2'];
    $agno  = get_option('woorenewoption_admin')['woorenewoption_textfield_4'];
    woocommerce_form_field( 
        'woorenewoption_select_agree', array(
        'type'          => 'select',
        'class'         => array( 'wps-drop' ),
        'required'      => true,
        'label'         => $renewoption_textfield_1,
        'options'       => array(
            'blank'		=> __( 'Select Please', 'woocommerce' ),
            'yes'	=> $agyes,
            'no'	=> $agno
        )
    ),
    $checkout->get_value( 'woorenewoption_select_agree' ) );
    ?></label></div>
    <?php 
    endif;
}
/**
 * Check if order contains subscriptions.
 *
 * @param  WC_Order|int $order_id
 * @return bool
 */
function woorenewoption_order_is_subscription() 
{
    
    //$order = wc_get_order( $order_id );
    if( WC_Subscriptions_Cart::cart_contains_subscription() ) 
    return true;
}

/**
 * Check if order is Subscription Admin side
 * 
 */
function woorenewoption_check_admin_order_subscrition($order_id, $args=array())
{
    return wcs_get_subscriptions_for_order( $order_id, $args );
    return false;
}
// 2.) Validation 
add_action('woocommerce_checkout_process', 'woorenewoption_checkout_field_process');

function woorenewoption_checkout_field_process()
{
    if( woorenewoption_order_is_subscription() ) : 
	// if the field is set, if not then show an error message.
    if (!$_POST['woorenewoption_select_agree']) 
    wc_add_notice(__('Please check agree notice.') , 'error');
    endif;
}

/**
 * 3.) Update value of field
 * @param string $order_id Global order id
 * 
 */
add_action( 'woocommerce_checkout_update_order_meta', 'woorenewoption_checkout_field_update_order_meta' );

function woorenewoption_checkout_field_update_order_meta($order_id)
{
	if (!empty($_POST['woorenewoption_select_agree'])) {
        update_post_meta($order_id, 'woorenewoption_select_agree', 
        sanitize_text_field($_POST['woorenewoption_select_agree']));
	}
}

/**
 * 4.) Add field to Admin orders page
 * 
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'woorenewoption_agree_field_display_admin_order_meta', 10, 1 );

function woorenewoption_agree_field_display_admin_order_meta($order)
{

    if( woorenewoption_check_admin_order_subscrition($order->get_id() ) ) : 
    // Get the custom field value
    $select_agree = get_post_meta( $order->get_id(), 
                                'woorenewoption_select_agree', true );

    $args  = array( 'name'    => 'woorenewoption_select_agree',
                'value'   => esc_attr( $select_agree ),
                'options' => array(
                                  "yes" => __( 'YES has agreed', 'woocommerce' ), 
                                  "no"  => __( 'NO did not agree', 'woocommerce'),
                                ),
                );
    if( ! empty ( $args['options'] && is_array( $args['options'] ) ) )
    {
        print( '<p><form action="" method="post">
        <label for="woorenewoption_select_agree">
        <strong>Agree to Subscription Renewal </strong></label>');
        
        $options_markup = '';
        $value          = $args['value'];
            foreach( $args['options'] as $key => $label )
            {
                $options_markup .= sprintf( '<option value="%s" %s>%s</option>', 
                $key, selected( $value, $key, false ), $label );
            }
            printf( '<br><span class="selection">
            <select name="%1$s" id="%1$s" disabled="true">%2$s</select>
            </span>',  
            $args['name'],
            $options_markup );
    }

        wp_nonce_field( 'woorenewoption_agree', 'woorenewoption_agree' );
        printf( '<input type="hidden" name="order_id" value="%1$s">', 
            $order->get_id() );
        print( '</form></p>' );    

    endif;
} 
//save routine
add_action( 'save_post', 'woorenewoption_select_agree_field_save');

function woorenewoption_select_agree_field_save($order_id) 
{   
    global $post;

    $post = $order_id;

    //$order_id = absint( $_POST[ 'cdx_order_id' ] );
    $is_autosave = wp_is_post_autosave( $order_id );
    $is_revision = wp_is_post_revision( $order_id );
    $is_valid_nonce = ( isset( $_POST[ 'woorenewoption_agree' ] ) && 
    wp_verify_nonce( $_POST[ 'woorenewoption_agree' ], basename( __FILE__ ) ) 
    ) ? 'true' : 'false';
 
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    if( ! current_user_can( 'edit_post', $order_id ) ) 
    {
    return;
    }
    //update post meta
    if( isset( $_POST[ 'woorenewoption_select_agree' ] ) ) {
        update_post_meta($order_id, 'woorenewoption_select_agree', 
        sanitize_text_field($_POST[ 'woorenewoption_select_agree' ] ) );
        }
} 

//add checkout data to user_meta - Members 
function woorenewoption_checkout_update_user_meta( $order_id ) {
    $order = new WC_Order($order_id);
    $customer_id = $order->customer_user;    

    if (isset($_POST['woorenewoption_select_agree'])) {
        $value = sanitize_text_field( $_POST['woorenewoption_select_agree'] );
        update_user_meta( $customer_id, 'woorenewoption_select_agree', $value);
    }
}
add_action( 'woocommerce_checkout_update_order_meta', 'woorenewoption_checkout_update_user_meta', 10, 2 ); 
