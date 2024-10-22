<?php
/**
 * Main plugin settings view
 * 
 * @package Librarian
 */
$query_args = array(
    'post_type' => 'book_collection',
    'post_status' => 'publish',
    'order' => 'DESC',
    'order_by' => 'date',
    'posts_per_page' => 5
);

$query = new WP_Query( $query_args );
?>
<div class="wrap librarian-wrapper">
    <h1>Latest added collection</h1>
</div>