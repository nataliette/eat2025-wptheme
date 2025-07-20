<?php get_header(); ?>

<main class="container my-5">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <article <?php post_class(); ?>>

      <div class="row gx-5">
        <div class="col-md-6">
          <h1 class="mb-2"><?php the_title(); ?></h1>

            <?php if ($desc = get_field('recipe_description')): ?>
              <p class="lead"><?php echo esc_html($desc); ?></p>
            <?php endif; ?>

          <?php
          function format_minutes_to_duration($minutes) {
            if (!is_numeric($minutes) || $minutes <= 0) return '';
            $hours = floor($minutes / 60);
            $mins = $minutes % 60;
            $parts = [];
            if ($hours > 0) $parts[] = $hours . ' hour' . ($hours > 1 ? 's' : '');
            if ($mins > 0) $parts[] = $mins . ' mins';
            return implode(' ', $parts);
          }
          ?>

          <ul class="d-flex flex-wrap gap-2 my-3 recipe-meta list-unstyled">
            <?php
              $total = get_field('total_time');
              if (!$total) {
                $prep = (int) get_field('prep_time');
                $rest = (int) get_field('rest_time');
                $cook = (int) get_field('cook_time');
                $total = $prep + $rest + $cook;
              }
            ?>
            <li class="badge rounded-pill border py-2 px-3"><i class="bi bi-clock"></i> <?php echo format_minutes_to_duration($total); ?></li>
            <li class="badge rounded-pill border py-2 px-3"><i class="bi bi-measuring-cup"></i> <?= esc_html(get_field('yield')); ?></li>
            <li class="badge rounded-pill border py-2 px-3"><i class="bi bi-egg-fried"></i> <?= get_the_term_list(get_the_ID(), 'meal', '', ', '); ?></li>
            <?php
              $diets = get_the_terms(get_the_ID(), 'diet');
              if ($diets) {
                foreach ($diets as $term) {
                  echo '<li class="badge rounded-pill border py-2 px-3"><i class="bi bi-fork-knife"></i> ' . esc_html($term->name) . '</li>';
                }
              }

              $cuisines = get_the_terms(get_the_ID(), 'cuisine');
              if ($cuisines) {
                foreach ($cuisines as $term) {
                  echo '<li class="badge rounded-pill border py-2 px-3"><i class="bi bi-globe-americas"></i> ' . esc_html($term->name) . '</li>';
                }
              }
            ?>
          </ul>

          <?php if (have_rows('ingredients_group')): ?>
            <section class="mb-4">

              <h2>Ingredients</h2>

              <!-- Units & Yield Toggle -->
              <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                <div class="d-flex align-items-center gap-2">
                  <span class="fw-semibold">Units:</span>
                  <div class="btn-group" role="group" aria-label="Units">
                    <input type="radio" class="btn-check" name="units" id="unitMetric" value="metric" autocomplete="off" checked>
                    <label class="btn btn-outline-dark btn-sm" for="unitMetric">Metric</label>

                    <input type="radio" class="btn-check" name="units" id="unitImperial" value="imperial" autocomplete="off">
                    <label class="btn btn-outline-dark btn-sm" for="unitImperial">Imperial</label>
                  </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                  <span class="fw-semibold">Yield:</span>
                  <div class="btn-group" role="group" aria-label="Yield">
                    <input type="radio" class="btn-check" name="yield" id="yieldOriginal" value="original" autocomplete="off" checked>
                    <label class="btn btn-outline-dark btn-sm" for="yieldOriginal">Original</label>

                    <input type="radio" class="btn-check" name="yield" id="yieldHalf" value="half" autocomplete="off">
                    <label class="btn btn-outline-dark btn-sm" for="yieldHalf">Half</label>

                    <input type="radio" class="btn-check" name="yield" id="yieldDouble" value="double" autocomplete="off">
                    <label class="btn btn-outline-dark btn-sm" for="yieldDouble">Double</label>
                  </div>
                </div>
              </div>

              <!-- Ingredient Groups -->
              <?php while (have_rows('ingredients_group')): the_row(); ?>
                <?php $group_label = get_sub_field('group_label'); ?>
                <?php if ($group_label): ?>
                  <h4 class="h6 mt-4"><?php echo esc_html($group_label); ?></h4>
                <?php endif; ?>

                <ul class="list-unstyled mb-3">
                  <?php if (have_rows('items')): ?>
                    <?php while (have_rows('items')): the_row(); 
                      $amount = get_sub_field('amount');
                      $unit = get_sub_field('unit');
                      $ingredient = get_sub_field('ingredient');
                      $prep = get_sub_field('prep_note');
                      $optional = get_sub_field('optional');
                    ?>
                      <li class="mb-1" data-amount="<?= esc_attr($amount); ?>" data-unit="<?= esc_attr($unit); ?>">
                        <label class="form-check-label d-flex align-items-start">
                          <input type="checkbox" class="form-check-input me-2 mt-1">
                          <span>
                            <span class="ingredient-amount"><?= esc_html($amount); ?></span>
                            <span class="ingredient-unit"><?= esc_html($unit); ?></span>
                            <?= esc_html($ingredient); ?>
                            <?php if ($prep): ?>, <?= esc_html($prep); ?><?php endif; ?>
                            <?php if ($optional): ?> <em>(optional)</em><?php endif; ?>
                          </span>
                        </label>
                      </li>
                    <?php endwhile; ?>
                  <?php endif; ?>
                </ul>
              <?php endwhile; ?>
              </section>
          <?php endif; ?>
        </div>

        <div class="col-md-6">

          <?php if ($method = get_field('method')): ?>
            <section class="mb-4">
              <h2>Method</h2>
              <?php echo apply_filters('the_content', $method); ?>
            </section>
          <?php endif; ?>

          <?php if (get_field('notes')): ?>
            <div class="border rounded p-3 bg-light mt-4">
              <h5 class="fw-semibold mb-2">Notes</h5>
              <?= apply_filters('the_content', get_field('notes')); ?>
            </div>
          <?php endif; ?>

          <?php if ($nutrition = get_field('nutrition_info')): ?>
            <section class="mb-4">
              <h2>Nutrition Information</h2>
              <?php echo apply_filters('the_content', $nutrition); ?>
            </section>
          <?php endif; ?>

        </div>
      </div>

      <footer class="mt-5">
      </footer>

    </article>

  <?php endwhile; endif; ?>
