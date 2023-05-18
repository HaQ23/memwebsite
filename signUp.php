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
		<main class="main signUp-main">
			<section class="encourage-register">
				<h2 class="section-title">
					Chcesz uzyskać nowe możliwości? <br />
					Załóż profil użytkownika!
				</h2>
				<h3 class="sub-title">Co uzyskasz?</h3>
				<ul class="encourage-register__profits">
					<li class="encourage-register__profit">
						<img src="./dist/assets/icons/check.svg" alt="" class="icon" />
						Możliwośc dodawania memów.
					</li>
					<li class="encourage-register__profit">
						<img
							src="./dist/assets/icons/check.svg"
							alt=""
							class="icon"
						/>Możliwośc komentowania memów.
					</li>
					<li class="encourage-register__profit">
						<img
							src="./dist/assets/icons/check.svg"
							alt=""
							class="icon"
						/>Możliwośc oceniania memów.
					</li>
					<li class="encourage-register__profit">
						<img
							src="./dist/assets/icons/check.svg"
							alt=""
							class="icon"
						/>Panel użytkownika z wieloma nowymi funkcjami.
					</li>
					<li class="encourage-register__profit">
						Brzmi świetnie? Załóż konto już teraz!
					</li>
				</ul>
			</section>
			<section class="sign signUp">
				<a href="index.php" class="logo-name"
					>Mem<span class="other-color">Hub</span></a
				>
				<h2 class="section-title">Zarejestruj się</h2>
				<form action="./backend/login/signup.php"
				method="POST" class="form-sign">
					<div class="inputs-boxes">
						<div class="input-box">
							<label for="name-user">Imie</label>
							<input type="text" name="name-user" id="name-user" />
							<?php 
							if(isset($_GET['error'])) {
								if($_GET['error'] == "emptyfields") {

									echo '<p aria-hidden="true" class="error-info">To pole jest wymagane</p>';
								} 
							}
							?>
						</div>
						<div class="input-box">
							<label for="surname-user">Nazwisko</label>
							<input type="text" name="surrname-user" id="surname-user" />
							<?php 
							if(isset($_GET['error'])) {
								if($_GET['error'] == "emptyfields") {

									echo '<p aria-hidden="true" class="error-info">To pole jest wymagane</p>';
								} 
							}
							?>
						</div>
					</div>
					<div class="inputs-boxes">
						<div class="input-box">
							<label for="nick-user">Nazwa użytkownika </label>
							<input type="text" name="nick-user" id="nick-user" />
							<?php 
							if(isset($_GET['error'])) {
								if($_GET['error'] == "emptyfields") {

									echo '<p aria-hidden="true" class="error-info">To pole jest wymagane</p>';
								} else if($_GET['error'] == "username") {
									echo '<p aria-hidden="true" class="error-info">Ta nazwa jest zajęta</p>';
								} 
							}
							?>
						</div>
						<div class="input-box">
							<label for="data-of-birth-user">Data urodzenia </label>
							<input
								type="date"
								name="data-of-birth-user"
								id="data-of-birth-user"
								value="2023-07-22"
							/>
							<?php 
							if(isset($_GET['error'])) {
								if($_GET['error'] == "emptyfields") {

									echo '<p aria-hidden="true" class="error-info">To pole jest wymagane</p>';
								} 
							}
							?>
						</div>
					</div>
					<div class="input-box">
						<label for="email-user">Email </label>
						<input type="email" name="email-user" id="email-user" />
						<?php 
							if(isset($_GET['error'])) {
								if($_GET['error'] == "emptyfields") {

									echo '<p aria-hidden="true" class="error-info">To pole jest wymagane</p>';
								} else if($_GET['error'] == "email") {
									echo '<p aria-hidden="true" class="error-info">Podaj poprawny adres email</p>';
								} 
							}
						?>
					</div>

					<div class="input-box">
						<label for="user-password">Hasło</label>
						<input type="password" name="user-password" id="user-password" />
						<?php 
							if(isset($_GET['error'])) {
								if($_GET['error'] == "emptyfields") {

									echo '<p  class="error-info">To pole jest wymagane</p>';
								} else if($_GET['error'] == "pwd") {
									echo '<p  class="error-info">Hasła nie są identyczne</p>';
								} 
							}
						?>
					</div>

					<div class="input-box">
						<label for="user-password-repeat">Powtórz hasło</label>
						<input
							type="password"
							name="user-password-repeat"
							id="user-password-repeat"
						/>
						<?php 
							if(isset($_GET['error'])) {
								if($_GET['error'] == "emptyfields") {

									echo '<p aria-hidden="true" class="error-info">To pole jest wymagane</p>';
								}  else if($_GET['error'] == "pwd") {
									echo '<p aria-hidden="true" class="error-info">Hasła nie są identyczne</p>';
								}
							}
						?>
					</div>
					<input class="sign-btn" name="user-signup-submit" type="submit" value="Stwórz konto" />
					<?php 
							if(isset($_GET['error'])) {
								if($_GET['error'] == "userexists") {

									echo '<p aria-hidden="true" class="error-info">Użytkownik o podanym adresie email lub nazwie użytkownika istnieje</p>';
								}
							}
						?>
						
					<div class="info-box">
						<p class="form-text">Masz już konto ?</p>
						<a href="./signIn.php" class="sign-now">Zaloguj się teraz</a>
					</div>
				</form>
			</section>
		</main>
		<div class="bg-color-other"></div>
	</body>
</html>
