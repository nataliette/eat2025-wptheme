<?php get_header(); ?>

<main class="container py-5">

  <h1 class="mb-4">All Recipes</h1>

  <?php if (have_posts()) : ?>
    <ul class="recipe-list list-unstyled">
      <?php while (have_posts()) : the_post(); ?>
        <li class="mb-4">
          <h2 class="h5 mb-1">
            <a href="<?php the_permalink(); ?>" class="text-decoration-none">
              <?php the_title(); ?>
            </a>
          </h2>

          <div class="text-muted small">
            <?php
              $meal = get_the_term_list(get_the_ID(), 'meal', '', ', ');
              $cuisine = get_the_term_list(get_the_ID(), 'cuisine', '', ', ');
              if ($meal || $cuisine) {
                echo $meal ? "<span class='me-2'>🍽️ $meal</span>" : '';
                echo $cuisine ? "<span>🌍 $cuisine</span>" : '';
              }
            ?>
          </div>
        </li>
      <?php endwhile; ?>
    </ul>

  <?php else : ?>
    <p>No recipes found.</p>
  <?php endif; ?>

</main>

<?php get_footer(); ?>