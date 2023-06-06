/**
 * @module memsJS - Skrypt zarządzający wyświetlaniem oraz obsługą memów na stronie głównej
 */

/**
 * Przyciski do dodawania komentarzy
 * @type {NodeList}
 */
const allAddCommentBtn = document.querySelectorAll(".add-comment");

/**
 * Przycisk do zamykania sekcji komentarzy
 * @type {Element}
 */
const closeCommentBtn = document.querySelector(".comments .close-btn");

/**
 * Przycisk do zamykania sekcji zgłoszeń
 * @type {Element}
 */
const closeReportBtn = document.querySelector(".close-report-btn");

/**
 * Przycisk sortowania
 * @type {Element}
 */
const sortBtn = document.querySelector(".sort");

/**
 * Lista sortowania
 * @type {Element}
 */
const sortList = document.querySelector(".sort-list");

/**
 * Elementy listy sortowania
 * @type {NodeList}
 */
const sortListItems = document.querySelectorAll(".sort-list__item");

/**
 * Przycisk sortowania komentarzy
 * @type {Element}
 */
const sortCommentsBtn = document.querySelector(".btn-sort-comments");

/**
 * Przycisk do wysyłania komentarza
 * @type {Element}
 */
const sendCommentBtn = document.querySelector(".add-comment-btn");

/**
 * Formularz zgłoszenia
 * @type {Element}
 */
const reportForm = document.getElementById("report-form");

/**
 * Pole sortowania komentarzy
 * @type {Element}
 */
const sortCommentBox = document.querySelector(".sort-comments-options");

/**
 * Przyciski do zamykania sekcji odpowiedzi
 * @type {NodeList}
 */
const showResponseCloseBtn = document.querySelectorAll(
	".showResponse__close-btn"
);

/**
 * Wartość sortowania
 * @type {string}
 */
let sortValue = "najnowsze";

/**
 * Wartość sortowania komentarzy
 * @type {string}
 */
let sortCommentsValue = "najnowsze";

/**
 * Identyfikator zgłoszonego elementu
 * @type {string}
 */
let whatItemIsReported, storeIdToSendReport;

/**
 * Identyfikator elementu mema
 * @type {string}
 */
let storeIdMem, storeIdComment;

/**
 * Wartość memów
 * @type {string}
 */
let valueOfMems;

/**
 * Początkowa wartość wyświetlania memów
 * @type {number}
 */
let startValueShowMem = 0;

/**
 * Limit memów
 * @type {number}
 */
let limit = 10;

/**
 * Wysokość przewijania
 * @type {number}
 */
let scrollHeight;

/**
 * Maksymalna liczba memów
 * @type {number}
 */
let maxMems;

/**
 * Zmienna kontrolująca generowanie memów
 * @type {boolean}
 */
let stopGenerate = false;

/**
 * Przełącza błąd na sekcji
 * @param {Element} el - Element, na którym ma zostać wykonane przełączenie
 */
const toggleErrorOnSection = el => {
	el.classList.toggle("error");
	setTimeout(function () {
		el.classList.toggle("error");
	}, 2000);
};
/**
 * Udostępnia mem na Facebooku.
 *
 * @param {string} memeSrc - Adres URL mema.
 */
function shareOnFacebook(memeSrc) {
	var shareURL =
		"https://www.facebook.com/sharer/sharer.php?u=" +
		encodeURIComponent(memeSrc);
	window.open(shareURL, "_blank");
}

/**
 * Wyświetla sekcję powiadomienia o podanym typie.
 *
 * @param {number} type - Typ powiadomienia (1 - sukces, inna wartość - błąd).
 */
