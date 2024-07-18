<?php
include 'config.php';

try {
    $stmt = $conn->prepare("SELECT COUNT(*) as reservations FROM reservations");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'reservations' => $row['reservations']]);

  
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
