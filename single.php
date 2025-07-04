<?php get_header(); ?>

<main class="container py-5">

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

    <article <?php post_class('recipe-post'); ?>>
      <h1 class="mb-4"><?php the_title(); ?></h1>

      <?php if (has_post_thumbnail()) : ?>
        <div class="mb-4">
          <?php the_post_thumbnail('large', ['class' => 'img-fluid rounded']); ?>
        </div>
      <?php endif; ?>

      <div class="meta mb-4 text-muted small">
        <?php
          $meal = get_the_term_list(get_the_ID(), 'meal', '<strong>Meal:</strong> ', ', ');
          $cuisine = get_the_term_list(get_the_ID(), 'cuisine', '<strong>Cuisine:</strong> ', ', ');
          $ingredients = get_the_term_list(get_the_ID(), 'ingredient', '<strong>Ingredients:</strong> ', ', ');
          $diet = get_the_term_list(get_the_ID(), 'diet', '<strong>Diet:</strong> ', ', ');

          echo $meal ? "<p>$meal</p>" : '';
          echo $cuisine ? "<p>$cuisine</p>" : '';
          echo $ingredients ? "<p>$ingredients</p>" : '';
          echo $diet ? "<p>$diet</p>" : '';
        ?>
      </div>

      <div class="recipe-content">
        <?php the_content(); ?>
      </div>
    </article>

  <?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>