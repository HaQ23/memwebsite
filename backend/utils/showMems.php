<?php 	
/**
 * @brief Funkcja wczytuje memy z bazy danych na podstawie parametrów zapytania GET.
 *
 * Funkcja wczytuje memy z bazy danych na podstawie opcjonalnych parametrów zapytania GET: index, limit i sort.
 * Parametr index określa indeks memu, od którego należy rozpocząć wczytywanie (domyślnie 0).
 * Parametr limit określa liczbę memów do wczytania (domyślnie 10).
 * Parametr sort określa sposób sortowania memów (domyślnie "najnowsze").
 *
 * @param void
 * @return void
 */
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
/**
 * @brief Funkcja zlicza oceny memu o podanym identyfikatorze.
 *
 * Funkcja zlicza oceny memu o podanym identyfikatorze z bazy danych.
 * 
 * @param int $idMeme Identyfikator memu
 * @return void
 */
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
/**
 * @brief Pobiera liczbę komentarzy dla danego mema na podstawie jego identyfikatora.
 *
 * @param int $idMeme Identyfikator mema
 * @return void
 */
function getCountComments($idMeme) {
  require_once "../database/database.php"; // Zaimportowanie pliku z konfiguracją bazy danych

  $query = "SELECT count(comment.id_comment) as commentCount FROM meme inner join comment on meme.id_meme = comment.id_meme where meme.id_meme=$idMeme;"; // Zapytanie SQL do zliczenia komentarzy

  $result = $conn->query($query); // Wykonanie zapytania
  $conn->close(); // Zamknięcie połączenia z bazą danych

  echo json_encode($result->fetch_assoc()); // Wyświetlenie wyniku jako JSON
}

/**
 * @brief Pobiera liczbę memów.
 *
 * @return void
 */
function getCountMems() {
  require_once "../database/database.php"; // Zaimportowanie pliku z konfiguracją bazy danych

  $query = "SELECT count(meme.id_meme) as memCount FROM meme;"; // Zapytanie SQL do zliczenia memów

  $result = $conn->query($query); // Wykonanie zapytania
  $conn->close(); // Zamknięcie połączenia z bazą danych

  echo json_encode($result->fetch_assoc()); // Wyświetlenie wyniku jako JSON
}


/**
 * @brief Wczytuje komentarze dla danego mema.
 *
 * @param int $idMeme ID mema
 * @return void
 */
function loadComments($idMeme) {
  require_once "../database/database.php"; // Zaimportowanie pliku z konfiguracją bazy danych

  $sort = isset($_GET['sort']) ? strval($_GET['sort']) : "najnowsze"; // Sprawdzenie parametru sortowania

  $query; // Zmienna przechowująca zapytanie SQL

  switch ($sort) {
      case "najnowsze":
          $query = "SELECT id_comment, id_user, body, adding_date FROM comment WHERE id_meme = $idMeme ORDER BY adding_date DESC;";
          break;
      case "najstarsze":
          $query = "SELECT id_comment, id_user, body, adding_date FROM comment WHERE id_meme = $idMeme ORDER BY adding_date;";
          break;
      case "najtrafniejsze":
          $query = "SELECT COUNT(comment_rating.id_comment), comment.id_comment, comment.id_user, comment.body, comment.adding_date 
                    FROM comment
                    LEFT JOIN comment_rating ON comment.id_comment = comment_rating.id_comment AND comment_rating.rating = 1 
                    WHERE comment.id_meme = $idMeme
                    GROUP BY comment.id_comment ORDER BY COUNT(comment_rating.id_comment) DESC;";
          break;
  }

  $result = $conn->query($query); // Wykonanie zapytania

  $arr = array(); // Tablica przechowująca wyniki

  while ($rowSec = $result->fetch_assoc()) {
      $secondQuery = "SELECT nick FROM account WHERE id_user = $rowSec[id_user];"; // Zapytanie pobierające nick użytkownika
      $secondResult = $conn->query($secondQuery); // Wykonanie drugiego zapytania
      $rowSec['name'] = $secondResult->fetch_assoc(); // Dodanie nicku do wyniku
      $arr[] = $rowSec; // Dodanie wyniku do tablicy
  }

  $conn->close(); // Zamknięcie połączenia z bazą danych

  echo json_encode($arr); // Wyświetlenie wyników jako JSON
}

/**
 * @brief Wysyła komentarz do mema.
 *
 * @return void
 */
