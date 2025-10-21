# web/src/db.php

<?php
$DB_HOST = getenv('DB_HOST') ?: 'db';
$DB_USER = getenv('MYSQL_USER') ?: 'honeypot_user';
$DB_PASS = getenv('MYSQL_PASSWORD') ?: 'honeypot_pass';
$DB_NAME = getenv('MYSQL_DATABASE') ?: 'honeypot';
$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_error) {
	die("DB conn error: " . $mysqli->connect_error);
}
?>
