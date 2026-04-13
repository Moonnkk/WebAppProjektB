<?php
/**
 * formcheck.php - Uebung 07
 * Displays all form data received via GET or POST method.
 * Used for testing the booking form with both methods.
 */
$page_title = 'Form Check';
include 'includes/header.php';

$method = $_SERVER['REQUEST_METHOD'];
$data = $method === 'POST' ? $_POST : $_GET;
?>

<div class="section-header" style="padding-top: 20px;">
  <h1>&#128269; FormCheck.php</h1>
  <p class="subtitle">Uebung 07 - Testing form submissions with GET and POST</p>
</div>

<div class="formcheck-output">
  <span class="method-badge <?php echo $method === 'POST' ? 'method-post' : 'method-get'; ?>">
    <?php echo $method; ?> Request
  </span>

  <?php if (empty($data)): ?>
    <p style="color: var(--text-muted); padding: 20px; text-align: center;">
      No form data received. Submit the booking form to see data here.<br><br>
      <a href="booking.php" style="color: var(--neon-green);">Go to Booking Form &#8594;</a>
    </p>
    <div style="margin-top: 20px; padding: 15px; border: 2px dashed var(--border-color); border-radius: 10px;">
      <p><strong>How to test:</strong></p>
      <p>1. Change the form action in booking.php to <code>formcheck.php</code></p>
      <p>2. To test GET: also change method to <code>GET</code></p>
      <p>3. Submit the form and see the data displayed here</p>
    </div>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Field Name</th>
          <th>Value</th>
          <th>Type</th>
        </tr>
      </thead>
      <tbody>
        <?php
        function displayFormData($data, $prefix = '') {
            foreach ($data as $key => $value) {
                $fullKey = $prefix ? $prefix . '[' . $key . ']' : $key;
                if (is_array($value)) {
                    displayFormData($value, $fullKey);
                } else {
                    $type = gettype($value);
                    $displayValue = htmlspecialchars($value);
                    // Mask credit card numbers
                    if (stripos($key, 'credit') !== false && strlen($value) > 4) {
                        $displayValue = str_repeat('*', strlen($value) - 4) . substr($value, -4);
                    }
                    echo '<tr>';
                    echo '<td><strong>' . htmlspecialchars($fullKey) . '</strong></td>';
                    echo '<td>' . ($displayValue ?: '<em style="color: var(--text-muted);">(empty)</em>') . '</td>';
                    echo '<td><span style="color: var(--warm-orange); font-size: 0.85rem;">' . $type . '</span></td>';
                    echo '</tr>';
                }
            }
        }
        displayFormData($data);
        ?>
      </tbody>
    </table>

    <div style="margin-top: 20px; padding: 15px; border-top: 2px solid var(--border-color);">
      <p><strong>Raw <?php echo $method; ?> Data:</strong></p>
      <pre style="background: var(--bg-secondary); padding: 15px; border-radius: 8px; overflow-x: auto; color: var(--neon-green);"><?php
        echo htmlspecialchars(print_r($data, true));
      ?></pre>
    </div>
  <?php endif; ?>
</div>

<div style="text-align: center; margin-top: 20px;">
  <a href="booking.php" class="cta-btn" style="display: inline-block;">Back to Booking Form</a>
</div>

<?php include 'includes/footer.php'; ?>
