<?php
require __DIR__ . '/includes/init.php';

$ids = isset($_GET['ids']) ? explode(',', $_GET['ids']) : [];
$status = $_GET['status'] ?? '';

if (!empty($ids) && in_array($status, ['confirmed', 'cancelled'])) {
    $placeholders = str_repeat('?,', count($ids) - 1) . '?';
    $sql = "UPDATE appointments 
            SET status = ?, 
                updated_at = CURRENT_TIMESTAMP 
            WHERE appointment_id IN ($placeholders)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_merge([$status], $ids));
}

header('Location: appointmentsClass.php');
exit;