<?php
require __DIR__.'/includes/init.php';

$sql = "UPDATE `appointments` 
        SET `status` = 'cancelled',
            `updated_at` = CURRENT_TIMESTAMP
        WHERE `appointment_id` = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$_GET['id']]);

header('Location: appointmentsClass.php');
exit;