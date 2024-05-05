<div class="align-wide">
<h3 style="margin-bottom:30px"><?= $title; ?></h3>

<?php

$args = array(
    'post_type' => 'job',
    'post_status' => 'publish',
    'posts_per_page' => 10,
    'meta_query' => array(
        array(
            'key' => '_job_info_1_key',
            'value' => 'open',
            'compare' => 'LIKE',
        )
    )
);

$query = new WP_Query( $args );

if ($query->have_posts()) :
    echo '<ul style="list-style:none; padding:0;">';

    while ($query->have_posts()) : $query->the_post();
        echo '<li style="margin-bottom:20px;border: 1px solid; padding: 10px;"><p>'.get_the_title().'</p><a href='. get_the_permalink() . '> Learn More</a></li>';
    endwhile;
    echo '</ul>';
endif;

wp_reset_postdata();

?>

</div>
