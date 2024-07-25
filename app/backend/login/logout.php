<?php
/**
 * @file
 * Skrypt do zakończenia sesji użytkownika i przekierowania na stronę główną.
 */

/**
 * Rozpoczęcie lub wznowienie sesji.
 */
session_start();

/**
 * Usunięcie wszystkich zmiennych sesji.
 */
session_unset();

/**
 * Zniszczenie sesji.
 */
session_destroy();

/**
 * Przekierowanie użytkownika na stronę główną.
 */
header("location: ../../index.php");

/**
 * Zakończenie działania skryptu.
 */
exit();
