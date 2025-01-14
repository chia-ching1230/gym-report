<?php

require __DIR__.'/includes/init.php';

$news_id = empty($_GET['news_id'])? 0 : intval($_GET['news_id']);



if($news_id){
    $sql ="DELETE FROM gym_news WHERE news_id = $news_id";
    $pdo->query($sql);
}
$come_from='gymNews.php';
if(isset($_SERVER['HTTP_REFERER'])){
    $come_from=$_SERVER['HTTP_REFERER'];
}

header("Location: $come_from");