/* ============================================================
   SunShine Tours - Booking Form JavaScript
   Implements Uebung 13 requirements:
   1a) Add "required" via DOM to address + date fields
   1b) Calculate cost (persons x days x price + excursions)
   1c) Display cost dynamically in a DIV
   2)  Summary of all form data with "Check inputs" button
   ============================================================ */

document.addEventListener('DOMContentLoaded', function () {

  var form = document.getElementById('bookingForm');
  if (!form) return;

  // -------------------------------------------------------
  // 1a) Add "required" attribute via JavaScript (DOM)
  //     to address fields and travel date fields
  // -------------------------------------------------------
  var requiredIds = [
    'lastName', 'firstName', 'address', 'email',
    'arrivalDate', 'departureDate'
  ];

  requiredIds.forEach(function (id) {
    var el = document.getElementById(id);
    if (el) {
      el.setAttribute('required', 'required');
    }
  });

  // -------------------------------------------------------
  // 1b + 1c) Real-time cost calculation
  // -------------------------------------------------------
  var pricePerDay = parseFloat(document.getElementById('pricePerDay').value) || 69;
  var costDisplay = document.getElementById('costDisplay');

  function calculateCost() {
    var persons = parseInt(document.getElementById('numPersons').value) || 1;
    var arrivalVal = document.getElementById('arrivalDate').value;
    var departureVal = document.getElementById('departureDate').value;

    var days = 0;
    if (arrivalVal && departureVal) {
      var arrival = new Date(arrivalVal);
      var departure = new Date(departureVal);
      if (departure > arrival) {
        days = Math.ceil((departure - arrival) / (1000 * 60 * 60 * 24));
      }
    }

    var baseCost = persons * days * pricePerDay;

    // Excursion costs
    var excursionCost = 0;
    var excursionNames = [];
    document.querySelectorAll('input[name="excursions[]"]:checked').forEach(function (cb) {
      excursionCost += parseFloat(cb.getAttribute('data-price')) || 0;
      excursionNames.push(cb.parentElement.textContent.trim());
    });

    var total = baseCost + excursionCost;

    // Build cost display HTML
    var html = '<h3>&#128176; Kostenubersicht (Live!)</h3>';

    if (days > 0) {
      html += '<p class="cost-line">' + persons + ' Person(en) x ' + days + ' Tag(e) x ' + pricePerDay.toFixed(2) + ' EUR = <strong>' + baseCost.toFixed(2) + ' EUR</strong></p>';
    } else {
      html += '<p class="cost-line">Bitte Reisedaten auswaehlen...</p>';
    }

    if (excursionNames.length > 0) {
      html += '<p class="cost-line">Ausfluege: ' + excursionNames.join(', ') + ' = <strong>' + excursionCost.toFixed(2) + ' EUR</strong></p>';
    }

    html += '<div class="cost-total">TOTAL: ' + total.toFixed(2) + ' EUR</div>';

    if (total > 1000) {
      html += '<p style="color: var(--hot-orange); font-size: 0.85rem; margin-top: 5px;">&#128293; Wow, big spender! Are you sure about this?</p>';
    }

    costDisplay.innerHTML = html;
  }

  // Attach event listeners for real-time updates
  ['numPersons', 'arrivalDate', 'departureDate'].forEach(function (id) {
    var el = document.getElementById(id);
    if (el) {
      el.addEventListener('change', calculateCost);
      el.addEventListener('input', calculateCost);
    }
  });

  document.querySelectorAll('input[name="excursions[]"]').forEach(function (cb) {
    cb.addEventListener('change', calculateCost);
  });

  // Initial calculation
  calculateCost();

  // -------------------------------------------------------
  // Dynamic additional person fields
  // -------------------------------------------------------
  var numPersonsField = document.getElementById('numPersons');
  var additionalContainer = document.getElementById('additionalPersons');

  if (numPersonsField && additionalContainer) {
    numPersonsField.addEventListener('change', updateAdditionalPersons);
    numPersonsField.addEventListener('input', updateAdditionalPersons);
  }

  function updateAdditionalPersons() {
    var count = parseInt(numPersonsField.value) || 1;
    additionalContainer.innerHTML = '';

    for (var i = 2; i <= count; i++) {
      var div = document.createElement('div');
      div.className = 'additional-person';
      div.innerHTML =
        '<label>Person ' + i + ':</label>' +
        '<input type="text" name="additional_first_' + i + '" placeholder="Vorname">' +
        '<input type="text" name="additional_last_' + i + '" placeholder="Nachname">';
      additionalContainer.appendChild(div);
    }

    // Recalculate cost when persons change
    calculateCost();
  }

  // -------------------------------------------------------
  // 2) Summary of all form data - "Eingaben pruefen" button
  // -------------------------------------------------------
  var checkBtn = document.getElementById('checkInputsBtn');
  var summaryDisplay = document.getElementById('summaryDisplay');

  if (checkBtn && summaryDisplay) {
    checkBtn.addEventListener('click', function () {
      var formData = new FormData(form);
      var html = '<h3>&#128270; Zusammenfassung Ihrer Eingaben</h3>';
      html += '<table>';

      // Readable field labels
      var labels = {
        'destination': 'Reiseziel',
        'last_name': 'Nachname',
        'first_name': 'Vorname',
        'address': 'Adresse',
        'phone': 'Telefonnummer',
        'email': 'E-Mail',
        'num_persons': 'Anzahl Personen',
        'num_rooms': 'Zimmer/Betten',
        'arrival_date': 'Anreise',
        'departure_date': 'Abreise',
        'excursions[]': 'Ausfluege',
        'smoking': 'Raucher/Nichtraucher',
        'credit_card': 'Kreditkarte',
        'notes': 'Anmerkungen'
      };

      // Collect excursions separately
      var excursions = [];
      var seenKeys = {};

      for (var pair of formData.entries()) {
        var key = pair[0];
        var value = pair[1];

        // Skip hidden fields
        if (key === 'offer_number' || key === 'price_per_day') continue;

        // Collect excursions
        if (key === 'excursions[]') {
          excursions.push(value);
          continue;
        }

        // Handle additional persons
        if (key.startsWith('additional_')) {
          var parts = key.split('_');
          var personNum = parts[parts.length - 1];
          var fieldType = parts[1]; // first or last
          var displayKey = 'Person ' + personNum + ' ' + (fieldType === 'first' ? 'Vorname' : 'Nachname');
          html += '<tr><td>' + displayKey + '</td><td>' + escapeHtml(value || '-') + '</td></tr>';
          continue;
        }

        var label = labels[key] || key;
        var displayValue = value || '-';

        // Mask credit card
        if (key === 'credit_card' && value.length > 4) {
          displayValue = '*'.repeat(value.length - 4) + value.slice(-4);
        }

        // Translate smoking
        if (key === 'smoking') {
          displayValue = value === 'smoker' ? 'Raucher' : 'Nichtraucher';
        }

        // Translate destination
        if (key === 'destination') {
          var destNames = {
            'paris': 'Paris, Frankreich',
            'pyongyang': 'Pyongyang, Nordkorea',
            'chernobyl': 'Chernobyl, Ukraine',
            'gary': 'Gary, Indiana, USA',
            'bielefeld': 'Bielefeld, Deutschland'
          };
          displayValue = destNames[value] || value || '-';
        }

        if (!seenKeys[key]) {
          html += '<tr><td>' + label + '</td><td>' + escapeHtml(displayValue) + '</td></tr>';
          seenKeys[key] = true;
        }
      }

      // Add excursions row
      if (excursions.length > 0) {
        html += '<tr><td>Ausfluege</td><td>' + escapeHtml(excursions.join(', ')) + '</td></tr>';
      }

      html += '</table>';

      summaryDisplay.innerHTML = html;
      summaryDisplay.classList.add('visible');
      summaryDisplay.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
  }

  function escapeHtml(str) {
    var div = document.createElement('div');
    div.appendChild(document.createTextNode(str));
    return div.innerHTML;
  }

});
