<?php 
    //top30 memow
    $qTopMemes = 'SELECT m.id_meme, m.imgsource, COUNT(CASE WHEN mr.rating = 0 THEN 1 END) AS liczba_dislike, COUNT(CASE WHEN mr.rating = 1 THEN 1 END) AS liczba_like, COUNT(CASE WHEN mr.rating = 1 THEN 1 END) - COUNT(CASE WHEN mr.rating = 0 THEN 1 END) AS roznica FROM meme m LEFT JOIN meme_rating mr ON m.id_meme = mr.id_meme GROUP BY m.id_meme, m.imgsource ORDER BY roznica DESC LIMIT 30;';

    //mem miesiąca
    $qBestMemeMonth = 'SELECT m.id_meme, m.imgsource,
        COUNT(CASE WHEN mr.rating = 0 THEN 1 END) AS liczba_dislike,
        COUNT(CASE WHEN mr.rating = 1 THEN 1 END) AS liczba_like,
        COUNT(CASE WHEN mr.rating = 1 THEN 1 END) - COUNT(CASE WHEN mr.rating = 0 THEN 1 END) AS roznica
        FROM meme m
        JOIN meme_rating mr ON m.id_meme = mr.id_meme
        WHERE m.adding_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)
        GROUP BY m.id_meme, m.imgsource
        ORDER BY roznica DESC;
    ';

    //Złapanie mema miesiąca
    $result = mysqli_query($conn, $qBestMemeMonth);
    $bestMemeMonth = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    //złapanie topki 30 memów
    $result = mysqli_query($conn, $qTopMemes);
    $topMemes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    function printBestMemSource(){
        //wypisanie najlepszego mema z ostatniego miesiąca
        global $bestMemeMonth;
        echo $bestMemeMonth[0]['imgsource'];
    }

    function printWorstMemSource(){
        //funkcja odwraca tabele najlepszych memów w ciągu miesiąca, i wypisuje najgorszy z nich
        global $bestMemeMonth;
        echo array_reverse($bestMemeMonth)[0]['imgsource'];
    }

    function printTopMemes(){
        $index = 1;
        global $topMemes;
        foreach($topMemes as $mem){
            echo '
            <div class="grid meme-row">
            <div class="meme--ranking-place">'. $index++ .'</div>
              <div class="meme-ranking">
                <img
                  class="meme--ranking-img"
                  src="'. $mem['imgsource'] .'"
                  alt="zdjęcie mema"
                />
              </div>
            </div>';
        }
    }
?>