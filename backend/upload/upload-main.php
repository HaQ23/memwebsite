<?php
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
        echo 'Przesłany plik nie jest obrazem.';

        $uploadOk = false;
        header("Location: ../../index.php?upload=wrongfile");
        exit();
    }

    // Sprawdź rozmiar pliku
    if ($_FILES['upload-file-input']['size'] > 5000000) {
        echo 'Przesłany plik jest za duży.';
 
        $uploadOk = false;
        header("Location: ../../index.php?upload=size");
        exit();
    }

    // Dozwolone rozszerzenia plików
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    if (!in_array($imageFileType, $allowedExtensions)) {
       
        
        $uploadOk = false;
        header("Location: ../../index.php?upload=extension");
        exit();
    }

    // Jeżeli wszystkie sprawdzenia przeszły pomyślnie, przenieś przesłany plik do docelowego katalogu
    if ($uploadOk) {
        if (move_uploaded_file($_FILES['upload-file-input']['tmp_name'], $targetFile)) {
            require_once '../database/database.php';
            $author = $_SESSION['username'];
            $authorId = $_SESSION['userid'];
            $date = date('Y/m/d');
            $sql = "INSERT INTO meme (id_meme, title, id_user, adding_date, accepted, imgsource, original_url) 
                    VALUES (NULL, 'user', '$authorId', '1', '$date', '0', '$randomFilename', '-')";
            $conn->query($sql);
            $conn->close();
        } else {
            echo 'Wystąpił błąd podczas przesyłania pliku.';
        }
    }
}


?>