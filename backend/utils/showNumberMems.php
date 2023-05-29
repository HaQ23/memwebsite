<?php
require_once "../database/database.php";
$query = "SELECT count(*) FROM meme ;";
$result = $conn->query($query);

$memes = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $memes[] = $row;
  }
}
$conn->close();
echo json_encode($memes);
?>