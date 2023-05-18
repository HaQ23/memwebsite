<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Memhub | Odzyskiwanie hasła</title>
		<meta charset="UTF-8" />

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
	href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
	rel="stylesheet"
/>
<meta name="description" content="Put your description here." />

		<link rel="stylesheet" href="./dist/css/recovery.min.css" />
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
			<a href="#" class="nav__item">Poczekalnia</a>
			<div class="button-box">
				<a href="#" class="nav__button secondary-btn"> Dodaj mema </a>
				<a href="./signIn.php" class="nav__button primary-btn"> Logowanie </a>
			</div>
		</div>
	</div>
</nav>

		<main class="main wrapper">
			<?php
				if(isset($_GET['step'])) {
					if($_GET['step'] == '2') {
					
							$email = $_GET['email'];
					
						echo '
						<form 		action="./backend/login/recovery.php"
						method="post" class="recovery__form recovery__form--step-two">
						<h2 class="recovery__heading">Resetowanie hasła</h2>
						<p class="recovery__text">
							Na podany adres e-mail wysłaliśmy odpowiednie instrukcje, zapoznaj się
							z nimi a następnie wypełnij poniższe pola.
						</p>
						<div class="recovery__box">
							<label class="recovery__label" for="recovery-token"
								>Token<sup class="recovery__sup">*</sup>
							</label>
							<input
								class="recovery__input"
								type="text"
								id="recovery-token"
								name="recovery-token"
								placeholder="Podaj otrzymany token"
							/>
						</div>
						<div class="recovery__box">
							<label class="recovery__label" for="recovery-password"
								>Nowe hasło<sup class="recovery__sup">*</sup>
							</label>
							<input
								class="recovery__input"
								type="password"
								id="recovery-password"
								name="recovery-password"
								placeholder="Podaj nowe hasło"
							/>
						</div>
						<p class="recovery__info">
							<sup class="recovery__sup">*</sup> - Pole wymagane
						</p>
						<input type="hidden" name="recovery-email" value='.$email.'>
						<input type="submit" value="Zatwierdź" name="recovery-step-two" class="recovery__submit" />
					</form>
						
						';
					} else if($_GET['step'] == '3') {
						echo '
						<div class="final">
						<img src="./dist/assets/icons/check_circle.svg" alt="" />
						<h2 class="final__heading">Hasło zostało zmienione pomyślnie!</h2>
						<p class="final__text">
							Od teraz możesz zalogować się do swojego konta korzystając z nowego
							hasła, zrób to już teraz!
						</p>
						<a href="./signIn.php" class="final__button">Logowanie</a>
						</div>

						';
					}
				} else {
					echo '
					<form
					action="./backend/login/recovery.php"
					method="post"
					class="recovery__form recovery__form--step-one"
				>
					<h2 class="recovery__heading">Resetowanie hasła</h2>
	
					<div class="recovery__box">
						<label class="recovery__label" for="recovery-email"
							>Adres e-mail<sup class="recovery__sup">*</sup>
						</label>
						<input
							class="recovery__input"
							type="email"
							id="recovery-email"
							name="recovery-email"
							placeholder="Podaj adres e-mail"
							required
						/>
					</div>
					<p class="recovery__info">
						<sup class="recovery__sup">*</sup> - Pole wymagane
					</p>
					<input
						type="submit"
						value="Przywróć hasło"
						name="recovery-step-one"
						class="recovery__submit"
					/>
				</form>
					
					';
				}

			?>
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
		<div class="alert">
			<p class="alert__text">Zalogowano pomyślnie!</p>
		</div>		
		<script src="./dist/js/main.min.js"></script>
		<?php
			sleep(0.1);
			if(isset($_GET['error'])) {
				if($_GET['error'] == "notoken") {
					echo '<script>handleAlert("Podano błędny token!")</script>';
				} else if($_GET['error'] == "usedtoken") {
					echo '<script>handleAlert("Podany token jest wykorzystany!")</script>';
				}
			}			
		?>
	</body>
</html>
