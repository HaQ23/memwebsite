/**
 * @module ContactJS - Skrypt zarządzający Formularzem Kontaktowy
 */

/**
 * Funkcja usuwa wszystkie błędy z formularza.
 * @param {HTMLFormElement} form - Formularz, z którego należy usunąć błędy.
 */
const deleteErrors = form => {
	const allErrors = form.querySelectorAll(".wrong");
	if (allErrors) {
		allErrors.forEach(el => {
			el.classList.remove("wrong");
		});
	}
};

/**
 * Pobranie formularza kontaktowego.
 */
const contactForm = document.querySelector(".contact-form");

/**
 * Funkcja sprawdza poprawność adresu e-mail.
 * @param {string} email - Adres e-mail, który ma zostać sprawdzony.
 * @returns {Array|null} - Zwraca dopasowany wzorzec lub null w przypadku braku dopasowania.
 */
const validateEmail = email => {
	return String(email)
		.toLowerCase()
		.match(
			/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
		);
};

/**
 * Funkcja czyści zawartość formularza.
 * @param {HTMLFormElement} form - Formularz, który ma zostać wyczyszczony.
 */
const clearForm = form => {
	const allInp = form.querySelectorAll(".input-text");
	allInp.forEach(item => {
		item.value = "";
	});
};

/**
 * Funkcja sprawdza poprawność formularza.
 * @param {HTMLFormElement} form - Formularz, który ma zostać sprawdzony.
 */
const checkForm = form => {
	form.classList.remove("wrong");
	deleteErrors(form);
	const allImportantInputs = form.querySelectorAll(".input-text");
	const storeEmail = form.querySelector("#contact-mail");
	if (!validateEmail(storeEmail.value)) {
		storeEmail.classList.add("wrong");
	}
	allImportantInputs.forEach(el => {
		if (el.value == "") {
			el.classList.add("wrong");
		}
	});
};

/**
 * Inicjalizacja EmailJS.
 */
(function () {
	emailjs.init("WTM9x0rZh8lu-b1aK");
})();

/**
 * Funkcja wysyła formularz e-mailem.
 * @param {Event} form - Wysłane zdarzenie formularza.
 */
function sendMail(form) {
	const info = form.target.querySelector(".form-info");
	form.preventDefault();
	checkForm(form.target);
	if (form.target.querySelectorAll(".wrong").length === 0) {
		emailjs
			.sendForm(
				"service_26knk99",
				"template_69r7rxd",
				"#contact-form",
				"WTM9x0rZh8lu-b1aK"
			)
			.then(
				() => {
					form.target.classList.add("success-send");
					info.textContent = "Wiadomość wysłana poprawnie";
					setTimeout(() => {
						form.target.classList.remove("success-send");
						info.textContent = "Nieprawidłowe dane!";
					}, 5000);
					alert("Dziękujemy, twoja wiadomość została wysłana");
				},
				error => {
					alert("ops", error);
				}
			);
	} else {
		form.target.classList.add("wrong");
	}
	clearForm(form.target);
}

// Dodajemy nasłuchiwanie na zdarzenie submit dla formularza kontaktowego.
contactForm.addEventListener("submit", sendMail);
