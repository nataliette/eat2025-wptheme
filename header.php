<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="p-3">
  <div class="container">
    <h1 class="mb-0">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="text-decoration-none text-dark">
        <?php bloginfo('name'); ?>
      </a>
    </h1>
  </div>
</header>