/**
 * @module generateMemJS - Skrypt zarządzający generatorem memów
 */

/**
 * Pobranie wszystkich elementów o klasie "select-temaplate__carousel-item".
 * @type {NodeList}
 */
const allTemaplateItems = document.querySelectorAll(".select-temaplate__carousel-item ");

/**
 * Pobranie elementu o klasie "select-temaplate".
 * @type {Element}
 */
const selectTemplateSection = document.querySelector(".select-temaplate");

/**
 * Pobranie elementu o klasie "set-image".
 * @type {Element}
 */
const setImageSection = document.querySelector(".set-image");

/**
 * Pobranie elementu o klasie "set-image__back".
 * @type {Element}
 */
const backToSelectTemplateSeciontBtn = document.querySelector(".set-image__back");

/**
 * Pobranie elementu o klasie "create-mem".
 * @type {Element}
 */
const createMemSection = document.querySelector(".create-mem");

/**
 * Pobranie elementu o klasie "add-file".
 * @type {Element}
 */
const loadFileBtn = document.querySelector(".add-file");

/**
 * Pobranie elementu o klasie "back" wewnątrz createMemSection.
 * @type {Element}
 */
const createMemBackBtn = createMemSection.querySelector(".back");

/**
 * Pobranie elementu o klasie "create-mem__img-box" wewnątrz createMemSection.
 * @type {Element}
 */
const currentlyCreatedMem = createMemSection.querySelector(".create-mem__img-box");

/**
 * Pobranie wszystkich elementów o klasie "standard-theme__item".
 * @type {NodeList}
 */
const allStandardImage = document.querySelectorAll(".standard-theme__item");

/**
 * Pobranie elementu o klasie "download-mem".
 * @type {Element}
 */
const downloadMemBtn = document.querySelector(".download-mem");

/**
 * Pobranie elementu o klasie "create-mem__mem-box".
 * @type {Element}
 */
const createMemBox = document.querySelector(".create-mem__mem-box");

/**
 * Pobranie elementu o id "canvas-mem".
 * @type {Element}
 */
const canvas = document.querySelector("#canvas-mem");

/**
 * Pobranie wszystkich elementów pasujących do selektora "[data-text-align]".
 * @type {NodeList}
 */
const textAlignBtns = document.querySelectorAll("[data-text-align]");

/**
 * Pobranie wszystkich elementów o klasie "font-style-btn".
 * @type {NodeList}
 */
const fontStyleBtns = document.querySelectorAll(".font-style-btn");

/**
 * Pobranie elementu o klasie "create-mem__change-template".
 * @type {Element}
 */
const changeTemplateBtn = document.querySelector(".create-mem__change-template");

/**
 * Pobranie elementu o klasie "change-template".
 * @type {Element}
 */
const changeTemplateSect = document.querySelector(".change-template");

/**
 * Pobranie elementu o klasie "close-btn" wewnątrz changeTemplateSect.
 * @type {Element}
 */
const closeChangeTemplateSectBtn = changeTemplateSect.querySelector(".close-btn");

/**
 * Zmienna przechowująca wybrany element.
 * @type {string}
 */
let selectedElement;

/**
 * Flaga informująca, czy używane jest własne zdjęcie.
 * @type {boolean}
 */
let useYourPhoto = false;

/**
 * Obrazek.
 * @type {HTMLImageElement}
 */
let image;

/**
 * Szerokość obrazka.
 * @type {number}
 */
let imageWidth;

/**
 * Wysokość obrazka.
 * @type {number}
 */
let imageHeight;

/**
 * Numer mema.
 * @type {number}
 */
let numberOfMem = 1;

/**
 * Funkcja zmieniająca wyświetlane elementy.
 * @returns {void}
 */
const changeShowElement = () => {
  setImageSection.classList.toggle("show");
  selectTemplateSection.classList.toggle("show");
};

/**
 * Funkcja wywoływana po wyborze aktualnego szablonu.
 * @param {Event} el - Event wywołujący funkcję.
 * @returns {void}
 */
const chooseCurrentTemaplte = (el) => {
  selectedElement = el.target.dataset.typeTemplate;
  const selectedTemplateImg = document.querySelector(".selected-temaplate img");
  selectedTemplateImg.setAttribute(
    "src",
    `./dist/assets/images/meme-demo-template-${selectedElement}.webp`
  );
  changeShowElement();
};

/**
 * Funkcja wyświetlająca sekcję tworzenia mema.
 * @param {Event} el - Event wywołujący funkcję.
 * @returns {void}
 */
const showCreateMem = (el) => {
  if (!createMemSection.classList.contains("show")) {
    setWidthAndHeightMem(el);
  }
  document.querySelector("body").classList.toggle("no-scroll");
  createMemSection.classList.toggle("show");
  useYourPhoto = false;
};

/**
 * Funkcja ustawiająca szerokość i wysokość mema.
 * @param {Event} el - Event wywołujący funkcję.
 * @returns {void}
 */
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

/**
 * Funkcja generująca mem.
 * @param {number} width - Szerokość mema.
 * @param {number} height - Wysokość mema.
 * @returns {void}
 */
