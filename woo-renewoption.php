<?php
/*
Plugin Name: Woo Renewoption
Plugin URI: http://themes.tradesouthwest.com/wordpress/plugins/
Description: Extendable plugin by Codeable Expert for Woo Subscriptions extendability. Menu under PrePay Shipments.
Version: 1.0.33
Author: tradesouthwest
Author URI: http://tradesouthwest.com/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
WordPress Available:  yes
Requires License:    no
*/
if ( ! function_exists( 'add_action' ) ) {
	die( 'Nothing to see here...' );
}
/* Important constants */
//if (!defined('COOKIEPATH'))    { define( 'COOKIEPATH', '/' ); } 
//if (!defined('COOKIE_DOMAIN')) { define( 'COOKIE_DOMAIN', get_bloginfo('url') ); }
if (!defined('WOORENEWOPTION_VER')) { define( 'WOORENEWOPTION_VER', '1.0.33' ); }
if (!defined('WOORENEWOPTION_URL')) { define( 'WOORENEWOPTION_URL', plugin_dir_url(__FILE__)); }

//activate/deactivate hooks
function woorenewoption_plugin_activation() {

  // Check for WooCommerce Subscriptions
  /*
  if( !class_exists('WC_Subscriptions') && WC_Subscriptions::$name = 'subscription');
  return; */
    return false;
}

function woorenewoption_plugin_deactivation() {
    
    return false;
}

/**
 * Include loadable plugin files
 */
// Initialise - load in translations
add_action('plugins_loaded', 'woorenewoption_loadtranslations');

function woorenewoption_loadtranslations () 
{

    $plugin_dir = basename(dirname(__FILE__)).'/languages';
    
    load_plugin_textdomain( 'woorenewoption', false, $plugin_dir );
}


/**
 * Enqueue admin only scripts 
 */
//add_action( 'admin_enqueue_scripts', 'woorenewoption_load_admin_scripts', 99 );

function woorenewoption_load_admin_scripts() 
{

    wp_enqueue_style( 'woorenewoption-admin', WOORENEWOPTION_URL 
                    . 'css/woorenewoption-admin.css', 
                    array(), WOORENEWOPTION_VER, false 
                    );
}      
            
/**
 * Register Scripts - note: v 1.0 not using ajax but script can be used for validate
 * @since 1.0.1
 * 
 * Plugin has CSS editor on plugin settings page. 
 * js-code-editor not enabled by default.
 */
add_action( 'wp_enqueue_scripts', 'woorenewoption_enqueue_scripts' );

function woorenewoption_enqueue_scripts() {

    /* wp_register_script( 'bnswfields-plugin', plugins_url(
                        'js/bnswfields.js', __FILE__ ), array( 'jquery' ), true ); */
    
    wp_enqueue_style( 'woorenewoption-style', WOORENEWOPTION_URL 
                        . '/css/woorenewoption-style.css',
                        array(), WOORENEWOPTION_VER, false );
    wp_register_script( 'js-code-editor', plugin_dir_url( __FILE__ ) 
    . 'js/js-code-editor.js', array( 'jquery' ), '', true );
    // Put scripts to head or footer.
    wp_enqueue_script( 'js-code-editor');
    wp_enqueue_code_editor( array( 'type' => 'text/html' ) );

    //wp_enqueue_script( 'bnswfields-plugin' );
}

// hook the plugin activation
    register_activation_hook(   __FILE__, 'woorenewoption_plugin_activation');
    register_deactivation_hook( __FILE__, 'woorenewoption_plugin_deactivation');
/**
 * Instansiate shortcodes
 * 
 */
add_action( 'init', 'woorenewoption_shortcodes_register');

function woorenewoption_shortcodes_register()
{
     
    add_shortcode( 'woorenewoption', 'woorenewoption_shortcode_prepaid_shipments' );
}
    require_once ( plugin_dir_path(__FILE__) . 'public/woo-renewoption-shortcode.php' );
    require_once ( plugin_dir_path( __FILE__ ) . 'inc/woo-renewoption-settings.php' );
    require_once ( plugin_dir_path(__FILE__) . 'inc/woo-renewoption-styles-functions.php' ); 
    require_once ( plugin_dir_path( __FILE__ ) . 'inc/woo-renewoption-woocheckout.php' ); 
    require_once ( plugin_dir_path( __FILE__ ) . 'inc/woo-renewoption-notices.php' );
?>