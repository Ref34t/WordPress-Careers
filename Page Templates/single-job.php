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
if (!empty($meta_array) && is_array($meta_array)) {
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



    echo '<div class="default-max-width">';
    echo '<h3 style="margin-bottom:20px">' . get_the_title() . '</h3>';
    echo '<p>-Location: ' . $location . '</p>';
    echo '<p>-Employment Type: ' . $type . '</p>';
    echo '<h4 style="margin-top:30px; margin-bottom:10px">Description</h4>';
    echo '<p>' . $description . '</p>';
    echo '<h4 style="margin-top:30px; margin-bottom:10px">What Will You Do?</h4>';
    echo '<p>' . $what . '</p>';
    echo '<h4 style="margin-top:30px; margin-bottom:10px">About You</h4>';
    echo '<p>' . $about . '</p>';
    echo '<h4 style="margin-top:30px; margin-bottom:10px">Bonus Points</h4>';
    echo '<p>' . $bonus . '</p>';
    echo '<h4 style="margin-top:30px; margin-bottom:10px">The Position Benefits </h4>';
    echo '<p>' . $benefits . '</p>';
    echo '<h4 style="margin-top:30px; margin-bottom:10px">How to Apply</h4>';
    echo '<p>' . $apply . '</p>';
    echo '<button id="openModalBtn" style="margin-top:30px" class="wp-element-button" type="submit">Apply Here</button>';
    echo '</div>';
    ?>

    <div id="myModal" class="modal job-application-form-modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 class="job-application-form_title">Apply For <?php the_title() ?></h3>
            <form id="job-application-form" action="#" method="post"
                data-url="<?php echo admin_url('admin-ajax.php'); ?>">

                <div class="field-container">
                    <label for="name">Your Name</label>
                    <input type="text" class="field-input" id="name" name="name" required>
                    <small class="field-msg error" data-error="invalidName">Your Name is Required</small>
                </div>

                <div class="field-container">
                    <label for="email">Your Email</label>
                    <input type="email" class="field-input" " id="email" name="email" required>
                    <small class="field-msg error" data-error="invalidEmail">The Email address is not valid</small>
                </div>

                <div class="field-container">
                    <label for="country">Your Country</label>
                    <input type="text" name="country" id="country" class="field-input">
                    <small class="field-msg error" data-error="invalidCountry">A Country is Required</small>
                </div>

                <div class="field-container">
                    <label for="custom_file">Your Resume</label>
                    <input type="file" name="custom_file" id="custom_file" class="field-input">
                    <small class="field-msg error" data-error="invalidResume">Upload Your Resume in pdf with less than 1MB Size</small>
                </div>

                <div class="field-container">
                    <label for="coverletter">Your Cover letter</label>
                    <textarea name="coverletter" id="coverletter" class="field-input"></textarea>
                    <small class="field-msg error" data-error="invalidCoverletter">A Cover letter is Required</small>
                </div>

                

                <div class="field-container">
                    <div>
                        <button type="stubmit" class="btn btn-default btn-lg btn-sunset-form">Submit</button>
                    </div>
                    <small class="field-msg js-form-submission">Submission in process, please wait&hellip;</small>
                    <small class="field-msg success js-form-success">Message Successfully submitted, thank you!</small>
                    <small class="field-msg error js-form-error">There was a problem with the Contact Form, please try
                        again!</small>
                </div>

                <input type="hidden" name="action" value="submit_form">
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce("applyform-nonce") ?>">

            </form>
        </div>
    </div>

    <?php
}

get_footer();