<?php
	session_start();

?>

<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>MemHub</title>
		<meta charset="UTF-8" />

<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
	href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
	rel="stylesheet"
/>
<meta name="description" content="Put your description here." />

		<link rel="stylesheet" href="./dist/css/home.min.css" />
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
			<a href="../index.html" class="nav__item">Strona główna</a>
			<a href="../generator.html" class="nav__item">Generator</a>

			<a href="#" class="nav__item">Ranking</a>
			<a href="#" class="nav__item">Poczekalnia</a>
			<div class="button-box">
				<a href="#" class="nav__button secondary-btn"> Dodaj mema </a>
				<?php
					if(isset($_SESSION['userid'])) {
						echo '<a href="./signIn.php" class="nav__button primary-btn"> Panel </a>';
					} else {
						echo '<a href="./signIn.php" class="nav__button primary-btn"> Logowanie </a>';
					}
				?>
			</div>
		</div>
	</div>
</nav>

		<div class="container">
			<main class="main">
				<div class="wrapper">
					<h1 class="main-title">
						Mem<span class="other-color">Hub</span> - najlepsze memy w sieci!
					</h1>

					<section class="mems">
						<button class="sort">Sortuj Według</button>
						<ul class="sort-list">
							<li data-category="najnowsze" class="sort-list__item active">
								Najnowsze
							</li>
							<li data-category="najstarsze" class="sort-list__item">
								Najstarsze
							</li>
							<li data-category="najlepsze" class="sort-list__item">
								Najwyższa ocena
							</li>
							<li data-category="najgorsze" class="sort-list__item">
								Najgorsza ocena
							</li>
						</ul>
						<div class="mems__container">
							<div class="mem">
								<img
									src="./dist/assets/images/mem1.webp"
									alt=""
									class="mem__img"
								/>
								<div class="mem__info">
									<div class="mem__assessments">
										<div class="mem__assessment">
											<span class="mem__assessment-score"> 123 </span>
											<button
												aria-label="Polub ten mem"
												class="add-assessment like"
											>
												<svg
													xmlns="http://www.w3.org/2000/svg"
													width="24"
													height="24"
													viewBox="0 0 24 24"
													fill="none"
													stroke="currentColor"
													stroke-width="2"
													stroke-linecap="round"
													stroke-linejoin="round"
													class="feather feather-thumbs-up"
												>
													<path
														d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"
													></path>
												</svg>
											</button>
										</div>
										<div class="mem__assessment">
											<span class="mem__assessment-score"> 123 </span>
											<button
												aria-label="Polub ten mem"
												class="add-assessment dilike"
											>
												<svg
													xmlns="http://www.w3.org/2000/svg"
													width="24"
													height="24"
													viewBox="0 0 24 24"
													fill="none"
													stroke="currentColor"
													stroke-width="2"
													stroke-linecap="round"
													stroke-linejoin="round"
													class="feather feather-thumbs-down"
												>
													<path
														d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"
													></path>
												</svg>
											</button>
										</div>
									</div>
									<div class="mem__comment">
										<span class="mem__comment"> 123 </span>
										<button aria-label="Polub ten mem" class="add-comment">
											<svg
												xmlns="http://www.w3.org/2000/svg"
												width="24"
												height="24"
												viewBox="0 0 24 24"
												fill="none"
												stroke="currentColor"
												stroke-width="2"
												stroke-linecap="round"
												stroke-linejoin="round"
												class="feather feather-message-square"
											>
												<path
													d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"
												></path>
											</svg>
										</button>
									</div>
									<div class="mem__author">
										<div class="profile-box">
											<img
												src="./dist/assets/icons/user.svg"
												alt=""
												class="profile-photo"
											/>
										</div>
										<span class="user-name">Jan Kowalski</span>
									</div>
									<button class="report-mem">Zgłoś mema</button>
								</div>
							</div>
						</div>
						<div class="mems__container">
							<div class="mem">
								<img
									src="./dist/assets/images/mem2.webp"
									alt=""
									class="mem__img"
								/>
								<div class="mem__info">
									<div class="mem__assessments">
										<div class="mem__assessment">
											<span class="mem__assessment-score"> 123 </span>
											<button
												aria-label="Polub ten mem"
												class="add-assessment like"
											>
												<img
													src="../dist/assets/icons/thumbs-up.svg"
													alt=""
													class="icon"
												/>
											</button>
										</div>
										<div class="mem__assessment">
											<span class="mem__assessment-score"> 123 </span>
											<button
												aria-label="Polub ten mem"
												class="add-assessment dilike"
											>
												<img
													src="../dist/assets/icons/thumbs-down.svg"
													alt=""
													class="icon"
												/>
											</button>
										</div>
									</div>
									<div class="mem__comment">
										<span class="mem__comment-score"> 123 </span>
										<button aria-label="Polub ten mem" class="add-comment">
											<img
												src="../dist/assets/icons/message-square.svg"
												alt=""
												class="icon"
											/>
										</button>
									</div>
									<div class="mem__author">
										<a href="#" class="profile-box">
											<img
												src="./dist/assets/icons/user.svg"
												alt=""
												class="profile-photo"
											/>
										</a>
										<span class="user-name">Jan Kowalski</span>
									</div>
									<button class="report-mem">Zgłoś mema</button>
								</div>
							</div>
						</div>
						<div class="mems__container">
							<div class="mem">
								<img
									src="../dist/assets/images/mem2.webp"
									alt=""
									class="mem__img"
								/>
								<div class="mem__info">
									<div class="mem__assessments">
										<div class="mem__assessment">
											<span class="mem__assessment-score"> 123 </span>
											<button
												aria-label="Polub ten mem"
												class="add-assessment like"
											>
												<img
													src="../dist/assets/icons/thumbs-up.svg"
													alt=""
													class="icon"
												/>
											</button>
										</div>
										<div class="mem__assessment">
											<span class="mem__assessment-score"> 123 </span>
											<button
												aria-label="Polub ten mem"
												class="add-assessment dilike"
											>
												<img
													src="../dist/assets/icons/thumbs-down.svg"
													alt=""
													class="icon"
												/>
											</button>
										</div>
									</div>
									<div class="mem__comment">
										<span class="mem__comment-score"> 123 </span>
										<button aria-label="Polub ten mem" class="add-comment">
											<img
												src="../dist/assets/icons/message-square.svg"
												alt=""
												class="icon"
											/>
										</button>
									</div>
									<div class="mem__author">
										<a href="#" class="profile-box">
											<img
												src="../dist/assets/icons/user.svg"
												alt=""
												class="profile-photo"
											/>
										</a>
										<span class="user-name">Jan Kowalski</span>
									</div>
									<button class="report-mem">Zgłoś mema</button>
								</div>
							</div>
						</div>
					</section>
				</div>
			</main>
			<aside class="aside">
				<section class="best-users">
					<h2 class="section-title">Top 3 użytkowników tygodnia:</h2>
					<ol class="best-users__container">
						<li class="best-users__item">
							<span class="number">1.</span>
							<div class="profile-box">
								<img
									src="./dist/assets/icons/user.svg"
									alt=""
									class="profile-photo"
								/>
							</div>
							<span class="name-user">Jan kowalski</span>
							<span class="user-score">1233pkt</span>
						</li>
						<li class="best-users__item">
							<span class="number">2.</span>
							<div class="profile-box">
								<img
									src="./dist/assets/icons/user.svg"
									alt=""
									class="profile-photo"
								/>
							</div>
							<span class="name-user">Jan kowalski</span>
							<span class="user-score">1233pkt</span>
						</li>
						<li class="best-users__item">
							<span class="number">3.</span>
							<div class="profile-box">
								<img
									src="./dist/assets/icons/user.svg"
									alt=""
									class="profile-photo"
								/>
							</div>
							<span class="name-user">Jan kowalski</span>
							<span class="user-score">1233pkt</span>
						</li>
					</ol>
				</section>
				<section class="best-mems">
					<h2 class="section-title">Najlepsze memy</h2>
					<a
						aria-label="link do najlepszego mema"
						href="#"
						class="best-mems__container"
					>
						<img src="./dist/assets/images/mem2.webp" alt="" />
					</a>
					<a
						aria-label="link do najlepszego mema"
						href="#"
						class="best-mems__container"
					>
						<img src="./dist/assets/images/mem2.webp" alt="" />
					</a>
				</section>
			</aside>
		</div>
		<section class="comments">
			<div class="comments__options-box">
				<button class="btn-sort-comments">
					Najtrafniejsze
					<img
						src="../dist/assets/icons/chevron-down.svg"
						alt=""
						class="icon"
					/>
				</button>
				<button class="close-btn" aria-label="Zamknij sekcje komentarzy">
					<div class="close-btn__box">
						<span class="close-btn__inner"></span>
					</div>
				</button>
			</div>
			<ul class="sort-comments-options">
				<li class="sort-comments-options__item">
					<button
						data-category="Najtrafniejsze"
						class="sort-comments-options__btn currentSort"
					>
						<div class="circle">
							<span class="inner-circle"></span>
						</div>
						Najtrafniejsze
					</button>
				</li>
				<li class="sort-comments-options__item">
					<button data-category="Najnowsze" class="sort-comments-options__btn">
						<div class="circle">
							<span class="inner-circle"></span>
						</div>
						Najnowsze
					</button>
				</li>
				<li class="sort-comments-options__item">
					<button data-category="Najstarsze" class="sort-comments-options__btn">
						<div class="circle">
							<span class="inner-circle"></span>
						</div>
						Najstarsze
					</button>
				</li>
			</ul>
			<div class="comments__content">
				<div class="comment">
					<a href="#" class="profile-box">
						<img
							src="../dist/assets/icons/user.svg"
							alt=""
							class="profile-photo"
						/>
					</a>
					<div class="comment__content-box">
						<div class="comment__content">
							<span class="comment__author">Jan kowalski</span>
							<p class="comment__text">
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores
								ratione impedit commodi, minus optio et ipsam deserunt
								provident?
							</p>
						</div>
						<div class="comment__options">
							<div class="box">
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__like"
									>
										<img
											src="../dist/assets/icons/thumbs-up.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__like-score"
										>123</span
									>
								</div>
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__dislike"
									>
										<img
											src="../dist/assets/icons/thumbs-down.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__unlike-score"
										>123
									</span>
								</div>
							</div>
							<div class="box">
								<button class="comment__option comment__report">Zgłoś</button>
								<span class="comment__date-info">1 dzień temu</span>
							</div>
						</div>
					</div>
				</div>
				<div class="comment">
					<a href="#" class="profile-box">
						<img
							src="../dist/assets/icons/user.svg"
							alt=""
							class="profile-photo"
						/>
					</a>
					<div class="comment__content-box">
						<div class="comment__content">
							<span class="comment__author">Jan kowalski</span>
							<p class="comment__text">
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores
								ratione impedit commodi, minus optio et ipsam deserunt
								provident?
							</p>
						</div>
						<div class="comment__options">
							<div class="box">
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__like"
									>
										<img
											src="../dist/assets/icons/thumbs-up.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__like-score"
										>123</span
									>
								</div>
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__dislike"
									>
										<img
											src="../dist/assets/icons/thumbs-down.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__unlike-score"
										>123
									</span>
								</div>
							</div>
							<div class="box">
								<button class="comment__option comment__report">Zgłoś</button>
								<span class="comment__date-info">1 dzień temu</span>
							</div>
						</div>
					</div>
				</div>
				<div class="comment">
					<a href="#" class="profile-box">
						<img
							src="../dist/assets/icons/user.svg"
							alt=""
							class="profile-photo"
						/>
					</a>
					<div class="comment__content-box">
						<div class="comment__content">
							<span class="comment__author">Jan kowalski</span>
							<p class="comment__text">
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores
								ratione impedit commodi, minus optio et ipsam deserunt
								provident?
							</p>
						</div>
						<div class="comment__options">
							<div class="box">
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__like"
									>
										<img
											src="../dist/assets/icons/thumbs-up.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__like-score"
										>123</span
									>
								</div>
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__dislike"
									>
										<img
											src="../dist/assets/icons/thumbs-down.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__unlike-score"
										>123
									</span>
								</div>
							</div>
							<div class="box">
								<button class="comment__option comment__report">Zgłoś</button>
								<span class="comment__date-info">1 dzień temu</span>
							</div>
						</div>
					</div>
				</div>
				<div class="comment">
					<a href="#" class="profile-box">
						<img
							src="../dist/assets/icons/user.svg"
							alt=""
							class="profile-photo"
						/>
					</a>
					<div class="comment__content-box">
						<div class="comment__content">
							<span class="comment__author">Jan kowalski</span>
							<p class="comment__text">
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores
								ratione impedit commodi, minus optio et ipsam deserunt
								provident?
							</p>
						</div>
						<div class="comment__options">
							<div class="box">
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__like"
									>
										<img
											src="../dist/assets/icons/thumbs-up.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__like-score"
										>123</span
									>
								</div>
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__dislike"
									>
										<img
											src="../dist/assets/icons/thumbs-down.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__unlike-score"
										>123
									</span>
								</div>
							</div>
							<div class="box">
								<button class="comment__option comment__report">Zgłoś</button>
								<span class="comment__date-info">1 dzień temu</span>
							</div>
						</div>
					</div>
				</div>
				<div class="comment">
					<a href="#" class="profile-box">
						<img
							src="../dist/assets/icons/user.svg"
							alt=""
							class="profile-photo"
						/>
					</a>
					<div class="comment__content-box">
						<div class="comment__content">
							<span class="comment__author">Jan kowalski</span>
							<p class="comment__text">
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores
								ratione impedit commodi, minus optio et ipsam deserunt
								provident?
							</p>
						</div>
						<div class="comment__options">
							<div class="box">
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__like"
									>
										<img
											src="../dist/assets/icons/thumbs-up.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__like-score"
										>123</span
									>
								</div>
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__dislike"
									>
										<img
											src="../dist/assets/icons/thumbs-down.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__unlike-score"
										>123
									</span>
								</div>
							</div>
							<div class="box">
								<button class="comment__option comment__report">Zgłoś</button>
								<span class="comment__date-info">1 dzień temu</span>
							</div>
						</div>
					</div>
				</div>
				<div class="comment">
					<a href="#" class="profile-box">
						<img
							src="../dist/assets/icons/user.svg"
							alt=""
							class="profile-photo"
						/>
					</a>
					<div class="comment__content-box">
						<div class="comment__content">
							<span class="comment__author">Jan kowalski</span>
							<p class="comment__text">
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores
								ratione impedit commodi, minus optio et ipsam deserunt
								provident?
							</p>
						</div>
						<div class="comment__options">
							<div class="box">
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__like"
									>
										<img
											src="../dist/assets/icons/thumbs-up.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__like-score"
										>123</span
									>
								</div>
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__dislike"
									>
										<img
											src="../dist/assets/icons/thumbs-down.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__unlike-score"
										>123
									</span>
								</div>
							</div>
							<div class="box">
								<button class="comment__option comment__report">Zgłoś</button>
								<span class="comment__date-info">1 dzień temu</span>
							</div>
						</div>
					</div>
				</div>
				<div class="comment">
					<a href="#" class="profile-box">
						<img
							src="../dist/assets/icons/user.svg"
							alt=""
							class="profile-photo"
						/>
					</a>
					<div class="comment__content-box">
						<div class="comment__content">
							<span class="comment__author">Jan kowalski</span>
							<p class="comment__text">
								Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolores
								ratione impedit commodi, minus optio et ipsam deserunt
								provident?
							</p>
						</div>
						<div class="comment__options">
							<div class="box">
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__like"
									>
										<img
											src="../dist/assets/icons/thumbs-up.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__like-score"
										>123</span
									>
								</div>
								<div class="comment__assessment">
									<button
										aria-label="Polub ten mem"
										class="comment__option comment__dislike"
									>
										<img
											src="../dist/assets/icons/thumbs-down.svg"
											alt=""
											class="icon"
										/>
									</button>
									<span class="comment__assessment-score comment__unlike-score"
										>123
									</span>
								</div>
							</div>
							<div class="box">
								<button class="comment__option comment__report">Zgłoś</button>
								<span class="comment__date-info">1 dzień temu</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="bg-shadow"></div>
			<div class="add-coment-container">
				<textarea
					class="addComment"
					aria-label=""
					type="text"
					placeholder="Napisz komentarz..."
				></textarea>
				<button aria-label="Dodaj kometrz" class="add-comment-btn">
					<img
						class="icon"
						src="../dist/assets/icons/chevron-right.svg"
						alt=""
					/>
				</button>
			</div>
		</section>
		<section class="report">
			<div class="report__header">
				<h2 class="report__title">Zgłoś</h2>
				<button class="close-btn close-report-btn" aria-label="Zamknij sekcje zgłoszenia">
					<div class="close-btn__box">
						<span class="close-btn__inner"></span>
					</div>
				</button>
			</div>

			<div class="report__content">
				<h3 class="report__subTitle">
					Zgłoś tą treść, która wygląda na nieodpowiednią
				</h3>
				<p class="report__description">
					Jeżeli uważasz, że dane treść nie jest zgodna z naszym regulaminem,
					lub też któraś z treści występująca na naszej stronie jest obrażliwa
					dla ciebie, poinforumuj nas o tym.
				</p>
				<form action="" class="report__form">
					<h3 class="report__form-title">
						Napisz nam jaki jest powód zgłoszenia
					</h3>
					<textarea
						class="report__text"
						name="report__text"
						placeholder="Wpisz powód zgłoszenia"
					></textarea>
					<input
						type="submit"
						value="Wyślij zgłoszenie"
						class="report__send-btn primary-btn"
					/>
				</form>
			</div>
		</section>
		<div class="body-shadow bg-shadow"></div>
		<footer class="footer">
	<div class="wrapper">
		<a href="index.html" class="logo-name"
			>Mem<span class="other-color">Hub</span></a
		>
		<div class="footer__items">
			<a href="./contact.html" class="footer__item">Kontakt</a>
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

<<<<<<< HEAD:index.php
		<script src="./dist/js/main.min.js"></script>
		<script src="./dist/js/index.min.js"></script>
=======
		<script src="../dist/js/main.min.js"></script>
		<script src="../dist/js/mems.min.js"></script>
		<script src="../dist/js/index.min.js"></script>
>>>>>>> origin/only-html-ver:index.html
	</body>
</html>
