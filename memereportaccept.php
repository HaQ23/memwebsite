<?php
    
    require_once './backend/database/database.php';
   
    
 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    
    $query = "DELETE FROM meme_report WHERE id_report = '$id'";
    $result = mysqli_query($conn, $query);
    header("Location: admin.php");

    $result ->free_result();
}

// Zamykanie połączenia
mysqli_close($conn);
?>
