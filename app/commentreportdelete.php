<?php
    
    require_once './backend/database/database.php';
  
    
   


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $id_report = $_POST['id'];
    $id_comment = $_POST['id_comment'];
    

    $query = "DELETE FROM comment WHERE id_comment = '$id_comment'";
    $query1 = "DELETE FROM comment_report WHERE id_report = '$id_report'";
    $result1 = mysqli_query($conn, $query1);
    $result = mysqli_query($conn, $query);
    header("Location: admin.php");
    $result ->free_result();
    $result1 ->free_result();
}

// Zamykanie połączenia
mysqli_close($conn);
?>
