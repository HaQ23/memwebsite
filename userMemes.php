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
				$resultsMeme = getUserMemes($id_user,$conn);
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
						class="feather feather-image">
						<rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
						<circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
						Memy
				</div>
				<a href="index.php" class="button"> Strona Główna</a>
			</div>
			<div class="content">
				<div class="container">
				<?php if(empty($resultsMeme)){ 
				
					echo '<div class="title">Nie dodałeś jeszcze żadnego mema</div>';
				}
					else {
				?>
					<div class="title">
						Twoje memy
					</div>
					<div class="table">
						<table>
							<tr>
								<th>ID</th>
								<th>Mem</th>
								<th>Polubienia</th>
								<th>Komentarze</th>
								<th>Data dodania</th>
								<th>Usun mema</th>
							</tr>
							<?php foreach ($resultsMeme as $meme) : ?>
							<tr>
								<td><?php echo $meme['id_meme']; ?></td>
								<td><img class="myImages" id="myImg" src="<?php echo $meme['imgsource']; ?>" alt="Meme"/></td>
								<td><?php if($meme['like_count']>0){echo $meme['like_count'];} else {echo 0;} ?></td>
								<td><?php echo $meme['comment_count']; ?></td>
								<td><?php echo $meme['adding_date']; ?></td>
								<td>
									<form  method="post"> 
										<input type="hidden" name="id_meme" value="<?php echo $meme['id_meme']; ?>">
										<button type="submit" name="delete_button">Usuń</button> 
									</form>
									<?php
									require_once 'backend/database/database.php';
									if(isset($_POST['delete_button'])){
										$id_meme = $_POST['id_meme'];
										deleteMeme($id_meme,$conn);?>
										<script>
											function refreshPage() {
											location.reload();
											}
										</script><?php
									}
									?>
								</td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>
					<?php }?>
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
		