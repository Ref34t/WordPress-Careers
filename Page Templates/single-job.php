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
        $type = isset($meta_array['type']) ? $meta_array['type'] : '';
        $description = isset($meta_array['description']) ? $meta_array['description'] : '';
        $featured = isset($meta_array['featured']) ? $meta_array['featured'] : '';
        $status = isset($meta_array['status']) ? $meta_array['status'] : '';
        $what = isset($meta_array['what']) ? $meta_array['what'] : '';
        $about = isset($meta_array['about']) ? $meta_array['about'] : '';
        $bonus = isset($meta_array['bonus']) ? $meta_array['bonus'] : '';
        $benefits = isset($meta_array['benefits']) ? $meta_array['benefits'] : '';
        $apply = isset($meta_array['apply']) ? $meta_array['apply'] : '';



        echo    '<div class="default-max-width">';
        echo    '<h3 style="margin-bottom:20px">'. get_the_title() .'</h3>';
        echo    '<p>-Location: ' . $location . '</p>';
        echo    '<p>-Employment Type: ' . $type . '</p>';
        echo    '<h4 style="margin-top:30px; margin-bottom:10px">Description</h4>';
        echo    '<p>' . $description . '</p>';
        echo    '<h4 style="margin-top:30px; margin-bottom:10px">What Will You Do?</h4>';
        echo    '<p>' . $what . '</p>';
        echo    '<h4 style="margin-top:30px; margin-bottom:10px">About You</h4>';
        echo    '<p>' . $about . '</p>';
        echo    '<h4 style="margin-top:30px; margin-bottom:10px">Bonus Points</h4>';
        echo    '<p>' . $bonus . '</p>';
        echo    '<h4 style="margin-top:30px; margin-bottom:10px">The Position Benefits </h4>';
        echo    '<p>' . $benefits . '</p>';
        echo    '<h4 style="margin-top:30px; margin-bottom:10px">How to Apply</h4>';
        echo    '<p>' . $apply . '</p>';
        echo    '<button id="openModalBtn" style="margin-top:30px" class="wp-element-button" type="submit">Apply Here</button>';
        echo    '</div>';
        ?>

                <div id="myModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>let's go</p>
                </div>
                </div>

        <?php
    }

get_footer();