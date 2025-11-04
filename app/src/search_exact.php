<?php
// app/src/search_exact.php — intentionally vulnerable exact-match demo
require 'includes/db.php';
/* For demo: suppress mysqli exceptions so SQL errors render cleanly */
mysqli_report(MYSQLI_REPORT_OFF);
?>
<!doctype html><html><head><meta charset="utf-8"><title>Exact Search</title></head><body>
<h1>Exact Search results</h1>
<?php
$q = isset($_GET['q']) ? $_GET['q'] : '';
error_log("EXACT_SEARCH_QUERY input: " . $q);

// Purposefully vulnerable: direct string interpolation into WHERE = (no prepared statements)
$sql = "SELECT id, name, description FROM products WHERE name = '$q' OR description = '$q'";
error_log("EXACT_SEARCH_QUERY: " . $sql);
$res = $mysqli->query($sql);
if(!$res){
  echo "<p>DB error: " . htmlspecialchars($mysqli->error) . "</p>";
} else {
  $found = false;
  while($r = $res->fetch_assoc()){
    $found = true;
    echo "<div style='margin-bottom:12px'><h3>" . htmlspecialchars($r['name']) . "</h3><p>" . htmlspecialchars($r['description']) . "</p></div>";
  }
  if (!$found) echo "<p><em>No results</em></p>";
}
?>
</body></html>

