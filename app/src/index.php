<?php require 'includes/db.php'; ?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Honeypot Shop</title></head>
<body>
<h1>Honeypot Shop</h1>
<p>Search products (vulnerable to SQLi):</p>
<form action="search.php" method="get">
  <input name="q" placeholder="search term">
  <button type="submit">Search</button>
</form>

<hr>
<h2>Leave a comment (vulnerable to XSS)</h2>
<form action="comment.php" method="post">
  <input name="user" placeholder="name"><br>
  <textarea name="message" placeholder="message"></textarea><br>
  <button type="submit">Post</button>
</form>

<hr>
<p>Recent comments:</p>
<ul>
<?php
$result = $mysqli->query("SELECT user, message FROM comments ORDER BY id DESC LIMIT 10");
while ($row = $result->fetch_assoc()){
  // Intentionally vulnerable: no escaping
  echo "<li><strong>{$row['user']}</strong>: {$row['message']}</li>";
}
?>
</ul>
</body>
</html>