const genereteMem = (width, height) => {
  const ctx = canvas.getContext("2d");
  const yOffset = 3;
  const textalign = document.querySelector("[data-text-align].active-value").dataset.textAlign;

  let fontSize = document.querySelector("#font-size").value;
  const strokeStyle = document.querySelector("#input-stroke-style").value;
  const fillStyle = document.querySelector("#input-color-text").value;
  const fontStyle = document.querySelector(".font-style-btn.active-value").dataset.fontStyle;
  const fontFamilly = document.querySelector("#select-font").value;
  const frameThickness = 80;
  let xOfText, textTop = "", textBottom = "";
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
  }
};

/**
 * Funkcja pobierająca dane mema i przekierowująca do pobrania.
 * @returns {void}
 */
const downloadMem = () => {
  const link = document.createElement("a");
  link.setAttribute("download", `meme-${numberOfMem}.png`);
  link.setAttribute("href", canvas.toDataURL("image/png").replace("image/png", "image/octet-stream"));
  link.click();
  numberOfMem++;
};

/**
 * Funkcja obsługująca zmianę wybranego elementu.
 * @param {Event} el - Event wywołujący funkcję.
 * @returns {void}
 */
const changeSelectedElement = (el) => {
  selectedElement = el.target.dataset.typeTemplate;
};

/**
 * Funkcja obsługująca zmianę wybranego justowania tekstu.
 * @param {Event} el - Event wywołujący funkcję.
 * @returns {void}
 */
const changeTextAlign = (el) => {
  const currentTextAlign = document.querySelector("[data-text-align].active-value");
  currentTextAlign.classList.remove("active-value");
  el.target.classList.add("active-value");
};

/**
 * Funkcja obsługująca zmianę wybranego stylu czcionki.
 * @param {Event} el - Event wywołujący funkcję.
 * @returns {void}
 */
const changeFontStyle = (el) => {
  const currentFontStyle = document.querySelector(".font-style-btn.active-value");
  currentFontStyle.classList.remove("active-value");
  el.target.classList.add("active-value");
};

/**
 * Funkcja obsługująca zmianę zdjęcia w sekcji ustawiania obrazka.
 * @param {Event} el - Event wywołujący funkcję.
 * @returns {void}
 */
const changeImage = (el) => {
  const imageDataUrl = el.target.src;
  image = new Image();
  image.src = imageDataUrl;
  currentlyCreatedMem.innerHTML = "";
  image.classList.add("create-mem__img");
  currentlyCreatedMem.appendChild(image);
  image = currentlyCreatedMem.querySelector("img");
  image.onload = function () {
    imageWidth = image.clientWidth;
    imageHeight = image.clientHeight;
    currentlyCreatedMem.classList.add("active");
    canvas.style.display = "block";
    genereteMem(imageWidth, imageHeight);
  };
};

/**
 * Funkcja obsługująca powrót do sekcji wyboru szablonu.
 * @returns {void}
 */
const backToSelectTemplate = () => {
  document.querySelector("body").classList.toggle("no-scroll");
  createMemSection.classList.toggle("show");
  setImageSection.classList.toggle("show");
  canvas.style.display = "none";
};

/**
 * Funkcja obsługująca otwarcie sekcji zmiany szablonu.
 * @returns {void}
 */
const openChangeTemplateSection = () => {
  changeTemplateSect.classList.add("show");
};

/**
 * Funkcja obsługująca zamknięcie sekcji zmiany szablonu.
 * @returns {void}
 */
const closeChangeTemplateSection = () => {
  changeTemplateSect.classList.remove("show");
};

/**
 * Funkcja obsługująca zmianę aktualnego szablonu.
 * @param {Event} el - Event wywołujący funkcję.
 * @returns {void}
 */
const changeTemplate = (el) => {
  const selectedTemplateImg = document.querySelector(".selected-temaplate img");
  selectedTemplateImg.setAttribute("src", el.target.src);
  selectedElement = el.target.dataset.typeTemplate;
  genereteMem(imageWidth, imageHeight);
  closeChangeTemplateSection();
};

/**
 * Funkcja obsługująca dodanie własnego obrazka.
 * @param {Event} el - Event wywołujący funkcję.
 * @returns {void}
 */
const addOwnImage = (el) => {
  const imageDataUrl = URL.createObjectURL(el.target.files[0]);
  image = new Image();
  image.src = imageDataUrl;
  currentlyCreatedMem.innerHTML = "";
  image.classList.add("create-mem__img");
  currentlyCreatedMem.appendChild(image);
  image = currentlyCreatedMem.querySelector("img");
  image.onload = function () {
    imageWidth = image.clientWidth;
    imageHeight = image.clientHeight;
    currentlyCreatedMem.classList.add("active");
    canvas.style.display = "block";
    genereteMem(imageWidth, imageHeight);
  };
  useYourPhoto = true;
};

// Event listeners

useYourPhotoBtn.addEventListener("click", showCreateMem);
loadFileBtn.addEventListener("change", addOwnImage);
downloadBtn.addEventListener("click", downloadMem);
changeTemplateBtn.addEventListener("click", openChangeTemplateSection);
closeChangeTemplateBtn.addEventListener("click", closeChangeTemplateSection);
changeTemplateImages.forEach((el) =>
  el.addEventListener("click", changeTemplate)
);
closeCanvasBtn.addEventListener("click", backToSelectTemplate);
openCanvasBtn.addEventListener("click", changeShowElement);
backBtn.addEventListener("click", changeShowElement);