const showResponseAlert = type => {
	document.querySelector(".body-shadow").classList.toggle("show");
	document.querySelector("body").classList.toggle("no-scroll");
	if (type === 1) {
		const responseSection = document.querySelector(".showResponse__success");
		responseSection.classList.toggle("show");
	} else {
		const responseSection = document.querySelector(".showResponse__error");
		responseSection.classList.toggle("show");
	}
};
function capitalizeFirstLetter(str) {
	return str.charAt(0).toUpperCase() + str.slice(1);
}
const showSortMemsList = () => {
	sortList.classList.toggle("active");
};
const toggleShowReport = () => {
	const currentReport = document.querySelector(".report");
	currentReport.classList.toggle("show");
	document.querySelector(".body-shadow").classList.toggle("show");
	document.querySelector("body").classList.toggle("no-scroll");
	if (document.querySelector(".comments").classList.contains("show")) {
		showComments();
	}
};
const setValuesToReport = (el) => {
	const currentReport = document.querySelector(".report");
	toggleShowReport();
	if (currentReport.classList.contains("show")) {
		if (el.closest(".mem")) {
			whatItemIsReported = "mem";
			storeIdToSendReport = el.closest(".mem").dataset.idMeme;
		} else {
			whatItemIsReported = "comment";
			storeIdToSendReport = storeIdComment;
		}
	}
};

/**
 * Aktualizuje status oceny mema.
 *
 * @param {string} idMeme - Identyfikator mema.
 */
function updateAssessmentStatus(idMeme) {
	const xhr = new XMLHttpRequest();
	xhr.open(
		"GET",
		"./backend/utils/showMems.php?idMeme=" +
			idMeme +
			"&functionToDo=getCountAssessment",
		true
	);
	xhr.onload = function () {
		if (xhr.status === 200) {
			const assessments = JSON.parse(xhr.responseText);
			const currentMem =
				document.querySelector(`[data-id-meme="${idMeme}"]`) || false;
			if (currentMem === false) {
				return;
			}
			const disLikeScore = currentMem.querySelector(".dislike-score");
			const likeScore = currentMem.querySelector(".like-score");

			if ("0" in assessments) {
				if ("rating" in assessments["0"]) {
					disLikeScore.textContent = assessments["0"]["assessment"];
				} else {
					disLikeScore.textContent = 0;
				}
			}
			if ("1" in assessments) {
				if ("rating" in assessments["1"]) {
					likeScore.textContent = assessments["1"]["assessment"];
				} else {
					likeScore.textContent = 0;
				}
			}
		}
	};
	xhr.onerror = function () {
		console.log("Wystąpił błąd zapytania.");
	};
	xhr.send();
}

/**
 * Aktualizuje status komentarzy mema.
 *
 * @param {string} idMeme - Identyfikator mema.
 */
function updateCommentsStatus(idMeme) {
	const xhr = new XMLHttpRequest();
	xhr.open(
		"GET",
		"./backend/utils/showMems.php?idMeme=" +
			idMeme +
			"&functionToDo=getCountComments",
		true
	);
	xhr.onload = function () {
		if (xhr.status === 200) {
			const comment = JSON.parse(xhr.responseText);
			const currentMem =
				document.querySelector(`[data-id-meme="${idMeme}"]`) || false;
			if (currentMem === false) {
				return;
			}
			const commentScore = currentMem.querySelector(".mem__comment-score");
			if (comment["commentCount"] !== undefined) {
				commentScore.textContent = comment["commentCount"];
			} else {
				commentScore.textContent = 0;
			}
		}
	};
	xhr.onerror = function () {
		console.log("Wystąpił błąd zapytania.");
	};
	xhr.send();
}

/**
 * Sprawdza, czy użytkownik jest zalogowany.
 *
 * @returns {boolean} - Wartość logiczna, czy użytkownik jest zalogowany.
 */
function isLoginUser() {
	const xhr = new XMLHttpRequest();
	xhr.open(
		"GET",
		"./backend/utils/showMems.php?" + "&functionToDo=isLoginUser"
	);

	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.onload = function () {
		if (xhr.status === 200) {
			const response = JSON.parse(xhr.responseText);
			return response.staus_uzytkownika;
		} else {
			console.log("Wystąpił błąd zapytania.");
		}
	};
	xhr.onerror = function () {
		console.log("Wystąpił błąd zapytania.");
	};

	xhr.send();
}

/**
 * Pobiera liczbę memów.
 */
