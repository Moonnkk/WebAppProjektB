<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="de" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SunShine Tours - <?php echo $page_title ?? 'Discover Your Dreams'; ?></title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header class="site-header">
    <div class="header-inner">
      <a href="index.php" class="logo">
        <div class="logo-sun"></div>
        <div>
          <span class="logo-text">SunShine Tours</span>
          <span class="logo-tagline">~ Discover Your Dreams Since 1997 ~</span>
        </div>
      </a>
      <div class="header-right">
        <button class="theme-toggle" id="themeToggle" title="Toggle Dark/Light Mode">
          <span class="theme-icon">&#127769;</span>
        </button>
        <button class="mobile-menu-btn" id="mobileMenuBtn">&#9776;</button>
      </div>
    </div>
    <nav class="main-nav">
      <ul id="navMenu">
        <li><a href="index.php" class="<?php echo $current_page === 'index' ? 'active' : ''; ?>">Home</a></li>
        <li><a href="about.php" class="<?php echo $current_page === 'about' ? 'active' : ''; ?>">About Us</a></li>
        <li><a href="tours.php" class="<?php echo $current_page === 'tours' ? 'active' : ''; ?>">Tours & Reviews</a></li>
        <li><a href="booking.php" class="<?php echo $current_page === 'booking' ? 'active' : ''; ?>">Book Now!</a></li>
        <li><a href="legal.php" class="<?php echo $current_page === 'legal' ? 'active' : ''; ?>">Legal Stuff</a></li>
      </ul>
    </nav>
  </header>
  <main class="main-content">
    <div class="container">
