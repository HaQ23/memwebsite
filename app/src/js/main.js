/**
 * @module mainJS - Plik główny zawierający elementy globalne
 */

/**
 * Przycisk reprezentujący przycisk menu typu hamburger.
 * @type {HTMLElement}
 */
const hamBtn = document.querySelector(".ham-btn");

/**
 * Kontener reprezentujący menu.
 * @type {HTMLElement}
 */
const menu = document.querySelector(".nav__items");

/**
 * Element reprezentujący tekst ostrzeżenia.
 * @type {HTMLElement}
 */
const alertText = document.querySelector(".alert__text");

/**
 * Element reprezentujący pole ostrzeżenia.
 * @type {HTMLElement}
 */
const alertBox = document.querySelector(".alert");

/**
 * Przełącza widoczność menu.
 */
const showMenu = () => {
	hamBtn.classList.toggle("active");
	menu.classList.toggle("active");
};

/**
 * Obsługuje wyświetlanie ostrzeżeń.
 * @param {string} text - Tekst ostrzeżenia.
 */
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

// Dodaje nasłuchiwanie na kliknięcie przycisku hamBtn
hamBtn.addEventListener("click", showMenu);
