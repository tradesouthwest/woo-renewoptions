<?php
/**
 * woorenewoption admin setting page
 * @since 1.0.0
 */  
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
/** a.) Register new settings
 *  $option_group (page), $option_name, $sanitize_callback
 *  --------
 ** b.) Add sections
 *  $id, $title, $callback, $page
 *  --------
 ** c.) Add fields 
 *  $id, $title, $callback, $page, $section, $args = array() 
 *  --------
 ** d.) Options Form Rendering. action="options.php"
 *
 */

//$page_title, $menu_title, $capability, $menu_slug, $function-to-render, $icon_url, $position
function woorenewoption_add_admin_menu_page() {

    add_menu_page( 
        __( 'WooSubcrptn PrePayment' ),
        __( 'PrePay Shipments' ), 
        'manage_options',
        'woorenewoption_menu', 
        'woorenewoption_admin_section',
        'dashicons-admin-tools'
    );
}
add_action( 'admin_menu', 'woorenewoption_add_admin_menu_page' );
add_action( 'admin_init', 'woorenewoption_settings_init' );
 
function woorenewoption_settings_init( ) {

    register_setting( 'woorenewoption_admin', 'woorenewoption_admin' ); //options pg

    /**
     * b1.) options section
     */       
        add_settings_section(
            'woorenewoption_admin_section',
            'woorenewoption',
            'woorenewoption_admin_section_cb',
            'woorenewoption_admin'
        ); 
    // c1.) settings 

    add_settings_field(
        'woorenewoption_checkbox_1',
        __('Enable Agree on Checkout Page', 'woorenewoption'),
        'woorenewoption_checkbox_1_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section'
    );
    add_settings_field(
        'woorenewoption_textfield_cart',
        __('Verbage on Product Page for Agree.', 'woorenewoption'),
        'woorenewoption_textfield_cart_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section'
    );
    add_settings_field(
        'woorenewoption_textfield_1',
        __('Verbage for renewal select LABEL in Checkout.', 'woorenewoption'),
        'woorenewoption_textfield_1_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section'
    );
    add_settings_field(
        'woorenewoption_textfield_2',
        __('Verbage for renew select.', 'woorenewoption'),
        'woorenewoption_textfield_2_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section'
    );
    add_settings_field(
        'woorenewoption_textfield_4',
        __('Verbage for Do Not renew select.', 'woorenewoption'),
        'woorenewoption_textfield_4_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section'
    );
    
    add_settings_field(
        'woorenewoption_textfield_5pnt',
        __('Title of Parent Subscription', 'woorenewoption'),
        'woorenewoption_textfield_5pnt_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section'
    );  
    add_settings_field(
        'woorenewoption_textfield_5',
        __('Title of Page which holds PrePaid Subscriptions', 'woorenewoption'),
        'woorenewoption_textfield_5_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section'
    );  
    add_settings_field(
        'woorenewoption_textfield_6pnt',
        __('Title for second parent.', 'woorenewoption'),
        'woorenewoption_textfield_6pnt_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section'
    ); 
    add_settings_field(
        'woorenewoption_textfield_6',
        __('Title for second pg PrePaid Subscriptions.', 'woorenewoption'),
        'woorenewoption_textfield_6_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section'
    ); 
    add_settings_field(
        'woorenewoption_textfield_7pnt',
        __('Title for third parent.', 'woorenewoption'),
        'woorenewoption_textfield_7pnt_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section'
    ); 
    add_settings_field(
        'woorenewoption_textfield_7',
        __('Title for third pg PrePaid Subscriptions.', 'woorenewoption'),
        'woorenewoption_textfield_7_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section'
    ); 
    add_settings_field(
        'woorenewoption_textfield_8pnt',
        __('Title for fourth parent.', 'woorenewoption'),
        'woorenewoption_textfield_8pnt_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section'
    ); 
    add_settings_field(
        'woorenewoption_textfield_8',
        __('Title for fourth pg PrePaid Subscriptions.', 'woorenewoption'),
        'woorenewoption_textfield_8_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section'
    ); 
    add_settings_field(
        'woorenewoption_print_styles',
        __( 'Style Editor', 'woorenewoption' ),
        'woorenewoption_print_styles_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section',
        array( 
            'type'        => 'text',
            'option_name' => 'woorenewoption_admin', 
            'name'        => 'woorenewoption_print_styles',
            'value'       => ( empty( get_option('woorenewoption_admin')['woorenewoption_print_styles'] )) 
                            ? false : get_option('woorenewoption_admin')['woorenewoption_print_styles'],
            'default'     => '',
            'description' => esc_html__( 'Enter styles. Please validate', 'woorenewoption' ),
            'tip'     => esc_attr__( 'Be sure to check your styles', 'woorenewoption' ),  
            'placeholder' => ''
        ) 
    ); 
    // settings checkbox 
    add_settings_field(
        'woorenewoption_styles_radio',
        __('Deactivate Custom Styles', 'woorenewoption'),
        'woorenewoption_styles_radio_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section',
        array( 
            'type'        => 'checkbox',
            'option_name' => 'woorenewoption_admin', 
            'name'        => 'woorenewoption_styles_radio',
'value'       => ( empty( get_option('woorenewoption_admin')['woorenewoption_styles_radio'] )) 
                    ? 0 : get_option('woorenewoption_admin')['woorenewoption_styles_radio'],
            'checked'     => esc_attr( checked( 1, 
                             get_option('woorenewoption_admin')['woorenewoption_styles_radio'], 
                             false ) ),
            'description' => esc_html__( 'Check to use styles.', 'woorenewoption' ),
            'tip'     => esc_attr__( 'Default is ON (check). Uncheck to discontinue using styles. Could be used for theme change.', 'woorenewoption' )  
        )
    ); 
    add_settings_field(
        'woorenewoption_priority_order',
        __( 'Style Editor', 'woorenewoption' ),
        'woorenewoption_priority_order_cb',
        'woorenewoption_admin',
        'woorenewoption_admin_section',
        array( 
            'type'        => 'number',
            'option_name' => 'woorenewoption_admin', 
            'name'        => 'woorenewoption_priority_order',
            'value'       => ( empty( get_option('woorenewoption_admin')['woorenewoption_priority_order'] )) 
                            ? absint( 10 ) : get_option('woorenewoption_admin')['woorenewoption_priority_order'],
            'default'     => '',
            'description' => esc_html__( 'Enter Priority of this styles script', 'woorenewoption' ),
            'tip'     => esc_attr__( '10 is default and should allow styles to show last in the head. Raise number to 11 or 12 if your styles are not taking.', 'woorenewoption' ),  
            'placeholder' => ''    
        ) 
    );    

}
/* ----------------------------------------------- callback functions  */
/**
 * WC_Subscriptions_Product::get_xxxx_string( $product )
 * ID can also be used to get the subscription using wcs_get_subscription().
 * 
 */
