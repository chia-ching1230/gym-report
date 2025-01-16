<?php

require __DIR__ . '/includes/init.php';

$admin_id = empty($_GET['admin_id']) ? 0 : intval($_GET['admin_id']);

if ($admin_id > 0) {
    $sql ="DELETE FROM gym_admin WHERE admin_id = $admin_id";
    $pdo->query($sql);
}

$come_from='gymAdmin.php';
if (isset($_SERVER['HTTP_REFERER'])) {
    $come_from = $_SERVER['HTTP_REFERER'];
}

header("Location: $come_from");