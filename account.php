<?php
	if(!isset($_GET['user'])) {
		header("Location: ./index.php");
		exit();
	} else {
		require_once './backend/database/database.php';
		$userId = $_GET['user'];
	
		$thumbsUpSql = "SELECT COUNT(id_meme) AS summary FROM meme_rating WHERE id_author = '$userId' AND rating = 1";
		$thumbsDownSql = "SELECT COUNT(id_meme) AS summary FROM meme_rating WHERE id_author = '$userId' AND rating = 0";
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
				<a href="#" class="nav__button secondary-btn"> Dodaj mema </a>
				<a href="./signIn.php" class="nav__button primary-btn"> Logowanie </a>
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
                <p class="user-fame-text user-likes"><img src="./dist/assets/icons/thumbs-up.svg" alt=""> <?php echo $thumbsUp; ?></p>
                <p class="user-fame-text user-dislikes"><img src="./dist/assets/icons/thumbs-down.svg" alt=""> <?php echo $thumbsDown; ?></p>
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
		<div class="line"></div>
		<p class="copyRigth-text">
			Copyright <span class="currentData">2023</span>. MemHub
		</p>
	</div>
</footer>

    <script src="./dist/js/main.min.js"></script>
</body>
</html>