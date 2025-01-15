
<?php
require __DIR__ . '/includes/init.php';
header('Content-Type: application/json');

$output = [
    'success' => false,
    'bodyData' => $_POST,
    'code' => 0,
    'error' => '',
    'lastInsertId' => 0,
];

$fitness_goals = implode(',', $_POST['fitness_goals']);


$sql_basic = "UPDATE `member_basic`
   SET 
   `member_name`=?,
   `phone`=?,
   `address`=?
   WHERE `member_id`=?";


$stmt1 = $pdo->prepare($sql_basic);
$stmt1->execute([
    $_POST['member_name'],
    $_POST['phone'],
    $_POST['address'],
    $_POST['member_id']
]);





$sql_profile = "UPDATE `member_profile`
   SET 
   `height`=?,
   `weight`=?,
   `fitness_goals`=?,
   `bio`=?
   WHERE `member_id`=?";

$stmt3 = $pdo->prepare($sql_profile);
$stmt3->execute([

    $_POST['height'],
    $_POST['weight'],
    $fitness_goals,
    $_POST['bio'],
    $_POST['member_id']
]);



$output['success'] = !!$stmt1->rowCount();
$output['lastInsertId'] = $pdo->lastInsertId();
echo json_encode($output, JSON_UNESCAPED_UNICODE);
