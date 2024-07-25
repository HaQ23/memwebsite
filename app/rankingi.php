<?php 
  // $conn = mysqli_connect('localhost', 'admin', 'Cisco2020', 'memhub3');
  // if(!$conn){
  //   echo "SOMETHING WENT WRONG WITH CONNECTION TO DATABASE!";
  // }

  require_once './backend/database/database.php';
  session_start();
  include('ulubieniUzytkownicy.php');
  include('memMiesiaca.php'); 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="stylesheet" href="./dist/css/home.min.css?v=2" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
      rel="stylesheet"
    />
    <link
			rel="stylesheet"
			href="https://unpkg.com/flickity@2/dist/flickity.min.css"
		/>
    <link href="css/styleRankingi.css" rel="stylesheet" />
    <link href="css/generalRankingi.css" rel="stylesheet" />
    <link href="css/mediaRankingi.css" rel="stylesheet" />

    <title>Ranking</title>
  </head>
  <body>
  <nav class="nav">
	<div class="wrapper">
		<a href="index.php" class="logo-name"
			>Mem<span class="other-color">Hub</span></a
		>
		<button class="ham-btn" aria-label="Show menu">
			<div class="ham-btn__box">
				<span class="ham-btn__inner"></span>
			</div>
		</button>
		<div class="nav__items">
			<a href="./index.php" class="nav__item">Strona główna</a>
			<a href="./generator.php" class="nav__item">Generator</a>

			<a href="rankingi.php" class="nav__item">Ranking</a>
			<a href="./queue.php" class="nav__item">Poczekalnia</a>
			<div class="button-box">
				
				<?php
					if(isset($_SESSION['userid'])) {
						echo '<button class="nav__button secondary-btn upload-button-navbar"> Dodaj mema </button>';
						echo '<a href="./dashboard.php" class="nav__button primary-btn"> Panel </a>';
					} else {
						echo '<a href="./signIn.php" class="nav__button primary-btn"> Logowanie </a>';
					}
				?>
			</div>
		</div>
	</div>
