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
				$results = array(0,0,0,0,0);
				$results = getStatistic($id_user,$conn);
				$resultsMeme = getMemes($id_user,$conn);
				$top_memes = $resultsMeme['top_memes'];
				$last_memes = $resultsMeme['last_memes'];
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
						class="feather-file-text">
						<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z">
						</path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
						Pulpit
				</div>
				<a href="index.php" class="button"> Strona Główna</a>
			</div>
			<div class="content">
				<div class="container">
					<div class="title">
						Podsumowanie
					</div>
					<div class="stats">
						<div class = "area">
							Dodane memy: <span> <?php echo $results[0];?> </span>
						</div>
						<div class = "area">
							Polubione memy: <span> <?php echo  $results[3];?> </span>
						</div>
						<div class = "area">
							Dodane komentarze: <span> <?php echo  $results[1];?> </span>
						</div>
						<div class = "area">
							Dodane zgłoszenia: <span> <?php echo  $results[2];?> </span>
						</div>
						<div class = "area">
							Zebrane polubienia: <span> <?php if(isset($results)){echo  0;}else {echo  $results[4];}?> </span>
						</div>
					</div>
				</div>
				<div class="container">
				<?php if(empty($top_memes)){ 
				
					echo '<div class="title">Nie dodałeś jeszcze żadnego mema</div>';
				}
					else {
				?>
					<div class="title">
						Twoje najlepsze memy
					</div>
					<div class="table">
						<table>
							<tr>
								<th>ID</th>
								<th>Mem</th>
								<th>Polubienia</th>
								<th>Komentarze</th>
								<th>Data dodania</th>
							</tr>
							<?php foreach ($top_memes as $meme) : ?>
							<tr>
								<td><?php echo $meme['id_meme']; ?></td>
								<td><img src="<?php echo 'mem2.jpg'; ?>" alt="Meme"></td>
								<td><?php if($meme['like_count']>0)echo $meme['like_count']; else echo 0; ?></td>
								<td><?php echo $meme['comment_count']; ?></td>
								<td><?php echo $meme['adding_date']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
				<div class="container">
					<div class="title">
						Twoje ostatnie memy
					</div>
					<div class="table">
						<table>
							<tr>
								<th>ID</th>
								<th>Mem</th>
								<th>Polubienia</th>
								<th>Komentarze</th>
								<th>Data dodania</th>
							</tr>
							<?php foreach ($last_memes as $meme) : ?>
							<tr>
								<td><?php echo $meme['id_meme']; ?></td>
								<td><img src="<?php echo 'mem2.jpg'; ?>" alt="Meme"></td>
								<td><?php if($meme['like_count']>0)echo $meme['like_count']; else echo 0; ?></td>
								<td><?php echo $meme['comment_count']; ?></td>
								<td><?php echo $meme['adding_date']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
				</div>
					<?php }?>
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