const allAddCommentBtn = document.querySelectorAll(".add-comment");
const closeCommentBtn = document.querySelector(".comments .close-btn");
const sortBtn = document.querySelectorAll(".btn-sort-comments");
const allReportBtn = document.querySelectorAll(".report-mem, .comment__report");
const closeReportBtn = document.querySelector(".close-report-btn");
const showComments = () => {
	const currentComments = document.querySelector(".comments");
	currentComments.classList.toggle("show");
	document.querySelector(".body-shadow").classList.toggle("show");
	document.querySelector("body").classList.toggle("no-scroll");
};
const showReport = () => {
	const currentReport = document.querySelector(".report");
	currentReport.classList.toggle("show");
	document.querySelector(".body-shadow").classList.toggle("show");
	document.querySelector("body").classList.toggle("no-scroll");
	if (document.querySelector(".comments").classList.contains("show")) {
		showComments();
	}
};
const showSortList = (el) => {
	const currentMem = el.target.closest(".comments");
	currentMem.classList.toggle("show-sort-value");
	const allSortOptions = currentMem.querySelectorAll(
		".sort-comments-options__btn"
	);
	const currentSortBtn = currentMem.querySelector(".btn-sort-comments");
	currentMem.addEventListener("click", function (e) {
		if (e.target.classList.contains("sort-comments-options__btn")) {
			allSortOptions.forEach((el) => {
				el.classList.remove("currentSort");
			});
			e.target.classList.add("currentSort");
			const currentSortValue = e.target.dataset.category;
			currentSortBtn.innerHTML = `${currentSortValue} <img
            src="../dist/assets/icons/chevron-down.svg"
            alt=""
            class="icon"
        />`;
			currentMem.classList.remove("show-sort-value");
		} else if (e.target.classList.contains("bg-shadow")) {
			currentMem.classList.remove("show-sort-value");
		}
	});
};
[...allAddCommentBtn, closeCommentBtn].forEach((el) => {
	el.addEventListener("click", showComments);
});
sortBtn.forEach((el) => {
	el.addEventListener("click", showSortList);
});
[...allReportBtn, closeReportBtn].forEach((el) => {
	el.addEventListener("click", showReport);
});
