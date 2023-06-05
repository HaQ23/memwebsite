<?php 	

function loadMems(){
  require_once "../database/database.php";
  $offset = isset($_GET['index']) ? intval($_GET['index']) : 0;
  $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10; 
  $sort = isset($_GET['sort']) ? strval($_GET['sort']) : "najnowsze"; 
  $query;
  switch ($sort){
    case "najnowsze":
      $query= "SELECT id_meme,imgsource,id_user,original_url FROM meme where accepted = 1 order by adding_date,id_meme LIMIT $offset,$limit;";
      break;
      case "najstarsze":
        $query= "SELECT id_meme,imgsource,id_user,original_url FROM meme where accepted = 1  order by adding_date,id_meme desc LIMIT $offset,$limit;";
        break;
        case "najgorsze":
          $query= "SELECT COUNT(meme_rating.id_meme), meme.id_meme, meme.imgsource, meme.id_user,meme.original_url
            FROM meme
            LEFT JOIN meme_rating ON meme.id_meme = meme_rating.id_meme AND meme_rating.rating = 0 where meme.accepted = 1
            GROUP BY meme.id_meme ORDER by COUNT(meme_rating.id_meme) DESC, meme.id_meme limit  $offset,$limit;";
          break;
          case "najlepsze":
            $query= "SELECT COUNT(meme_rating.id_meme), meme.id_meme, meme.imgsource, meme.id_user,meme.original_url
            FROM meme
            LEFT JOIN meme_rating ON meme.id_meme = meme_rating.id_meme AND meme_rating.rating = 1 where meme.accepted = 1
            GROUP BY meme.id_meme ORDER by COUNT(meme_rating.id_meme) DESC , meme.id_meme limit  $offset,$limit;";
            break;
  }
  
  $result = $conn->query($query);
  $memes = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $secondQuery = "SELECT nick FROM account where id_user = $row[id_user];";
      $secondResult = $conn->query($secondQuery);
      $row['name']=$secondResult->fetch_assoc();
      $memes[] = $row;
    }
    
  }
  
  $conn->close();
  echo json_encode($memes);
}
function getCountAssessment($idMeme){
  require_once "../database/database.php";
  $query = "SELECT rating,count(rating) as assessment  FROM meme inner join meme_rating on meme.id_meme = meme_rating.id_meme where meme.id_meme=$idMeme GROUP by rating";
  $result = $conn->query($query);
  $arr = array();
  while ($rowSec = $result->fetch_assoc()) {
    $arr[] =  $rowSec;
  } 
  $conn->close();
  echo json_encode($arr);
}
function getCountComments($idMeme){
  require_once "../database/database.php";
  $query = "SELECT count(comment.id_comment) as commentCount  FROM meme inner join comment on meme.id_meme = comment.id_meme where meme.id_meme=$idMeme ;";
  $result = $conn->query($query);
  $conn->close();
  echo json_encode($result->fetch_assoc());
}
function getCountMems(){
  require_once "../database/database.php";
  $query = "SELECT count(meme.id_meme) as memCount  FROM meme ;";
  $result = $conn->query($query);
  $conn->close();
  echo json_encode($result->fetch_assoc());
}