function sendComment() {
  require_once "../database/database.php"; // Zaimportowanie pliku z konfiguracją bazy danych
  session_start(); // Rozpoczęcie sesji

  $response = ""; // Zmienna przechowująca odpowiedź

  if (!isset($_SESSION['userid'])) {
      $response = array('success' => false, 'message' => 'niezalogowany.'); // Niezalogowany użytkownik
      echo json_encode($response); // Wyświetlenie odpowiedzi jako JSON
      exit(); // Zakończenie działania
  }

  $idUser = $_SESSION['userid']; // ID zalogowanego użytkownika
  $comment = $_POST['comment']; // Treść komentarza
  $idMeme = $_POST['idMeme']; // ID mema

  $stmt = mysqli_stmt_init($conn); // Inicjalizacja przygotowania instrukcji SQL

  $sql = "INSERT INTO comment ( `id_user`, `id_meme`, `body`, `accepted`) VALUES (?, ?, ? , 1)"; // Zapytanie SQL do wstawienia komentarza

  if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, 'sss', $idUser, $idMeme, $comment); // Przypisanie wartości do parametrów zapytania

      if (mysqli_stmt_execute($stmt)) {
          $response = array('success' => true, 'message' => 'Komentarz został dodany.'); // Dodanie komentarza powiodło się
      } else {
          $response = array('success' => false, 'message' => 'Wystąpił błąd podczas dodawania komentarza.'); // Wystąpił błąd podczas dodawania komentarza
      }
  } else {
      $response = array('success' => false, 'message' => 'Wystąpił błąd podczas przygotowania zapytania.'); // Wystąpił błąd podczas przygotowania zapytania
  }

  mysqli_stmt_close($stmt); // Zamknięcie instrukcji SQL

  echo json_encode($response); // Wyświetlenie odpowiedzi jako JSON
  exit(); // Zakończenie działania
}

/**
 * @brief Wysyła zgłoszenie do moderacji.
 *
 * @return void
 */
function sendReport() {
  require_once "../database/database.php"; // Zaimportowanie pliku z konfiguracją bazy danych
  session_start(); // Rozpoczęcie sesji

  if (!isset($_SESSION['userid'])) {
      $response = array('success' => false, 'message' => 'niezalogowany.'); // Niezalogowany użytkownik
      echo json_encode($response); // Wyświetlenie odpowiedzi jako JSON
      exit(); // Zakończenie działania
  }

  $idUser = $_SESSION['userid'] || 1; // ID zalogowanego użytkownika (lub 1, jeśli nie jest zalogowany)
  $message = $_POST['message']; // Treść zgłoszenia
  $idOfItem = $_POST['idItem']; // ID zgłaszanego elementu
  $typeOfItem = $_POST['typeOfItem']; // Typ zgłaszanego elementu (mem lub komentarz)

  $stmt = mysqli_stmt_init($conn); // Inicjalizacja przygotowania instrukcji SQL
  $sql = "";

  if ($typeOfItem == "mem") {
      $sql = "INSERT INTO meme_report ( `id_user`, `id_meme`, `body`) VALUES (?, ?, ?)"; // Zapytanie SQL do wstawienia zgłoszenia dotyczącego mema
  } else {
      $sql = "INSERT INTO `comment_report` ( `id_user`, `id_comment`, `body`) VALUES (?, ?, ?)"; // Zapytanie SQL do wstawienia zgłoszenia dotyczącego komentarza
  }

  if (mysqli_stmt_prepare($stmt, $sql)) {
      mysqli_stmt_bind_param($stmt, 'sss', $idUser, $idOfItem, $message); // Przypisanie wartości do parametrów zapytania

      if (mysqli_stmt_execute($stmt)) {
          $response = array('success' => true, 'message' => 'zgloszenie zostalo wyslane.'); // Zgłoszenie zostało wysłane
          echo json_encode($response); // Wyświetlenie odpowiedzi jako JSON
      } else {
          $response = array('success' => false, 'message' => 'Wystąpił błąd podczas dodawania zgloszenia.'); // Wystąpił błąd podczas dodawania zgłoszenia
          echo json_encode($response); // Wyświetlenie odpowiedzi jako JSON
      }
  } else {
      $response = array('success' => false, 'message' => 'Wystąpił błąd podczas przygotowania zapytania.'); // Wystąpił błąd podczas przygotowania zapytania
      echo json_encode($response); // Wyświetlenie odpowiedzi jako JSON
  }

  mysqli_stmt_close($stmt); // Zamknięcie instrukcji SQL

  exit(); // Zakończenie działania
}

/**
 * @brief Wysyła ocenę mema.
 *
 * @return void
 */
