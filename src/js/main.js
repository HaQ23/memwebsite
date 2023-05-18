const hamBtn = document.querySelector(".ham-btn");
const menu = document.querySelector(".nav__items");
const alertText = document.querySelector('.alert__text');
const alertBox = document.querySelector('.alert');
const showMenu = () => {
	hamBtn.classList.toggle("active");
	menu.classList.toggle("active");
};
const handleAlert = text => {
	let scaleAmount = 1;
	alertBox.style.setProperty("--scale-alert", `0.${scaleAmount}`);
	alertText.innerHTML = text;

	let timer = setInterval(() => {
		if (scaleAmount < 0) {
			alertBox.style.display = "none";
			clearInterval(timer);
		} else {
			alertBox.style.display = "block";
			alertBox.style.setProperty("--scale-alert", `${scaleAmount}`);
			scaleAmount -= 0.1;
		}
	}, 300);
};
hamBtn.addEventListener("click", showMenu);
