<?php

require __DIR__.'/includes/init.php';

$video_id = empty($_GET['videos_id'])? 0 : intval($_GET['videos_id']);



if($video_id){
    $sql ="DELETE FROM Videos WHERE videos_id = $video_id";
    $pdo->query($sql);
}
$come_from='videos.php';
if(isset($_SERVER['HTTP_REFERER'])){
    $come_from=$_SERVER['HTTP_REFERER'];
}

header("Location: $come_from");