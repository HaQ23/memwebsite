/**
 * @module CarouselJS - Skrypt zarządzający slajderami
 */

/**
 * Pobranie elementu o klasie "main-carousel".
 * @type {Element}
 */
var elem = document.querySelector(".main-carousel");

/**
 * Inicjalizacja Flickity z opcjami dla elementu.
 * @type {Flickity}
 */
var flkty = new Flickity(elem, {
	// options
	contain: true,
	cellAlign: "left",
	prevNextButtons: true,
	wrapAround: true,
	imagesLoaded: true,
});

/**
 * Funkcja zmienia opcje Flickity w zależności od szerokości okna przeglądarki.
 */
const changeOptions = () => {
	if (window.innerWidth > 992) {
		flkty.prevNextButtons = true;
	}
};

// Dodanie nasłuchiwania na zdarzenie resize dla okna przeglądarki.
window.addEventListener("resize", changeOptions);

// Drugi karuzela

/**
 * Pobranie elementu o klasie "standard-theme__main-carousel".
 * @type {Element}
 */
var elemSecond = document.querySelector(".standard-theme__main-carousel");

/**
 * Inicjalizacja Flickity z opcjami dla drugiego elementu karuzeli.
 * @type {Flickity}
 */
var flktySecond = new Flickity(elemSecond, {
	// options
	contain: true,
	cellAlign: "left",
	prevNextButtons: true,
	wrapAround: true,
	pageDots: false,
	imagesLoaded: true,
});

/**
 * Pobranie elementu o klasie "standard-theme__nav-carousel".
 * @type {Element}
 */
var elemThird = document.querySelector(".standard-theme__nav-carousel");

/**
 * Inicjalizacja Flickity z opcjami dla trzeciego elementu karuzeli.
 * @type {Flickity}
 */
var flktyThird = new Flickity(elemThird, {
	// options
	asNavFor: ".standard-theme__main-carousel",
	contain: true,
	pageDots: false,
	prevNextButtons: false,
	imagesLoaded: true,
});
