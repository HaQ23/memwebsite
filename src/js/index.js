const sortBtn = document.querySelector(".sort");
const sortList = document.querySelector(".sort-list");
const sortListItems = document.querySelectorAll(".sort-list__item");
let sortValue = "najnowsze";

const showSortList = () => {
	sortList.classList.toggle("active");
};

function closeShortList(el) {
	if (el.target.classList.contains("sort-list__item")) {
		sortValue = el.target.dataset.category;
		showSortList();
		sortListItems.forEach((el) => {
			if (el.dataset.category == sortValue) {
				el.classList.add("active");
			} else if (el.classList.contains("active")) {
				el.classList.toggle("active");
			}
		});
	}
}
sortBtn.addEventListener("click", showSortList);
sortList.addEventListener("click", closeShortList);