function sendRating() {
  require_once "../database/database.php"; // Zaimportowanie pliku z konfiguracją bazy danych
  session_start(); // Rozpoczęcie sesji

  $idMeme = $_POST['idMeme']; // ID mema, któremu zostaje wystawiona ocena
  $rating = $_POST['rating']; // Ocena (1 lub 0)
  $idUser = 0;

  if (isset($_SESSION['userid'])) {
      $idUser = $_SESSION['userid']; // ID zalogowanego użytkownika (jeśli istnieje)
  }

  $query = "SELECT * FROM meme_rating WHERE id_user=$idUser AND id_meme=$idMeme";
  $result = $conn->query($query);
  $secondQuery = "";

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      if ($row['rating'] == $rating) {
          $secondQuery = "DELETE FROM meme_rating WHERE id_user=$idUser AND id_meme=$idMeme"; // Usunięcie oceny, jeśli jest taka sama jak wcześniej
          $response = array('success' => true, 'message' => '1.'); 
          $conn->query($secondQuery); 
      } else {
          $secondQuery = "UPDATE meme_rating SET rating=$rating WHERE id_user=$idUser AND id_meme=$idMeme"; // Aktualizacja oceny, jeśli się zmieniła
          $response = array('success' => true, 'message' => '2.');
          $conn->query($secondQuery);
      }
  } else {
      if ($idUser != 0) {
          $secondQuery = "INSERT INTO meme_rating (id_meme, id_user, rating) VALUES ($idMeme, $idUser, $rating)"; // Dodanie nowej oceny
          $response = array('success' => true, 'message' => '3.');
          $conn->query($secondQuery);
      }
  }

  $thirdQuery = "SELECT r.rating, COALESCE(m.assessment, 0) AS assessment
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

  $response["currentRatingDislike"] = $secondResult->fetch_assoc();
  $response["currentRatingLike"] = $secondResult->fetch_assoc();

  $quarterQuery = "SELECT IF(COUNT(*) > 0, rating, NULL) AS user_rating FROM meme_rating WHERE id_user=$idUser AND id_meme=$idMeme;";
  $quarterResult = $conn->query($quarterQuery);

  $response["user_rating"] = $quarterResult->fetch_assoc();

  echo json_encode($response); // Wyświetlenie odpowiedzi jako JSON
  header('Content-Type: application/json'); // Ustawienie nagłówka Content-Type na application/json
  $conn->close(); // Zamknięcie połączenia z bazą danych
  exit(); // Zakończenie działania
}

/**
 * @brief Wysyła ocenę komentarza.
 *
 * @return void
 */
function sendRatingComment() {
  require_once "../database/database.php"; // Zaimportowanie pliku z konfiguracją bazy danych
  session_start(); // Rozpoczęcie sesji

  $idComment = $_POST['idComment']; // ID komentarza, któremu zostaje wystawiona ocena
  $rating = $_POST['rating']; // Ocena (1 lub 0)
  $idUser = 0;

  if (isset($_SESSION['userid'])) {
      $idUser = $_SESSION['userid']; // ID zalogowanego użytkownika (jeśli istnieje)
  }

  $query = "SELECT * FROM comment_rating WHERE id_user=$idUser AND id_comment=$idComment";
  $result = $conn->query($query);
  $secondQuery = "";

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      if ($row['rating'] == $rating) {
          $secondQuery = "DELETE FROM comment_rating WHERE id_user=$idUser AND id_comment=$idComment"; // Usunięcie oceny, jeśli jest taka sama jak wcześniej
          $response = array('success' => true, 'message' => '1.');  
      } else {
          $secondQuery = "UPDATE comment_rating SET rating=$rating WHERE id_user=$idUser AND id_comment=$idComment"; // Aktualizacja oceny, jeśli się zmieniła
          $response = array('success' => true, 'message' => '2.');
      }
  } else {
      if ($idUser != 0) {
          $secondQuery = "INSERT INTO comment_rating (id_comment, id_user, rating) VALUES ($idComment, $idUser, $rating)"; // Dodanie nowej oceny
          $response = array('success' => true, 'message' => '3.');
      } else {
          $secondQuery = "SELECT * FROM meme";
      }
  }

  $conn->query($secondQuery);

  $thirdQuery = "SELECT r.rating, COALESCE(m.assessment, 0) AS assessment
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

  $response["currentRatingDislike"] = $secondResult->fetch_assoc();
  $response["currentRatingLike"] = $secondResult->fetch_assoc();

  $quarterQuery = "SELECT IF(COUNT(*) > 0, rating, NULL) AS user_rating FROM comment_rating WHERE id_user = $idUser AND id_comment = $idComment;";
  $quarterResult = $conn->query($quarterQuery);

  $response["user_rating"] = $quarterResult->fetch_assoc();

  echo json_encode($response); // Wyświetlenie odpowiedzi jako JSON
  header('Content-Type: application/json'); // Ustawienie nagłówka Content-Type na application/json
  $conn->close(); // Zamknięcie połączenia z bazą danych
  exit();
}

/**
 * @brief Sprawdza, czy użytkownik jest zalogowany.
 *
 * @return void
 */
function isLoginUser() {
  require_once "../database/database.php"; // Zaimportowanie pliku z konfiguracją bazy danych
  session_start(); // Rozpoczęcie sesji

  $response;

  if (isset($_SESSION['userid'])) {
      $response = array('success' => true, 'status_uzytkownika' => 'zalogowany'); // Użytkownik jest zalogowany
  } else {
      $response = array('success' => true, 'status_uzytkownika' => 'niezalogowany'); // Użytkownik nie jest zalogowany
  }

  echo json_encode($response); // Wyświetlenie odpowiedzi jako JSON
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
