<?php

require __DIR__.'/includes/init.php';

$article_id = empty($_GET['article_id'])? 0 : intval($_GET['article_id']);



if($article_id){
    $sql ="DELETE FROM articles WHERE article_id = $article_id";
    $pdo->query($sql);
}
$come_from='article.php';
if(isset($_SERVER['HTTP_REFERER'])){
    $come_from=$_SERVER['HTTP_REFERER'];
}

header("Location: $come_from");