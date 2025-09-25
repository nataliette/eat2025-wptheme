<?php
// inc/acf-recipe-fields.php
if (!defined('ABSPATH')) exit;

add_action('acf/init', function () {
  if (!function_exists('acf_add_local_field_group')) return;

  acf_add_local_field_group([
    'key' => 'group_recipe_meta',
    'title' => 'Recipe Meta',
    'fields' => [

      // One-line Description
      [
        'key' => 'field_recipe_short_desc',
        'label' => 'One-line Description',
        'name' => 'recipe_short_desc',
        'type' => 'text',
        'instructions' => 'Very short hook/summary (one sentence).',
        'required' => 0,
      ],

      // Times (minutes)
      [
        'key' => 'field_recipe_times',
        'label' => 'Times',
        'name' => 'recipe_times',
        'type' => 'group',
        'layout' => 'block',
        'sub_fields' => [
          [
            'key' => 'field_prep_minutes',
            'label' => 'Prep (min)',
            'name' => 'prep_minutes',
            'type' => 'number',
            'min' => 0,
            'step' => 1,
          ],
          [
            'key' => 'field_rest_minutes',
            'label' => 'Rest (min, optional)',
            'name' => 'rest_minutes',
            'type' => 'number',
            'min' => 0,
            'step' => 1,
          ],
          [
            'key' => 'field_cook_minutes',
            'label' => 'Cook (min)',
            'name' => 'cook_minutes',
            'type' => 'number',
            'min' => 0,
            'step' => 1,
          ],
          [
            'key' => 'field_total_minutes',
            'label' => 'Total Time (min)',
            'name' => 'total_minutes',
            'type' => 'number',
            'min' => 0,
            'step' => 1,
            'instructions' => 'Enter explicitly (don’t auto-calc).',
          ],
        ]
      ],

      // Yield & Serving Size
      [
        'key' => 'field_recipe_yield',
        'label' => 'Yield',
        'name' => 'recipe_yield',
        'type' => 'text',
        'instructions' => 'e.g., “4 servings” or “1 loaf (8 slices)”.',
      ],
      [
        'key' => 'field_serving_size',
        'label' => 'Serving Size',
        'name' => 'serving_size',
        'type' => 'text',
        'instructions' => 'e.g., “220 g per serve” or “1 slice”. (Note: nutrition is per serving only.)',
      ],

      // Ingredients Repeater
      [
        'key' => 'field_ingredients',
        'label' => 'Ingredients',
        'name' => 'ingredients',
        'type' => 'repeater',
        'instructions' => 'Shown as a checklist on the front-end.',
        'collapsed' => 'field_ing_item',
        'layout' => 'row',
        'button_label' => 'Add Ingredient',
        'sub_fields' => [
          [
            'key' => 'field_ing_amount',
            'label' => 'Amount',
            'name' => 'amount',
            'type' => 'text',
            'placeholder' => 'e.g., ½, 1, 100',
          ],
          [
            'key' => 'field_ing_unit',
            'label' => 'Unit',
            'name' => 'unit',
            'type' => 'text',
            'placeholder' => 'g, ml, tsp, tbsp, cup, etc.',
          ],
          [
            'key' => 'field_ing_item',
            'label' => 'Ingredient',
            'name' => 'item',
            'type' => 'text',
            'placeholder' => 'Flour, chicken thigh, etc.',
          ],
          [
            'key' => 'field_ing_brand',
            'label' => 'Brand (optional)',
            'name' => 'brand',
            'type' => 'text',
            'placeholder' => 'e.g., Bob’s Red Mill',
          ],
          [
            'key' => 'field_ing_note',
            'label' => 'Note (optional)',
            'name' => 'note',
            'type' => 'text',
            'placeholder' => 'room temp, divided, etc.',
          ],
          [
            'key' => 'field_ing_group',
            'label' => 'Group (optional)',
            'name' => 'group',
            'type' => 'text',
            'instructions' => 'e.g., “Dough”, “Topping”.',
          ],
        ],
      ],

      // Method (steps with nested sub-steps)
      [
        'key' => 'field_method',
        'label' => 'Method',
        'name' => 'method',
        'type' => 'repeater',
        'layout' => 'row',
        'button_label' => 'Add Step',
        'sub_fields' => [
          [
            'key' => 'field_step_text',
            'label' => 'Step',
            'name' => 'step_text',
            'type' => 'textarea',
            'rows' => 2,
          ],
          [
            'key' => 'field_substeps',
            'label' => 'Sub-steps (optional)',
            'name' => 'substeps',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => 'Add Sub-step',
            'sub_fields' => [
              [
                'key' => 'field_substep_text',
                'label' => 'Sub-step',
                'name' => 'substep_text',
                'type' => 'textarea',
                'rows' => 2,
              ],
            ],
          ],
        ],
      ],

      // Notes
      [
        'key' => 'field_notes',
        'label' => 'Notes (optional)',
        'name' => 'notes',
        'type' => 'textarea',
        'rows' => 3,
      ],

      // Nutrition (per serving ONLY)
      [
        'key' => 'field_nutrition_group',
        'label' => 'Nutrition (per serving)',
        'name' => 'nutrition_per_serving',
        'type' => 'group',
        'layout' => 'block',
        'instructions' => 'These values are PER SERVING. No auto-scaling.',
        'sub_fields' => [
          [
            'key' => 'field_kcal',
            'label' => 'Calories (kcal)',
            'name' => 'calories_kcal',
            'type' => 'number',
            'min' => 0, 'step' => 'any',
          ],
          [
            'key' => 'field_protein',
            'label' => 'Protein (g)',
            'name' => 'protein_g',
            'type' => 'number',
            'min' => 0, 'step' => 'any',
          ],
          [
            'key' => 'field_carbs',
            'label' => 'Carbohydrates (g)',
            'name' => 'carbs_g',
            'type' => 'number',
            'min' => 0, 'step' => 'any',
          ],
          [
            'key' => 'field_fat',
            'label' => 'Fat (g)',
            'name' => 'fat_g',
            'type' => 'number',
            'min' => 0, 'step' => 'any',
          ],
        ],
      ],

      // Recipe Breakdown (per-ingredient macros table you enter)
      [
        'key' => 'field_breakdown',
        'label' => 'Recipe Breakdown (per ingredient)',
        'name' => 'recipe_breakdown',
        'type' => 'repeater',
        'instructions' => 'Each row: “<Amount> <Ingredient> (<Brand>)” + macros.',
        'layout' => 'table',
        'button_label' => 'Add Row',
        'sub_fields' => [
          [
            'key' => 'field_rb_line',
            'label' => 'Ingredient (display line)',
            'name' => 'line',
            'type' => 'text',
            'placeholder' => 'e.g., 100 g cream cheese (Philadelphia)',
          ],
          [
            'key' => 'field_rb_kcal',
            'label' => 'Calories',
            'name' => 'calories',
            'type' => 'number',
            'step' => 'any',
          ],
          [
            'key' => 'field_rb_pro',
            'label' => 'Protein (g)',
            'name' => 'protein',
            'type' => 'number',
            'step' => 'any',
          ],
          [
            'key' => 'field_rb_carb',
            'label' => 'Carbs (g)',
            'name' => 'carbs',
            'type' => 'number',
            'step' => 'any',
          ],
          [
            'key' => 'field_rb_fat',
            'label' => 'Fat (g)',
            'name' => 'fat',
            'type' => 'number',
            'step' => 'any',
          ],
        ],
      ],

    ],
    'location' => [[['param' => 'post_type', 'operator' => '==', 'value' => 'post']]],
    'style' => 'seamless',
    'position' => 'normal',
    'active' => true,
    'show_in_rest' => 1,
  ]);
});
