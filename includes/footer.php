    </div><!-- /.container -->
  </main>

  <footer class="site-footer">
    <!-- News Ticker -->
    <div class="news-ticker">
      <div class="ticker-track">
        <span class="ticker-item">BREAKING: SunShine Tours Customer Returns From Bermuda Triangle After 3 Years, Says "Time Flies"</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">URGENT: Our Chernobyl Tour Now Includes Complimentary Geiger Counter</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">NEW: Pyongyang Tour Updated - Now With 40% Less Surveillance</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">ALERT: Gary, Indiana Tour Participants Asked to Sign Additional Waivers</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">EXCLUSIVE: Bielefeld Tour Cancelled Again Due to City Still Not Existing</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">SPECIAL OFFER: Book Two Trips to Chernobyl, Get a Third Eye Free</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">JUST IN: SunShine Tours Voted "Most Concerning Travel Agency" By TripAdvisor For 5th Consecutive Year</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">Terror Probe Launched +++ US Senate Passes Bill to End Historic Government Shutdown +++ Turkish Military Cargo Plane Crashes in Georgia</span>
        <span class="ticker-separator">+++</span>
        <!-- Duplicate for seamless scroll -->
        <span class="ticker-item">BREAKING: SunShine Tours Customer Returns From Bermuda Triangle After 3 Years, Says "Time Flies"</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">URGENT: Our Chernobyl Tour Now Includes Complimentary Geiger Counter</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">NEW: Pyongyang Tour Updated - Now With 40% Less Surveillance</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">ALERT: Gary, Indiana Tour Participants Asked to Sign Additional Waivers</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">EXCLUSIVE: Bielefeld Tour Cancelled Again Due to City Still Not Existing</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">SPECIAL OFFER: Book Two Trips to Chernobyl, Get a Third Eye Free</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">JUST IN: SunShine Tours Voted "Most Concerning Travel Agency" By TripAdvisor For 5th Consecutive Year</span>
        <span class="ticker-separator">+++</span>
        <span class="ticker-item">Terror Probe Launched +++ US Senate Passes Bill to End Historic Government Shutdown +++ Turkish Military Cargo Plane Crashes in Georgia</span>
        <span class="ticker-separator">+++</span>
      </div>
    </div>

    <!-- Footer Content -->
    <div class="footer-content">
      <div class="footer-section">
        <h4>SunShine Tours</h4>
        <p style="font-size: 0.9rem; color: var(--text-muted);">Your #1 source for questionable travel decisions since 1997.</p>
        <div class="construction-badge">
          <span>&#128679; UNDER CONSTRUCTION &#128679;</span>
        </div>
      </div>
      <div class="footer-section">
        <h4>Quick Links</h4>
        <a href="index.php">Home</a>
        <a href="tours.php">Our "Tours"</a>
        <a href="booking.php">Book Now (YOLO)</a>
        <a href="about.php">Our "Team"</a>
      </div>
      <div class="footer-section">
        <h4>Legal (lol)</h4>
        <a href="legal.php?section=impressum">Impressum</a>
        <a href="legal.php?section=datenschutz">Datenschutz</a>
        <a href="legal.php?section=agb">AGBs</a>
      </div>
      <div class="footer-section">
        <h4>Contact</h4>
        <p style="font-size: 0.85rem; color: var(--text-muted);">
          &#128231; info@sunshine-tours.fake<br>
          &#128222; 0800-SCAM-420<br>
          &#128506; Kellerstra&szlig;e 69, 68159 Mannheim
        </p>
      </div>
    </div>

    <!-- Visitor Counter -->
    <div class="visitor-counter">
      You are visitor number:
      <div class="counter-display">
        <?php
        $counter_file = __DIR__ . '/../visitor_count.txt';
        $count = 0;
        if (file_exists($counter_file)) {
            $count = (int)file_get_contents($counter_file);
        }
        $count++;
        file_put_contents($counter_file, $count);
        $digits = str_pad($count, 7, '0', STR_PAD_LEFT);
        for ($i = 0; $i < strlen($digits); $i++) {
            echo '<span class="counter-digit">' . $digits[$i] . '</span>';
        }
        ?>
      </div>
    </div>

    <div class="footer-bottom">
      &copy; <?php echo date('Y'); ?> SunShine Tours GmbH & Co. KG (definitely a real company).
      <span class="est-date">Est. 1997-01-01</span>
      | Made with &#128150; and questionable judgment.
    </div>
  </footer>

  <script src="js/main.js"></script>
  <?php if (isset($include_booking_js) && $include_booking_js): ?>
  <script src="js/booking.js"></script>
  <?php endif; ?>
</body>
</html>