function woorenewoption_product_select_dropdown_args($args)
{
    global $wpdb, $product;
    $options_markup = '';
    $prods = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE post_type = 'product'" );

    $woorenew_id = (empty(get_option('woorenewoption_admin')[$args]))
    ? '' : get_option('woorenewoption_admin')[$args];

   foreach( $prods as $label )
   {
       $options_markup .= sprintf( '<option value="%s" %s>%s</option>', 
       $label, 
       selected( $woorenew_id, $label, false ), 
       get_the_title($label) . ' ' . $label );
   }
   printf( '<select name="%1$s" id="'. $args .'">
   <option value="-1">----Select----</option>%2$s</select>', 
       esc_attr('woorenewoption_admin['.$args.']'), 
       $options_markup 
      );

   $args = $options_markup =null;
}

/** 
 * Text of label
 * @since 1.0.1
 * 
 */
function woorenewoption_textfield_5pnt_cb() 
{
     
    woorenewoption_product_select_dropdown_args( 'woorenewoption_textfield_5pnt' );
}

/** 
 * Text of label
 * @since 1.0.1
 * 
 */
function woorenewoption_textfield_5_cb() 
{
     
    woorenewoption_product_select_dropdown_args( 'woorenewoption_textfield_5' );
}
/** 
 * Text of label
 * @since 1.0.1
 * 
 */
function woorenewoption_textfield_6pnt_cb() 
{
     
    woorenewoption_product_select_dropdown_args( 'woorenewoption_textfield_6pnt' );
}
/** 
 * Text of label
 * @since 1.0.1
 * 
 */
function woorenewoption_textfield_6_cb() 
{
     
    woorenewoption_product_select_dropdown_args( 'woorenewoption_textfield_6' );
}
/** 
 * Text of label
 * @since 1.0.1
 * 
 */
