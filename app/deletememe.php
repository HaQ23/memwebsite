<?php
    
    require_once './backend/database/database.php';

    
 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $id = $_POST['id'];
    
    $query = "DELETE FROM meme WHERE id_meme = '$id'";
    $result = mysqli_query($conn, $query);
    header("Location: admin.php");

    $result ->free_result();
}

// Zamykanie połączenia
mysqli_close($conn);
?>
