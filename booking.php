<?php
$page_title = 'Book Now';
$include_booking_js = true;
?>
<?php include 'includes/header.php'; ?>

<div class="section-header" style="padding-top: 20px;">
  <h1>&#128176; Book Your Dream Vacation</h1>
  <p class="subtitle">Fill out the form below. No refunds. No regrets. Okay maybe some regrets.</p>
</div>

<div class="booking-section">

  <!-- Summary Display (Uebung 13, Aufgabe 2) - shown above the form -->
  <div id="summaryDisplay"></div>

  <!-- Check Inputs Button (Uebung 13) -->
  <button type="button" class="check-btn" id="checkInputsBtn">
    &#128270; Eingaben pruefen (Check Your Inputs)
  </button>

  <!-- Cost Display (Uebung 13, 1c) - dynamic cost display -->
  <div id="costDisplay">
    <h3>&#128176; Kostenubersicht (Live!)</h3>
    <p class="cost-line">Bitte Reisedaten auswaehlen...</p>
    <div class="cost-total">TOTAL: 0.00 EUR</div>
  </div>

  <!-- Booking Form -->
  <form id="bookingForm" action="process_booking.php" method="POST">

    <!-- Hidden Fields -->
    <!-- Uebung 07: verstecktes Feld mit interner Angebotsnummer -->
    <input type="hidden" name="offer_number" value="ST-2026-0042">
    <!-- Uebung 13: hidden price per day per person for cost calculation -->
    <input type="hidden" name="price_per_day" id="pricePerDay" value="69">

    <!-- 1. Reiseziel (Destination) -->
    <fieldset>
      <legend>&#127758; Reiseziel (Destination)</legend>
      <div class="form-group">
        <label for="destination">Wohin soll die Reise gehen?</label>
        <select name="destination" id="destination" required>
          <option value="">-- Bitte waehlen / Please choose --</option>
          <option value="paris">&#127879; Paris, Frankreich - City of Love & Overpriced Croissants</option>
          <option value="pyongyang">&#127471;&#127472; Pyongyang, Nordkorea - 5-Star Government Escort!</option>
          <option value="chernobyl">&#9762;&#65039; Chernobyl, Ukraine - Glowing Reviews!</option>
          <option value="gary">&#127961;&#65039; Gary, Indiana, USA - The American Dream (Barely Alive)</option>
          <option value="bielefeld">&#128123; Bielefeld, Deutschland - Does It Even Exist?</option>
        </select>
      </div>
    </fieldset>

    <!-- 2. Persoenliche Daten (Personal Data) -->
    <fieldset>
      <legend>&#128100; Persoenliche Daten (Personal Data)</legend>
      <div class="form-row">
        <div class="form-group">
          <label for="lastName">Nachname (Last Name) *</label>
          <input type="text" name="last_name" id="lastName" placeholder="z.B. McBookington">
        </div>
        <div class="form-group">
          <label for="firstName">Vorname (First Name) *</label>
          <input type="text" name="first_name" id="firstName" placeholder="z.B. Chad">
        </div>
      </div>
      <div class="form-group">
        <label for="address">Adresse (Address) *</label>
        <input type="text" name="address" id="address" placeholder="z.B. Kellerstrasse 69, 68159 Mannheim">
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="phone">Telefonnummer (Phone)</label>
          <input type="tel" name="phone" id="phone" placeholder="z.B. 0800-SCAM-420">
        </div>
        <div class="form-group">
          <label for="email">E-Mail-Adresse *</label>
          <input type="email" name="email" id="email" placeholder="z.B. yolo@sunshine-tours.fake">
        </div>
      </div>
    </fieldset>

    <!-- 3. Reisedetails (Travel Details) -->
    <fieldset>
      <legend>&#128197; Reisedetails (Travel Details)</legend>

      <div class="form-row">
        <div class="form-group">
          <label for="numPersons">Anzahl Personen / Number of Persons (max. 4)</label>
          <input type="number" name="num_persons" id="numPersons" min="1" max="4" value="1">
        </div>
        <div class="form-group">
          <label for="numRooms">Anzahl Zimmer/Betten (Rooms/Beds)</label>
          <input type="number" name="num_rooms" id="numRooms" min="1" max="10" value="1">
        </div>
      </div>

      <!-- Dynamic additional person fields (populated by JS) -->
      <div id="additionalPersons"></div>

      <div class="form-row">
        <div class="form-group">
          <label for="arrivalDate">Anreisedatum (Arrival Date) *</label>
          <input type="date" name="arrival_date" id="arrivalDate">
        </div>
        <div class="form-group">
          <label for="departureDate">Abreisedatum (Departure Date) *</label>
          <input type="date" name="departure_date" id="departureDate">
        </div>
      </div>
    </fieldset>

    <!-- 4. Ausfluege & Extras (Excursions & Extras) -->
    <fieldset>
      <legend>&#127915; Ausfluege & Extras (Excursions)</legend>

      <p style="margin-bottom: 10px; color: var(--text-muted);">Optional excursions (flat fee, added to total):</p>
      <div class="checkbox-group">
        <label>
          <input type="checkbox" name="excursions[]" value="sewer_tour" data-price="25">
          <span>&#128701; Guided Sewer System Tour (25 EUR)</span>
        </label>
        <label>
          <input type="checkbox" name="excursions[]" value="cat_safari" data-price="15">
          <span>&#128008; Street Cat Safari (15 EUR)</span>
        </label>
        <label>
          <input type="checkbox" name="excursions[]" value="mystery_food" data-price="30">
          <span>&#127828; Mystery Food Challenge (30 EUR)</span>
        </label>
        <label>
          <input type="checkbox" name="excursions[]" value="haunted_parking" data-price="20">
          <span>&#128123; Haunted Parking Lot Visit (20 EUR)</span>
        </label>
        <label>
          <input type="checkbox" name="excursions[]" value="pigeon_watching" data-price="10">
          <span>&#128038; Extreme Pigeon Watching (10 EUR)</span>
        </label>
      </div>

      <hr style="border-color: var(--border-color); margin: 15px 0;">

      <p style="margin-bottom: 10px; color: var(--text-muted);">Raucher / Nichtraucher (Smoker / Non-Smoker):</p>
      <div class="radio-group">
        <label>
          <input type="radio" name="smoking" value="smoker">
          <span>&#128684; Raucher (Smoker)</span>
        </label>
        <label>
          <input type="radio" name="smoking" value="non_smoker" checked>
          <span>&#128285; Nichtraucher (Non-Smoker)</span>
        </label>
      </div>
    </fieldset>

    <!-- 5. Zahlung (Payment) -->
    <fieldset>
      <legend>&#128179; Zahlung (Payment)</legend>
      <div class="form-group">
        <label for="creditCard">Kreditkartennummer (Credit Card Number)</label>
        <input type="text" name="credit_card" id="creditCard" placeholder="z.B. 4242 4242 4242 4242" maxlength="19">
        <small style="color: var(--text-muted);">Don't worry, we store this very securely (on a Post-it note in the office).</small>
      </div>
    </fieldset>

    <!-- 6. Anmerkungen (Notes) -->
    <fieldset>
      <legend>&#128221; Anmerkungen (Notes)</legend>
      <div class="form-group">
        <label for="notes">Ihre Anmerkungen, Wuensche, letzten Worte...</label>
        <textarea name="notes" id="notes" rows="5" placeholder="z.B. 'Please make sure my room doesn't glow in the dark' or 'I have accepted my fate'"></textarea>
      </div>
    </fieldset>

    <!-- Form Actions -->
    <div class="form-actions">
      <button type="submit">&#128640; JETZT BUCHEN! (Book Now!)</button>
      <button type="reset">&#128465; Reset (Flucht planen)</button>
    </div>

  </form>
</div>

<?php include 'includes/footer.php'; ?>
