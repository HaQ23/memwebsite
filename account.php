<?php
	session_start();
	if(!isset($_GET['user'])) {
		header("Location: ./index.php");
		exit();
	} else {
		require_once './backend/database/database.php';
		$userId = $_GET['user'];
		
		$checkUserSql = "SELECT nick FROM account WHERE id_user = $userId";
		$result = $conn->query($checkUserSql);
		if($result->num_rows === 0) {
			header("Location: ./index.php");
			exit();
		} 
		$thumbsUpSql = "SELECT COUNT(id_meme) AS summary FROM meme_rating WHERE id_user = '$userId' AND rating = 1";
		$thumbsDownSql = "SELECT COUNT(id_meme) AS summary FROM meme_rating WHERE id_user = '$userId' AND rating = 0";
		$userDetailsSql = "SELECT name, surrname, nick FROM account WHERE id_user = $userId";
		$statsAddedMemesSql = "SELECT COUNT(id_meme) AS summary FROM meme WHERE id_user = $userId";
		$statsAddedCommentsSql = "SELECT COUNT(id_comment) AS summary FROM comment WHERE id_user = $userId";
		$statsAddedMemeReportsSql = "SELECT COUNT(id_report) AS summary FROM meme_report WHERE id_user = $userId";
		$statsAddedCommentReportsSql = "SELECT COUNT(id_report) AS summary FROM comment_report WHERE id_user = $userId";
		$statsReceivedMemeReportsSql = "SELECT COUNT(id_report) AS summary FROM meme_report INNER JOIN meme ON meme.id_meme = meme_report.id_meme WHERE meme.id_user = $userId";
		$statsReceivedCommentReportsSql = "SELECT COUNT(id_report) AS summary FROM comment_report INNER JOIN comment ON comment.id_comment = comment_report.id_comment WHERE comment.id_user = $userId";
		
		$thumbsUp = 0;
		$thumbsDown = 0;
		$addedMemes = 0;
		$addedComments = 0;
		$addedReports = 0;
		$receivedReports = 0;
		$userName = 'John';
		$userSurrname = "Doe";
		$userNickname = "john.doe";
		

		$result = $conn->query($thumbsUpSql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$thumbsUp = $row['summary'];
			}
		} 
		$result = $conn->query($thumbsDownSql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$thumbsDown = $row['summary'];
			}
		}
		$result = $conn->query($userDetailsSql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$userName = $row['name'];
				$userSurrname = $row['surrname'];
				$userNickname = $row['nick'];
			}
		}
		$result = $conn->query($statsAddedMemesSql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$addedMemes = $row['summary'];
			}
		}
		$result = $conn->query($statsAddedCommentsSql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$addedComments = $row['summary'];
			}
		}
		$result = $conn->query($statsAddedMemeReportsSql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$addedReports = $row['summary'];
			}
		}
		$result = $conn->query($statsAddedCommentReportsSql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$addedReports = $addedReports+$row['summary'];
			}
		}
		$result = $conn->query($statsReceivedMemeReportsSql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$receivedReports = $row['summary'];
			}
		}
		$result = $conn->query($statsReceivedMemeReportsSql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$receivedReports = $receivedReports+$row['summary'];
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Użytkownika</title>
    <meta charset="UTF-8" />

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
	href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
	rel="stylesheet"
/>
<meta name="description" content="Put your description here." />

    <link rel="stylesheet" href="./dist/css/account.min.css">
</head>
<body>
    <nav class="nav">
	<div class="wrapper">
		<a href="index.php" class="logo-name"
			>Mem<span class="other-color">Hub</span></a
		>
		<button class="ham-btn" aria-label="Show menu">
			<div class="ham-btn__box">
				<span class="ham-btn__inner"></span>
			</div>
		</button>
		<div class="nav__items">
			<a href="./index.php" class="nav__item">Strona główna</a>
			<a href="./generator.php" class="nav__item">Generator</a>

			<a href="#" class="nav__item">Ranking</a>
			<a href="./queue.php" class="nav__item">Poczekalnia</a>
			<div class="button-box">
			<?php
					if(isset($_SESSION['userid'])) {
						echo '<button class="nav__button secondary-btn upload-button-navbar"> Dodaj mema </button>';
						echo '<a href="./dashboard.php" class="nav__button primary-btn"> Panel </a>';
					} else {
						echo '<a href="./signIn.php" class="nav__button primary-btn"> Logowanie </a>';
					}
				?>
			</div>
		</div>
	</div>
</nav>

    <main class="main wrapper">
        <div class="user">
            <img src="./dist/assets/icons/user.svg" alt="" class="user-img">
            <p class="user-name"><?php echo $userName.' '.$userSurrname ?></p>
            <p class="user-nickname">@<?php echo $userNickname; ?></p>
            <div class="user-fame">
                <p class="user-fame-text user-likes">				<svg class="icon like-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#5ab450" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg> <?php echo $thumbsUp; ?></p>
                <p class="user-fame-text user-dislikes"><svg class="icon dislike-icon"xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f72020" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg> <?php echo $thumbsDown; ?></p>
            </div>
        </div>
        <div class="score">
            <p class="section-heading score-heading">Statystyki użytkownika</p>
            <div class="score-items">
                <div class="score-item">
                    <p class="score-text">Dodane memy: <span class="score-amount"><?php echo $addedMemes; ?></span></p>
                </div>
                <div class="score-item">
                    <p class="score-text">Dodane komentarze: <span class="score-amount"><?php echo $addedComments; ?></span></p>
                </div>
                <div class="score-item">
                    <p class="score-text">Dodane zgłoszenia: <span class="score-amount"><?php echo $addedReports; ?></span></p>
                </div>
                <div class="score-item">
                    <p class="score-text">Otrzymane zgłoszenia: <span class="score-amount"><?php echo $receivedReports; ?></span></p>
                </div>
            </div>
        </div>
        <div class="memes">
            <p class="memes-heading section-heading">Memy użytkownika</p>
            <div class="memes-items">
				<?php
					$sql = "SELECT imgsource FROM meme WHERE id_user = $userId";

					$result = $conn->query($sql);
					if($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							echo '<img class="memes-image" src="./memes/'.$row['imgsource'].'" alt="">';
						}
					} else {
						echo '<p class="memes-nomeme">Użytkownik nie dodał jeszcze żadnego mema.</p>';
					}
					$conn->close();
				?>	
            </div>
        </div>
    </main>
    <footer class="footer">
	<div class="wrapper">
		<a href="index.php" class="logo-name"
			>Mem<span class="other-color">Hub</span></a
		>
		<div class="footer__items">
			<a href="./contact.php" class="footer__item">Kontakt</a>
			<a href="#" class="footer__item">Regulamin</a>
		</div>
		<div class="footer__social-media">
			<h2 class="section-title">Zaobserwuj nas na:</h2>
			<a
				aria-label="link do facebooka strony memhub"
				href="#"
				class="footer__social-media-link"
				><svg
					class="icon"
					xmlns="http://www.w3.org/2000/svg"
					width="32"
					height="32"
					viewBox="0 0 24 24"
					fill="none"
					stroke="#fff"
					stroke-width="1"
					stroke-linecap="round"
					stroke-linejoin="round"
					class="feather feather-facebook"
				>
					<path
						d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"
					></path></svg
			></a>
			<a
				aria-label="link do instagrama strony memhub"
				href="#"
				class="footer__social-media-link"
				><svg
					class="icon"
					xmlns="http://www.w3.org/2000/svg"
					width="32"
					height="32"
					viewBox="0 0 24 24"
					fill="none"
					stroke="#fff"
					stroke-width="1"
					stroke-linecap="round"
					stroke-linejoin="round"
					class="feather feather-instagram"
				>
					<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
					<path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
					<line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg
			></a>
		</div>
		<div class="upload upload-overlay">
			<div class="upload-box">
				<div class="upload-topbar">
					<p class="upload-title">Dodaj mema</p>
					<button class="upload-close"><img src="./dist/assets/icons/close.svg" alt="" /></button>
				</div>
				<form action="./backend/upload/upload-main.php" method="post" class="upload-content" enctype="multipart/form-data">
					<p class="upload-text">
						Wybierz odpowiedni plik aby dodać mema na nasz portal.
					</p>
				
					<div class="upload-file-box">
						<label for="upload-file-input" class="upload-file-label">
							<img src="./dist/assets/icons/upload.svg" class="upload-file-icon" alt="">
							<p class="upload-file-text">Wybierz plik</p>
						</label>
						<input type="file" class="upload-file-input" name="upload-file-input" id="upload-file-input" required>
						<p class="upload-filetype">Obsługiwane formaty: <span class="upload-filetype-highlighted">png, jpg, jpeg</span></p>
						<p class="upload-filetype">Maksymalny rozmiar pliku: <span class="upload-filetype-highlighted">5mb</span></p>
						<p class="upload-text">
							Po dodaniu mema opublikuj go na naszym portalu aby inni,
							mogli go ocenić!
						</p>
					</div>
					<input type="submit" value="Opublikuj" name="upload-submit" class="upload-submit">
					<p class="upload-generatorinfo">Masz pomysł na unikalnego mema który spodoba się każdemu?
						Skorzystaj z naszego <a href="./generator.php" class="upload-generatorinfo-link">generatora</a> i stwórz nowego mema już teraz!</p>
				</form>
			</div>
			<div class="upload-status upload-status--hidden">
				<img src="./dist/assets/icons/publish.webp" alt="">
				<p class="upload-status-text">Przesyłanie pliku...</p>
				<p class="upload-status-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi, voluptate!</p>
				<button class="upload-status-button">Gotowe</button>
				<progress class="upload-progress" max="100" value="0"></progress>
			</div>
		</div>
		<div class="line"></div>
		<p class="copyRigth-text">
			Copyright <span class="currentData">2023</span>. MemHub
		</p>
	</div>
</footer>

    <script src="./dist/js/main.min.js"></script>
	<script src="./dist/js/upload.min.js?v=1"></script>
</body>
</html>