<?php
/**
 * @file
 * Skrypt do połączenia z bazą danych MySQL.
 */

/**
 * Adres hosta bazy danych.
 *
 * @var string $database_host
 */
$database_host = "serwer2315046.home.pl";

/**
 * Nazwa użytkownika bazy danych.
 *
 * @var string $database_user
 */
$database_user = "37063954_memhub";

/**
 * Nazwa bazy danych.
 *
 * @var string $database_name
 */
$database_name = "37063954_memhub";

/**
 * Hasło dostępu do bazy danych.
 *
 * @var string $database_pwd
 */
$database_pwd = "_kz9k1UD";

/**
 * Obiekt reprezentujący połączenie z bazą danych.
 *
 * @var mysqli $conn
 */
$conn = new mysqli($database_host, $database_user, $database_pwd, $database_name);

/**
 * Sprawdzenie czy udało się nawiązać połączenie z bazą danych.
 */
if ($conn->connect_error) {
  die("Błąd łączenia z bazą danych: " . $conn->connect_error);
}
?>