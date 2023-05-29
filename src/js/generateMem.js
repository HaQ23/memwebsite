const allTemaplateItems = document.querySelectorAll(
	".select-temaplate__carousel-item "
);
const selectTemplateSection = document.querySelector(".select-temaplate");
const setImageSection = document.querySelector(".set-image");
const backToSelectTemplateSeciontBtn =
	document.querySelector(".set-image__back");

const createMemSection = document.querySelector(".create-mem");
const loadFileBtn = document.querySelector(".add-file");
const createMemBackBtn = createMemSection.querySelector(".back");
const currentlyCreatedMem = createMemSection.querySelector(
	".create-mem__img-box"
);
const allStandardImage = document.querySelectorAll(".standard-theme__item");
const downloadMemBtn = document.querySelector(".download-mem");
const createMemBox = document.querySelector(".create-mem__mem-box");
const canvas = document.querySelector("#canvas-mem");
const textAlignBtns = document.querySelectorAll("[data-text-align]")
const fontStyleBtns = document.querySelectorAll(".font-style-btn");
const changeTemplateBtn = document.querySelector(
	".create-mem__change-template"
);
const changeTemplateSect = document.querySelector(".change-template");
const closeChangeTemplateSectBtn =
	changeTemplateSect.querySelector(".close-btn");
let selectedElement;
let useYourPhoto = false;
let image;
let imageWidth, imageHeight;
let numberOfMem = 1;

const changeShowElement = () => {
	setImageSection.classList.toggle("show");
	selectTemplateSection.classList.toggle("show");
};

const chooseCurrentTemaplte = (el) => {
	selectedElement = el.target.dataset.typeTemplate;
	const selectedTemplateImg = document.querySelector(".selected-temaplate img");
	selectedTemplateImg.setAttribute(
		"src",
		`../dist/assets/images/meme-demo-template-${selectedElement}.webp`
	);
	changeShowElement();
};

const showCreateMem = (el) => {
	if (!createMemSection.classList.contains("show")) {
		setWidthAndHeightMem(el);
	}
	document.querySelector("body").classList.toggle("no-scroll");
	createMemSection.classList.toggle("show");
	useYourPhoto = false;
};
//this function sets   imageWidth, imageHeight  which will be needed for the correct display of memes
const setWidthAndHeightMem = (el) => {
	if (useYourPhoto) {
		const imageDataUrl = URL.createObjectURL(loadFileBtn.files[0]);
		image = new Image();
		image.src = imageDataUrl;
		currentlyCreatedMem.innerHTML = "";
		image.classList.add("create-mem__img");
		currentlyCreatedMem.appendChild(image);
		image = currentlyCreatedMem.querySelector("img");
	} else {
		const imageDataUrl = el.target.querySelector("img").src;
		image = new Image();
		image.src = imageDataUrl;
		currentlyCreatedMem.innerHTML = "";
		image.classList.add("create-mem__img");
		currentlyCreatedMem.appendChild(image);
	}
	image.onload = function () {
		imageWidth = image.clientWidth;
		imageHeight = image.clientHeight;
		currentlyCreatedMem.classList.add("active");
		canvas.style.display = "block";
		genereteMem(imageWidth, imageHeight);
	};
};
const genereteMem = (width, height) => {
	const ctx = canvas.getContext("2d");
	const yOffset = 3;
	const textalign = document.querySelector("[data-text-align].active-value")
		.dataset.textAlign;

	let fontSize = document.querySelector("#font-size").value;
	const strokeStyle = document.querySelector("#input-stroke-style").value;
	const fillStyle = document.querySelector("#input-color-text").value;
	const fontStyle = document.querySelector(".font-style-btn.active-value")
		.dataset.fontStyle;
	const fontFamilly = document.querySelector("#select-font").value;
	const frameThickness = 80;
	let xOfText,
		textTop = "",
		textBottom = "";
	if (fontSize > 60 || fontSize == "") {
		fontSize = 60;
	} else if (fontSize < 10) {
		fontSize = 10;
	}
	canvas.width = width;
	canvas.height = height;
	ctx.lineWidth = Math.floor(fontSize / 4);
	ctx.textAlign = textalign;
	ctx.lineJoin = "round";
	ctx.font = `${fontStyle} ${fontSize}px ${fontFamilly}`;
	ctx.strokeStyle = strokeStyle;
	ctx.drawImage(
		image,
		0,
		0,
		image.naturalWidth,
		image.height,
		0,
		0,
		width,
		height
	);
	if (textalign == "left") {
		xOfText = 5;
	} else if (textalign == "center") {
		xOfText = width / 2;
	} else {
		xOfText = width - 5;
	}
	switch (selectedElement) {
		case "1":
			ctx.fillStyle = "black";
			ctx.fillRect(0, 0, width, frameThickness);
			ctx.fillRect(0, height - frameThickness, width, frameThickness);
			textTop = document.querySelector("#top-text").value;
			textBottom = document.querySelector("#bottom-text").value;
			ctx.textBaseline = "top";
			ctx.fillStyle = fillStyle;
			ctx.strokeText(textTop, xOfText, yOffset);
			ctx.fillText(textTop, xOfText, yOffset);
			ctx.textBaseline = "bottom";
			ctx.strokeText(textBottom, xOfText, height - yOffset);
			ctx.fillText(textBottom, xOfText, height - yOffset);
			break;
		case "2":
			ctx.fillStyle = "black";
			ctx.fillRect(0, 0, width, frameThickness);
			textTop = document.querySelector("#top-text").value;
			ctx.textBaseline = "top";
			ctx.fillStyle = fillStyle;
			ctx.strokeText(textTop, xOfText, yOffset);
			ctx.fillText(textTop, xOfText, yOffset);
			break;
		case "3":
			ctx.fillStyle = "black";
			ctx.fillRect(0, height - frameThickness, width, frameThickness);
			textBottom = document.querySelector("#bottom-text").value;
			ctx.fillStyle = fillStyle;
			ctx.textBaseline = "bottom";
			ctx.strokeText(textBottom, xOfText, height - yOffset);
			ctx.fillText(textBottom, xOfText, height - yOffset);
			break;
		case "4":
			ctx.fillStyle = "white";
			ctx.fillRect(0, 0, width, frameThickness);
			ctx.fillRect(0, height - frameThickness, width, frameThickness);
			textTop = document.querySelector("#top-text").value;
			textBottom = document.querySelector("#bottom-text").value;
			ctx.textBaseline = "top";
			ctx.fillStyle = fillStyle;
			ctx.strokeText(textTop, xOfText, yOffset);
			ctx.fillText(textTop, xOfText, yOffset);
			ctx.textBaseline = "bottom";
			ctx.strokeText(textBottom, xOfText, height - yOffset);
			ctx.fillText(textBottom, xOfText, height - yOffset);
			break;
		case "5":
			ctx.fillStyle = "white";
			ctx.fillRect(0, 0, width, frameThickness);
			textTop = document.querySelector("#top-text").value;
			ctx.textBaseline = "top";
			ctx.fillStyle = fillStyle;
			ctx.strokeText(textTop, xOfText, yOffset);
			ctx.fillText(textTop, xOfText, yOffset);
			break;
		case "6":
			ctx.fillStyle = "white";
			ctx.fillRect(0, height - frameThickness, width, frameThickness);
			textBottom = document.querySelector("#bottom-text").value;
			ctx.fillStyle = fillStyle;
			ctx.textBaseline = "bottom";
			ctx.strokeText(textBottom, xOfText, height - yOffset);
			ctx.fillText(textBottom, xOfText, height - yOffset);
			break;
		case "7":
			textTop = document.querySelector("#top-text").value;
			textBottom = document.querySelector("#bottom-text").value;
			ctx.textBaseline = "top";
			ctx.fillStyle = fillStyle;
			ctx.strokeText(textTop, xOfText, yOffset);
			ctx.fillText(textTop, xOfText, yOffset);
			ctx.textBaseline = "bottom";
			ctx.strokeText(textBottom, xOfText, height - yOffset);
			ctx.fillText(textBottom, xOfText, height - yOffset);
			break;
		case "8":
			textTop = document.querySelector("#top-text").value;
			ctx.textBaseline = "top";
			ctx.fillStyle = fillStyle;
			ctx.strokeText(textTop, xOfText, yOffset);
			ctx.fillText(textTop, xOfText, yOffset);
			break;
		case "9":
			textBottom = document.querySelector("#bottom-text").value;
			ctx.textBaseline = "bottom";
			ctx.fillStyle = fillStyle;
			ctx.strokeText(textBottom, xOfText, height - yOffset);
			ctx.fillText(textBottom, xOfText, height - yOffset);
			break;
	}
};

