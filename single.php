<?php get_header(); ?>

<main class="container my-5">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <article <?php post_class(); ?>>
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

      <section class="mb-4">
        <ul class="list-unstyled">
          <?php if ($prep = get_field('prep_time')): ?>
            <li><strong>Prep Time:</strong> <?php echo format_minutes_to_duration($prep); ?></li>
          <?php endif; ?>
          <?php if ($rest = get_field('rest_time')): ?>
            <li><strong>Rest Time:</strong> <?php echo format_minutes_to_duration($rest); ?></li>
          <?php endif; ?>
          <?php if ($cook = get_field('cook_time')): ?>
            <li><strong>Cook Time:</strong> <?php echo format_minutes_to_duration($cook); ?></li>
          <?php endif; ?>

          <?php
            $total = get_field('total_time');
            if (!$total) {
              $prep = (int) get_field('prep_time');
              $rest = (int) get_field('rest_time');
              $cook = (int) get_field('cook_time');
              $total = $prep + $rest + $cook;
            }
          ?>
          <?php if ($total): ?>
            <li><strong>Total Time:</strong> <?php echo format_minutes_to_duration($total); ?></li>
          <?php endif; ?>
        </ul>
        <ul class="list-unstyled">
          <?php if ($yield = get_field('yield')): ?>
            <li><strong>Yield:</strong> <?php echo esc_html($yield); ?></li>
          <?php endif; ?>
          <?php if ($serving = get_field('serving_size')): ?>
            <li><strong>Serving Size:</strong> <?php echo esc_html($serving); ?></li>
          <?php endif; ?>
        </ul>
      </section>

      <?php if (have_rows('ingredients_group')): ?>
        <div class="mb-4">

          <!-- Units & Yield Toggle -->
          <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
            <div class="d-flex align-items-center gap-2">
              <span class="fw-semibold">Units:</span>
              <div class="btn-group" role="group" aria-label="Units">
                <input type="radio" class="btn-check" name="units" id="unitMetric" value="metric" autocomplete="off" checked>
                <label class="btn btn-outline-secondary btn-sm" for="unitMetric">Metric</label>

                <input type="radio" class="btn-check" name="units" id="unitImperial" value="imperial" autocomplete="off">
                <label class="btn btn-outline-secondary btn-sm" for="unitImperial">Imperial</label>
              </div>
            </div>

            <div class="d-flex align-items-center gap-2">
              <span class="fw-semibold">Yield:</span>
              <div class="btn-group" role="group" aria-label="Yield">
                <input type="radio" class="btn-check" name="yield" id="yieldOriginal" value="original" autocomplete="off" checked>
                <label class="btn btn-outline-secondary btn-sm" for="yieldOriginal">Original</label>

                <input type="radio" class="btn-check" name="yield" id="yieldHalf" value="half" autocomplete="off">
                <label class="btn btn-outline-secondary btn-sm" for="yieldHalf">½</label>

                <input type="radio" class="btn-check" name="yield" id="yieldDouble" value="double" autocomplete="off">
                <label class="btn btn-outline-secondary btn-sm" for="yieldDouble">2×</label>
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
        </div>
      <?php endif; ?>

      <?php if ($method = get_field('method')): ?>
        <section class="mb-4">
          <h2>Method</h2>
          <?php echo apply_filters('the_content', $method); ?>
        </section>
      <?php endif; ?>

      <?php if ($notes = get_field('notes')): ?>
        <section class="mb-4">
          <h2>Notes</h2>
          <?php echo apply_filters('the_content', $notes); ?>
        </section>
      <?php endif; ?>

      <?php if ($nutrition = get_field('nutrition_info')): ?>
        <section class="mb-4">
          <h2>Nutrition Information</h2>
          <?php echo apply_filters('the_content', $nutrition); ?>
        </section>
      <?php endif; ?>

      <footer class="mt-5">
        <div class="taxonomy">
          <p><strong>Cuisine:</strong> <?php the_terms(get_the_ID(), 'cuisine', '', ', '); ?></p>
          <p><strong>Meal:</strong> <?php the_terms(get_the_ID(), 'meal', '', ', '); ?></p>
          <p><strong>Ingredients:</strong> <?php the_terms(get_the_ID(), 'ingredients', '', ', '); ?></p>
          <p><strong>Diet:</strong> <?php the_terms(get_the_ID(), 'diet', '', ', '); ?></p>
        </div>
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