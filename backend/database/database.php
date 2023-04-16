<?php

$database_host = "serwer2315046.home.pl";
$database_user = "37063954_memhub";
$database_name = "37063954_memhub";
$database_pwd = "_kz9k1UD";

$conn = new mysqli($database_host, $database_user, $database_pwd, $database_name);

if ($conn->connect_error) {
  die("Błąd łączenia z bazą danych: " . $conn->connect_error);
}

?>