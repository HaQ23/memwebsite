const allAddCommentBtn = document.querySelectorAll(".add-comment");
const closeCommentBtn = document.querySelector(".comments .close-btn");
const closeReportBtn = document.querySelector(".close-report-btn");
const sortBtn = document.querySelector(".sort");
const sortList = document.querySelector(".sort-list");
const sortListItems = document.querySelectorAll(".sort-list__item");
const sortCommentsBtn = document.querySelector(".btn-sort-comments");
const sendCommentBtn = document.querySelector(".add-comment-btn");
const reportForm = document.getElementById("report-form");
const sortCommentBox = document.querySelector(".sort-comments-options");
const showResponseCloseBtn = document.querySelectorAll(
	".showResponse__close-btn"
);
let sortValue = "najnowsze",
	sortCommentsValue = "najnowsze";
let whatItemIsReported, storeIdToSendReport;
let storeIdMem, storeIdComment;
let valueOfMems;
let startValueShowMem = 0,
	limit = 10;
let scrollHeight,
	maxMems,
	stopGenerate = false;
const toggleErrorOnSection = (el) => {
	el.classList.toggle("error");
	setTimeout(function () {
		el.classList.toggle("error");
	}, 2000);
};
function shareOnFacebook(memeSrc) {
	var shareURL =
		"https://www.facebook.com/sharer/sharer.php?u=" +
		encodeURIComponent(memeSrc);
	window.open(shareURL, "_blank");
}
const showResponseAlert = (type) => {
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

function updateAssessmentStatus(idMeme) {
	const xhr = new XMLHttpRequest();
	xhr.open(
		"GET",
		"../memwebsite/backend/utils/showMems.php?idMeme=" +
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
function updateCommentsStatus(idMeme) {
	const xhr = new XMLHttpRequest();
	xhr.open(
		"GET",
		"../memwebsite/backend/utils/showMems.php?idMeme=" +
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
function isLoginUser() {
	const xhr = new XMLHttpRequest();
	xhr.open(
		"GET",
		"../memwebsite/backend/utils/showMems.php?" + "&functionToDo=isLoginUser"
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

function getCountOfMems() {
	const xhr = new XMLHttpRequest();
	xhr.open(
		"GET",
		"../memwebsite/backend/utils/showMems.php?" + "&functionToDo=getCountMems",
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
function setNickofAuthor(el) {
	if (el === null) {
		return "Pobrane z ...";
	} else {
		return el.nick;
	}
}
function setSrcOfAuthor(idUser, originalUrl) {
	if (originalUrl === "") {
		return `./account.php?user=${idUser}`;
	} else {
		return originalUrl;
	}
}
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
function sendRating(idMeme, rating) {
	const xhr = new XMLHttpRequest();

	xhr.open(
		"POST",
		"../memwebsite/backend/utils/showMems.php?" + "&functionToDo=sendRating"
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
function sendCommentRating(idComment, rating) {
	const xhr = new XMLHttpRequest();

	xhr.open(
		"POST",
		"../memwebsite/backend/utils/showMems.php?" +
			"&functionToDo=sendRatingComment"
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
function likeMem(idMeme) {
	if (idMeme !== null) {
		sendRating(idMeme, 1);
	}
}
function dislikeMem(idMeme) {
	if (idMeme !== null) {
		sendRating(idMeme, 0);
	}
}
function likeComment(idComment) {
	if (idComment !== null) {
		sendCommentRating(idComment, 1);
	}
}
function dislikeComment(idComment) {
	if (idComment !== null) {
		sendCommentRating(idComment, 0);
	}
}
function getMems(index) {
	return new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		xhr.open(
			"GET",
			"../memwebsite/backend/utils/showMems.php?index=" +
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
			//updateAssessmentStatus(mem["id_meme"]);

			sendRating(mem["id_meme"]);
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
				console.log(srcMem);
				console.log("adS");
				shareOnFacebook(srcMem);
			});
			memyContainer.appendChild(memDiv);
		}
	} catch (error) {
		console.error("Błąd podczas pobierania memów:", error);
	}
}
function getTimeAgo(commentDate) {
	const currentDate = new Date();
	const commentDateTime = new Date(commentDate);

	const timeDiff = currentDate - commentDateTime;
	const minutesDiff = Math.ceil(timeDiff / (1000 * 60));
	const hoursDiff = Math.floor(timeDiff / (1000 * 60 * 60));
	const daysDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));

	if (daysDiff > 0) {
		return `${daysDiff} dni temu`;
	} else if (hoursDiff > 0) {
		return `${hoursDiff} godzin temu`;
	} else {
		return `${minutesDiff} minut temu`;
	}
}

function loadComments(idMeme) {
	const xhr = new XMLHttpRequest();
	xhr.open(
		"GET",
		"../memwebsite/backend/utils/showMems.php?idMeme=" +
			idMeme +
			"&sort=" +
			sortCommentsValue +
			"&functionToDo=loadComments",
		true
	);
	xhr.onreadystatechange = function () {};
	xhr.onload = function () {
		if (xhr.status === 200) {
			const comments = JSON.parse(xhr.responseText);
			const commentsContainer = document.querySelector(".comments__content");
			commentsContainer.innerHTML = "";
			for (let i = 0; i < comments.length; i++) {
				const comment = comments[i];
				const commentBox = document.createElement("div");
				commentBox.classList.add("comment");
				commentBox.setAttribute("data-id-comment", comment["id_comment"]);
				commentBox.innerHTML = `<a href="#" class="profile-box">
				<img
					src="./dist/assets/icons/user.svg"
					alt=""
					class="profile-photo"
				/>
			</a>
			<div class="comment__content-box data-id-coment='${comment.idComment}'">
				<div class="comment__content">
					<span class="comment__author">${comment.name.nick}</span>
					<p class="comment__text">
					${comment["body"]}
					</p>
				</div>
				<div class="comment__options">
					<div class="box">
						<div class="comment__assessment">
							<button
								aria-label="Polub ten mem"
								class="comment__option comment__like like"
							>
							<svg class="like-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#5ab450" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
							</button>
							<span class="comment__assessment-score comment__like-score like-score"
								>0</span
							>
						</div>
						<div class="comment__assessment">
							<button
								aria-label="Polub ten mem"
								class="comment__option comment__dislike dislike"
							>
							<svg class="dislike-icon"xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f72020" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
							</button>
							<span class="comment__assessment-score comment__unlike-score dislike-score"
								>0
							</span>
						</div>
					</div>
					<div class="box">
						<button class="comment__option comment__report">Zgłoś</button>
						<span class="comment__date-info">${getTimeAgo(comment.adding_date)}</span>
					</div>
				</div>
			</div>`;
				storeIdComment = comment.id_comment;
				sendCommentRating(storeIdComment);
				commentBox
					.querySelector(".comment__report")
					.addEventListener("click", function () {
						setValuesToReport(this);
					});
				commentBox
					.querySelector(".like")
					.addEventListener("click", function (e) {
						likeComment(
							parseInt(e.target.closest(".comment").dataset.idComment)
						);
					});
				commentBox
					.querySelector(".dislike")
					.addEventListener("click", function (e) {
						dislikeComment(
							parseInt(e.target.closest(".comment").dataset.idComment)
						);
					});
				commentsContainer.appendChild(commentBox);
			}
		}
	};
	xhr.onerror = function () {
		console.log("Wystąpił błąd zapytania.");
	};
	xhr.send();
}
const showComments = (el) => {
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
const addErrorOnCommentInput = (el) => {
	if (el.classList.contains("error")) {
		el.classList.toggle("error");
		el.setAttribute("placeholder", "Napisz komentarz...");
	} else {
		el.classList.toggle("error");
		el.setAttribute("placeholder", "Musisz być zalogowany aby dodać komentarz");
	}
};
function sendComment() {
	const commentValue = document.getElementById("addComment");
	const xhr = new XMLHttpRequest();
	if (commentValue.value !== "") {
		xhr.open(
			"POST",
			"../memwebsite/backend/utils/showMems.php?" + "&functionToDo=sendComment",
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
function sendReport() {
	const reportValue = document.getElementById("reportInputValue");
	if (reportValue.value !== "") {
		const xhr = new XMLHttpRequest();
		xhr.open(
			"POST",
			"../memwebsite/backend/utils/showMems.php?" + "&functionToDo=sendReport",
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
function checkScrollPosition() {
	scrollHeight = document.querySelector(".mems__container").scrollHeight;
	const windowHeight = window.innerHeight;
	const scrollTop =
		document.documentElement.scrollTop || document.body.scrollTop;
	if (windowHeight + scrollTop >= scrollHeight - 1000) {
		startValueShowMem = startValueShowMem + limit;
		loadMems(startValueShowMem);
	}
}
function changeSortMemes() {
	document.querySelector(
		".mems__container"
	).innerHTML = `<div class = "loading-spinner" id="loading-spinner-mem"></div>`;
	startValueShowMem = 0;
	loadMems(startValueShowMem);
}
function closeSortList(el) {
	if (el.target.classList.contains("sort-list__item")) {
		sortValue = el.target.dataset.category;
		showSortMemsList();
		sortListItems.forEach((el) => {
			if (el.dataset.category == sortValue) {
				el.classList.add("active");
			} else if (el.classList.contains("active")) {
				el.classList.toggle("active");
			}
		});
		changeSortMemes();
	}
}
const storeValueOfSortComments = (e) => {
	showCommentsSortList(e);
	const currentMem = e.target.closest(".comments");
	const currentSortBtn = document.querySelector(".btn-sort-name");
	const allSortOptions = currentMem.querySelectorAll(
		".sort-comments-options__btn"
	);
	if (e.target.classList.contains("sort-comments-options__btn")) {
		allSortOptions.forEach((el) => {
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
const showCommentsSortList = (el) => {
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

showResponseCloseBtn.forEach((el) => {
	el.addEventListener("click", function () {
		if (el.closest(".showResponse__error")) {
			showResponseAlert(2);
		} else {
			showResponseAlert(1);
		}
	});
});