function woorenewoption_textfield_7pnt_cb() 
{
     
    woorenewoption_product_select_dropdown_args( 'woorenewoption_textfield_7pnt' );
}
/** 
 * Text of label
 * @since 1.0.1
 * 
 */
function woorenewoption_textfield_7_cb() 
{
     
    woorenewoption_product_select_dropdown_args( 'woorenewoption_textfield_7' );
}
/** 
 * Text of label
 * @since 1.0.1
 * 
 */
function woorenewoption_textfield_8pnt_cb() 
{
     
    woorenewoption_product_select_dropdown_args( 'woorenewoption_textfield_8pnt' );
}
/** 
 * Text of label
 * @since 1.0.1
 * 
 */
function woorenewoption_textfield_8_cb() 
{
     
    woorenewoption_product_select_dropdown_args( 'woorenewoption_textfield_8' );
}
/* checkbox for 'auto renewal checkbox' field
 * @since 1.0.0
 * @package woorenewoption
 * @subpackage inc/woorenewoption-settings
 */
function woorenewoption_checkbox_1_cb() 
{
    $options = get_option('woorenewoption_admin'); 
    $checkbox = (empty($options['woorenewoption_checkbox_1'] )) 
         ? 0 : absint( $options['woorenewoption_checkbox_1'] ); ?>
    
    <input type="hidden" name="woorenewoption_admin[woorenewoption_checkbox_1]" 
           value="0" />
    <input name="woorenewoption_admin[woorenewoption_checkbox_1]" 
           value="1" 
           type="checkbox" <?php echo esc_attr( 
           checked( 1, $checkbox, true ) ); ?> /> 	
    <?php esc_html_e( 'Check to activate checkout page notice ', 'woorenewoption' ); ?>
    <?php 
}
/** 
 * Text at top of product page
 * @since 1.0.0
 * Option agree and accept the renewal of my annual subscription
 * dummy text= Agree to Auto-Renew Order Subscription is Located in Checkout Page
 */
function woorenewoption_textfield_cart_cb()
{
    $options = get_option('woorenewoption_admin'); 
    $woorenewoption_textfield_cart = (empty($options['woorenewoption_textfield_cart'] )) 
             ? '' : $options['woorenewoption_textfield_cart']; 
    ob_start();
echo '<textarea id="wooreneoption_textfield_cart" rows="4" cols="38" name="woorenewoption_admin[woorenewoption_textfield_cart]">'
. esc_textarea( $woorenewoption_textfield_cart ). '</textarea><br/>';
    
    $html = ob_get_clean();
        
        echo $html;
}


/** 
 * Text of label
 * @since 1.0.0
 * I agree and accept the renewal of my annual membership.
 * dummy text= Agreement to Automatically Renew Order When Subscription Ends
 */
function woorenewoption_textfield_1_cb()
{
    $options = get_option('woorenewoption_admin'); 
    $woorenewoption_textfield_1 = (empty($options['woorenewoption_textfield_1'] )) 
             ? '' : sanitize_text_field( $options['woorenewoption_textfield_1'] ); 
    ?>

    <input type="text" 
           name="woorenewoption_admin[woorenewoption_textfield_1]" 
           value="<?php print( $woorenewoption_textfield_1 ); ?>" 
           size="40"><br/>
           Agreement to Automatically Renew Order When Subscription Ends
    <?php 
}
/** 
 * Text of option YES
 * @since 1.0.1
 * 
 */
function woorenewoption_textfield_2_cb()
{
    $options = get_option('woorenewoption_admin'); 
    $woorenewoption_textfield_2 = (empty($options['woorenewoption_textfield_2'] )) 
 ? 'I Agree to Auto-Renewal of My Subscription Orders' : 
 sanitize_text_field( $options['woorenewoption_textfield_2'] ); 
    ?>

    <input type="text" 
           name="woorenewoption_admin[woorenewoption_textfield_2]" 
           value="<?php echo $woorenewoption_textfield_2; ?>" 
           size="40">
    <?php 
}
/** 
 * Text of option NO
 * @since 1.0.1
 * 
 */
function  woorenewoption_textfield_4_cb()
{
    $options = get_option('woorenewoption_admin'); 
    $woorenewoption_textfield_4 = (empty($options['woorenewoption_textfield_4'] )) 
 ? 'Do Not Auto-Renew when pre-pay period has finished' : 
 sanitize_text_field( $options['woorenewoption_textfield_4'] ); 
    ?>

    <input type="text" 
           name="woorenewoption_admin[woorenewoption_textfield_4]" 
           value="<?php echo $woorenewoption_textfield_4; ?>" 
           size="40"> 
    <?php 
}

