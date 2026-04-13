<?php
session_start();

// Check if we have booking data
if (!isset($_SESSION['booking_id']) || !isset($_SESSION['booking_data'])) {
    header('Location: booking.php');
    exit;
}

$booking = $_SESSION['booking_data'];
$booking_id = $_SESSION['booking_id'];

// Destination names
$destinations = [
    'paris'      => 'Paris, Frankreich',
    'pyongyang'  => 'Pyongyang, Nordkorea',
    'chernobyl'  => 'Chernobyl, Ukraine',
    'gary'       => 'Gary, Indiana, USA',
    'bielefeld'  => 'Bielefeld, Deutschland',
];

// Excursion names
$excursion_names = [
    'sewer_tour'      => 'Guided Sewer System Tour',
    'cat_safari'      => 'Street Cat Safari',
    'mystery_food'    => 'Mystery Food Challenge',
    'haunted_parking' => 'Haunted Parking Lot Visit',
    'pigeon_watching'  => 'Extreme Pigeon Watching',
];

$dest_name = $destinations[$booking['destination']] ?? $booking['destination'];
$cost = $booking['cost_breakdown'];

$page_title = 'Booking Confirmed!';
include 'includes/header.php';
?>

<!-- Confetti effect -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  var colors = ['#FFD700', '#FF8C00', '#FF4500', '#00FF41', '#7FFF00', '#FF69B4', '#00FFFF'];
  for (var i = 0; i < 60; i++) {
    var confetti = document.createElement('div');
    confetti.className = 'confetti-piece';
    confetti.style.left = Math.random() * 100 + 'vw';
    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
    confetti.style.animationDelay = Math.random() * 3 + 's';
    confetti.style.animationDuration = (Math.random() * 3 + 3) + 's';
    confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
    confetti.style.width = (Math.random() * 10 + 5) + 'px';
    confetti.style.height = (Math.random() * 10 + 5) + 'px';
    document.body.appendChild(confetti);
    (function(el) {
      setTimeout(function() { el.remove(); }, 6000);
    })(confetti);
  }
});
</script>

<div class="confirmation-box">
  <span class="confirmation-icon">&#127881;</span>
  <h1>BUCHUNG ERFOLGREICH!</h1>
  <p style="font-size: 1.2rem; color: var(--text-secondary);">
    Congratulations! Your booking has been confirmed. There is no turning back now.
  </p>

  <div class="booking-id">
    Buchungs-ID: <?php echo htmlspecialchars($booking_id); ?>
  </div>

  <div class="booking-details">
    <h3 style="text-align: center; color: var(--warm-orange);">&#128203; Buchungsdetails</h3>
    <table>
      <tr>
        <td>Buchungs-ID</td>
        <td><?php echo htmlspecialchars($booking_id); ?></td>
      </tr>
      <tr>
        <td>Zeitstempel</td>
        <td><?php echo htmlspecialchars($booking['timestamp']); ?></td>
      </tr>
      <tr>
        <td>Angebotsnummer</td>
        <td><?php echo htmlspecialchars($booking['offer_number']); ?></td>
      </tr>
      <tr>
        <td>Reiseziel</td>
        <td><?php echo htmlspecialchars($dest_name); ?></td>
      </tr>
      <tr>
        <td>Name</td>
        <td><?php echo htmlspecialchars($booking['first_name'] . ' ' . $booking['last_name']); ?></td>
      </tr>
      <tr>
        <td>Adresse</td>
        <td><?php echo htmlspecialchars($booking['address']); ?></td>
      </tr>
      <tr>
        <td>Telefon</td>
        <td><?php echo htmlspecialchars($booking['phone']); ?></td>
      </tr>
      <tr>
        <td>E-Mail</td>
        <td><?php echo htmlspecialchars($booking['email']); ?></td>
      </tr>
      <tr>
        <td>Anzahl Personen</td>
        <td><?php echo $booking['num_persons']; ?></td>
      </tr>
      <?php if (!empty($booking['additional_persons'])): ?>
      <tr>
        <td>Weitere Personen</td>
        <td>
          <?php foreach ($booking['additional_persons'] as $i => $person): ?>
            <?php echo htmlspecialchars($person['first_name'] . ' ' . $person['last_name']); ?>
            <?php if ($i < count($booking['additional_persons']) - 1) echo '<br>'; ?>
          <?php endforeach; ?>
        </td>
      </tr>
      <?php endif; ?>
      <tr>
        <td>Zimmer/Betten</td>
        <td><?php echo $booking['num_rooms']; ?></td>
      </tr>
      <tr>
        <td>Anreise</td>
        <td><?php echo htmlspecialchars($booking['arrival_date']); ?></td>
      </tr>
      <tr>
        <td>Abreise</td>
        <td><?php echo htmlspecialchars($booking['departure_date']); ?></td>
      </tr>
      <tr>
        <td>Reisetage</td>
        <td><?php echo $cost['days']; ?> Tage</td>
      </tr>
      <?php if (!empty($booking['excursions'])): ?>
      <tr>
        <td>Ausfluege</td>
        <td>
          <?php foreach ($booking['excursions'] as $exc): ?>
            <?php echo htmlspecialchars($excursion_names[$exc] ?? $exc); ?><br>
          <?php endforeach; ?>
        </td>
      </tr>
      <?php endif; ?>
      <tr>
        <td>Raucher</td>
        <td><?php echo $booking['smoking'] === 'smoker' ? 'Ja' : 'Nein'; ?></td>
      </tr>
      <tr>
        <td>Kreditkarte</td>
        <td><?php echo htmlspecialchars($booking['credit_card_masked']); ?></td>
      </tr>
      <?php if (!empty($booking['notes'])): ?>
      <tr>
        <td>Anmerkungen</td>
        <td><?php echo nl2br(htmlspecialchars($booking['notes'])); ?></td>
      </tr>
      <?php endif; ?>
      <tr style="border-top: 3px solid var(--sun-yellow);">
        <td>Grundkosten</td>
        <td><?php echo $booking['num_persons']; ?> Pers. x <?php echo $cost['days']; ?> Tage x <?php echo number_format($booking['price_per_day'], 2); ?> EUR = <strong><?php echo number_format($cost['base_cost'], 2); ?> EUR</strong></td>
      </tr>
      <?php if ($cost['excursion_cost'] > 0): ?>
      <tr>
        <td>Ausflugskosten</td>
        <td><?php echo number_format($cost['excursion_cost'], 2); ?> EUR</td>
      </tr>
      <?php endif; ?>
      <tr style="background: rgba(0,255,65,0.1);">
        <td style="font-size: 1.2rem;"><strong>GESAMTKOSTEN</strong></td>
        <td style="font-size: 1.5rem; color: var(--neon-green); font-family: var(--font-heading);">
          <strong><?php echo number_format($cost['total_cost'], 2); ?> EUR</strong>
        </td>
      </tr>
    </table>
  </div>

  <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 20px;">
    Eine Bestaetigungs-E-Mail wurde an <strong><?php echo htmlspecialchars($booking['email']); ?></strong> gesendet.
    <br>(Nicht wirklich. Aber stellen Sie es sich vor.)
  </p>

  <div style="margin-top: 30px;">
    <a href="index.php" class="cta-btn" style="display: inline-block;">Zurueck zur Startseite</a>
  </div>
</div>

<?php
// Clear session data after displaying
unset($_SESSION['booking_id']);
unset($_SESSION['booking_data']);
?>

<?php include 'includes/footer.php'; ?>