function loadComments($idMeme){
  require_once "../database/database.php";
  $sort = isset($_GET['sort']) ? strval($_GET['sort']) : "najnowsze"; 
  $query;
  switch ($sort){
    case "najnowsze":
      $query = "SELECT id_comment,id_user,body,adding_date from comment where id_meme = $idMeme order by adding_date desc;" ;
      break;
      case "najstarsze":
        $query = "SELECT id_comment,id_user,body,adding_date from comment where id_meme = $idMeme order by adding_date ;" ;
        break;
        case "najtrafniejsze":
        $query = "SELECT COUNT(comment_rating.id_comment), comment.id_comment, comment.id_user, comment.body,comment.adding_date 
        FROM comment
        LEFT JOIN comment_rating ON comment.id_comment = comment_rating.id_comment AND comment_rating.rating = 1 where comment.id_meme = $idMeme
        GROUP BY comment.id_comment ORDER by COUNT(comment_rating.id_comment) DESC;" ;
        break;
        
  }
  $result = $conn->query($query);
  $arr = array();
  while ($rowSec = $result->fetch_assoc()) {
    $secondQuery = "SELECT nick FROM account where id_user = $rowSec[id_user];";
    $secondResult = $conn->query($secondQuery);
    $rowSec['name']=$secondResult->fetch_assoc();
    $arr[] =  $rowSec;
  } 
  $conn->close();
  echo json_encode($arr);
}
function sendComment(){
require_once "../database/database.php";
session_start();
$response = "";
if (!isset($_SESSION['userid'])) {
  $response = array('success' => false, 'message' => 'niezaalogowany.');
  echo json_encode($response);
  exit();
}
$idUser=$_SESSION['userid'];
$comment = $_POST['comment'];
$idMeme = $_POST['idMeme'];
$stmt = mysqli_stmt_init($conn);
$sql = "INSERT INTO comment ( `id_user`, `id_meme`, `body`, `accepted`) VALUES (?, ?, ? , 1)";

if (mysqli_stmt_prepare($stmt, $sql)) {
  mysqli_stmt_bind_param($stmt, 'sss', $idUser,$idMeme,$comment);
  if (mysqli_stmt_execute($stmt)) {
    $response = array('success' => true, 'message' => 'Komentarz został dodany.');
    
  } else {
    $response = array('success' => false, 'message' => 'Wystąpił błąd podczas dodawania komentarza.');
   
  }
} else {
  $response = array('success' => false, 'message' => 'Wystąpił błąd podczas przygotowania zapytania.');
  
}
mysqli_stmt_close($stmt);

echo json_encode($response);
exit(); 
}
function sendReport(){
  require_once "../database/database.php";
  session_start();
 
  if(!isset($_SESSION['userid'])){
    $response = array('success' => false, 'message' => 'niezaalogowany.');
    echo json_encode($response);
    exit(); 
  }
  $idUser = $_SESSION['userid']||1;
  $message = $_POST['message'];
  $idOfItem = $_POST['idItem'];
  $typeOfItem = $_POST['typeOfItem'];
  $stmt = mysqli_stmt_init($conn);
  $sql = "";
  if($typeOfItem =="mem"){
   $sql = "INSERT INTO meme_report ( `id_user`, `id_meme`, `body`) VALUES (?, ?, ?)";
  }else{
    $sql = "INSERT INTO `comment_report` ( `id_user`, `id_comment`, `body`) VALUES (?, ?, ?)";
  }
  if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, 'sss', $idUser,$idOfItem,$message);
    if (mysqli_stmt_execute($stmt)) {
      $response = array('success' => true, 'message' => 'zgloszenie zostalo wyslane.');
      echo json_encode($response);
    } else {
      $response = array('success' => false, 'message' => 'Wystąpił błąd podczas dodawania zgloszenia.');
      echo json_encode($response);
    }
  } else {
    $response = array('success' => false, 'message' => 'Wystąpił błąd podczas przygotowania zapytania.');
    echo json_encode($response);
  }
  mysqli_stmt_close($stmt);
  exit(); 
  }
function sendRating(){
  require_once "../database/database.php";
  session_start();
  $idMeme = $_POST['idMeme'];
  $rating = $_POST['rating'];
  $idUser = 0;
  if(isset($_SESSION['userid'])){
    $idUser = $_SESSION['userid'];
  }


  $query = "SELECT * from meme_rating where id_user=$idUser and id_meme= $idMeme";
  $result = $conn->query($query);
  $secondQuery ="";
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if($row['rating']==$rating){
      $secondQuery = "DELETE FROM meme_rating WHERE id_user =$idUser  AND id_meme = $idMeme";
      $response = array('success' => true, 'message' => '1.'); 
      $conn->query($secondQuery); 
    }else{
      $secondQuery = "UPDATE meme_rating SET rating = $rating WHERE id_user = $idUser AND id_meme = $idMeme ;";
      $response = array('success' => true, 'message' => '2.');
      $conn->query($secondQuery);
    }
} 
else{
  if($idUser !=0){
    $secondQuery = "INSERT into meme_rating (id_meme,id_user,rating) values ($idMeme,$idUser,$rating) ";
    $response = array('success' => true, 'message' => '3.');
    $conn->query($secondQuery);
  }
}