function getCountOfMems() {
	const xhr = new XMLHttpRequest();
	xhr.open(
		"GET",
		"./backend/utils/showMems.php?" + "&functionToDo=getCountMems",
		true
	);
	xhr.onload = function () {
		const countMems = JSON.parse(xhr.responseText);
	};
	xhr.onerror = function () {
		console.log("Wystąpił błąd zapytania.");
	};
	xhr.send();
}

/**
 * Ustawia nick autora.
 *
 * @param {HTMLElement} el - Element autora.
 * @returns {string} - Nick autora lub domyślny tekst.
 */
function setNickofAuthor(el) {
	if (el === null) {
		return "Pobrane z ...";
	} else {
		return el.nick;
	}
}

/**
 * Ustawia źródło autora.
 *
 * @param {string} idUser - Identyfikator użytkownika.
 * @param {string} originalUrl - Oryginalny URL.
 * @returns {string} - Źródło autora.
 */
function setSrcOfAuthor(idUser, originalUrl) {
	if (originalUrl === "") {
		return `./account.php?user=${idUser}`;
	} else {
		return originalUrl;
	}
}

/**
 * Aktualizuje interfejs oceny mema.
 *
 * @param {string} idMeme - Identyfikator mema.
 * @param {number} likes - Liczba polubień.
 * @param {number} dislikes - Liczba niepolubień.
 * @param {number} userChoosed - Wybór użytkownika (0 - niepolubienie, 1 - polubienie, inna wartość - brak wyboru).
 */
function updateRatingUI(idMeme, likes, dislikes, userChoosed) {
	const memyContainer = document.querySelector(`[data-id-meme="${idMeme}"]`);
	if (memyContainer !== null) {
		memyContainer.querySelector(".like-score").textContent = likes;
		memyContainer.querySelector(".dislike-score").textContent = dislikes;
		if (userChoosed === 1) {
			memyContainer.querySelector(".like-icon").setAttribute("fill", "#5ab450");
			memyContainer.querySelector(".dislike-icon").setAttribute("fill", "none");
		} else if (userChoosed === 0) {
			memyContainer
				.querySelector(".dislike-icon")
				.setAttribute("fill", "#f72020");
			memyContainer.querySelector(".like-icon").setAttribute("fill", "none");
		} else {
			memyContainer.querySelector(".dislike-icon").setAttribute("fill", "none");
			memyContainer.querySelector(".like-icon").setAttribute("fill", "none");
		}
	}
}

/**
 * Aktualizuje interfejs oceny komentarza.
 *
 * @param {string} idComment - Identyfikator komentarza.
 * @param {number} likes - Liczba polubień.
 * @param {number} dislikes - Liczba niepolubień.
 * @param {number} userChoosed - Wybór użytkownika (0 - niepolubienie, 1 - polubienie, inna wartość - brak wyboru).
 */
function updateRatingCommentUI(idComment, likes, dislikes, userChoosed) {
	const comment = document.querySelector(`[data-id-comment="${idComment}"]`);
	if (comment !== null) {
		comment.querySelector(".like-score").textContent = likes;
		comment.querySelector(".dislike-score").textContent = dislikes;
		if (userChoosed === 1) {
			comment.querySelector(".like-icon").setAttribute("fill", "#5ab450");
			comment.querySelector(".dislike-icon").setAttribute("fill", "none");
		} else if (userChoosed === 0) {
			comment.querySelector(".dislike-icon").setAttribute("fill", "#f72020");
			comment.querySelector(".like-icon").setAttribute("fill", "none");
		} else {
			comment.querySelector(".dislike-icon").setAttribute("fill", "none");
			comment.querySelector(".like-icon").setAttribute("fill", "none");
		}
	}
}

/**
 * Wysyła ocenę mema.
 *
 * @param {string} idMeme - Identyfikator mema.
 * @param {string} rating - Ocena (0 - niepolubienie, 1 - polubienie).
 */
