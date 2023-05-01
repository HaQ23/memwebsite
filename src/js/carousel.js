var elem = document.querySelector(".main-carousel");
var flkty = new Flickity(elem, {
	// options
	contain: true,
	cellAlign: "left",
	prevNextButtons: true,
	wrapAround: true,
	imagesLoaded: true,
});

const changeOptions = () => {
	if (window.innerWidth > 992) {
		flkty.prevNextButtons = true;
	}
};

window.addEventListener("resize", changeOptions);

//second carousel

var elemSecond = document.querySelector(".standard-theme__main-carousel");
var flkty = new Flickity(elemSecond, {
	// options
	contain: true,
	cellAlign: "left",
	prevNextButtons: true,
	wrapAround: true,
	pageDots: false,
	imagesLoaded: true,
});
var elemThird = document.querySelector(".standard-theme__nav-carousel");
var flkty = new Flickity(elemThird, {
	// options
	asNavFor: ".standard-theme__main-carousel",
	contain: true,
	pageDots: false,
	prevNextButtons: false,
	imagesLoaded: true,
});
