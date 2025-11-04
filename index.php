<?php
$page_title = "Home";
include __DIR__ . '/includes/header.php';
?>
<section class="hero card">
  <div>
    <h1>Welcome to MECC</h1>
    <p>MECC is a hands-on learning environment for exploring web security, detection, and logging. Use the links above to try search, login, and comments features.</p>
    <p style="margin-top:0.6rem; font-size:0.9rem; color:#475569">This environment is for testing and education. Access is limited to authorized users.</p>
  </div>
</section>

<section class="card">
  <h2>Getting started</h2>
  <p>Use the search box in the top-right to exercise the search functionality. Use the <a href="/comments.php">Comments</a> page to view and post messages (handled by the existing backend). The Login page uses client-side test accounts to keep the backend behavior unchanged.</p>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>