function sendRating(idMeme, rating) {
	const xhr = new XMLHttpRequest();

	xhr.open(
		"POST",
		"./backend/utils/showMems.php?" + "&functionToDo=sendRating"
	);

	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.onload = function () {
		if (xhr.status === 200) {
			const response = JSON.parse(xhr.responseText);
			const like = response.currentRatingLike.assessment;
			const dislike = response.currentRatingDislike.assessment;
			const userChoosed = response.user_rating.user_rating;
			updateRatingUI(
				idMeme,
				parseInt(like),
				parseInt(dislike),
				parseInt(userChoosed)
			);
		} else {
			console.log("Wystąpił błąd zapytania.");
		}
	};
	xhr.onerror = function () {
		console.log("Wystąpił błąd zapytania.");
	};

	xhr.send(
		"idMeme=" +
			encodeURIComponent(idMeme) +
			"&rating=" +
			encodeURIComponent(rating)
	);
}

/**
 * Wysyła ocenę komentarza.
 *
 * @param {string} idComment - Identyfikator komentarza.
 * @param {string} rating - Ocena (0 - niepolubienie, 1 - polubienie).
 */
function sendCommentRating(idComment, rating) {
	const xhr = new XMLHttpRequest();

	xhr.open(
		"POST",
		"./backend/utils/showMems.php?" + "&functionToDo=sendRatingComment"
	);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.onload = function () {
		if (xhr.status === 200) {
			const response = JSON.parse(xhr.responseText);
			const like = response.currentRatingLike.assessment;
			const dislike = response.currentRatingDislike.assessment;
			const userChoosed = response.user_rating.user_rating;

			updateRatingCommentUI(
				idComment,
				parseInt(like),
				parseInt(dislike),
				parseInt(userChoosed)
			);
		} else {
			console.log("Wystąpił błąd zapytania.");
		}
	};
	xhr.onerror = function () {
		console.log("Wystąpił błąd zapytania.");
	};

	xhr.send(
		"idComment=" +
			encodeURIComponent(idComment) +
			"&rating=" +
			encodeURIComponent(rating)
	);
}

/**
 * Funkcja do polubienia mema.
 *
 * @param {string} idMeme - Identyfikator mema.
 */
function likeMem(idMeme) {
	if (idMeme !== null) {
		sendRating(idMeme, 1);
	}
}

/**
 * Funkcja do niepolubienia mema.
 *
 * @param {string} idMeme - Identyfikator mema.
 */
function dislikeMem(idMeme) {
	if (idMeme !== null) {
		sendRating(idMeme, 0);
	}
}

/**
 * Funkcja do polubienia komentarza.
 *
 * @param {string} idComment - Identyfikator komentarza.
 */
function likeComment(idComment) {
	if (idComment !== null) {
		sendCommentRating(idComment, 1);
	}
}

/**
 * Funkcja do niepolubienia komentarza.
 *
 * @param {string} idComment - Identyfikator komentarza.
 */
function dislikeComment(idComment) {
	if (idComment !== null) {
		sendCommentRating(idComment, 0);
	}
}

/**
 * Funkcja do pobierania memów.
 *
 * @param {number} index - Indeks memów.
 * @returns {Promise} - Obiekt Promise z memami.
 */
function getMems(index) {
	return new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		xhr.open(
			"GET",
			"./backend/utils/showMems.php?index=" +
				index +
				"&limit=" +
				limit +
				"&sort=" +
				sortValue +
				"&functionToDo=loadMems",
			true
		);

		xhr.onload = function () {
			if (xhr.status === 200) {
				const memy = JSON.parse(xhr.responseText);
				resolve(memy);
			} else {
				reject(xhr.status);
			}
		};
		xhr.onerror = function () {
			reject(xhr.status);
		};
		xhr.send();
	});
}

/**
 * Funkcja do ładowania memów.
 *
 * @param {number} index - Indeks memów.
 */
