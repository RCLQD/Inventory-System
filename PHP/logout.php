<?php
session_start();

$_SESSION = array();

session_destroy();

setcookie("PHPSESSID", "", time() - 3600, "/");

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

header("Location: login.php");
exit();
?>
