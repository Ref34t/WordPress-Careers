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
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
        add_action('wp_ajax_submit_form', array($this, 'submit_form'));
        add_action('wp_ajax_nopriv_submit_form', array($this, 'submit_form'));
      

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

    public function add_meta_boxes()
    {
        add_meta_box(

            'application_data',
            'Application Data',
            array($this, 'render_job_box'),
            'application',
            'normal',
            'default'
        );
    }

    public function render_job_box($post)
    {
        wp_nonce_field('application_data', 'application_data_nonce');

        $data = get_post_meta($post->ID, '_application_data_key', true);
        $email = isset($data['email']) ? $data['email'] : '';
        $country = isset($data['country']) ? $data['country'] : '';
        $cover = isset($data['cover']) ? $data['cover'] : "";
        $job_id = isset($data['job']) ? $data['job'] : '';
        $resume = isset($data['resume']) ? $data['resume'] : '';

        ?>

        <label for="job_info_email">Email Address</label>
        </br>
        <input class="widefat" type="text" id="job_info_email" name="job_info_email"
            value="<?= esc_attr($email); ?>">

        </br></br>


        <label for="job_info_country">Country</label>
        <input type="text" id="job_info_country" name="job_info_country" class="widefat" value="<?= esc_attr($country); ?>">

        </br></br>


        <label for="job_info_cover">Job cover</label>
        </br>
        <textarea id="job_info_cover" name="job_info_cover" class="widefat" value="<?= $cover ?>"><?= $cover ?></textarea>

        </br></br>


        <label for="custom_file">Resume</label>
        <input type="text" id="custom_file" name="custom_file" class="widefat" value="<?= $resume; ?>">
        <br>

        </br></br>


        <label for="job_info_id">Job ID</label>
        </br>
        <input type="text" id="job_info_id" name="job_info_id" class="widefat" value="<?= $job_id ?>">


        </br></br>

     

        <?php
    }

    public function save_meta_boxes($post_id)
    {
        if (!isset($_POST['job_info_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['job_info_nonce'];

        if (!wp_verify_nonce($nonce, 'job_info')) {
            return $post_id;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        

        $data = array(


            'email' => sanitize_email($_POST['job_info_email']),
            'country' => sanitize_text_field($_POST['job_info_country']),
            'cover' => sanitize_textarea_field($_POST['job_info_cover']),
            'job_id' => sanitize_text_field($_POST['job_info_id']),
            'resume' => sanitize_text_field($_POST['custom_file']), // sanitize the URL

        );


        update_post_meta($post_id, '_application_data_key', $data);
    }


    public function submit_form() {
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        $country = sanitize_text_field($_POST['country']);
        $cover = sanitize_textarea_field($_POST['coverletter']);
        $job = sanitize_text_field($_POST['job']);
    
        $resume_url = '';
    
        // Handle the file upload
        if (isset($_FILES['custom_file']) && $_FILES['custom_file']['error'] === UPLOAD_ERR_OK) {
            $attachment_id = media_handle_upload('custom_file', 0);
    
            if (!is_wp_error($attachment_id)) {
                $resume_url = wp_get_attachment_url($attachment_id);
            } else {
                // Handle upload error
                $error_message = $attachment_id->get_error_message();
                error_log($error_message);
            }
        } else {
            // File upload error
            error_log('File upload error: ' . $_FILES['custom_file']['error']);
        }


        $data = array(
            'name' => $name,
            'email' => $email,
            'country' => $country,
            'cover' => $cover,
            'job' => $job,
            'resume' => $resume_url,
        );

        $args = array(
            'post_title' => $name,
            'post_content' => '',
            'post_author' => 1,
            'post_status' => 'publish',
            'post_type' => 'application',
            'meta_input' => array(
                '_application_data_key' => $data
            )

        );

        $postID = wp_insert_post( $args);

        if ($postID) {
           $return = array(
            'status' => 'success',
            'ID' => $postID,
            'resume' => $resume_url
           );

           wp_send_json($return);

           wp_die();
        }

        $return = array(
            'status' => 'error'
        );

        wp_send_json($return);

        wp_die();
    }
}