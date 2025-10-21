#web/src/search.php

<?php
require_once 'db.php';
$q = isset($_GET['q']) ? $_GET['q'] : '';
$sql = "SELECT id, name, description FROM products WHERE name LIKE '%" . $q . "%' LIMIT 50";
$result = $mysqli->query($sql);
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Search</title></head>
<body>
  <h1>Search products</h1>
  <form method="get" action="/search.php">
    <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="search...">
    <button type="submit">Search</button>
  </form>
  <?php if ($result): ?>
    <ul>
    <?php while ($row = $result->fetch_assoc()): ?>
      <li><strong><?=htmlspecialchars($row['name'])?></strong> - <?=htmlspecialchars($row['description'])?></li>
    <?php endwhile; ?>
    </ul>
  <?php endif; ?>
</body>
</html>
