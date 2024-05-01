<?php
/**
 * @package WPCareers
 */
namespace Inc\Base;


class CPTController
{
    public function register() 
    {
        add_action('init', array($this, 'createPostType'));
    }

    public  function createPostType()
    {
        $args = array(
            'labels' => array(
                'name' => __( 'Jobs' ),
                'singular_name' => __( 'Job' ),
                'add_new' => __( 'Add New Job' ),
                'add_new_item' => __( 'Add New Job' ),
                'edit_item' => __( 'Edit Job' ),
                'new_item' => __( 'New Job' ),
                'view_item' => __( 'View Job' ),
                'search_items' => __( 'Search Jobs' ),
                'not_found' => __( 'No Jobs found' ),
                'not_found_in_trash' => __( 'No jobs found in Trash' ),
                'parent_item_colon' => __( 'Parent Job:' ),
                'menu_name' => __( 'Jobs' ),
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'job' ),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-businessperson',
            'show_in_rest' => true,
            'supports' => array( 'title', 'editor', 'author', 'thumbnail' )
        );

        register_post_type( 'job', $args );
    }
}