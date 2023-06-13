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
$database_host = "45.84.205.255";

/**
 * Nazwa użytkownika bazy danych.
 *
 * @var string $database_user
 */
$database_user = "u596017563_memhub";

/**
 * Nazwa bazy danych.
 *
 * @var string $database_name
 */
$database_name = "u596017563_memhub";

/**
 * Hasło dostępu do bazy danych.
 *
 * @var string $database_pwd
 */
$database_pwd = "j@E2s$2V";

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