async function loadMems(index) {
	try {
		const memy = await getMems(index);
		const memyContainer = document.querySelector(".mems__container");
		if (memyContainer.childElementCount === 1) {
			memyContainer.textContent = "";
		}
		const maxMems = getCountOfMems();
		if (memy.length === 0) {
			stopGenerate = true;
			return;
		}
		for (let i = 0; i < memy.length; i++) {
			const mem = memy[i];
			const memDiv = document.createElement("div");
			memDiv.classList.add("mem");
			memDiv.setAttribute("data-id-meme", mem["id_meme"]);
			const srcMem = "memes/" + mem.imgsource;
			memDiv.innerHTML = `<img
					src=${srcMem}
					alt="mem"
					class="mem__img"
				/>
				<div class="mem__info">
					<div class="mem__assessments">
						<div class="mem__assessment">
							<span class="mem__assessment-score like-score">0</span>
							<button
								aria-label="Polub ten mem"
								class="add-assessment like"
							>
							<svg class="icon like-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#5ab450" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
							</button>
						</div>
						<div class="mem__assessment">
							<span class="mem__assessment-score dislike-score">0 </span>
							<button
								aria-label="Polub ten mem"
								class="add-assessment dislike"
							>
							<svg class="icon dislike-icon"xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f72020" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
							</button>
						</div>
					</div>
					<div class="mem__comment">
						<span class="mem__comment-score"> 0 </span>
						<button aria-label="Polub ten mem" class="add-comment">
							<img
								src="./dist/assets/icons/message-square.svg"
								alt=""
								class="icon"
							/>
						</button>
					</div>
					<div class="box">
					<a href="${setSrcOfAuthor(mem.id_user, mem.original_url)}" class="mem__author">
						<div class="profile-box">
							<img
								src="./dist/assets/icons/user.svg"
								alt=""
								class="profile-photo"
							/>
							
						</div>
						<span class="user-name">${setNickofAuthor(mem.name)}</span>
					</a>
					</div>
					<div class="box">
					<div class="share-mem">
					<button class ="share-btn share-btn-facebook"><img class="icon"src="./dist/assets/icons/facebookSquare.webp"></button>

					</div>
					<button class="report-mem">Zgłoś mema</button>
					</div>
				</div>`;

			sendRating(mem["id_meme"], 2);
			updateCommentsStatus(mem["id_meme"]);
			memDiv
				.querySelector(".add-comment")
				.addEventListener("click", showComments);
			memDiv
				.querySelector(".report-mem")
				.addEventListener("click", function () {
					setValuesToReport(this);
				});

			memDiv.querySelector(".like").addEventListener("click", function (e) {
				likeMem(parseInt(e.target.closest(".mem").dataset.idMeme));
			});
			memDiv.querySelector(".dislike").addEventListener("click", function (e) {
				dislikeMem(parseInt(e.target.closest(".mem").dataset.idMeme));
			});
			memDiv.querySelector(".share-btn").addEventListener("click", function () {
				shareOnFacebook(`http://mem-hub.pl/${srcMem}`);
			});
			memyContainer.appendChild(memDiv);
		}
	} catch (error) {
		console.error("Błąd podczas pobierania memów:", error);
	}
}

/**
 * Funkcja oblicza czas, który minął od dodania komentarza do teraźniejszości.
 *
 * @param {string} commentDate - Data dodania komentarza w formacie tekstowym.
 * @returns {string} - Czas, który minął od dodania komentarza.
 */
function getTimeAgo(commentDate) {
	// Pobranie aktualnej daty
	const currentDate = new Date();

	// Konwersja daty komentarza na obiekt Date
	const commentDateTime = new Date(commentDate);

	// Obliczenie różnicy czasu między aktualną datą a datą komentarza
	const timeDiff = currentDate - commentDateTime;

	// Obliczenie różnicy w minutach, godzinach i dniach
	const minutesDiff = Math.ceil(timeDiff / (1000 * 60));
	const hoursDiff = Math.floor(timeDiff / (1000 * 60 * 60));
	const daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));

	// Sprawdzenie, czy minęły dni, godziny lub tylko minuty i zwrócenie odpowiedniego wyniku
	if (daysDiff > 0) {
		return `${daysDiff} dni temu`;
	} else if (hoursDiff > 0) {
		return `${hoursDiff} godzin temu`;
	} else {
		return `${minutesDiff} minut temu`;
	}
}

