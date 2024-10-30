<?php
/**
 * Plugin Name: LH Oembed White List
 * Plugin URI: https://lhero.org/portfolio/lh-oembed-white-list/
 * Description: Embed any link from the web easily as a beautiful Content Card
 * Version: 1.02
 * Author: Peter Shaw
 * Author URI: https://shawfactor.com
 * License: GPL2
*/

// If this file is called directly, abandon ship.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if (!class_exists('LH_Oembed_white_list_plugin')) {


class LH_Oembed_white_list_plugin {

var $filename;
var $options;
var $providers_field_name = 'lh_oembed_white_list-providers';
var $path = 'lh-oembed-white-list/lh-oembed-white-list.php';

static function return_plugin_namespace(){
    
    return 'lh_oembed_white_list';
    
}    


private static $instance;

static function on_uninstall(){

delete_option(self::return_plugin_opt_name());
delete_site_option(self::return_plugin_opt_name());

}

static function return_plugin_opt_name(){

return 'lh_oembed_white_list-options';

}


private function is_this_plugin_network_activated(){

if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

if ( is_plugin_active_for_network( $this->path ) ) {
    // Plugin is activated

return true;

} else  {


return false;


}

}

private function isValidURL($url){ 

return (bool)parse_url($url);
}

public function get_plugin_options() {

if ($this->is_this_plugin_network_activated()){

$options = get_site_option(self::return_plugin_opt_name());

} else {



$options = get_option(self::return_plugin_opt_name());

}

return $options;

}


public function network_plugin_menu() {
add_submenu_page('settings.php', 'LH Oembed White List', 'Oembed White List', 'manage_options', $this->filename, array($this,"plugin_options"));


}



public function plugin_menu() {
add_options_page('LH Oembed White List', 'Oembed White List', 'manage_options', $this->filename, array($this,"plugin_options"));

}

public function plugin_options() {
    
    $this->options = $this->get_plugin_options();

if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

   
// See if the user has posted us some information
    // If they did, the nonce will be set


if( isset($_POST[ self::return_plugin_namespace().'-backend_form-nonce' ])  && wp_verify_nonce( $_POST[ self::return_plugin_namespace().'-backend_form-nonce' ], self::return_plugin_namespace().'-backend_form-nonce' )) {

if (isset($_POST[$this->providers_field_name.'-new_format']) and isset($_POST[$this->providers_field_name.'-new_provider']) and !empty($_POST[$this->providers_field_name.'-new_provider']) and $this->isValidURL($_POST[$this->providers_field_name.'-new_provider'])){

$format = sanitize_text_field($_POST[$this->providers_field_name.'-new_format']);

$provider = esc_url_raw($_POST[$this->providers_field_name.'-new_provider']);

$options[$this->providers_field_name][$format] = $provider;

}

if (isset($this->options[$this->providers_field_name])){     

foreach ($this->options[$this->providers_field_name] as $key => $value){

if (isset($_POST[$this->providers_field_name][$key]) and !empty($_POST[$this->providers_field_name][$key]) and $this->isValidURL($_POST[$this->providers_field_name][$key])){

$options[$this->providers_field_name][$key] = sanitize_text_field($_POST[$this->providers_field_name][$key]);


}

}
	
}


if ($this->is_this_plugin_network_activated()){


if (update_site_option( self::return_plugin_opt_name(), $options )){

$this->options = get_site_option(self::return_plugin_opt_name());


?>
<div class="updated"><p><strong><?php _e('Settings saved', self::return_plugin_namespace() ); ?></strong></p></div>
<?php

} 


} else {

if (update_option( self::return_plugin_opt_name(), $options )){

$this->options = get_option(self::return_plugin_opt_name());


?>
<div class="updated"><p><strong><?php _e('Settings saved', self::return_plugin_namespace() ); ?></strong></p></div>
<?php

} 

}

}

// Now display the settings editing screen

include ('partials/option-settings.php');


}

public function oembed_providers() {
    
    $this->options = $this->get_plugin_options();
  
if (isset($this->options[$this->providers_field_name])){

foreach ($this->options[$this->providers_field_name] as $pattern => $endpoint){

$is_regex = preg_match( '#^\w#', $pattern );
wp_oembed_add_provider( $pattern, $endpoint, $is_regex );

}
	
}

}




  /**
     * Gets an instance of our plugin.
     *
     * using the singleton pattern
     */
    public static function get_instance(){
        if (null === self::$instance) {
            self::$instance = new self();
        }
 
        return self::$instance;
    }

public function __construct() {

$this->filename = plugin_basename( __FILE__ );




if ( $this->is_this_plugin_network_activated() ) {
add_action('network_admin_menu', array($this,"network_plugin_menu"));
} else {
add_action('admin_menu', array($this,"plugin_menu"));
}

// Hook into the 'init' action
add_action( 'init', array( $this, 'oembed_providers' ));




}

}

$lh_oembed_white_list_instance = LH_Oembed_white_list_plugin::get_instance();
register_uninstall_hook( __FILE__, array('LH_Oembed_white_list_plugin','on_uninstall'));

}

?>