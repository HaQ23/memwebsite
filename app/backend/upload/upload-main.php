<?php
/**
 * @file
 * Skrypt do przesyłania memów na serwer
 */
/**
 * Przesyła przesłany plik obrazu na serwer i zapisuje go w określonym katalogu.
 * Dodaje informacje o przesłanym pliku do bazy danych.
 *
 * @return void
 */
if (isset($_FILES['upload-file-input'])) {
    session_start();
    $targetDir = '../../memes/'; // Podaj ścieżkę do katalogu, w którym chcesz zapisać przesłany plik
    $randomPrefix = 'meme_';
    $randomSuffix = uniqid('', true);
    $randomFilename = $randomPrefix . $randomSuffix . '.jpg';
    $targetFile = $targetDir . $randomFilename;
    $uploadOk = true;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Sprawdź, czy przesłany plik jest poprawnym obrazem
    $check = getimagesize($_FILES['upload-file-input']['tmp_name']);
    if ($check === false) {

        $uploadOk = false;
        $response = array('success' => false, 'message' => 'Przesłany plik nie jest poprawnym obrazem');
        
    }

    // Sprawdź rozmiar pliku
    if ($_FILES['upload-file-input']['size'] > 5000000) {
 
        $uploadOk = false;
        $response = array('success' => false, 'message' => 'Przesłany plik waży zbyt dużo');
     
    }

    // Dozwolone rozszerzenia plików
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    if (!in_array($imageFileType, $allowedExtensions)) {
       
        
        $uploadOk = false;
        $response = array('success' => false, 'message' => 'Przesłany obraz posiada niedozwolony format');
       
    }

    // Jeżeli wszystkie sprawdzenia przeszły pomyślnie, przenieś przesłany plik do docelowego katalogu
    if ($uploadOk) {
        if (move_uploaded_file($_FILES['upload-file-input']['tmp_name'], $targetFile)) {
            require_once '../database/database.php';
            $author = $_SESSION['username'];
            $authorId = $_SESSION['userid'];
            $date = date('Y/m/d');
            $sql = "INSERT INTO meme (id_meme, title, id_user, adding_date, accepted, imgsource, original_url) 
                    VALUES (NULL, 'user', '$authorId', '$date', '0', '$randomFilename', '-')";
            $conn->query($sql);
            $conn->close();
            $response = array('success' => true, 'message' => '');
        } else {
            $response = array('success' => false, 'message' => 'Błąd');
        }
    }
    echo json_encode($response);
    exit();
}
?>