/**
 * Funkcja wczytuje komentarze dla danego mema i wyświetla je na stronie.
 *
 * @param {number} idMeme - ID mema.
 */
function loadComments(idMeme) {
	// Utworzenie nowego obiektu XMLHttpRequest
	const xhr = new XMLHttpRequest();
	console.log(xhr);
	// Ustawienie parametrów zapytania GET
	xhr.open(
		"GET",
		"./backend/utils/showMems.php?idMeme=" +
			idMeme +
			"&sort=" +
			sortCommentsValue +
			"&functionToDo=loadComments",
		true
	);

	// Ustawienie funkcji wywoływanej przy zmianie stanu zapytania
	xhr.onreadystatechange = function () {};

	// Ustawienie funkcji wywoływanej po odebraniu odpowiedzi
	xhr.onload = function () {
		// Sprawdzenie statusu odpowiedzi
		if (xhr.status === 200) {
			// Parsowanie otrzymanych komentarzy
			const comments = JSON.parse(xhr.responseText);

			// Znalezienie kontenera na komentarze
			const commentsContainer = document.querySelector(".comments__content");

			// Wyczyszczenie kontenera komentarzy
			commentsContainer.innerHTML = "";

			// Przeiterowanie przez wszystkie komentarze
			for (let i = 0; i < comments.length; i++) {
				const comment = comments[i];

				// Utworzenie elementu div dla komentarza
				const commentBox = document.createElement("div");
				commentBox.classList.add("comment");
				commentBox.setAttribute("data-id-comment", comment["id_comment"]);

				// Uzupełnienie zawartości komentarza
				commentBox.innerHTML = `
					<a href="#" class="profile-box">
						<img src="./dist/assets/icons/user.svg" alt="" class="profile-photo" />
					</a>
					<div class="comment__content-box data-id-coment='${comment.idComment}'>
						<div class="comment__content">
							<span class="comment__author">${comment.name.nick}</span>
							<p class="comment__text">
								${comment["body"]}
							</p>
						</div>
						<div class="comment__options">
							<div class="box">
								<div class="comment__assessment">
									<button aria-label="Polub ten mem" class="comment__option comment__like like">
										<svg class="like-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#5ab450" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
											<path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
										</svg>
									</button>
									<span class="comment__assessment-score comment__like-score like-score">0</span>
								</div>
								<div class="comment__assessment">
									<button aria-label="Polub ten mem" class="comment__option comment__dislike dislike">
										<svg class="dislike-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f72020" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down">
											<path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
										</svg>
									</button>
									<span class="comment__assessment-score comment__unlike-score dislike-score">0</span>
								</div>
							</div>
							<div class="box">
								<button class="comment__option comment__report">Zgłoś</button>
								<span class="comment__date-info">${getTimeAgo(comment.adding_date)}</span>
							</div>
						</div>
					</div>`;

				storeIdComment = comment.id_comment;
				sendCommentRating(storeIdComment, 2);

				// Dodanie event listenera do przycisku zgłaszania komentarza
				commentBox
					.querySelector(".comment__report")
					.addEventListener("click", function () {
						setValuesToReport(this);
					});

				// Dodanie event listenera do przycisku polubienia komentarza
				commentBox
					.querySelector(".like")
					.addEventListener("click", function (e) {
						likeComment(
							parseInt(e.target.closest(".comment").dataset.idComment)
						);
					});

				// Dodanie event listenera do przycisku niepolubienia komentarza
				commentBox
					.querySelector(".dislike")
					.addEventListener("click", function (e) {
						dislikeComment(
							parseInt(e.target.closest(".comment").dataset.idComment)
						);
					});

				// Dodanie komentarza do kontenera
				commentsContainer.appendChild(commentBox);
			}
		}
	};

	// Ustawienie funkcji wywoływanej w przypadku błędu zapytania
	xhr.onerror = function () {
		console.log("Wystąpił błąd zapytania.");
	};

	// Wysłanie zapytania
	xhr.send();
}

