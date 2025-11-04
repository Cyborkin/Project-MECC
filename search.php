<?php
// search.php wrapper - run the original handler under app/src so relative includes resolve.
$target = __DIR__ . '/app/src/search.php';
if (is_file($target)) {
    chdir(dirname($target));
    include $target;
    exit;
}
http_response_code(404);
header('Content-Type: text/plain; charset=utf-8');
echo "search handler not found on server.";

