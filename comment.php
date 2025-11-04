<?php
// comment.php — wrapper that *executes* the original app/src handler.
// TEMP DEBUG (remove after fixing):
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$target = __DIR__ . '/app/src/comment.php';
if (is_file($target)) {
    chdir(dirname($target)); // make relative includes like includes/db.php work
    include $target;
    exit;
}
http_response_code(404);
header('Content-Type: text/plain; charset=utf-8');
echo "comment handler not found on server.";