/** 
 * Verbage for My Account page LegalEase dialog.
 * @since 1.0.1
 * 
 */
function woorenewoption_textfield_3_cb()
{
    $options = get_option('woorenewoption_admin'); 
    $woorenewoption_textfield_3 = (empty($options['woorenewoption_textfield_3'] )) 
 ? '' : 
  $options['woorenewoption_textfield_3']; 

echo "<textarea id='plugin_textarea_string' name='woorenewoption_admin[woorenewoption_textfield_3]' 
rows='7' cols='50' type='textarea'>{$woorenewoption_textfield_3}</textarea>
<p>Sample text: If you have selected to auto-renew please check your email for updates.</p>";
}

/** 
 * switch for 'allow styles' field
 * @since 1.0.1
 * @input type checkbox
 */
function woorenewoption_styles_radio_cb($args)
{ 
     printf(
        '<fieldset><b class="grctip" data-title="%6$s"></b><sup></sup>
        <input type="hidden" name="%3$s[%1$s]" value="0">
        <input id="%1$s" type="%2$s" name="%3$s[%1$s]" value="1"  
        class="regular-checkbox" %7$s /><br>
        <span class="vmarg">%5$s </span></fieldset>',
            $args['name'],
            $args['type'],
            $args['option_name'],
            $args['value'],
            $args['description'],
            $args['tip'],
            $args['checked']
        );
}  
/** 
 * render for 'priority order' field
 * @since 1.0.0
 */
function woorenewoption_priority_order_cb($args)
{  
    printf(
    '<fieldset><b class="grctip" data-title="%5$s"></b><sup></sup>
    <p><span class="vmarg">%4$s </span></p>
    <input id="%1$s" class="text-field" name="%2$s[%1$s]" type="%6$s" value="%3$s"/>
    </fieldset>',
        $args['name'],
        $args['option_name'],
        $args['value'],
        $args['description'],
        $args['tip'],
        $args['type']
    );
}
  
/** 
 * render for '0' field
 * @since 1.0.0
 */
function woorenewoption_print_styles_cb($args)
{  
    printf(
    '<fieldset><b class="grctip" data-title="%5$s"></b><sup></sup>
    <p><span class="vmarg">%4$s </span></p>
    <textarea id="%1$s" class="widefat textarea woorenewoption-textarea" name="%2$s[%1$s]" cols="26" rows="12">%3$s</textarea><br>
    </fieldset>',
        $args['name'],
        $args['option_name'],
        $args['value'],
        $args['description'],
        $args['tip']
    );
}

/**
 ** Section Callbacks
 *  $id, $title, $callback, $page
 */
function woorenewoption_admin_section_cb()
{
    $html = '';
    echo $html;
}

// d.) render admin page
function woorenewoption_admin_section() 
{
    
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) return;
    ?>
    <div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="post">
        <?php
        settings_fields( 'woorenewoption_admin' );
        do_settings_sections( 'woorenewoption_admin' );
        submit_button( 'Save Settings' );
        ?>
    </form>
    <table><tbody>
    <tr><td><hr></td></tr>
    <tr><td><h4>Tips and Instructions</h4></td></tr>
    <tr><td>
    <dl><dt>To change a customer’s subscription via the administration interface:</dt>
<dd>Go to the WooCommerce > Subscriptions administration screen.</dd>
<dd>Click the ID of the subscription you want to change to open the Edit Subscriptions screen.</dd>
<dd>Click the pencil icon next to the Billing Details section.</dd>
<dd>Click the Payment Method select box at the bottom of Billing Details.</dd>
<dd>Choose Manual.</dd>
<dd>Click Save Subscription.</dd>
</dl>
<img src="<?php echo esc_url( WOORENEWOPTION_URL . 'inc/change-subscription-to-manual-renewal-payments.png' ); ?>" alt="img" height="228"/>
</td></tr>
<tr><td><hr></td></tr>
    <tr><td><p>Selector style name for dropdown select is <code>#woorenewoption_select_agree</code>.</p></td></tr>
    </tbody></table>
    <hr>
   
    </div>
    <?php 
} 