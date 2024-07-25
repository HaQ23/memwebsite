<?php
    
    require_once './backend/database/database.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_report = $_POST['id'];
    $id_meme = $_POST['id_meme'];
    
    $query = "DELETE FROM meme WHERE id_meme = '$id_meme'";
    $query1 = "DELETE FROM meme_report WHERE id_report = '$id_report'";
    $result = mysqli_query($conn, $query);
    $result1 = mysqli_query($conn, $query1);
    header("Location: admin.php");

    $result ->free_result();
    $result1 ->free_result();
}

// Zamykanie połączenia
mysqli_close($conn);
?>