</main>









<script>
document.addEventListener("DOMContentLoaded", function () {
  const scaleSelect = document.getElementById('yield-scale');
  const unitSelect = document.getElementById('unit-toggle');

  function convert(amount, unit, toImperial) {
    const conversions = {
      // grams to ounces
      g: toImperial ? amt => amt * 0.0353 : amt => amt,
      // milliliters to fluid ounces
      ml: toImperial ? amt => amt * 0.0338 : amt => amt,
      // kg to lb
      kg: toImperial ? amt => amt * 2.2046 : amt => amt,
      // tsp to tsp
      tsp: amt => amt,
      tbsp: amt => amt,
      cup: amt => amt,
    };

    unit = unit.toLowerCase();
    const converter = conversions[unit] || (x => x);
    const newAmt = converter(parseFloat(amount));

    // Format fractions for imperial
    return {
      amount: Math.round(newAmt * 100) / 100,
      unit: toImperial ? {
        g: 'oz',
        ml: 'fl oz',
        kg: 'lb'
      }[unit] || unit : unit
    };
  }

  function updateIngredients() {
    const factor = parseFloat(scaleSelect.value);
    const useImperial = unitSelect.value === 'imperial';

    document.querySelectorAll('.ingredient-item').forEach(item => {
      const baseAmt = parseFloat(item.getAttribute('data-amount'));
      const unit = item.getAttribute('data-unit');
      const scaledAmt = baseAmt * factor;
      const converted = convert(scaledAmt, unit, useImperial);

      item.querySelector('.amount').textContent = converted.amount;
      item.querySelector('.unit').textContent = converted.unit;
    });
  }

  scaleSelect.addEventListener('change', updateIngredients);
  unitSelect.addEventListener('change', updateIngredients);
});
</script>
<?php get_footer(); ?>