$thirdQuery =  "SELECT r.rating, COALESCE(m.assessment, 0) AS assessment
FROM (
  SELECT 0 AS rating
  UNION SELECT 1 AS rating
) AS r
LEFT JOIN (
  SELECT rating, COUNT(rating) AS assessment
  FROM meme
  INNER JOIN meme_rating ON meme.id_meme = meme_rating.id_meme
  WHERE meme.id_meme = $idMeme
  GROUP BY rating
) AS m ON r.rating = m.rating
ORDER BY r.rating";
  $secondResult = $conn->query($thirdQuery);
  $response["currentRatingDislike"]=$secondResult->fetch_assoc();
  $response["currentRatingLike"]=$secondResult->fetch_assoc();
  $quarterQuery = "SELECT IF(COUNT(*) > 0, rating, NULL) AS user_rating FROM meme_rating WHERE id_user = $idUser AND id_meme = $idMeme;";
  $quarterResult =  $conn->query($quarterQuery);
  $response["user_rating"]=$quarterResult->fetch_assoc();
  echo json_encode($response);
  header('Content-Type: application/json');
  $conn->close();
  exit();
}
function sendRatingComment(){
  require_once "../database/database.php";
  session_start();
  $idComment = $_POST['idComment'];
  $rating = $_POST['rating'];
  $idUser = 0;
  if(isset($_SESSION['userid'])){
    $idUser = $_SESSION['userid'];
  }

  $query = "SELECT * from comment_rating where id_user=$idUser and id_comment= $idComment";
  $result = $conn->query($query);
  $secondQuery ="";
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if($row['rating']==$rating){
      $secondQuery = "DELETE FROM comment_rating WHERE id_user =$idUser  AND id_comment = $idComment";
      $response = array('success' => true, 'message' => '1.');  
    }else{
      $secondQuery = "UPDATE comment_rating SET rating = $rating WHERE id_user = $idUser AND id_comment = $idComment ;";
      $response = array('success' => true, 'message' => '2.');
    }
} 
else{
    if($idUser!=0){
      $secondQuery = "INSERT into comment_rating (id_comment,id_user,rating) values ($idComment,$idUser,$rating) ";
      $response = array('success' => true, 'message' => '3.');
    }else{
      $secondQuery ="select * from meme";
    }

}

  $conn->query($secondQuery);
$thirdQuery =  "SELECT r.rating, COALESCE(m.assessment, 0) AS assessment
FROM (
  SELECT 0 AS rating
  UNION SELECT 1 AS rating
) AS r
LEFT JOIN (
  SELECT rating, COUNT(rating) AS assessment
  FROM comment
  INNER JOIN comment_rating ON comment.id_comment = comment_rating.id_comment
  WHERE comment.id_comment = $idComment
  GROUP BY rating
) AS m ON r.rating = m.rating
ORDER BY r.rating";
  $secondResult = $conn->query($thirdQuery);
  $response["currentRatingDislike"]=$secondResult->fetch_assoc();
  $response["currentRatingLike"]=$secondResult->fetch_assoc();
  $quarterQuery = "SELECT IF(COUNT(*) > 0, rating, NULL) AS user_rating FROM comment_rating WHERE id_user = $idUser AND id_comment = $idComment;";
  $quarterResult =  $conn->query($quarterQuery);
  $response["user_rating"]=$quarterResult->fetch_assoc();
  echo json_encode($response);
  header('Content-Type: application/json');
  $conn->close();
  exit();
}
function isLoginUser(){
  require_once "../database/database.php";
  session_start();
  $response;
 if( isset($_SESSION['userid'])){
  $response = array('success' => true, 'status_uzytkownika' => 'zalogowany');

 }else{
    $response = array('success' => true, 'status_uzytkownika' => 'niezalogowany');
 }
 echo json_encode($response);
  exit();
}
switch(($_GET['functionToDo'])){
  case "loadMems":
    loadMems();
    break;
    case "getCountAssessment":
      getCountAssessment (isset($_GET['idMeme']) ? intval($_GET['idMeme']) : 0);
      break; 
    case "getCountComments":
      getCountComments(isset($_GET['idMeme']) ? intval($_GET['idMeme']) : 0);
      break; 
      case "getCountMems":
        getCountMems();
       break; 
    case "loadComments":
      loadComments(isset($_GET['idMeme']) ? intval($_GET['idMeme']) : 0);
      break;
    case "sendComment":
      sendComment();
      break;
    case "sendReport":
      sendReport();
      break;
    case "sendRating":
      sendRating();
      break;
    case "sendRatingComment":
      sendRatingComment();
        break;
    case "isLoginUser":
      isLoginUser();
      break;
}

?>
