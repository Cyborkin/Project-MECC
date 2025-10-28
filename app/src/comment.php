<?php require 'includes/db.php';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $user = $_POST['user'] ?? 'anon';
    $message = $_POST['message'] ?? '';
    // Intentionally no sanitization: stored XSS
    $stmt = $mysqli->prepare("INSERT INTO comments (user, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $user, $message);
    $stmt->execute();
    header("Location: /");
    exit;
}
?>

