<?php
/*
Plugin Name: Very Simple Media Taxonomy
Description: This plugin adds a taxonomy for Media files.
Version: 1.0
Author: Dan Poynor
*/

function vsmtax_add_media_categories() {
    $taxonomies = array('category');
    foreach($taxonomies as $tax) {
        register_taxonomy($tax, 'attachment', array(
            'hierarchical' => true,
            'labels' => array(
                'name' => 'Categories',
                'singular_name' => 'Category',
            ),
            'query_var' => true,
            'rewrite' => array('slug' => $tax),
        ));
    }
}
add_action('init', 'vsmtax_add_media_categories');

// Add a Categories column to the Media Library list view
function vsmtax_add_categories_column($columns) {
    $columns['categories'] = 'Categories';
    return $columns;
}
add_filter('manage_media_columns', 'vsmtax_add_categories_column');

// Display the categories in the Categories column
function vsmtax_display_categories_column($column_name, $post_id) {
    if ($column_name === 'categories') {
        $categories = get_the_category($post_id);
        foreach ($categories as $category) {
            echo $category->name . ' ';
        }
    }
}
add_action('manage_media_custom_column', 'vsmtax_display_categories_column', 10, 2);