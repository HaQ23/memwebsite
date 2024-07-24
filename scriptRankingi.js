"use strict";

const btnOpenNav = document.querySelector(".open--nav-icon");
const btnCloseNav = document.querySelector(".close--nav-icon");
const navHeader = document.querySelector(".container-header");

const btnUserStats = document.querySelectorAll(".users--ranking-rows");
const btnCloseModal = document.querySelector(".modal-cross");
const modalWindow = document.querySelector(".modal-window");
const overlay = document.querySelector(".overlay");
const userModalNick = document.querySelector(".user--modal-nick");
const userModalDate = document.querySelector(".here-since");
const userModalMeme = document.querySelector(".lmem-num");
const userModalComments = document.querySelector(".lkom-num");

const closeModal = function () {
  modalWindow.classList.add("hidden");
  overlay.classList.add("hidden");
};

//dodaj event listener na każdy wiersz rankingu użytkowników
btnUserStats.forEach((user) =>
  user.addEventListener("click", function () {
    modalWindow.classList.remove("hidden");
    overlay.classList.remove("hidden");
    userModalNick.textContent = user.querySelector(".user-nick").textContent;
    userModalDate.textContent =
      user.querySelector(".user--hidden-data").textContent;
    userModalMeme.textContent =
      user.querySelector(".user--hidden-memy").textContent;
    userModalComments.textContent = user.querySelector(
      ".user--hidden-komentarze"
    ).textContent;
  })
);

//zamykanie okna modalnego na 3 sposoby
btnCloseModal.addEventListener("click", closeModal);
overlay.addEventListener("click", closeModal);
document.addEventListener("keydown", function (e) {
  if (e.key === "Escape" && !modalWindow.classList.contains("hidden")) {
    closeModal();
  }
});

btnOpenNav.addEventListener("click", function () {
  navHeader.classList.add("nav-open");
});

btnCloseNav.addEventListener("click", function () {
  navHeader.classList.remove("nav-open");
});
