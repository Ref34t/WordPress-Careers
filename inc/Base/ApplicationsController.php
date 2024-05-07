<?php
/**
 * @package WPCareers
 */
namespace Inc\Base;

use Inc\Base\BaseController;


class ApplicationsController extends BaseController
{
    public function register()
    {
        add_action('init', array($this, 'create_post_type'));
      

    }

    public function create_post_type()
    {
        $args = array(
            'labels' => array(
                'name' => __('Applications'),
                'singular_name' => __('Application'),
                'add_new' => __('Add New Application'),
                'add_new_item' => __('Add New Application'),
                'edit_item' => __('Edit Application'),
                'new_item' => __('New Application'),
                'view_item' => __('View Application'),
                'search_items' => __('Search Applications'),
                'not_found' => __('No Applications found'),
                'not_found_in_trash' => __('No Applications found in Trash'),
                'parent_item_colon' => __('Parent Application:'),
                'menu_name' => __('Applications'),
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'query_var' => true,
            'rewrite' => array('slug' => 'application'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => null,
            'menu_icon' => 'dashicons-businessperson',
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'author', 'thumbnail')
        );

        register_post_type('application', $args);
    }

}