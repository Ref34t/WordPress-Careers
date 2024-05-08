
<?php
$args = array(
    'post_type'      => 'application',
    'posts_per_page' => 20, // Number of applications per page
    'paged'          => isset($_GET['paged']) ? max(1, intval($_GET['paged'])) : 1,
    'post_status' => array('publish', 'pending', 'draft') // Include draft and pending posts
);

$applications_query = new WP_Query($args);

if ($applications_query->have_posts()) {
  echo '<h2>' . __('Applications', 'text-domain') . '</h2>';
  echo '<table class="wp-list-table widefat fixed striped pages">';
  echo '<thead>';
  echo '<tr>';
  echo '<th scope="col" class="manage-column column-job  desc" data-sort="job">'. __('Job', 'text-domain') .'</th>'; // Added scope and class attributes
  echo '<th scope="col" class="manage-column column-title  desc" data-sort="title">'. __('Name', 'text-domain') .'</th>'; // Added scope and class attributes
  echo '<th scope="col" class="manage-column column-email  desc" data-sort="email">'. __('Email Address', 'text-domain') .'</th>'; // Added scope and class attributes
  echo '<th scope="col" class="manage-column column-country  desc" data-sort="country"> '. __('Country', 'text-domain') .'</th>'; // Added scope and class attributes
  echo '<th scope="col" class="manage-column column-resume  desc" data-sort="resume"> '. __('Resume', 'text-domain') .'</th>'; // Added scope and class attributes
  echo '<th scope="col" class="manage-column column-coverletter  desc" data-sort="coverletter">'. __('Coverletter', 'text-domain') .'</th>'; // Added scope and class attributes
  echo '<th scope="col" class="manage-column column-date  desc" data-sort="date">'. __('Date', 'text-domain') .'</th>'; // Added scope and class attributes
  // Add more table headers for additional columns
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';
  while ($applications_query->have_posts()) {
    $applications_query->the_post();
    $title = get_the_title();
    $date = get_the_date('', $applications_query->post->ID);
    $data = get_post_meta($applications_query->post->ID, '_application_data_key', true);
    $email = isset($data['email']) ? $data['email'] : '';
    $country = isset($data['country']) ? $data['country'] : '';
    $cover = isset($data['cover']) ? $data['cover'] : "";
    $job_id = isset($data['job']) ? $data['job'] : '';
    $resume = isset($data['resume']) ? $data['resume'] : '';
    $job_title = get_the_title($job_id);
    $job_url = get_permalink($job_id);
    echo '<tr>';
    echo '<td class="column-job"><a href="' . $job_url . '">' . $job_title . '</a></td>';
    echo '<td class="column-title"><p>' . $title . '</p></td>';
    echo '<td class="column-email"><p>' . $email . '</p></td>';
    echo '<td class="column-country"><p>' . $country . '</p></td>';
    echo '<td class="column-resume"><p>' . $resume . '</p></td>';
    echo '<td class="column-cover"><p>' . $cover . '</p></td>';
    echo '<td class="column-date">' . $date . '</td>';
    // Add more table cells with class names for additional columns
    echo '</tr>';
  }
  echo '</tbody>';
  echo '</table>';

  // Pagination (using built-in function)
  $total_pages = $applications_query->max_num_pages;
  if ($total_pages > 1) {
    $current_page = max(1, get_query_var('paged'));
    echo '<div class="tablenav bottom">';
    echo '<div class="tablenav-pages">';
    $page_links = paginate_links(array(
      'base' => add_query_arg('paged', '%#%'),
      'format' => '&paged=%#%',
      'current' => $current_page,
      'total' => $total_pages,
      'prev_text' => __('&laquo; Previous'),
      'next_text' => __('Next &raquo;'),
    ));
    if ($page_links) {
      echo '<span class="pagination-links">' . $page_links . '</span>';
    }
    echo '</div>';
    echo '</div>';
  }
} else {
  echo '<p>' . __('No applications found.', 'text-domain') . '</p>';
}

wp_reset_postdata();

