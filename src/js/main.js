const hamBtn = document.querySelector(".ham-btn");
const menu = document.querySelector(".nav__items");

const showMenu = () => {
	hamBtn.classList.toggle("active");
	menu.classList.toggle("active");
};

hamBtn.addEventListener("click", showMenu);
