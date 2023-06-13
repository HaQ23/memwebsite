<?php
	session_start()
?>
<!DOCTYPE HTML>

<html lang="pl">

	<head>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>MemHub</title>
		<link rel="preconnect" href="https://fonts.googleapis.com" />
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
		<link
			href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap"
			rel="stylesheet"
		/>
		<link rel="stylesheet" type="text/css" href="css/userPanel.css">
	</head>

	<body>
		<?php
			if(!isset($_SESSION['userid'])) {
				header("Location: ./index.php");
				exit();
			} else {
				require_once './backend/database/database.php';
				$id_user = $_SESSION['userid'];
				include 'backend/userpanel/userPanelFunctions.php';
				$results = getReports($id_user,$conn);
				$comment_reports = $results['comment_reports'];
				$meme_reports = $results['meme_reports'];
			}
			include('html/sidebar.html'); 
		?>
		<div id="myModal" class="modal">
			<span class="close">&times;</span>
			<img class="modal-content" id="img01">
			<div id="caption"></div>
		</div>
		<main class="main">
			<div class="header">
				<div class="title">
						<svg xmlns="http://www.w3.org/2000/svg"
							width="30"
							height="30"
							viewBox="0 0 24 24"
							fill="none"
							stroke="currentColor"
							stroke-width="2" 
							stroke-linecap="round" 
							stroke-linejoin="round" 
							class="feather feather-file-text">
						<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
						</path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
						Zgłoszenia
				</div>
				<a href="index.php" class="button">Strona Główna</a>
			</div>
			<div class="content">
				<div class="container">
				<?php if(empty($meme_reports)){ 
				
					echo '<div class="title">Nie zgłosiłeś jeszcze żadnego mema</div>';
				}
					else {
				?>
					<div class="title">
						Twoje ostatnie zgłoszenia memów
					</div>
					<div class="table">
						<table>
							<tr>
								<th>ID mema</th>
								<th>Mem</th>
								<th>Tresc zgloszenia</th>
							</tr>
							<?php foreach ($meme_reports as $report) : ?>
							<tr>
								<td><?php echo $report['id_meme']; ?></td>
								<td><img src="<?php echo 'mem2.jpg'; ?>" alt="Meme"></td>
								<td><?php echo $report['body']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
					<?php } ?>
				</div>
				<div class="container">
				<?php if(empty($comment_reports)){ 
				
					echo '<div class="title">Nie zgłosiłeś jeszcze żadnego komentarza</div>';
				}
					else {
				?>
					<div class="title">
						Twoje ostatnie zgłoszenia komentarzy
					</div>
					<div class="table">
						<table>
							<tr>
								<th>ID komentarza</th>
								<th>Tresc komentarza</th>
								<th>Tresc zgloszenia</th>
							</tr>
							<?php foreach ($comment_reports as $report) : ?>
							<tr>
								<td><?php echo $report['id_comment']; ?></td>
								<td><?php echo $report['body']; ?></td>
								<td><?php echo $report['tresc']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
					<?php } ?>
				</div>
			</div>
		</main>
	</body>
<script>
	var modal = document.getElementById('myModal');
	var images = document.getElementsByClassName('myImages');
	var modalImg = document.getElementById("img01");
	var captionText = document.getElementById("caption");

	for (var i = 0; i < images.length; i++) {
		var img = images[i];
		img.onclick = function(evt) {
			modal.style.display = "block";
			modalImg.src = this.src;
			captionText.innerHTML = this.alt;
		}
	}

	var span = document.getElementsByClassName("close")[0];

	span.onclick = function() {
	modal.style.display = "none";
	}
</script>
</html>
		