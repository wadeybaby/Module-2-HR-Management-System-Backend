<?php
header('Content-Type: application/json'); 
error_reporting(0);
// Database Connection
include '../database/db.php'; 

if (!isset($_GET['action']) || !isset($_GET['id'])) {
    echo json_encode(["status" => "error", "message" => "Action and ID are required."]);
    exit;
}

$action = $_GET['action'];
$id = (int)$_GET['id']; 

if ($action === 'deleteEmployee') {
    try {
   
        $stmt = $conn->prepare("DELETE FROM employees WHERE employeeId = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "message" => "Employee deleted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Employee not found or already deleted."]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid action."]);
}

$conn->close();
?>