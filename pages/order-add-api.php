<?php
require __DIR__.'/includes/init.php'; //這個裡面才有資料庫連線
header('Content-Type: application/json'); //告訴用戶,輸出json格式

#定義1個陣列(要輸出的放裡面)(這一支的目的是新增資料)
$output = [
    'success' => false , //有沒有新增成功
    'bodyData' => $_POST, //除錯用途(表單送過來的資料,在整個丟回去)
    'code' =>0, //塞自訂編號,一樣除錯用途
    'error'=>'', //回應給前端的錯誤訊息(可以 +s 變多個)
    'lastInsertId' =>0, //第28行,要回應給用戶端(最新拿到的PK)
];
$sql = "INSERT INTO `orders`
(`order_id`, `member_id`, `total_amount`, `self_pickup_store`,`payment_method`,`status`) 
VALUES (?,?,?,?,?,?)"; 
# 第13~15行,不是完整的SQL語法,因為新增沒有把真正的值放進去,所以不能用 query, query會直接執行

//$pdo->prepare($sql);的意思是把sql準備好,然後拿到 pdo statement
$stmt = $pdo->prepare($sql); //SQL語法是 select 以外的都不能呼叫 fetch,因為不是去讀取資料
$stmt -> execute([
    $_POST['order_id'],
    $_POST['member_id'],
    $_POST['total_amount'],
    $_POST['self_pickup_store'],
    $_POST['payment_method'],
    $_POST['status']
]);
$output['success'] = !!$stmt->rowCount(); //rowCount()影響幾列,新增了幾筆(CRUD都用此函數)
$output['lastInsertId'] = $pdo->lastInsertId(); //只有在新增資料,primary key 是 auto increment才會有(最新拿到的PK)

echo json_encode($output,JSON_UNESCAPED_UNICODE); 
#echo json_encode($_POST,JSON_UNESCAPED_UNICODE); 傳什麼樣的資料過來,就傳什麼樣的資料回去


