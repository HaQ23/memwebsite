const uploadCloseButton = document.querySelector(".upload-close");
const uploadOverlay = document.querySelector(".upload-overlay");
const uploadBox = document.querySelector(".upload-box");
const uploadButtonNavbar = document.querySelectorAll(".upload-button-navbar");
const uploadButtonSubmit = document.querySelector(".upload-submit");
const uploadProgress = document.querySelector(".upload-progress");
const uploadStatusBox = document.querySelector(".upload-status");
const uploadStatusText = document.querySelector(".upload-status-text");
const uploadStatusDesc = document.querySelector(".upload-status-desc");
const uploadStatusButton = document.querySelector(".upload-status-button");

const handleUploadBox = () => {
	document.body.classList.toggle("no-scroll");
	uploadOverlay.classList.toggle("upload-overlay--active");
};
const restoreUploadBox = () => {
	uploadBox.classList.remove("upload-box--hidden");
	uploadStatusBox.classList.add("upload-status--hidden");
	uploadStatusButton.classList.remove("upload-status-button--active");
	uploadStatusDesc.classList.remove("upload-status-desc--active");
	uploadProgress.classList.remove("upload-progress--hidden");
	uploadStatusText.innerHTML = "Przesyłanie pliku...";
	handleUploadBox();
};

const uploadFile = e => {
	e.preventDefault();

	const fileInput = document.getElementById("upload-file-input");
	const file = fileInput.files[0];

	if (file) {
		uploadBox.classList.add("upload-box--hidden");
		uploadStatusBox.classList.remove("upload-status--hidden");
		const formData = new FormData();
		formData.append("upload-file-input", file);

		const xhr = new XMLHttpRequest();

		xhr.open("POST", "../memwebsite/backend/upload/upload-main.php", true);

		xhr.upload.onprogress = function (event) {
			if (event.lengthComputable) {
				let percentComplete = (event.loaded / event.total) * 100;
				uploadProgress.value = percentComplete.toFixed(2);
			}
		};

		xhr.onload = function () {
			if (xhr.status === 200) {
				const response = JSON.parse(xhr.responseText);
				if (response.success) {
					uploadStatusText.innerHTML = "Plik został przesłany pomyślnie!";
					uploadStatusButton.classList.toggle("upload-status-button--active");
					uploadStatusDesc.classList.toggle("upload-status-desc--active");
					uploadStatusDesc.innerHTML =
						"Twój nowo dodany mem oczekuje na akceptację przez administratora.";
					uploadProgress.classList.toggle("upload-progress--hidden");
				} else {
					uploadStatusText.innerHTML = "Wystąpił błąd";
					uploadStatusButton.classList.toggle("upload-status-button--active");
					uploadStatusDesc.classList.toggle("upload-status-desc--active");
					uploadStatusDesc.innerHTML = response.message;
					uploadProgress.classList.toggle("upload-progress--hidden");
				}
			} else {
				uploadStatusText.innerHTML = "Wystąpił błąd";
				uploadStatusButton.classList.toggle("upload-status-button--active");
				uploadStatusDesc.classList.toggle("upload-status-desc--active");
				uploadStatusDesc.innerHTML =
					"Postaramy się rozwiązać ten problem możliwie jak najszybciej.";
				uploadProgress.classList.toggle("upload-progress--hidden");
			}
		};

		xhr.onerror = function () {
			console.log("Wystąpił błąd podczas przesyłania pliku.");
		};

		xhr.send(formData);
	}
};

document.addEventListener("DOMContentLoaded", () => {
	uploadCloseButton.addEventListener("click", handleUploadBox);
	uploadButtonNavbar.forEach(btn => btn.addEventListener("click", handleUploadBox));

	uploadButtonSubmit.addEventListener("click", uploadFile);
	uploadStatusButton.addEventListener("click", restoreUploadBox);
});
