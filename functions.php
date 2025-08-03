<?php 

// Helper functions
function decimal_to_fraction($value) {
  $fractions = [
    '0.25' => '¼',
    '0.33' => '⅓',
    '0.50' => '½',
    '0.66' => '⅔',
    '0.75' => '¾',
  ];

  $formatted = sprintf('%.2f', $value);

  if (array_key_exists($formatted, $fractions)) {
    return $fractions[$formatted];
  }

  return rtrim(rtrim(number_format($value, 2), '0'), '.'); // fallback
}

// Then your ACF hooks, actions, etc...

function natalie_recipes_enqueue_assets() {
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    wp_enqueue_style('eat2025-style', get_stylesheet_directory_uri() . '/style.css', [], filemtime(get_stylesheet_directory() . '/style.css'));
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', [], null, true);
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css');
}
add_action('wp_enqueue_scripts', 'natalie_recipes_enqueue_assets');

function eat2025_print_styles() {
  wp_enqueue_style('print-style', get_template_directory_uri() . '/css/print.css', [], null, 'print');
}
add_action('wp_enqueue_scripts', 'eat2025_print_styles');

function eat2025_register_custom_taxonomies() {

    register_taxonomy('cuisine', 'post', [
      'label' => 'Cuisine',
      'hierarchical' => true,
      'public' => true,
      'show_admin_column' => true,
      'show_in_rest' => true,
      'rewrite' => ['slug' => 'cuisine'],
    ]);
  
    register_taxonomy('meal', 'post', [
      'label' => 'Meal',
      'hierarchical' => true,
      'public' => true,
      'show_admin_column' => true,
      'show_in_rest' => true,
      'rewrite' => ['slug' => 'meal'],
    ]);
  
    register_taxonomy('ingredient', 'post', [
      'label' => 'Ingredients',
      'hierarchical' => false,
      'public' => true,
      'show_admin_column' => true,
      'show_in_rest' => true,
      'rewrite' => ['slug' => 'ingredient'],
    ]);
  
    register_taxonomy('diet', 'post', [
      'label' => 'Diet',
      'hierarchical' => false,
      'public' => true,
      'show_admin_column' => true,
      'show_in_rest' => true,
      'rewrite' => ['slug' => 'diet'],
    ]);
  }
  add_action('init', 'eat2025_register_custom_taxonomies');


  function eat2025_enqueue_recipe_scripts() {
    if (is_single()) {
      wp_enqueue_script(
        'recipe-scaler',
        get_template_directory_uri() . '/js/recipe-scaler.js',
        [],
        null,
        true // Load in footer
      );
    }
  }
  add_action('wp_enqueue_scripts', 'eat2025_enqueue_recipe_scripts');

  
?>

