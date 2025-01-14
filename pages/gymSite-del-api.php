<?php

require __DIR__.'/includes/init.php';

$gym_id = empty($_GET['gym_id'])? 0 : intval($_GET['gym_id']);



if($gym_id){
    $sql ="DELETE FROM gyms WHERE gym_id = $gym_id";
    $pdo->query($sql);
}
$come_from='gymSite.php';
if(isset($_SERVER['HTTP_REFERER'])){
    $come_from=$_SERVER['HTTP_REFERER'];
}

header("Location: $come_from");