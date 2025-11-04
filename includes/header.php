<?php
// includes/header.php
if (!isset($page_title)) $page_title = 'MECC';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?php echo htmlspecialchars($page_title); ?> — MECC</title>
  <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="/index.php">
      <img class="logo" src="/assets/img/logo.png" alt="MECC logo">
      <div>
        <div class="site-title">MECC</div>
        <div style="font-size:0.75rem;color:#4b5563">Most Extreme Cybersecurity Challenge</div>
      </div>
    </a>

    <div style="display:flex; align-items:center; gap:1rem;">
      <nav class="nav-links" aria-label="Main navigation">
        <a href="/index.php">Home</a>
        <a href="/login.php">Login</a>
        <a href="/comments.php">Comments</a>
      </nav>

      <!-- Search bar: uses existing search endpoint so vuln/WAF/logs remain in place -->
      <form class="search-form" method="get" action="/search_exact.php" role="search">
        <input type="text" name="q" placeholder="Widgets & gadgets" aria-label="Search query">
        <button type="submit">Search</button>
      </form>
    </div>
  </div>
</header>

<main class="container">

