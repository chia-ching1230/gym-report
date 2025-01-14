<?php

require __DIR__.'/includes/init.php';

$order_id = empty($_GET['order_id'])? 0 : intval($_GET['order_id']);



if($order_id){
    $sql ="DELETE FROM orders WHERE order_id = $order_id";
    $pdo->query($sql);
}
$come_from='order.php';
if(isset($_SERVER['HTTP_REFERER'])){
    $come_from=$_SERVER['HTTP_REFERER'];
}

header("Location: $come_from");