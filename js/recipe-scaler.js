document.addEventListener("DOMContentLoaded", function () {
    let scale = 1;
    let unitSystem = 'metric';
  
    function formatFraction(value) {
      const map = { 0.25: '¼', 0.33: '⅓', 0.5: '½', 0.66: '⅔', 0.75: '¾' };
      const whole = Math.floor(value);
      const decimal = +(value - whole).toFixed(2);
      let fraction = '';
  
      for (let dec in map) {
        if (Math.abs(decimal - parseFloat(dec)) < 0.02) {
          fraction = map[dec];
          break;
        }
      }
  
      if (whole && fraction) return `${whole} ${fraction}`;
      if (!whole && fraction) return fraction;
      if (!fraction && decimal < 0.02) return `${whole}`;
      return value.toFixed(2).replace(/\.00$/, '');
    }
  
    function convert(amount, unit, toImperial) {
      const conversions = {
        g: amt => amt * 0.0353,
        kg: amt => amt * 2.2046,
        ml: amt => amt * 0.0338,
        l: amt => amt * 4.2268
      };
  
      const outputUnits = {
        g: 'oz',
        kg: 'lb',
        ml: 'fl oz',
        l: 'cups',
        pc: 'pcs'
      };
  
      unit = unit.toLowerCase();
      let newAmt = amount;
      let newUnit = unit;
  
      if (toImperial && conversions[unit]) {
        newAmt = conversions[unit](amount);
        newUnit = outputUnits[unit] || unit;
      } else if (!toImperial && unit === 'pc') {
        newUnit = 'pc';
      }
  
      if (newUnit === 'pc' || newUnit === 'pcs') {
        newUnit = newAmt >= 2 ? 'pcs' : 'pc';
      }
  
      return {
        amount: newAmt,
        unit: newUnit
      };
    }
  
    function updateIngredients() {
      const useImperial = unitSystem === 'imperial';
  
      document.querySelectorAll('.ingredient-amount').forEach(span => {
        const parent = span.closest('[data-amount][data-unit]');
        const baseAmt = parseFloat(parent.dataset.amount);
        const unit = parent.dataset.unit;
        const scaledAmt = baseAmt * scale;
  
        const converted = convert(scaledAmt, unit, useImperial);
        const formatted = formatFraction(converted.amount);
  
        span.textContent = formatted;
  
        const unitSpan = parent.querySelector('.ingredient-unit');
        if (unitSpan) {
          unitSpan.textContent = converted.unit;
        }
      });
    }
  
    // Hook up unit toggle (radio-style)
    document.querySelectorAll('input[name="units"]').forEach(input => {
      input.addEventListener('change', function () {
        unitSystem = this.value;
        updateIngredients();
      });
    });
  
    // Hook up yield toggle
    document.querySelectorAll('input[name="yield"]').forEach(input => {
      input.addEventListener('change', function () {
        switch (this.value) {
          case 'half': scale = 0.5; break;
          case 'double': scale = 2; break;
          default: scale = 1;
        }
        updateIngredients();
      });
    });
  
    updateIngredients(); // Initial run
  });