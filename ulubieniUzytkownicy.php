<?php 
    //Ulubieni użytkownicy na podstawie różnicy między like i dislike pod ich memami
    $qFavUsers = 'SELECT a.id_user, a.nick, COUNT(CASE WHEN mr.rating = 1 THEN 1 END) AS liczba_like, COUNT(CASE WHEN mr.rating = 0 THEN 1 END) AS liczba_dislike, COUNT(CASE WHEN mr.rating = 1 THEN 1 END) - COUNT(CASE WHEN mr.rating = 0 THEN 1 END) AS rating_difference FROM account a JOIN meme m ON a.id_user = m.id_user JOIN meme_rating mr ON m.id_meme = mr.id_meme GROUP BY a.id_user, a.nick ORDER BY rating_difference DESC LIMIT 3;';

    //Najgorsi użytkownicy na podstawie różnicy między like i dislike pod ich memami
    $qDisfavUsers = 'SELECT a.id_user, a.nick, COUNT(CASE WHEN mr.rating = 1 THEN 1 END) AS liczba_like, COUNT(CASE WHEN mr.rating = 0 THEN 1 END) AS liczba_dislike, COUNT(CASE WHEN mr.rating = 1 THEN 1 END) - COUNT(CASE WHEN mr.rating = 0 THEN 1 END) AS rating_difference FROM account a JOIN meme m ON a.id_user = m.id_user JOIN meme_rating mr ON m.id_meme = mr.id_meme GROUP BY a.id_user, a.nick ORDER BY rating_difference ASC LIMIT 3;';

    //liczba memow najlepszego uzytkownika
    $qFavCountMemes = 'SELECT ac.id_user, ac.nick, COUNT(*) AS liczba_memow FROM account ac INNER JOIN meme m ON ac.id_user = m.id_user GROUP BY ac.id_user;';

    //liczba memów najgorszego uzytkownika


    //przechwycenie liczby likes/dislikes/roznicy uzytkownika
    $result = mysqli_query($conn, $qFavUsers);
    $favUsers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);


    //przechwycenie liczby memow uzytkownika
    $result = mysqli_query($conn, $qFavCountMemes);
    $favCountMemes = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    
    //przechwycenie liczby likes/dislikes/roznicy najgorszego uzytkownika
    $result = mysqli_query($conn, $qDisfavUsers);
    $disfavUsers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);


    function printNickFav($position){
       //funkcja wypisująca nick ulubionego uzytkownika w zależności od $position 0,1,2
       global $favUsers;
       echo $favUsers[$position]['nick'];
    }

    function printNickDisfav($position){
        //wypisuje nick najgorszego uzytkownika na ścianie wstydu
        global $disfavUsers;
        echo $disfavUsers[$position]['nick'];
    }


    function getIdFav($position){
        //funkcja zwraca id_user najlepszego o zadanej pozycji w rankingu($position)
        global $favUsers;
        return $favUsers[$position]['id_user'];
    }

    function getIdDisfav($position){
        //funkcja zwraca id_user najgorszego o zadanej pozycji w rankingu($position)
        global $disfavUsers;
        return $disfavUsers[$position]['id_user'];
    }

    function printLikesFav($position){
        //funkcja wypisująca liczbę likes ulubionego uzytkownika w zależności od $position 0,1,2
        global $favUsers;
        echo $favUsers[$position]['liczba_like'];
    }

    function printLikesDisfav($position){
        //funkcja wypisująca like najgorszego użytkownika na ścianie wstydu
        global $disfavUsers;
        echo $disfavUsers[$position]['liczba_like'];
    }

    function printDislikesFav($position){
        global $favUsers;
        echo $favUsers[$position]['liczba_dislike'];
    }

    function printDislikesDisfav($position){
        global $disfavUsers;
        echo $disfavUsers[$position]['liczba_dislike'];
    }

    function printFavCountMemes($id){
        global $favCountMemes;
        foreach($favCountMemes as $userMeme)
            if($userMeme['id_user'] == $id){
                echo $userMeme['liczba_memow'];
            }
    }  
?>