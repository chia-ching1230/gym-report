<?php
require __DIR__.'/includes/init.php';
header('Content-Type: application/json');

$output = [
    'success' => false , #有沒有登入成功
    'bodyData' => $_POST, # 除錯用途
    'code' =>0, #自訂編號，除錯用途
    'error'=>'', #回應給前端的除錯消息
];
//帳號密碼其中有一個欄位沒值就離開
if(empty($_POST['email'])or empty($_POST['admin_password'])){
    echo json_encode($output);
    exit;
}
//trim()去掉頭尾空白
$email=trim($_POST['email']);
$password=trim($_POST['admin_password']);
//1.先確認帳號使否正確
$sql = "SELECT * FROM gym_admin WHERE email=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$email]);
$row =$stmt->fetch();
//2.找不到帳號，帳號是錯的就離開
if(empty($row)){
    $output['code']=400;
    echo json_encode($output);
    exit;
}
if(!password_verify($password, $row['admin_password_hash()'])){
    $output['code']=420;
    echo json_encode($output);
    exit;
}
#帳密都對，狀態傳入session
$_SESSION['admin']=[
    'id'=>$row['admin_id'],
    'email'=>$email,
];
$output['success']=true; #登入成功

echo json_encode($output,JSON_UNESCAPED_UNICODE);








