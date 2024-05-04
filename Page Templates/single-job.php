<?php 
/*
Template Name: Single Job
@package WPCareers
*/
?>

<?php get_header();

$post_id = get_the_ID();

    // Get the meta value, which is an array
    $meta_array = get_post_meta($post_id, '_job_info_1_key', true);

    // Check if the meta value exists and is an array
    if ( !empty($meta_array) && is_array($meta_array) ) {
        // Iterate over the array and display each key-value pair
        $location = isset($meta_array['location']) ? $meta_array['location'] : '';
        $description = isset($meta_array['description']) ? $meta_array['description'] : '';
        $featured = isset($meta_array['featured']) ? $meta_array['featured'] : '';
        $status = isset($meta_array['status']) ? $meta_array['status'] : '';
        $what = isset($meta_array['what']) ? $meta_array['what'] : '';
        $about = isset($meta_array['about']) ? $meta_array['about'] : '';
        $bonus = isset($meta_array['bonus']) ? $meta_array['bonus'] : '';
        $benefits = isset($meta_array['benefits']) ? $meta_array['benefits'] : '';

        echo   '<p>location:' . $location . '</p>';
    }

get_footer();