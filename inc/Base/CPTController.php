<?php
/**
 * @package WPCareers
 */
namespace Inc\Base;

use Inc\Base\BaseController;


class CPTController extends BaseController
{
    public function register()
    {
        add_action('init', array($this, 'create_post_type'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
        add_shortcode( 'careers_page', array( $this, 'careers_page' ) );
        add_action('wp_ajax_submit_form', array($this, 'submit_form'));
        add_action('wp_ajax_nopriv_submit_form', array($this, 'submit_form'));

    }

    public function create_post_type()
    {
        $args = array(
            'labels' => array(
                'name' => __('Jobs'),
                'singular_name' => __('Job'),
                'add_new' => __('Add New Job'),
                'add_new_item' => __('Add New Job'),
                'edit_item' => __('Edit Job'),
                'new_item' => __('New Job'),
                'view_item' => __('View Job'),
                'search_items' => __('Search Jobs'),
                'not_found' => __('No Jobs found'),
                'not_found_in_trash' => __('No jobs found in Trash'),
                'parent_item_colon' => __('Parent Job:'),
                'menu_name' => __('Jobs'),
            ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'job'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 20,
            'menu_icon' => 'dashicons-businessperson',
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'author', 'thumbnail')
        );

        register_post_type('job', $args);
    }

    public function add_meta_boxes()
    {
        add_meta_box(

            'job_info',
            'Job Info',
            array($this, 'render_job_box'),
            'job',
            'normal',
            'default'
        );
    }

    public function render_job_box($post)
    {
        wp_nonce_field('job_info', 'job_info_nonce');

        $data = get_post_meta($post->ID, '_job_info_1_key', true);
        $location = isset($data['location']) ? $data['location'] : '';
        $description = isset($data['description']) ? $data['description'] : '';
        $featured = isset($data['featured']) ? $data['featured'] : false;
        $status = isset($data['status']) ? $data['status'] : "";
        $type = isset($data['type']) ? $data['type'] : "";
        $whatWillYouDo = isset($data['what']) ? $data['what'] : '';
        $about = isset($data['about']) ? $data['about'] : '';
        $bonus = isset($data['bonus']) ? $data['bonus'] : '';
        $benefits = isset($data['benefits']) ? $data['benefits'] : '';
        $apply = isset($data['apply']) ? $data['apply'] : '';


        ?>

        <label for="job_info_location">Location</label>
        </br>
        <input class="widefat" type="text" id="job_info_location" name="job_info_location"
            value="<?= esc_attr($location); ?>">

        </br></br>

        <label for="job_info_description">Description</label>
        </br>
        <input class="widefat" type="text" id="job_info_description" name="job_info_description"
            value="<?= esc_attr($description); ?>">

        </br></br>


        <label for="job_info_featured">Featured</label>
        <input class="widefat" type="checkbox" id="job_info_featured" name="job_info_featured" value="1" <?= $featured ? 'checked' : ""; ?>>

        </br></br>

        <label for="job_info_type">Job Type</label>
        </br>
        <select name="job_info_type" class="widefat" id="job_info_type">
            <option value="Full Time" <?= selected($type, 'Full Time', false) ?>>Full Time</option>
            <option value="Part Time" <?= selected($type, 'Part Time', false) ?>>Part Time</option>
            <option value="Contract" <?= selected($type, 'Contract', false) ?>>Contract</option>

        </select>

        </br></br>

        <label for="job-info-status">Job Status</label>
        </br>
        <select name="job-info-status" class="widefat" id="job-info_status">
            <option value="open" <?= selected($status, 'open', false) ?>>Open</option>
            <option value="closed" <?= selected($status, 'closed', false) ?>>Closed</option>
        </select>

        </br></br>

        <label for="job-info-what-will-you-do"> What Will You Do?</label>
        </br>
        <textarea id="job-info-what-will-you-do" name="job-info-what-will-you-do" class="widefat" value="<?= $whatWillYouDo ?>"><?= $whatWillYouDo ?></textarea>
        </br></br>

        <label for="job-info-about"> About You</label>
        </br>
        <textarea id="job-info-about" name="job-info-about" class="widefat" value="<?= $about ?>"><?= $about ?></textarea>
        </br></br>

        <label for="job-info-bonus">Bonus</label>
        </br>
        <textarea id="job-info-bonus" name="job-info-bonus" class="widefat" value="<?= $bonus ?>"><?= $bonus ?></textarea>
        </br></br>

        <label for="job-info-benefits">Benefits</label>
        </br>
        <textarea id="job-info-benefits" name="job-info-benefits" class="widefat" value="<?= $benefits ?>"><?= $benefits?></textarea>
        </br></br>


        <label for="job-info-apply">How To Apply</label>
        </br>
        <textarea id="job-info-apply" name="job-info-apply" class="widefat" value="<?= $apply ?>"><?= $apply?></textarea>
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

            'location' => sanitize_text_field($_POST['job_info_location']),
            'description' => sanitize_text_field($_POST['job_info_description']),
            'featured' => isset($_POST['job_info_featured']) ? 1 : 0,
            'status' => isset($_POST['job-info-status']) ? $_POST['job-info-status'] : '',
            'type' => isset($_POST['job_info_type']) ? $_POST['job_info_type'] : '',
            'what' => sanitize_textarea_field( $_POST['job-info-what-will-you-do']),
            'about' => sanitize_textarea_field( $_POST['job-info-about']),
            'bonus' => sanitize_textarea_field( $_POST['job-info-bonus']),  
            'benefits' => sanitize_textarea_field( $_POST['job-info-benefits']),
            'apply' => sanitize_textarea_field( $_POST['job-info-apply']),

        );

        update_post_meta($post_id, '_job_info_1_key', $data);
    }

    
    public function careers_page($atts = [])
    {
        // normalize attribute keys, lowercase
        $atts = array_change_key_case((array)$atts, CASE_LOWER);
    
        // override default attributes with user attributes
        $wp_atts = shortcode_atts([
                'title' => 'Open Positions',
             ], $atts);
    
        // you can now use $wp_atts['title'] in your shortcode function
        $title = $wp_atts['title'];
    
        ob_start();
        require_once( "$this->plugin_path/templates/careers_shortcode.php" );
        return ob_get_clean();
    }

    public function submit_form()
    {

        $name = sanitize_text_field( $_POST['name']);
        $email = sanitize_email( $_POST['email']);
        $country = sanitize_text_field( $_POST['country']);
        $cover = sanitize_textarea_field( $_POST['coverletter']);

        $data = array(
            'name' => $name,
            'email' => $email,
            'country' => $country,
            'cover' => $cover,
        );

        $args = array(
            'post_title' => 'Application from ' . $name,
            'post_content' => $email . $country . $cover,
            'post_author' => 1,
            'post_status' => 'publish',
            'post_type' => 'application'

        );

        $postID = wp_insert_post( $args);

        if ($postID) {
           $return = array(
            'status' => 'success',
            'ID' => $postID
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