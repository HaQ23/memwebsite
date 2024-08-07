<?php
	session_start();
	if(isset($_SESSION['userid'])) {
		header("Location: ./index.php");
		exit();
	}
?>

<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta charset="UTF-8" />

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
	href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
	rel="stylesheet"
/>
<meta name="description" content="Put your description here." />

		<title>MemHub</title>
		<link rel="stylesheet" href="./dist/css/signIn.min.css" />
	</head>
	<body>
		<main class="main">
			<section class="sign">
				<a href="index.php" class="logo-name"
					>Mem<span class="other-color">Hub</span></a
				>
				<h2 class="section-title">Zaloguj się</h2>
				<form action="./backend/login/signin.php"
				method="POST" class="form-sign">
					<div class="input-box">
						<label for="login-user">Nazwa użytkownika lub Email</label>
						<input type="text" name="login-user" id="login-user" />
						<?php 
						if(isset($_GET['error'])) {
							if($_GET['error'] == "emptyfields") {

								echo '<p aria-hidden="true" class="error-info">To pole jest wymagane</p>';
							} else if($_GET['error'] == "wronglogin") {
								echo '<p aria-hidden="true" class="error-info">Błędny login lub e-mail</p>';
							}
						}
						?>
						
					</div>

					<div class="input-box">
						<div class="text-box">
							<label for="user-password">Hasło</label>
							<a href="./recovery.php" class="forgot-password">Zapomniałeś hasła?</a>
						</div>
						<input type="password" name="user-password" id="user-password" />
						<?php 
							if(isset($_GET['error'])) {
								if($_GET['error'] == "emptyfields") {

									echo '<p aria-hidden="true" class="error-info">To pole jest wymagane</p>';
								} else if($_GET['error'] == "wrongpassword") {
									echo '<p aria-hidden="true" class="error-info">Błędne hasło</p>';
								}
							}
						?>
					</div>
					<input class="sign-btn" name="user-signin-submit" type="submit" value="Zaloguj się" />
					<div class="info-box">
						<p class="form-text">Nie masz konta jeszcze?</p>
						<a href="./signUp.php" class="sign-now">Zarejestruj się teraz</a>
					</div>
				</form>
			</section>
			<div class="bg-color"></div>
		</main>
	</body>
</html>
