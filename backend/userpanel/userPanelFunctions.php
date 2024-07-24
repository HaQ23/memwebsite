<?php
    /* Funkcja zczytująca z bazy danych 3 ostatnie i najlepsze memy
     */
	function getMemes($idUser, $con)
	{
		$results = array();
		$query_last_memes = "SELECT m.id_meme, m.imgsource, m.adding_date, COUNT(c.id_comment) AS comment_count, SUM(rating) AS like_count
					FROM meme m
					LEFT JOIN comment c ON m.id_meme = c.id_meme
					LEFT JOIN meme_rating r ON m.id_meme = r.id_meme
					WHERE m.id_user = $idUser
					GROUP BY m.id_meme, m.title, m.adding_date
					ORDER BY m.adding_date DESC
					LIMIT 3;";
		$query_top_memes = "SELECT m.id_meme, m.imgsource, m.adding_date, COUNT(c.id_comment) AS comment_count, SUM(rating) AS like_count
					FROM meme m
					LEFT JOIN comment c ON m.id_meme = c.id_meme
					LEFT JOIN meme_rating r ON m.id_meme = r.id_meme
					WHERE m.id_user = $idUser
					GROUP BY m.id_meme, m.title, m.adding_date
					ORDER BY like_count DESC
					LIMIT 3;";
			
		$result_top_memes = mysqli_query($con, $query_top_memes);
		$result_last_memes = mysqli_query($con, $query_last_memes);
		
		$top_memes = array();
		while ($row = mysqli_fetch_assoc($result_top_memes))
		{
			$top_memes[] = $row;
		}
		$last_memes = array();
		while ($row = mysqli_fetch_assoc($result_last_memes))
		{
			$last_memes[] = $row;
		}
		$results['top_memes'] = $top_memes;
		$results['last_memes'] = $last_memes;
		
		return $results;
	}
    /* Funkcja zczytująca zgłoszenia danego użytkownika
     */
    function getReports($idUser,$con)
	{
		$results = array();
		$query_meme_reports = "SELECT mr.id_meme, mr.body, meme.imgsource FROM meme_report mr LEFT JOIN meme ON mr.id_meme = meme.id_meme WHERE mr.id_user = $idUser ORDER BY mr.id_report DESC;";
		$query_comment_reports = "SELECT  comment.id_comment, cr.body, comment.body as tresc FROM comment_report cr LEFT JOIN comment ON cr.id_comment = comment.id_comment WHERE cr.id_user = $idUser ORDER BY cr.id_report DESC;";
		$result_meme_reports = mysqli_query($con, $query_meme_reports);
		$result_comment_reports = mysqli_query($con, $query_comment_reports);
		
		$meme_reports = array();
		while ($row = mysqli_fetch_assoc($result_meme_reports))
		{
			$meme_reports[] = $row;
		}
		$comment_reports = array();
		while ($row = mysqli_fetch_assoc($result_comment_reports))
		{
			$comment_reports[] = $row;
		}
		$results['meme_reports'] = $meme_reports;
		$results['comment_reports'] = $comment_reports;
		
		return $results;
		
	}
    /** Funkcja zczytująca podstawowe statystyki zalogowanego użytkownika
    */
    function getStatistic($idUser,$con)
	{
		$results = array(0,0,0,0,0);
		$sqlstat = array();
		$sqlstat[0] = "SELECT count(meme.id_meme) as wynik FROM meme WHERE meme.id_user=$idUser;";
		$sqlstat[1] = "SELECT count(comment.id_comment) as wynik FROM comment WHERE comment.id_user = $idUser;";
		$sqlstat[2] = "SELECT SUM(liczba) as wynik
						FROM (
							SELECT COUNT(DISTINCT mr.id_report) + COUNT(DISTINCT cr.id_report) AS liczba
							FROM meme_report mr
							LEFT JOIN comment_report cr ON mr.id_user = cr.id_user
							WHERE mr.id_user = $idUser OR cr.id_user = $idUser
						) AS subquery;";
		$sqlstat[3] = "SELECT count(meme_rating.id_meme) as wynik FROM meme_rating WHERE meme_rating.id_user=$idUser;";
		$sqlstat[4] = "SELECT SUM(polubienia) as wynik FROM (SELECT m.id_meme, SUM(r.rating) AS polubienia
						FROM meme m
						LEFT JOIN meme_rating r ON m.id_meme = r.id_meme
						WHERE m.id_user = $idUser
						GROUP BY m.id_meme) as subquery;;";
		
		$i = 0;
		foreach ($sqlstat as $sql)
		{
			$result = $con->query($sql);
			
			if ($result->num_rows > 0) 
			{
				while ($row = $result->fetch_assoc())
				{
					$results[$i] = $row['wynik'];			
				}
			}
			$i = $i + 1;
		
		}
		return $results;
	}
    /* Funkcja zczytująca memy użytkownika 
    */
    function getUserMemes($idUser,$con)
	{
		$query_meme = "SELECT m.id_meme, m.imgsource, m.adding_date, COUNT(c.id_comment) AS comment_count, SUM(rating) AS like_count
					FROM meme m
					LEFT JOIN comment c ON m.id_meme = c.id_meme
					LEFT JOIN meme_rating r ON m.id_meme = r.id_meme
					WHERE m.id_user = $idUser
					GROUP BY m.id_meme, m.title, m.adding_date
					ORDER BY m.adding_date DESC;";
		$result_meme = mysqli_query($con, $query_meme);
		
		$meme = array();
		while ($row = mysqli_fetch_assoc($result_meme))
		{
			$meme[] = $row;
		}

		return $meme;
	}
    function deleteMeme($idMeme,$conn)
	{
		$sql = "DELETE FROM meme WHERE id_meme = $idMeme";
		if ($conn->query($sql) === TRUE) {

		} else {
			echo "Błąd usuwania rekordu: " . $conn->error;
		}

	}
?>