const downloadMem = () => {
	downloadMemBtn.download = `meme${numberOfMem}.png`;
	downloadMemBtn.href = canvas.toDataURL();
	numberOfMem++;
};

const toggleShowChangeTemaplateSec = () => {
	if (!changeTemplateSect.classList.contains("show")) {
		const allTempaltes = changeTemplateSect.querySelectorAll(
			".change-template__item"
		);
		allTempaltes.forEach((el) => {
			if (el.dataset.typeTemplate == selectedElement) {
				el.classList.add("current-template");
			} else {
				el.classList.remove("current-template");
			}
		});
	}
	changeTemplateSect.classList.toggle("show");
};
allTemaplateItems.forEach((el) => {
	el.addEventListener("click", chooseCurrentTemaplte);
});
backToSelectTemplateSeciontBtn.addEventListener("click", changeShowElement);

loadFileBtn.addEventListener("change", function () {
	useYourPhoto = true;
	showCreateMem(this);
});
createMemBackBtn.addEventListener("click", function () {
	showCreateMem();
	useYourPhoto = false;
	canvas.style.display = "none";
	currentlyCreatedMem.classList.remove("active");
});
allStandardImage.forEach((el) => {
	el.addEventListener("click", showCreateMem);
});

downloadMemBtn.addEventListener("click", downloadMem);
textAlignBtns.forEach((el) => {
	el.addEventListener("click", function () {
		textAlignBtns.forEach((el) => {
			el.classList.remove("active-value");
		});
		el.classList.add("active-value");
		genereteMem(imageWidth, imageHeight);
	});
});
document.querySelectorAll(".create-mem__input").forEach((el) => {
	el.addEventListener("input", function () {
		genereteMem(imageWidth, imageHeight);
	});
});
fontStyleBtns.forEach((el) => {
	el.addEventListener("click", function () {
		fontStyleBtns.forEach((el) => {
			el.classList.remove("active-value");
		});
		el.classList.add("active-value");
		genereteMem(imageWidth, imageHeight);
	});
});
[closeChangeTemplateSectBtn, changeTemplateBtn].forEach((el) => {
	el.addEventListener("click", toggleShowChangeTemaplateSec);
});
changeTemplateSect.querySelectorAll(".change-template__item").forEach((el) => {
	el.addEventListener("click", function () {
		selectedElement = el.dataset.typeTemplate;
		changeTemplateSect.classList.toggle("show");
		genereteMem(imageWidth, imageHeight);
	});
});
