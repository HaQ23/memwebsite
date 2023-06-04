<?php
/**
 * @file
 * Skrypt do pobierania i zapisywania memów z różnych stron internetowych.
 */

/**
 * Wymagane pliki.
 */
require '../../backend/database/database.php';
require '../../vendor/autoload.php';

use Goutte\Client;

/**
 * Tablica przechowująca adresy URL memów.
 *
 * @var array $arr
 */
$arr = [];

/**
 * 
 * Klasa przechowująca Klienta który będzie poruszać się po poszczególnych stronach.
 * 
 */
$client = new Client();

// Pobieranie memów z kwejk.pl
/**
 * 
 * Metoda wykonująca zapytanie do zewnętrznej strony w celu uzyskania dostepu do jej zawartosci HTML
 * 
 */
$crawler = $client->request("GET", "https://kwejk.pl/");

/**
 * 
 * Metoda wykonująca filtrowanie poszczególnych elementów w celu określenia adresów URL memów
 * 
 */
$crawler->filter('.media-element-wrapper > .media-element')->each(function ($node) use (&$arr) {
    array_push($arr, $node->attr('data-image'));
});

// Pobieranie memów z memy.pl
$crawler = $client->request("GET", "https://memy.pl/");
$crawler->filter('.meme-item > .figure-item > a > img')->each(function ($node) use (&$arr) {
   array_push($arr, $node->attr('src'));
});

// Pobieranie memów z pocisk.org
$crawler = $client->request("GET", "https://pocisk.org/");
$crawler->filter('.attachment-bimber-stream')->each(function ($node) use (&$arr) {
   array_push($arr, $node->attr('data-src'));
});

// Pobieranie memów z redmik.pl
$crawler = $client->request("GET", "https://redmik.pl/");
$crawler->filter('.attachment-bimber-stream')->each(function ($node) use (&$arr) {
    array_push($arr, $node->attr('data-src'));
});

/**
 * Pobieranie i zapisywanie memów do bazy danych.
 */
for ($i = 0; $i < count($arr); $i++) {
    $uniqueId = uniqid('meme_', true);
    copy($arr[$i], '../../memes/'.$uniqueId.'.jpg');
    $date = date('Y/m/d');
    $sql = "INSERT INTO meme (id_meme, title, id_user, adding_date, accepted, imgsource, original_url) 
            VALUES (NULL, 'scrapped', '9999', '$date', '0', '$uniqueId.jpg', '$arr[$i]')";
    $conn->query($sql);
}

/**
 * Zamykanie połączenia z bazą danych.
 */
$conn->close();

/**
 * Zakończenie działania skryptu.
 */
exit();
?>