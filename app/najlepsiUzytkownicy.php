<?php 

    $qBestUsers = 'SELECT
        account.creation_date AS data_dolaczenia, IFNULL(meme_count,0) AS liczba_memow, IFNULL(comment_count, 0) AS liczba_komentarzy, account.id_user,account.nick,
        (COALESCE(meme_count, 0) * 5) AS waga_memow,
        (COALESCE(comment_count, 0) * 2) AS waga_komentarzy,
        (COALESCE(rating_count, 0) * 10) AS waga_ocen,
        (COALESCE(meme_count, 0) * 5) + (COALESCE(comment_count, 0) * 2) + (COALESCE(rating_count, 0) * 10) AS suma_wag
        FROM account
        LEFT JOIN (
        SELECT id_user, COUNT(id_meme) AS meme_count
        FROM meme
        GROUP BY id_user
        ) AS memy ON account.id_user = memy.id_user
        LEFT JOIN (
        SELECT id_user, COUNT(id_comment) AS comment_count
        FROM comment
        GROUP BY id_user
        ) AS komentarze ON account.id_user = komentarze.id_user
        LEFT JOIN (
        SELECT meme.id_user, COUNT(meme_rating.id_meme) AS rating_count
        FROM meme
        LEFT JOIN meme_rating ON meme.id_meme = meme_rating.id_meme
        WHERE meme_rating.rating = 1
        GROUP BY meme.id_user
        ) AS oceny ON account.id_user = oceny.id_user ORDER by suma_wag DESC;';

    $index = 1;

    $result = mysqli_query($conn, $qBestUsers);
    $bestUsers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    foreach($bestUsers as $user){
        echo '
        <div class="grid users--ranking-rows">
            <div class="user-place">'. $index++ .'</div>
            <div class="user-nick">'. $user['nick'] .'</div>
            <div class="user-points">'. $user['suma_wag'] .' pkt</div>
            <div class="user--hidden-data hidden">'. $user['data_dolaczenia'] .'</div>
            <div class="user--hidden-memy hidden">'. $user['liczba_memow'] .'</div>
            <div class="user--hidden-komentarze hidden">'. $user['liczba_komentarzy'] .'</div>
        </div>';
    }

?>