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
		<link rel="stylesheet" href="./dist/css/contact.min.css" />
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

		<main class="main">
			<div class="wrapper">
				<section class="contact">
					<h2 class="section-title">
						Masz jakieś pytania? <br />
						Śmiało skontaktuj się z nami, z chęcią odpowiemy na twoje wszelkie
						pytania.
					</h2>
					<form action="" class="contact-form" id="contact-form">
						<div class="input-box">
							<label for="contact-mail">Email</label>
							<input
								class="input-text"
								type="text"
								name="contact-mail"
								id="contact-mail"
							/>
						</div>
						<div class="input-box">
							<label for="contact-name">Imie i nazwisko</label>
							<input
								class="input-text"
								type="text"
								name="contact-name"
								id="contact-name"
							/>
						</div>
						<div class="input-box">
							<label for="message">Wiadomość</label>
							<textarea
								class="areaItem input-text"
								id="message"
								name="message"
							></textarea>
						</div>
						<input class="sign-btn" type="submit" value="Wyślij" />
						<p class="form-info">Nieprawidłowe dane!</p>
					</form>
				</section>
			</div>
			<div class="bg-color-other"></div>
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

		<script
			type="text/javascript"
			src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"
		></script>
		<script src="./dist/js/contact.min.js"></script>
		<script src="./dist/js/main.min.js"></script>
	</body>
</html>
