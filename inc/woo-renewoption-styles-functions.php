<?php
// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) 	exit;
/**
 * Plugin Scripts
 * @subpackage woorenewoption/inc/woorenewoption-styles-functions
 * 
 * Register and Enqueues public side styles -if used
 *
 * @since 1.0.0
 */

/**
 * Option to add a priority position of styles in head order.
 * @since 1.0.0
 * @param string $priory Priority order from plugin options
 * 
 */
function woorenewoption_get_position()
{
    $priory = '';
    $priory = ( empty( get_option('woorenewoption_admin')['woorenewoption_priority_order'] )) 
    ? absint( 10 ) : get_option('woorenewoption_admin')['woorenewoption_priority_order'];
        return absint( $priory );
}
/**
 * Put scripts in the head.
 * @since 1.0.0
 * @param wp_unslash   Remove slashes from a string or array of strings.
 */
add_action( 'wp_head', function()
{
 
    $output     = '';
    $html_toget = '';
    $html_toget = ( empty( get_option('woorenewoption_admin')['woorenewoption_print_styles'])) 
    ? false : get_option('woorenewoption_admin')['woorenewoption_print_styles'];
    $opt_styles = ( empty( get_option('woorenewoption_admin')['woorenewoption_styles_radio'])) 
    ? '1' : get_option('woorenewoption_admin')['woorenewoption_styles_radio'];
    
    if( $html_toget ) {
$output .= '<style type="text/css" id="woorenewoption-styles">';
    if( $opt_styles == '1' ) : 
$output .= wp_unslash( $html_toget );
    endif;
$output .= '</style> ';
    } 
    
    print( $output );
},  woorenewoption_get_position() );