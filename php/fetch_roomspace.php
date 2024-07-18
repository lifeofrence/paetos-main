<?php
include 'config.php';

try {
    $stmt = $conn->prepare("SELECT SUM(available_space) as total_available_space FROM room");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    echo json_encode(['status' => 'success', 'total_available_space' => $row['total_available_space']]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
