<?php
   require_once './backend/database/database.php';

    



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $id = $_POST['id'];
    

    $query = "DELETE FROM comment_report WHERE id_report = '$id'";
    $result = mysqli_query($conn, $query);
    $result ->free_result();
    header("Location: admin.php");
}

// Zamykanie połączenia
mysqli_close($conn);
?>
