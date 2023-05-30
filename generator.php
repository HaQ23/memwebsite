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
		<link
			rel="stylesheet"
			href="https://unpkg.com/flickity@2/dist/flickity.min.css"
		/>
		<link rel="stylesheet" href="./dist/css/generator.min.css" />
	</head>
	<body class="">
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
			<h2 class="section-title">
				Generator <span class="other-color">Memów</span>
			</h2>
			<p class="main-description">
				Wybierz odpowiedni szablon, dodaj zdjęcie i stwórz swojego mema!
			</p>
			<section class="select-temaplate show">
				<h3 class="select-temaplate__title">Wybierz szablon</h3>
				<div class="select-temaplate__carousel main-carousel" data-flickity>
					<div
						class="select-temaplate__carousel-item carousel-cell"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="1"
					>
						<img
							src="./dist/assets/images/meme-demo-template-1.webp"
							alt="zdjęcie szablonu 1"
							class="select-temaplate__carousel-img"
						/>
					</div>
					<div
						class="select-temaplate__carousel-item carousel-cell"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="2"
					>
						<img
							src="./dist/assets/images/meme-demo-template-2.webp"
							alt="zdjęcie szablonu 1"
							class="select-temaplate__carousel-img"
						/>
					</div>
					<div
						class="select-temaplate__carousel-item carousel-cell"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="3"
					>
						<img
							src="./dist/assets/images/meme-demo-template-3.webp"
							alt="zdjęcie szablonu 1"
							class="select-temaplate__carousel-img"
						/>
					</div>
					<div
						class="select-temaplate__carousel-item carousel-cell"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="4"
					>
						<img
							src="./dist/assets/images/meme-demo-template-4.webp"
							alt="zdjęcie szablonu 1"
							class="select-temaplate__carousel-img"
						/>
					</div>
					<div
						class="select-temaplate__carousel-item carousel-cell"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="5"
					>
						<img
							src="./dist/assets/images/meme-demo-template-5.webp"
							alt="zdjęcie szablonu 1"
							class="select-temaplate__carousel-img"
						/>
					</div>
					<div
						class="select-temaplate__carousel-item carousel-cell"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="6"
					>
						<img
							src="./dist/assets/images/meme-demo-template-6.webp"
							alt="zdjęcie szablonu 1"
							class="select-temaplate__carousel-img"
						/>
					</div>
					<div
						class="select-temaplate__carousel-item carousel-cell"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="7"
					>
						<img
							src="./dist/assets/images/meme-demo-template-7.webp"
							alt="zdjęcie szablonu 1"
							class="select-temaplate__carousel-img"
						/>
					</div>
					<div
						class="select-temaplate__carousel-item carousel-cell"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="8"
					>
						<img
							src="./dist/assets/images/meme-demo-template-8.webp"
							alt="zdjęcie szablonu 1"
							class="select-temaplate__carousel-img"
						/>
					</div>
					<div
						class="select-temaplate__carousel-item carousel-cell"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="9"
					>
						<img
							src="./dist/assets/images/meme-demo-template-9.webp"
							alt="zdjęcie szablonu 1"
							class="select-temaplate__carousel-img"
						/>
					</div>
				</div>
			</section>
			<section class="set-image">
				<div class="set-image__box">
					<div class="selected-temaplate">
						<img
							src="./dist/assets/images/meme-demo-template-9.webp"
							alt="zdjęcie szablonu 1"
							class="set-image__img"
						/>
					</div>
					<div class="set-image__box-file">
						<h3 class="subTitle">Prześlij swoje zdjęcie</h3>
						<label name="add-file " class="set-image__label"
							><img
								src="./dist/assets/icons/plus-circle.svg"
								alt=""
								class="icon"
							/>
							Wybierz plik
							<input
								for="add-file"
								type="file"
								class="set-image__input add-file"
							/>
						</label>

						<button class="set-image__back">Zmień szablon</button>
					</div>
				</div>
				<div class="standard-theme">
					<h2 class="section-title">Nie masz własnego zdjęcia?</h2>
					<p class="standard-theme__description">
						Jeżeli nie masz zadnego swojego zdjęcia, nie ma problemu, wybierz z
						pośród gotowych motywów.
					</p>
					<div class="standard-theme__container">
						<div class="standard-theme__main-carousel">
							<div
								class="standard-theme__item carousel-cell"
								role="button"
								aria-label="Wybierz szablon 1"
								data-type-template="9"
							>
								<img
									src="./dist/assets/images/them-1.webp"
									alt="zdjęcie szablonu 1"
									class="standard-theme__carousel-img"
								/>
							</div>
							<div
								class="standard-theme__item carousel-cell"
								role="button"
								aria-label="Wybierz szablon 1"
								data-type-template="9"
							>
								<img
									src="./dist/assets/images/them-2.webp"
									alt="zdjęcie szablonu 1"
									class="standard-theme__carousel-img"
								/>
							</div>
							<div
								class="standard-theme__item carousel-cell"
								role="button"
								aria-label="Wybierz szablon 1"
								data-type-template="9"
							>
								<img
									src="./dist/assets/images/them-3.webp"
									alt="zdjęcie szablonu 1"
									class="standard-theme__carousel-img"
								/>
							</div>
							<div
								class="standard-theme__item carousel-cell"
								role="button"
								aria-label="Wybierz szablon 1"
								data-type-template="9"
							>
								<img
									src="./dist/assets/images/them-4.webp"
									alt="zdjęcie szablonu 1"
									class="standard-theme__carousel-img"
								/>
							</div>
							<div
								class="standard-theme__item carousel-cell"
								role="button"
								aria-label="Wybierz szablon 1"
								data-type-template="9"
							>
								<img
									src="./dist/assets/images/them-5.webp"
									alt="zdjęcie szablonu 1"
									class="standard-theme__carousel-img"
								/>
							</div>
						</div>
						<div class="standard-theme__nav-carousel">
							<div
								class="standard-theme__item carousel-cell"
								role="button"
								aria-label="Wybierz szablon 1"
								data-type-template="9"
							>
								<img
									src="./dist/assets/images/them-1.webp"
									alt="zdjęcie szablonu 1"
									class="standard-theme__carousel-img"
								/>
							</div>
							<div
								class="standard-theme__item carousel-cell"
								role="button"
								aria-label="Wybierz szablon 1"
								data-type-template="9"
							>
								<img
									src="./dist/assets/images/them-2.webp"
									alt="zdjęcie szablonu 1"
									class="standard-theme__carousel-img"
								/>
							</div>
							<div
								class="standard-theme__item carousel-cell"
								role="button"
								aria-label="Wybierz szablon 1"
								data-type-template="9"
							>
								<img
									src="./dist/assets/images/them-3.webp"
									alt="zdjęcie szablonu 1"
									class="standard-theme__carousel-img"
								/>
							</div>
							<div
								class="standard-theme__item carousel-cell"
								role="button"
								aria-label="Wybierz szablon 1"
								data-type-template="9"
							>
								<img
									src="./dist/assets/images/them-4.webp"
									alt="zdjęcie szablonu 1"
									class="standard-theme__carousel-img"
								/>
							</div>
							<div
								class="standard-theme__item carousel-cell"
								role="button"
								aria-label="Wybierz szablon 1"
								data-type-template="9"
							>
								<img
									src="./dist/assets/images/them-5.webp"
									alt="zdjęcie szablonu 1"
									class="standard-theme__carousel-img"
								/>
							</div>
						</div>
					</div>
				</div>
			</section>

			<section class="guide">
				<h2 class="guide__title">Jak stworzyć mema?</h2>
				<div class="guide__items">
					<div class="guide__item">
						<span class="step">Krok 1</span>
						<h3 class="subTitle">Otwórz plik</h3>
						<p class="guide__text">
							Wybierz jeden z 8 dostępnych szablonów memów. Następnie wybierz
							obraz ze swojego urządzenia
						</p>
					</div>
					<div class="guide__item">
						<span class="step">Krok 2</span>
						<h3 class="subTitle">Stwórz mema</h3>
						<p class="guide__text">
							Po przesłaniu pliku możesz zmienić szablon mema, jeśli chcesz.
							Następnie wprowadź tekst, dostosuj czcionkę i przytnij ramkę.
						</p>
					</div>
					<div class="guide__item">
						<span class="step">Krok 3</span>
						<h3 class="subTitle">Pobierz własnego mema</h3>
						<p class="guide__text">
							Zapisz mema, klikając odpowiedni przycisk, następnie możesz
							pochwalić się stworzonym memem i umieścic go na naszej stronie.
						</p>
					</div>
				</div>
			</section>
		</main>
		<section class="create-mem">
			<button class="back">
				<img src="./dist/assets/icons/chevron-left.svg" alt="" class="icon" />
			</button>
			<div class="create-mem__mem-box">
				<div class="create-mem__img-box">
					<img
						src="./dist/assets/images/meme-demo-template-2.webp"
						alt=""
						class="create-mem__img"
					/>
				</div>
				<canvas class="canvas" id="canvas-mem"> </canvas>
			</div>
			<div class="create-mem__options-container">
				<button class="create-mem__change-template">
					<img src="./dist/assets/icons/image.svg" alt="" class="icon" />Zmień
					szablon
				</button>
				<div class="create-mem__text-box">
					<h2 class="create-mem__subTitle">Wpisz tekst</h2>
					<div class="create-mem__input-text-box">
						<input
							type="text"
							placeholder="Górny tekst"
							class="create-mem__input"
							id="top-text"
						/>
						<input
							placeholder="Dolny tekst"
							type="text"
							class="create-mem__input"
							id="bottom-text"
						/>
					</div>
					<div class="create-mem__option-box">
						<select
							name="font"
							class="create-mem__select-input create-mem__input"
							id="select-font"
						>
							<option value="Arial, sans-serif" class="option-item" checked>
								Arial
							</option>
							<option value="Times New Roman, Times, serif" class="option-item">
								Times New Roman
							</option>
							<option
								value="Courier New, Courier, monospace"
								class="option-item"
							>
								Courier New, Courier
							</option>
							<option value="Georgia, serif" class="option-item">
								Georgia
							</option>
							<option value="Verdana, sans-serif" class="option-item">
								Verdana
							</option>
							<option value="Tahoma, sans-serif" class="option-item">
								Tahoma
							</option>
							<option value="Impact, sans-serif" class="option-item">
								Impact
							</option>
							<option value="Comic Sans MS, sans-serif" class="option-item">
								Comic Sans MS
							</option>
						</select>
						<div class="create-mem__option-box">
							<button
								data-text-align="left"
								class="create-mem__option-btn active-value"
							>
								<img
									src="./dist/assets/icons/align-left.svg"
									alt=""
									class="icon"
								/>
							</button>
							<button data-text-align="center" class="create-mem__option-btn">
								<img
									src="./dist/assets/icons/align-center.svg"
									alt=""
									class="icon"
								/>
							</button>
							<button data-text-align="right" class="create-mem__option-btn">
								<img
									src="./dist/assets/icons/align-right.svg"
									alt=""
									class="icon"
								/>
							</button>
						</div>
					</div>
					<div class="create-mem__option-box">
						<input
							placeholder="Rozmiar czcionki "
							type="number"
							min="1"
							max="100"
							class="create-mem__input"
							id="font-size"
							value=""
						/>
						<button
							data-font-style="normal"
							class="create-mem__option-btn font-style-btn active-value"
						>
							<img src="./dist/assets/icons/type.svg" alt="" class="icon" />
						</button>
						<button
							data-font-style="italic"
							class="create-mem__option-btn font-style-btn"
						>
							<img src="./dist/assets/icons/italic.svg" alt="" class="icon" />
						</button>
					</div>
					<div class="create-mem__option-box">
						<label for="input-color-text" class="create-mem__label"
							><span class="text"> Kolor czcionki </span>
							<input
								name="input-color-text"
								type="color"
								value="#ff0000"
								class="create-mem__input input-color"
								id="input-color-text"
						/></label>

						<label for="input-stroke-style" class="create-mem__label"
							><span class="text">Obramowanie czcionki </span>
							<input
								name="input-stroke-style"
								type="color"
								value="#000000"
								class="create-mem__input input-color"
								id="input-stroke-style"
						/></label>
					</div>
					<div class="create-mem__buttons-box">
						<a href="#" class="download-mem primary-btn"
							><img
								src="./dist/assets/icons/download.svg"
								alt=""
								class="icon"
							/>Pobierz mema</a
						>
						<button class="add-mem primary-btn">Dodaj na stronę</button>
					</div>
				</div>
			</div>
			<div class="change-template">
				<button class="close-btn" aria-label="Zamknij wybor szablonu">
					<div class="close-btn__box">
						<span class="close-btn__inner"></span>
					</div>
				</button>
				<h2 class="change-template__title">Zmień swój szablon</h2>
				<div class="change-template__items">
					<div
						class="change-template__item"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="1"
					>
						<img
							src="./dist/assets/images/meme-demo-template-1.webp"
							alt="zdjęcie szablonu 1"
							class="change-template__img"
						/>
					</div>
					<div
						class="change-template__item"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="2"
					>
						<img
							src="./dist/assets/images/meme-demo-template-2.webp"
							alt="zdjęcie szablonu 1"
							class="change-template__img"
						/>
					</div>
					<div
						class="change-template__item"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="3"
					>
						<img
							src="./dist/assets/images/meme-demo-template-3.webp"
							alt="zdjęcie szablonu 1"
							class="change-template__img"
						/>
					</div>
					<div
						class="change-template__item"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="4"
					>
						<img
							src="./dist/assets/images/meme-demo-template-4.webp"
							alt="zdjęcie szablonu 1"
							class="change-template__img"
						/>
					</div>
					<div
						class="change-template__item"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="5"
					>
						<img
							src="./dist/assets/images/meme-demo-template-5.webp"
							alt="zdjęcie szablonu 1"
							class="change-template__img"
						/>
					</div>
					<div
						class="change-template__item"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="6"
					>
						<img
							src="./dist/assets/images/meme-demo-template-6.webp"
							alt="zdjęcie szablonu 1"
							class="change-template__img"
						/>
					</div>
					<div
						class="change-template__item"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="7"
					>
						<img
							src="./dist/assets/images/meme-demo-template-7.webp"
							alt="zdjęcie szablonu 1"
							class="change-template__img"
						/>
					</div>
					<div
						class="change-template__item"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="8"
					>
						<img
							src="./dist/assets/images/meme-demo-template-8.webp"
							alt="zdjęcie szablonu 1"
							class="change-template__img"
						/>
					</div>
					<div
						class="change-template__item"
						role="button"
						aria-label="Wybierz szablon 1"
						data-type-template="9"
					>
						<img
							src="./dist/assets/images/meme-demo-template-9.webp"
							alt="zdjęcie szablonu 1"
							class="change-template__img"
						/>
					</div>
				</div>
			</div>
		</section>

		<footer class="footer">
	<div class="wrapper">
		<a href="index.php" class="logo-name"
			>Mem<span class="other-color">Hub</span></a
		>
		<div class="footer__items">
			<a href="./contact.php" class="footer__item">Kontakt</a>
			<a href="./regulamin.php" class="footer__item">Regulamin</a>
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

		<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
		<script src="./dist/js/carousel.min.js"></script>
		<script src="./dist/js/main.min.js"></script>
		<script src="./dist/js/generateMem.min.js"></script>
	</body>
</html>