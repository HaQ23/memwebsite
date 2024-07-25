<?php 	
   
require_once "../database/database.php";
$offset = isset($_GET['index']) ? intval($_GET['index']) : 0;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10; 
$sort = isset($_GET['sort']) ? intval($_GET['sort']) : ""; 
$query = "SELECT id_meme,imgsource FROM meme LIMIT $offset,$limit;";
$result = $conn->query($query);
$memes = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $idMeme = $row['id_meme'];
    $secondQuery = "SELECT rating,count(rating) as assessment  FROM meme inner join meme_rating on meme.id_meme = meme_rating.id_meme where meme.id_meme=$idMeme GROUP by rating;";
    $resultSecond = $conn->query($secondQuery);
    while ($rowSec = $resultSecond->fetch_assoc()) {
      $row[] =  $rowSec;
    } 
    $thirdQuery =  "SELECT count(id_comment) as countComments  FROM meme inner join comment on meme.id_meme = comment.id_meme where meme.id_meme=$idMeme ;";
    $thirdResult = $conn->query($thirdQuery);
    $row[] = $thirdResult;
    $memes[] = $row;
  }
  
}

$conn->close();
echo json_encode($memes);

// Zwracanie memów w formacie JSON

?>
