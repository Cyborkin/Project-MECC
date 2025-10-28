<?php
$host = getenv('DB_HOST') ?: 'db';
$user = 'honeypot';
$pass = 'honeypotpass';
$dbname = 'honeypot';

$mysqli = new mysqli($host, $user, $pass, $dbname);
if ($mysqli->connect_error) {
    die("DB connect error: " . $mysqli->connect_error);
}
?>