/**
 * Funkcja odpowiedzialna za pokazywanie/ukrywanie sekcji z komentarzami.
 * @param {Element} el - Element, który wywołał funkcję.
 */
const showComments = el => {
	/**
	 * @type {Element}
	 */
	const currentComments = document.querySelector(".comments");
	currentComments.classList.toggle("show");
	document.querySelector(".body-shadow").classList.toggle("show");
	document.querySelector("body").classList.toggle("no-scroll");
	if (currentComments.classList.contains("show")) {
		storeIdMem = el.target.closest(".mem").dataset.idMeme;
		currentComments.querySelector(
			".comments__content"
		).innerHTML = `<div class = "loading-spinner"id="loading-spinner-comment"></div>`;
		loadComments(storeIdMem);
	} else {
		currentComments.querySelector(".comments__content").textContent = "";
	}
};

/**
 * Funkcja odpowiedzialna za dodawanie/usuwanie błędu na polu wprowadzania komentarza.
 * @param {Element} el - Pole wprowadzania komentarza.
 */
const addErrorOnCommentInput = el => {
	if (el.classList.contains("error")) {
		el.classList.toggle("error");
		el.setAttribute("placeholder", "Napisz komentarz...");
	} else {
		el.classList.toggle("error");
		el.setAttribute("placeholder", "Musisz być zalogowany aby dodać komentarz");
	}
};

/**
 * Funkcja odpowiedzialna za wysyłanie komentarza.
 */
function sendComment() {
	const commentValue = document.getElementById("addComment");
	const xhr = new XMLHttpRequest();
	if (commentValue.value !== "") {
		xhr.open(
			"POST",
			"./backend/utils/showMems.php?" + "&functionToDo=sendComment",
			true
		);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onload = function () {
			if (xhr.status === 200) {
				const answer = JSON.parse(xhr.responseText);

				if (answer.success === true) {
					commentValue.value = "";
					loadComments(storeIdMem);
				} else if (answer.success === false) {
					commentValue.value = "";
					addErrorOnCommentInput(commentValue);
					setTimeout(() => {
						addErrorOnCommentInput(commentValue);
					}, 5000);
				}
			}
		};
		xhr.onerror = function () {
			console.error("Wystąpił błąd podczas wysyłania żądania.");
		};
		xhr.send(
			"comment=" +
				encodeURIComponent(commentValue.value) +
				"&idMeme=" +
				parseInt(storeIdMem)
		);
	}
}

/**
 * Funkcja odpowiedzialna za wysyłanie zgłoszenia.
 */
function sendReport() {
	const reportValue = document.getElementById("reportInputValue");
	if (reportValue.value !== "") {
		const xhr = new XMLHttpRequest();
		xhr.open(
			"POST",
			"./backend/utils/showMems.php?" + "&functionToDo=sendReport",
			true
		);
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xhr.onload = function () {
			if (xhr.status === 200) {
				const answer = JSON.parse(xhr.responseText);
				if (answer.success === true) {
					reportValue.value = "";
					toggleShowReport();
					showResponseAlert(1);
					setTimeout(() => {
						if (
							document
								.querySelector(".showResponse__success")
								.classList.contains("show")
						) {
							showResponseAlert(1);
						}
					}, 1200);
				} else if (answer.success === false) {
					reportValue.value = "";
					toggleShowReport();
					showResponseAlert(2);
					setTimeout(() => {
						if (
							document
								.querySelector(".showResponse__error")
								.classList.contains("show")
						) {
							showResponseAlert(2);
						}
					}, 3000);
				}
			}
		};
		xhr.onerror = function () {
			console.error("Wystąpił błąd podczas wysyłania żądania.");
			alert("Błąd podczas wysyłania zgłoszenia");
		};
		xhr.send(
			"message=" +
				encodeURIComponent(reportValue.value) +
				"&idItem=" +
				parseInt(storeIdToSendReport) +
				"&typeOfItem=" +
				whatItemIsReported
		);
	} else {
		const reportSection = document.querySelector(".report");
		toggleErrorOnSection(reportSection);
	}
}

