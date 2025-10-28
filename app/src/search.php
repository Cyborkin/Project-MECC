<?php require 'includes/db.php'; ?>
<!doctype html><html><head><meta charset="utf-8"><title>Search</title></head><body>
<h1>Search results</h1>
<?php
$q = isset($_GET['q']) ? $_GET['q'] : '';
// Purposefully vulnerable — no prepared statements or sanitization
$sql = "SELECT id, name, description FROM products WHERE name LIKE '%$q%' OR description LIKE '%$q%'";
error_log("SEARCH_QUERY: " . $sql); // logs will contain the raw query
$res = $mysqli->query($sql);
if(!$res){
  echo "<p>DB error: " . $mysqli->error . "</p>";
} else {
  while($r = $res->fetch_assoc()){
    echo "<div><h3>" . htmlspecialchars($r['name']) . "</h3><p>" . htmlspecialchars($r['description']) . "</p></div>";
  }
}
?>
<p><a href="/">Back</a></p>
</body></html>

