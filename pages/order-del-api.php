<?php

require __DIR__.'/includes/init.php';
//後端,
$order_id = empty($_GET['order_id'])? 0 : intval($_GET['order_id']);



if($order_id){
    $sql ="DELETE FROM orders WHERE order_id = $order_id";
    $pdo->query($sql);
}
$come_from='order.php'; //從哪邊連過來的
if(isset($_SERVER['HTTP_REFERER'])){  //如果有這個值,就讓$come_from變數設定成這個值,如果沒有就回第1頁
    $come_from=$_SERVER['HTTP_REFERER']; 
}

header("Location: $come_from");