<?php
/**
 * @package WPCareers
 */
namespace Inc\Base;


class TaxonomyController
{
    public function register() 
    {
        add_action('init', array($this, 'addCustomTaxonomy'));
    }

    public  function addCustomTaxonomy()
    {
        $labels = array(
            'name' => _x( 'Specializations', 'taxonomy general name' ),
            'singular_name' => _x( 'Specialization', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Specializations' ),
            'all_items' => __( 'All Specializations' ),
            'parent_item' => __( 'Parent Specialization' ),
            'parent_item_colon' => __( 'Parent Specialization:' ),
            'edit_item' => __( 'Edit Specialization' ), 
            'update_item' => __( 'Update Specialization' ),
            'add_new_item' => __( 'Add New Specialization' ),
            'new_item_name' => __( 'New Specialization Name' ),
            'menu_name' => __( 'Specializations' ),
        );    
    
        register_taxonomy('specializations',array('job'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_in_rest' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'specialization' ),
        ));

    }
}