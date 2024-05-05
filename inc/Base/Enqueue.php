<?php 
/**
 * @package WPCareers
 */
namespace Inc\Base;

use Inc\Base\BaseController;


class Enqueue extends BaseController
{
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_client' ) );

	}
	
	function enqueue() {
		// enqueue all our scripts
		wp_enqueue_style( 'mypluginstyle', $this->plugin_url . 'assets/css/mystyle.min.css' );
		wp_enqueue_script('myscript', $this->plugin_url . 'assets/js/main.min.js');
	}

	function enqueue_client() {
		wp_enqueue_script( 'mypluginscript', $this->plugin_url . 'assets/user/js/user.min.js' );
		wp_enqueue_style( 'mypluginstyle', $this->plugin_url . 'assets/user/css/user.min.css' );

	}

}