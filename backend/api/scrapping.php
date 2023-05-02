<?php
    require '../../backend/database/database.php';
    require '../../vendor/autoload.php';

    use Goutte\Client;
    $arr = [];
    $client = new Client();

        //kwejk.pl
    $crawler = $client->request("GET", "https://kwejk.pl/");
    $crawler->filter('.media-element-wrapper > .media-element')->each(function ($node) use (&$arr) {
        array_push($arr, $node->attr('data-image'));
    });

    //memy.pl
    $crawler = $client->request("GET", "https://memy.pl/");
    $crawler->filter('.meme-item > .figure-item > a > img')->each(function ($node) use (&$arr) {
       array_push($arr, $node->attr('src'));
    });

    //pocisk.org
    $crawler = $client->request("GET", "https://pocisk.org/");
    $crawler->filter('.attachment-bimber-stream')->each(function ($node) use (&$arr) {
       array_push($arr, $node->attr('data-src'));
    });

    //redmik.pl
    $crawler = $client->request("GET", "https://redmik.pl/");
    $crawler->filter('.attachment-bimber-stream')->each(function ($node) use (&$arr) {
        array_push($arr, $node->attr('data-src'));
     });
     
     for($i = 0; $i < count($arr); $i++) {
        $uniqueId = uniqid('meme_', true);
        copy($arr[$i], '../../memes/'.$uniqueId.'.jpg');
        $date = date('Y/m/d');
        $sql = "INSERT INTO meme (id_meme, title, id_user, id_comment, adding_date, accepted, imgsource) 
                VALUES (NULL, 'scrapped', '9999', '1', '$date', '0', '$uniqueId.jpg')";
        $conn->query($sql);
       
     }
     $conn->close();
     exit();
?>