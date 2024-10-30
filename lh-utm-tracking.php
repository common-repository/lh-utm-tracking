<?php
/**
 * Plugin Name: LH UTM Tracking
 * Plugin URI: https://lhero.org/portfolio/lh-utm-tracking/
 * Description: Do lead tracking properly via localstorage
 * Version: 1.00
 * Author: Peter Shaw
 * Author URI: https://shawfactor.com/
 * Tags: UTM, analytics, google, tracking
*/

if (!class_exists('LH_Utm_tracking_plugin')) {


class LH_Utm_tracking_plugin {


var $namespace = 'lh_utm_tracking';
var $plugin_version = '1.00';



/**
     * Helper function for registering and enqueueing scripts and styles.
     *
     * @name    The    ID to register with WordPress
     * @file_path        The path to the actual file
     * @is_script        Optional argument for if the incoming file_path is a JavaScript source file.
     */
    private function load_file( $name, $file_path, $is_script = false, $deps = array(), $in_footer = true, $atts = array() ) {
        $url  = plugins_url( $file_path, __FILE__ );
        $file = plugin_dir_path( __FILE__ ) . $file_path;
        if ( file_exists( $file ) ) {
            if ( $is_script ) {
                wp_register_script( $name, $url, $deps, $this->plugin_version, $in_footer ); 
                wp_enqueue_script( $name );
            }
            else {
                wp_register_style( $name, $url, $deps, $this->plugin_version );
                wp_enqueue_style( $name );
            } // end if
        } // end if
	  
	  if (isset($atts) and is_array($atts) and isset($is_script)){
		
		
  $atts = array_filter($atts);

if (!empty($atts)) {

  $this->script_atts[$name] = $atts; 
  
}

		  
	 add_filter( 'script_loader_tag', function ( $tag, $handle ) {
	   

	   
if (isset($this->script_atts[$handle][0]) and !empty($this->script_atts[$handle][0])){
  
$atts = $this->script_atts[$handle];

$implode = implode(" ", $atts);
  
unset($this->script_atts[$handle]);

return str_replace( ' src', ' '.$implode.' src', $tag );

unset($atts);
usent($implode);

		 

	 } else {
	   
 return $tag;	   
	   
	   
	 }
	

}, 10, 2 );
 

	
	  
	}
		
    } // end load_file
    
    
private function register_scripts_and_styles() {

if (!is_user_logged_in()){

$array = array('defer="defer"');

//include the fantastic purser utm localstorage library, credit : https://github.com/bilbof/purser
$this->load_file( 'purser', '/scripts/purser.js',  true, array(), true, $array);

}


}


public function general_init() {
  
          // Load JavaScript and stylesheets
        $this->register_scripts_and_styles();
  
  

}
    
    
    

public function __construct() {
    
    //register required styles and scripts
add_action('init', array($this,"general_init"));
    
}


}

$lh_utm_tracking_instance = new LH_Utm_tracking_plugin();


}



?>