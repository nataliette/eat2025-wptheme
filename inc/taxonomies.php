<?php
// inc/taxonomies.php
add_action('init', function () {
  // Cuisine (category-like, hierarchical)
  register_taxonomy('cuisine', ['post'], [
    'label' => 'Cuisine',
    'hierarchical' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'rewrite' => ['slug' => 'cuisine'],
    'show_in_rest' => true,
  ]);

  // Meal (category-like, hierarchical)
  register_taxonomy('meal', ['post'], [
    'label' => 'Meal',
    'hierarchical' => true,
    'show_ui' => true,
    'show_admin_column' => true,
    'rewrite' => ['slug' => 'meal'],
    'show_in_rest' => true,
  ]);

  // Ingredients (tag-like)
  register_taxonomy('ingredients', ['post'], [
    'label' => 'Ingredients',
    'hierarchical' => false,
    'show_ui' => true,
    'show_admin_column' => true,
    'rewrite' => ['slug' => 'ingredient'],
    'show_in_rest' => true,
  ]);

  // Diet (tag-like)
  register_taxonomy('diet', ['post'], [
    'label' => 'Diet',
    'hierarchical' => false,
    'show_ui' => true,
    'show_admin_column' => true,
    'rewrite' => ['slug' => 'diet'],
    'show_in_rest' => true,
  ]);
});