</nav>

    <!-- MAIN SECTION -->
    <main>
      <div class="container grid grid--2-cols ranking">
        <h1 class="primary-header header-rankingi">
          Mem<span class="header-hub">Hub</span> - Ranking użytkowników i memów!
        </h1>
        <!-- UŻYTKOWNICY MIESIĄCA -->
        <div class="meme--month-box">
          <h2 class="secondary-header month-header">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="48"
              height="48"
              fill="#eed144"
              viewBox="0 0 256 256"
            >
              <path
                d="M216,96A88,88,0,1,0,72,163.83V240a8,8,0,0,0,11.58,7.16L128,225l44.43,22.21A8.07,8.07,0,0,0,176,248a8,8,0,0,0,8-8V163.83A87.85,87.85,0,0,0,216,96ZM56,96a72,72,0,1,1,72,72A72.08,72.08,0,0,1,56,96ZM168,227.06l-36.43-18.21a8,8,0,0,0-7.16,0L88,227.06V174.37a87.89,87.89,0,0,0,80,0ZM128,152A56,56,0,1,0,72,96,56.06,56.06,0,0,0,128,152Zm0-96A40,40,0,1,1,88,96,40,40,0,0,1,128,56Z"
              ></path>
            </svg>
            Ulubieni użytkownicy
          </h2>
          <div class="meme-window user-Month">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="96"
              height="96"
              fill="#eed144"
              viewBox="0 0 256 256"
              class="korona-icon"
            >
              <path
                d="M243.84,76.19a12.08,12.08,0,0,0-13.34-1.7l-50.21,25L138.37,29.86a12.11,12.11,0,0,0-20.74,0L75.71,99.52l-50.19-25A12.11,12.11,0,0,0,8.62,89.12l37,113.36a8,8,0,0,0,11.68,4.4C57.55,206.73,83.12,192,128,192s70.45,14.73,70.68,14.87a8,8,0,0,0,11.71-4.39l37-113.33A12.06,12.06,0,0,0,243.84,76.19ZM198,188.83C186,183.74,162.08,176,128,176s-58,7.74-70,12.83L26.71,93l45.07,22.47a12.17,12.17,0,0,0,15.78-4.59L128,43.66l40.44,67.2a12.17,12.17,0,0,0,15.77,4.59L229.29,93Z"
              ></path>
            </svg>
            <p class="user--Month-nick"><?php printNickFav(0); ?></p>
            <div class="user--Month-stats grid">
              <h3 class="third-header stats-header">
                Statystyki<svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  fill="#000111"
                  viewBox="0 0 256 256"
                >
                  <path
                    d="M232,208a8,8,0,0,1-8,8H32a8,8,0,0,1-8-8V48a8,8,0,0,1,16,0V156.69l50.34-50.35a8,8,0,0,1,11.32,0L128,132.69,180.69,80H160a8,8,0,0,1,0-16h40a8,8,0,0,1,8,8v40a8,8,0,0,1-16,0V91.31l-58.34,58.35a8,8,0,0,1-11.32,0L96,123.31l-56,56V200H224A8,8,0,0,1,232,208Z"
                  ></path>
                </svg>
              </h3>
              <div class="stats-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-thumbs-up"
                >
                  <path
                    d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"
                  ></path>
                </svg>
                <span class="stats-text"><?php printLikesFav(0); ?></span>
              </div>
              <div class="stats-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-thumbs-down"
                >
                  <path
                    d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"
                  ></path>
                </svg>
                <span class="stats-text"><?php printDislikesFav(0); ?></span>
              </div>
              <div class="stats-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#000" viewBox="0 0 256 256"><path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,16V158.75l-26.07-26.06a16,16,0,0,0-22.63,0l-20,20-44-44a16,16,0,0,0-22.62,0L40,149.37V56ZM40,172l52-52,80,80H40Zm176,28H194.63l-36-36,20-20L216,181.38V200ZM144,100a12,12,0,1,1,12,12A12,12,0,0,1,144,100Z"></path></svg>
                <span class="stats-text"><?php printFavCountMemes(getIdFav(0)); ?></span>
              </div>
            </div>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="96"
              height="96"
              fill="#737373"
              viewBox="0 0 256 256"
              class="korona-icon"
            >
              <path
                d="M243.84,76.19a12.08,12.08,0,0,0-13.34-1.7l-50.21,25L138.37,29.86a12.11,12.11,0,0,0-20.74,0L75.71,99.52l-50.19-25A12.11,12.11,0,0,0,8.62,89.12l37,113.36a8,8,0,0,0,11.68,4.4C57.55,206.73,83.12,192,128,192s70.45,14.73,70.68,14.87a8,8,0,0,0,11.71-4.39l37-113.33A12.06,12.06,0,0,0,243.84,76.19ZM198,188.83C186,183.74,162.08,176,128,176s-58,7.74-70,12.83L26.71,93l45.07,22.47a12.17,12.17,0,0,0,15.78-4.59L128,43.66l40.44,67.2a12.17,12.17,0,0,0,15.77,4.59L229.29,93Z"
              ></path>
            </svg>
            <p class="user--Month-nick"><?php printNickFav(1); ?></p>
            <div class="user--Month-stats grid">
              <h3 class="third-header stats-header">
                Statystyki<svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  fill="#000111"
                  viewBox="0 0 256 256"
                >
                  <path
                    d="M232,208a8,8,0,0,1-8,8H32a8,8,0,0,1-8-8V48a8,8,0,0,1,16,0V156.69l50.34-50.35a8,8,0,0,1,11.32,0L128,132.69,180.69,80H160a8,8,0,0,1,0-16h40a8,8,0,0,1,8,8v40a8,8,0,0,1-16,0V91.31l-58.34,58.35a8,8,0,0,1-11.32,0L96,123.31l-56,56V200H224A8,8,0,0,1,232,208Z"
                  ></path>
                </svg>
              </h3>
              <div class="stats-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-thumbs-up"
                >
                  <path
                    d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"
                  ></path>
                </svg>
                <span class="stats-text"><?php printLikesFav(1); ?></span>
              </div>
              <div class="stats-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-thumbs-down"
                >
                  <path
                    d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"
                  ></path>
                </svg>
                <span class="stats-text"><?php printDislikesFav(1); ?></span>
              </div>
              <div class="stats-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#000" viewBox="0 0 256 256"><path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,16V158.75l-26.07-26.06a16,16,0,0,0-22.63,0l-20,20-44-44a16,16,0,0,0-22.62,0L40,149.37V56ZM40,172l52-52,80,80H40Zm176,28H194.63l-36-36,20-20L216,181.38V200ZM144,100a12,12,0,1,1,12,12A12,12,0,0,1,144,100Z"></path></svg>
                <span class="stats-text"><?php printFavCountMemes(getIdFav(1)); ?></span>
              </div>
            </div>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="96"
              height="96"
              fill="#854d0e"
              viewBox="0 0 256 256"
              class="korona-icon"
            >
              <path
                d="M243.84,76.19a12.08,12.08,0,0,0-13.34-1.7l-50.21,25L138.37,29.86a12.11,12.11,0,0,0-20.74,0L75.71,99.52l-50.19-25A12.11,12.11,0,0,0,8.62,89.12l37,113.36a8,8,0,0,0,11.68,4.4C57.55,206.73,83.12,192,128,192s70.45,14.73,70.68,14.87a8,8,0,0,0,11.71-4.39l37-113.33A12.06,12.06,0,0,0,243.84,76.19ZM198,188.83C186,183.74,162.08,176,128,176s-58,7.74-70,12.83L26.71,93l45.07,22.47a12.17,12.17,0,0,0,15.78-4.59L128,43.66l40.44,67.2a12.17,12.17,0,0,0,15.77,4.59L229.29,93Z"
              ></path>
            </svg>
            <p class="user--Month-nick"><?php printNickFav(2); ?></p>
            <div class="user--Month-stats grid">
              <h3 class="third-header stats-header">
                Statystyki<svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  fill="#000111"
                  viewBox="0 0 256 256"
                >
                  <path
                    d="M232,208a8,8,0,0,1-8,8H32a8,8,0,0,1-8-8V48a8,8,0,0,1,16,0V156.69l50.34-50.35a8,8,0,0,1,11.32,0L128,132.69,180.69,80H160a8,8,0,0,1,0-16h40a8,8,0,0,1,8,8v40a8,8,0,0,1-16,0V91.31l-58.34,58.35a8,8,0,0,1-11.32,0L96,123.31l-56,56V200H224A8,8,0,0,1,232,208Z"
                  ></path>
                </svg>
              </h3>
              <div class="stats-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-thumbs-up"
                >
                  <path
                    d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"
                  ></path>
                </svg>
                <span class="stats-text"><?php printlikesFav(2); ?></span>
              </div>
              <div class="stats-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-thumbs-down"
                >
                  <path
                    d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"
                  ></path>
                </svg>
                <span class="stats-text"><?php printDislikesFav(2); ?></span>
              </div>
              <div class="stats-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#000" viewBox="0 0 256 256"><path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,16V158.75l-26.07-26.06a16,16,0,0,0-22.63,0l-20,20-44-44a16,16,0,0,0-22.62,0L40,149.37V56ZM40,172l52-52,80,80H40Zm176,28H194.63l-36-36,20-20L216,181.38V200ZM144,100a12,12,0,1,1,12,12A12,12,0,0,1,144,100Z"></path></svg>
                <span class="stats-text"><?php printFavCountMemes(getIdFav(2)); ?></span>
              </div>
            </div>
          </div>
        </div>
        <!-- ŚCIANA WSTYDU UŻYTKOWNIKÓW -->
        <div class="shame--hall-box shame-users">
          <h2 class="secondary-header month-header">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="48"
              height="48"
              fill="#f03e3e"
              viewBox="0 0 256 256"
            >
              <path
                d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216ZM80,108a12,12,0,1,1,12,12A12,12,0,0,1,80,108Zm96,0a12,12,0,1,1-12-12A12,12,0,0,1,176,108Zm-1.08,64a8,8,0,1,1-13.84,8c-7.47-12.91-19.21-20-33.08-20s-25.61,7.1-33.08,20a8,8,0,1,1-13.84-8c10.29-17.79,27.39-28,46.92-28S164.63,154.2,174.92,172Z"
              ></path>
            </svg>
            Ściana wstydu użytkowników
          </h2>
          <div class="worst--user-window user-Month">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="96"
              height="96"
              fill="#f03e3e"
              viewBox="0 0 256 256"
              class="cross"
            >
              <path
                d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"
              ></path>
            </svg>
            <p class="user--Month-nick"><?php printNickDisfav(0); ?></p>
            <div class="user--Month-stats grid">
              <h3 class="third-header stats-header">
                Statystyki<svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  fill="#000111"
                  viewBox="0 0 256 256"
                >
                  <path
                    d="M232,208a8,8,0,0,1-8,8H32a8,8,0,0,1-8-8V48a8,8,0,0,1,16,0V156.69l50.34-50.35a8,8,0,0,1,11.32,0L128,132.69,180.69,80H160a8,8,0,0,1,0-16h40a8,8,0,0,1,8,8v40a8,8,0,0,1-16,0V91.31l-58.34,58.35a8,8,0,0,1-11.32,0L96,123.31l-56,56V200H224A8,8,0,0,1,232,208Z"
                  ></path>
                </svg>
              </h3>
              <div class="stats-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-thumbs-up"
                >
                  <path
                    d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"
                  ></path>
                </svg>
                <span class="stats-text"><?php printLikesDisfav(0); ?></span>
              </div>
              <div class="stats-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-thumbs-down"
                >
                  <path
                    d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"
                  ></path>
                </svg>
                <span class="stats-text"><?php printDislikesDisfav(0) ?></span>
              </div>
              <div class="stats-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#000000" viewBox="0 0 256 256"><path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,16V158.75l-26.07-26.06a16,16,0,0,0-22.63,0l-20,20-44-44a16,16,0,0,0-22.62,0L40,149.37V56ZM40,172l52-52,80,80H40Zm176,28H194.63l-36-36,20-20L216,181.38V200ZM144,100a12,12,0,1,1,12,12A12,12,0,0,1,144,100Z"></path></svg>
                <span class="stats-text"><?php printFavCountMemes(getIdDisfav(0)); ?></span>
              </div>
            </div>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="96"
              height="96"
              fill="#f03e3e"
              viewBox="0 0 256 256"
              class="cross"
            >
              <path
                d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"
              ></path>
            </svg>
            <p class="user--Month-nick"><?php printNickDisfav(1); ?></p>
            <div class="user--Month-stats grid">
              <h3 class="third-header stats-header">
                Statystyki<svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  fill="#000111"
                  viewBox="0 0 256 256"
                >
                  <path
                    d="M232,208a8,8,0,0,1-8,8H32a8,8,0,0,1-8-8V48a8,8,0,0,1,16,0V156.69l50.34-50.35a8,8,0,0,1,11.32,0L128,132.69,180.69,80H160a8,8,0,0,1,0-16h40a8,8,0,0,1,8,8v40a8,8,0,0,1-16,0V91.31l-58.34,58.35a8,8,0,0,1-11.32,0L96,123.31l-56,56V200H224A8,8,0,0,1,232,208Z"
                  ></path>
                </svg>
              </h3>
              <div class="stats-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-thumbs-up"
                >
                  <path
                    d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"
                  ></path>
                </svg>
                <span class="stats-text"><?php printLikesDisfav(1); ?></span>
              </div>
              <div class="stats-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-thumbs-down"
                >
                  <path
                    d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"
                  ></path>
                </svg>
                <span class="stats-text"><?php printDislikesDisfav(1); ?></span>
              </div>
              <div class="stats-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#000000" viewBox="0 0 256 256"><path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,16V158.75l-26.07-26.06a16,16,0,0,0-22.63,0l-20,20-44-44a16,16,0,0,0-22.62,0L40,149.37V56ZM40,172l52-52,80,80H40Zm176,28H194.63l-36-36,20-20L216,181.38V200ZM144,100a12,12,0,1,1,12,12A12,12,0,0,1,144,100Z"></path></svg>
                <span class="stats-text"><?php printFavCountMemes(getIdDisfav(1)); ?></span>
              </div>
            </div>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="96"
              height="96"
              fill="#f03e3e"
              viewBox="0 0 256 256"
              class="cross"
            >
              <path
                d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"
              ></path>
            </svg>
            <p class="user--Month-nick"><?php printNickDisfav(2); ?></p>
            <div class="user--Month-stats grid">
              <h3 class="third-header stats-header">
                Statystyki<svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  fill="#000111"
                  viewBox="0 0 256 256"
                >
                  <path
                    d="M232,208a8,8,0,0,1-8,8H32a8,8,0,0,1-8-8V48a8,8,0,0,1,16,0V156.69l50.34-50.35a8,8,0,0,1,11.32,0L128,132.69,180.69,80H160a8,8,0,0,1,0-16h40a8,8,0,0,1,8,8v40a8,8,0,0,1-16,0V91.31l-58.34,58.35a8,8,0,0,1-11.32,0L96,123.31l-56,56V200H224A8,8,0,0,1,232,208Z"
                  ></path>
                </svg>
              </h3>
              <div class="stats-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-thumbs-up"
                >
                  <path
                    d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"
                  ></path>
                </svg>
                <span class="stats-text"><?php printlikesDisfav(2); ?></span>
              </div>
              <div class="stats-icon">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  class="feather feather-thumbs-down"
                >
                  <path
                    d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"
                  ></path>
                </svg>
                <span class="stats-text"><?php printDislikesDisfav(2); ?></span>
              </div>
              <div class="stats-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#000000" viewBox="0 0 256 256"><path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,16V158.75l-26.07-26.06a16,16,0,0,0-22.63,0l-20,20-44-44a16,16,0,0,0-22.62,0L40,149.37V56ZM40,172l52-52,80,80H40Zm176,28H194.63l-36-36,20-20L216,181.38V200ZM144,100a12,12,0,1,1,12,12A12,12,0,0,1,144,100Z"></path></svg>
                <span class="stats-text"><?php printFavCountMemes(getIdDisfav(2)); ?></span>
              </div>
            </div>
          </div>
        </div>
        <!-- MEM MIESIĄCA -->
        <div class="margin-top meme--month-box meme--month-container">
          <h2 class="secondary-header month-header">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="48"
              height="48"
              fill="#eed144"
              viewBox="0 0 256 256"
            >
              <path
                d="M216,96A88,88,0,1,0,72,163.83V240a8,8,0,0,0,11.58,7.16L128,225l44.43,22.21A8.07,8.07,0,0,0,176,248a8,8,0,0,0,8-8V163.83A87.85,87.85,0,0,0,216,96ZM56,96a72,72,0,1,1,72,72A72.08,72.08,0,0,1,56,96ZM168,227.06l-36.43-18.21a8,8,0,0,0-7.16,0L88,227.06V174.37a87.89,87.89,0,0,0,80,0ZM128,152A56,56,0,1,0,72,96,56.06,56.06,0,0,0,128,152Zm0-96A40,40,0,1,1,88,96,40,40,0,0,1,128,56Z"
              ></path>
            </svg>
            Mem miesiąca
          </h2>
          <div class="meme-window">
            <img class="meme-month" src="<?php printBestMemSource(); ?>" alt="mem miesiąca" />
          </div>
        </div>
        <!-- ŚCIANA WSTYDU MEMÓW -->
        <div class="margin-top shame--hall-box">
          <h2 class="secondary-header month-header">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="48"
              height="48"
              fill="#f03e3e"
              viewBox="0 0 256 256"
            >
              <path
                d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216ZM80,108a12,12,0,1,1,12,12A12,12,0,0,1,80,108Zm96,0a12,12,0,1,1-12-12A12,12,0,0,1,176,108Zm-1.08,64a8,8,0,1,1-13.84,8c-7.47-12.91-19.21-20-33.08-20s-25.61,7.1-33.08,20a8,8,0,1,1-13.84-8c10.29-17.79,27.39-28,46.92-28S164.63,154.2,174.92,172Z"
              ></path>
            </svg>
            Najgorszy mem miesiąca
          </h2>
          <div class="worst--meme-window">
            <img class="worst-meme" src="<?php printWorstMemSource(); ?>" alt="najgorszy mem" />
          </div>
        </div>
        <!-- RANKING MEMÓW -->
        <div class="meme--ranking-box">
          <h2 class="secondary-header month-header">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="48"
              height="48"
              fill="#eed144"
              viewBox="0 0 256 256"
            >
              <path
                d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216ZM80,108a12,12,0,1,1,12,12A12,12,0,0,1,80,108Zm96,0a12,12,0,1,1-12-12A12,12,0,0,1,176,108Zm-1.07,48c-10.29,17.79-27.4,28-46.93,28s-36.63-10.2-46.92-28a8,8,0,1,1,13.84-8c7.47,12.91,19.21,20,33.08,20s25.61-7.1,33.07-20a8,8,0,0,1,13.86,8Z"
              ></path>
            </svg>
            Najlepsze memy
          </h2>
          <div class="meme--ranking-table">
            <?php printTopMemes(); ?>
          </div>
        </div>
        <!-- RANKING NAJLEPSZYCH UŻYTKOWNIKÓW -->
        <div class="users--ranking-box">
          <h2 class="secondary-header month-header">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="48"
              height="48"
              fill="#eed144"
              viewBox="0 0 256 256"
            >
              <path
                d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216ZM80,108a12,12,0,1,1,12,12A12,12,0,0,1,80,108Zm96,0a12,12,0,1,1-12-12A12,12,0,0,1,176,108Zm-1.07,48c-10.29,17.79-27.4,28-46.93,28s-36.63-10.2-46.92-28a8,8,0,1,1,13.84-8c7.47,12.91,19.21,20,33.08,20s25.61-7.1,33.07-20a8,8,0,0,1,13.86,8Z"
              ></path>
            </svg>
            Najlepsi użytkownicy
          </h2>
          <div class="users--ranking-table">
            <?php include('najlepsiUzytkownicy.php'); ?>
          </div>
          <!-- okno modalne -->
          <div class="modal-window hidden">
            <svg class="modal-cross" xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="#ffffff" viewBox="0 0 256 256"><path d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"></path></svg>
            <svg class='user--modal-icon' xmlns="http://www.w3.org/2000/svg" width="56" height="56" fill="#fff" viewBox="0 0 256 256"><path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path></svg>
            <span class="user--modal-nick">nick</span>
            <div class="user--modal-date">
              <span class="modal-date">Na serwisie od: <span class="here-since">2020-02-02</span></span>
            </div>
            <div class="user--modal-stats">
              <span class="user-lmemow">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40Zm0,16V158.75l-26.07-26.06a16,16,0,0,0-22.63,0l-20,20-44-44a16,16,0,0,0-22.62,0L40,149.37V56ZM40,172l52-52,80,80H40Zm176,28H194.63l-36-36,20-20L216,181.38V200ZM144,100a12,12,0,1,1,12,12A12,12,0,0,1,144,100Z"></path></svg><span class="lmem-num">12</span>
              </span>
              <span class="user-lkomentarzy">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M216,48H40A16,16,0,0,0,24,64V224a15.84,15.84,0,0,0,9.25,14.5A16.05,16.05,0,0,0,40,240a15.89,15.89,0,0,0,10.25-3.78.69.69,0,0,0,.13-.11L82.5,208H216a16,16,0,0,0,16-16V64A16,16,0,0,0,216,48ZM40,224h0ZM216,192H82.5a16,16,0,0,0-10.3,3.75l-.12.11L40,224V64H216Z"></path></svg><span class="lkom-num">30</span>
              </span>
            </div>
          </div>
        </div>

        <div class="fill"></div>
      </div>
    </main>
    <!-- STOPKA -->
    <footer class="footer">
	<div class="wrapper">
		<a href="index.php" class="logo-name"
			>Mem<span class="other-color">Hub</span></a
		>
		<div class="footer__items">
			<a href="./contact.php" class="footer__item">Kontakt</a>
			<a href="./regulamin.php" class="footer__item">Regulamin</a>
		</div>
		<div class="footer__social-media">
			<h2 class="section-title">Zaobserwuj nas na:</h2>
			<a
				aria-label="link do facebooka strony memhub"
				href="#"
				class="footer__social-media-link"
				><svg
					class="icon"
					xmlns="http://www.w3.org/2000/svg"
					width="32"
					height="32"
					viewBox="0 0 24 24"
					fill="none"
					stroke="#fff"
					stroke-width="1"
					stroke-linecap="round"
					stroke-linejoin="round"
					class="feather feather-facebook"
				>
					<path
						d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"
					></path></svg
			></a>
			<a
				aria-label="link do instagrama strony memhub"
				href="#"
				class="footer__social-media-link"
				><svg
					class="icon"
					xmlns="http://www.w3.org/2000/svg"
					width="32"
					height="32"
					viewBox="0 0 24 24"
					fill="none"
					stroke="#fff"
					stroke-width="1"
					stroke-linecap="round"
					stroke-linejoin="round"
					class="feather feather-instagram"
				>
					<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
					<path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
					<line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg
			></a>
			
		</div>
		<div class="upload upload-overlay">
			<div class="upload-box">
				<div class="upload-topbar">
					<p class="upload-title">Dodaj mema</p>
					<button class="upload-close"><img src="./dist/assets/icons/close.svg" alt="" /></button>
				</div>
				<form action="./backend/upload/upload-main.php" method="post" class="upload-content" enctype="multipart/form-data">
					<p class="upload-text">
						Wybierz odpowiedni plik aby dodać mema na nasz portal.
					</p>
				
					<div class="upload-file-box">
						<label for="upload-file-input" class="upload-file-label">
							<img src="./dist/assets/icons/upload.svg" class="upload-file-icon" alt="">
							<p class="upload-file-text">Wybierz plik</p>
						</label>
						<input type="file" class="upload-file-input" name="upload-file-input" id="upload-file-input" required>
						<p class="upload-filetype">Obsługiwane formaty: <span class="upload-filetype-highlighted">png, jpg, jpeg</span></p>
						<p class="upload-filetype">Maksymalny rozmiar pliku: <span class="upload-filetype-highlighted">5mb</span></p>
						<p class="upload-text">
							Po dodaniu mema opublikuj go na naszym portalu aby inni,
							mogli go ocenić!
						</p>
					</div>
					<input type="submit" value="Opublikuj" name="upload-submit" class="upload-submit">
					<p class="upload-generatorinfo">Masz pomysł na unikalnego mema który spodoba się każdemu?
						Skorzystaj z naszego <a href="./generator.php" class="upload-generatorinfo-link">generatora</a> i stwórz nowego mema już teraz!</p>
				</form>
			</div>
			<div class="upload-status upload-status--hidden">
				<img src="./dist/assets/icons/publish.webp" alt="">
				<p class="upload-status-text">Przesyłanie pliku...</p>
				<p class="upload-status-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi, voluptate!</p>
				<button class="upload-status-button">Gotowe</button>
				<progress class="upload-progress" max="100" value="0"></progress>
			</div>
		</div>
		<div class="line"></div>
		<p class="copyRigth-text">
			Copyright <span class="currentData">2023</span>. MemHub
		</p>
	</div>
</footer>
    <div class="overlay hidden"></div>
    <div class="alert">
			<p class="alert__text">Zalogowano pomyślnie!</p>
		</div>
	
		<script>
			
		</script>	
		<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
		<script src="./dist/js/carousel.min.js"></script>
		<script src="./dist/js/main.min.js?v=1"></script>
		<script src="./dist/js/generateMem.min.js?v=1"></script>
		<script src="./dist/js/upload.min.js?v=1"></script>	

    <script src="scriptRankingi.js"></script>
  </body>
</html>