/**
 * Funkcja sprawdzająca pozycję przewijania strony i ładowanie nowych memów, jeśli użytkownik jest blisko końca strony.
 */
function checkScrollPosition() {
	/**
	 * @type {number}
	 */
	scrollHeight = document.querySelector(".mems__container").scrollHeight;
	const windowHeight = window.innerHeight;
	const scrollTop =
		document.documentElement.scrollTop || document.body.scrollTop;
	if (windowHeight + scrollTop >= scrollHeight - 1000) {
		startValueShowMem = startValueShowMem + limit;
		loadMems(startValueShowMem);
	}
}

/**
 * Funkcja zmieniająca sortowanie memów.
 */
function changeSortMemes() {
	document.querySelector(
		".mems__container"
	).innerHTML = `<div class = "loading-spinner" id="loading-spinner-mem"></div>`;
	startValueShowMem = 0;
	loadMems(startValueShowMem);
}

/**
 * Funkcja obsługująca zamknięcie listy sortowania memów.
 * @param {Event} el - Zdarzenie zamknięcia listy sortowania.
 */
function closeSortList(el) {
	if (el.target.classList.contains("sort-list__item")) {
		sortValue = el.target.dataset.category;
		showSortMemsList();
		sortListItems.forEach(el => {
			if (el.dataset.category == sortValue) {
				el.classList.add("active");
			} else if (el.classList.contains("active")) {
				el.classList.toggle("active");
			}
		});
		changeSortMemes();
	}
}

/**
 * Funkcja przechowująca wartość sortowania komentarzy i aktualizująca wygląd interfejsu.
 * @param {Event} e - Zdarzenie kliknięcia na opcję sortowania komentarzy.
 */
const storeValueOfSortComments = e => {
	showCommentsSortList(e);
	const currentMem = e.target.closest(".comments");
	const currentSortBtn = document.querySelector(".btn-sort-name");
	const allSortOptions = currentMem.querySelectorAll(
		".sort-comments-options__btn"
	);
	if (e.target.classList.contains("sort-comments-options__btn")) {
		allSortOptions.forEach(el => {
			el.classList.remove("currentSort");
		});
		e.target.classList.add("currentSort");
		sortCommentsValue = e.target.dataset.category;
		currentSortBtn.innerHTML = `${capitalizeFirstLetter(sortCommentsValue)}`;
		currentMem.classList.remove("show-sort-value");
		currentMem.querySelector(
			".comments__content"
		).innerHTML = `<div class = "loading-spinner"id="loading-spinner-comment"></div>`;
		loadComments(storeIdMem);
	} else if (e.target.classList.contains("bg-shadow")) {
		currentMem.classList.remove("show-sort-value");
	}
};

/**
 * Funkcja wyświetlająca listę sortowania komentarzy.
 * @param {Event} el - Zdarzenie kliknięcia na przycisk sortowania komentarzy.
 */
const showCommentsSortList = el => {
	const currentMem = el.target.closest(".comments");
	currentMem.classList.toggle("show-sort-value");
};

window.addEventListener("load", function () {
	loadMems(startValueShowMem);
});
window.addEventListener("scroll", function () {
	if (!stopGenerate) {
		checkScrollPosition();
	}
});

closeCommentBtn.addEventListener("click", showComments);

sortCommentsBtn.addEventListener("click", showCommentsSortList);
closeReportBtn.addEventListener("click", toggleShowReport);
sortBtn.addEventListener("click", showSortMemsList);
sortList.addEventListener("click", closeSortList);
window.addEventListener("beforeunload", function () {
	window.scrollTo(0, 0);
});

sendCommentBtn.addEventListener("click", sendComment);
reportForm.addEventListener("submit", function (event) {
	event.preventDefault();
	sendReport();
});
sortCommentBox.addEventListener("click", storeValueOfSortComments);

showResponseCloseBtn.forEach(el => {
	el.addEventListener("click", function () {
		if (el.closest(".showResponse__error")) {
			showResponseAlert(2);
		} else {
			showResponseAlert(1);
		}
	});
});
