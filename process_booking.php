<?php
/**
 * SunShine Tours - Booking Processor
 * Receives POST data from the booking form, saves to JSON, redirects to confirmation.
 */

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: booking.php');
    exit;
}

session_start();

// Generate unique booking ID
$booking_id = 'ST-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));

// Collect all form data
$booking = [
    'booking_id'      => $booking_id,
    'timestamp'        => date('Y-m-d H:i:s'),
    'offer_number'     => $_POST['offer_number'] ?? 'N/A',
    'destination'      => $_POST['destination'] ?? '',
    'last_name'        => $_POST['last_name'] ?? '',
    'first_name'       => $_POST['first_name'] ?? '',
    'address'          => $_POST['address'] ?? '',
    'phone'            => $_POST['phone'] ?? '',
    'email'            => $_POST['email'] ?? '',
    'num_persons'      => (int)($_POST['num_persons'] ?? 1),
    'num_rooms'        => (int)($_POST['num_rooms'] ?? 1),
    'arrival_date'     => $_POST['arrival_date'] ?? '',
    'departure_date'   => $_POST['departure_date'] ?? '',
    'excursions'       => $_POST['excursions'] ?? [],
    'smoking'          => $_POST['smoking'] ?? 'non_smoker',
    'credit_card'      => $_POST['credit_card'] ?? '',
    'notes'            => $_POST['notes'] ?? '',
    'price_per_day'    => (float)($_POST['price_per_day'] ?? 69),
];

// Collect additional person names
$additional_persons = [];
$num_persons = $booking['num_persons'];
for ($i = 2; $i <= $num_persons; $i++) {
    $additional_persons[] = [
        'first_name' => $_POST['additional_first_' . $i] ?? '',
        'last_name'  => $_POST['additional_last_' . $i] ?? '',
    ];
}
$booking['additional_persons'] = $additional_persons;

// Calculate costs
$days = 0;
if ($booking['arrival_date'] && $booking['departure_date']) {
    $arrival = new DateTime($booking['arrival_date']);
    $departure = new DateTime($booking['departure_date']);
    $diff = $arrival->diff($departure);
    $days = $diff->days;
}

$base_cost = $booking['num_persons'] * $days * $booking['price_per_day'];

// Excursion costs
$excursion_prices = [
    'sewer_tour'      => 25,
    'cat_safari'      => 15,
    'mystery_food'    => 30,
    'haunted_parking' => 20,
    'pigeon_watching'  => 10,
];

$excursion_cost = 0;
$excursion_details = [];
foreach ($booking['excursions'] as $exc) {
    $price = $excursion_prices[$exc] ?? 0;
    $excursion_cost += $price;
    $excursion_details[] = [
        'name' => $exc,
        'price' => $price,
    ];
}

$total_cost = $base_cost + $excursion_cost;

$booking['cost_breakdown'] = [
    'days'            => $days,
    'base_cost'       => $base_cost,
    'excursion_cost'  => $excursion_cost,
    'excursion_details' => $excursion_details,
    'total_cost'      => $total_cost,
];

// Mask credit card for storage (keep last 4 digits)
if (strlen($booking['credit_card']) > 4) {
    $booking['credit_card_masked'] = str_repeat('*', strlen($booking['credit_card']) - 4) . substr($booking['credit_card'], -4);
} else {
    $booking['credit_card_masked'] = $booking['credit_card'];
}
// Remove raw credit card from stored data
unset($booking['credit_card']);

// Ensure bookings directory exists
$bookings_dir = __DIR__ . '/bookings';
if (!is_dir($bookings_dir)) {
    mkdir($bookings_dir, 0755, true);
}

// Save booking as JSON file
$filename = $bookings_dir . '/' . $booking_id . '.json';
$json = json_encode($booking, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

if (file_put_contents($filename, $json) === false) {
    // If saving fails, store in session and still redirect
    $_SESSION['booking_error'] = 'Failed to save booking file.';
}

// Store booking ID in session for confirmation page
$_SESSION['booking_id'] = $booking_id;
$_SESSION['booking_data'] = $booking;

// Redirect to confirmation page
header('Location: confirmation.php');
exit;
