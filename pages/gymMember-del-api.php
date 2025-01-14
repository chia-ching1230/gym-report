<?php

require __DIR__ . '/includes/init.php';

$member_id = empty($_GET['member_id']) ? 0 : intval($_GET['member_id']);




if ($member_id) {

    $sql = "DELETE FROM member_basic WHERE member_id = $member_id";


    $pdo->query($sql);
}


$come_from = 'gymMember.php';
if (isset($_SERVER['HTTP_REFERER'])) {
    $come_from = $_SERVER['HTTP_REFERER'];
}

header("Location: $come_from");
