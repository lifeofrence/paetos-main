<?php
include 'config.php';

try {
    $stmt = $conn->prepare("SELECT COUNT(*) as payments FROM payments");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'payments' => $row['payments']]);

  
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
