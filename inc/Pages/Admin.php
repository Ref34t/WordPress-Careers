<?php 
/**
 * @package WPCareers
 */
namespace Inc\Pages;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

/**
* 
*/
class Admin extends BaseController
{
	public $settings;

	public $callbacks;

	public $pages = array();

	public $subpages = array();

	public function register() 
	{
		$this->settings = new SettingsApi();

		$this->callbacks = new AdminCallbacks();

		$this->setPages();

		$this->setSubpages();

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
	}

	public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'WP Careers', 
				'menu_title' => 'WP Careers', 
				'capability' => 'manage_options', 
				'menu_slug' => 'wpcareers_plugin', 
				'callback' => array( $this->callbacks, 'adminDashboard' ), 
				'icon_url' => 'dashicons-dashboard', 
				'position' => 110
			)
		);
	}

	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'wpcareers_plugin', 
				'page_title' => 'Applications', 
				'menu_title' => 'Applications', 
				'capability' => 'manage_options', 
				'menu_slug' => 'wpcareers_applications', 
				'callback' => array( $this->callbacks, 'adminApplications' )
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'wpcareers_options_group',
				'option_name' => 'text_example',
				'callback' => array( $this->callbacks, 'wpcareersOptionsGroup' )
			),
			array(
				'option_group' => 'wpcareers_options_group',
				'option_name' => 'first_name'
			)
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'wpcareers_admin_index',
				'title' => 'Settings',
				'callback' => array( $this->callbacks, 'wpcareersAdminSection' ),
				'page' => 'wpcareers_plugin'
			)
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(
			array(
				'id' => 'text_example',
				'title' => 'Text Example',
				'callback' => array( $this->callbacks, 'wpcareersTextExample' ),
				'page' => 'wpcareers_plugin',
				'section' => 'wpcareers_admin_index',
				'args' => array(
					'label_for' => 'text_example',
					'class' => 'example-class'
				)
			),
			array(
				'id' => 'first_name',
				'title' => 'First Name',
				'callback' => array( $this->callbacks, 'wpcareersFirstName' ),
				'page' => 'wpcareers_plugin',
				'section' => 'wpcareers_admin_index',
				'args' => array(
					'label_for' => 'first_name',
					'class' => 'example-class'
				)
			)
		);

		$this->settings->setFields( $args );
	}
}