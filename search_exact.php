<?php
// root wrapper that shows your site header/footer around the exact-search demo
$page_title = "Exact Search";
include __DIR__ . '/includes/header.php';

// include the backend demo (change dir so relative includes inside app/src work)
chdir(__DIR__ . '/app/src');
include 'search_exact.php';

// include footer and restore cwd
chdir(__DIR__);
include __DIR__ . '/includes/footer.php';
