# web/src/login.php

<?php
require_once 'db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user = $_POST['username'] ?? '';
	$pass = $_POST['password'] ?? '';
	$query = "SELECT id, username, role FROM users WHERE username = '$user' AND password = '$pass' LIMIT 1";
	$res = $mysqli->query($query);
	if ($res && $res->num_rows > 0) {
		$row = $res->fetch_assoc();
		$msg = "Welcome Back, " . htmlspecialchars($row['username']) . " (role: " . htmlspecialchars($row['role']) . ")";
	} 
	else {
		$msg = "Invalid Credentials.";
	}
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Login</title></head>
<body>
  <h1>Login</h1>
  <form method="post" action="/login.php">
    <label>Username: <input name="username" /></label><br/>
    <label>Password: <input name="password" type="password" /></label><br/>
    <button type="submit">Login</button>
  </form>
  <p><?= $msg ?></p>
</body></html>

