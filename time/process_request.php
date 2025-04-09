<?php
include '../database/db.php'; 

header('Content-Type: application/json'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['leaveRequestId'])) {
        $leaveRequestId = $_POST['leaveRequestId'];  

        // Determine the action based on which button was clicked
        if (isset($_POST['approve'])) {
            $action = 'Approved';
        } elseif (isset($_POST['deny'])) {
            $action = 'Denied';
        } else {
            echo json_encode(["success" => false, "error" => "No action specified."]);
            exit;
        }

        // Update the leave request status
        $query = "UPDATE leaverequests SET status = ? WHERE leaveRequestId = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("si", $action, $leaveRequestId);
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "status" => $action]);
            } else {
                echo json_encode(["success" => false, "error" => $stmt->error]);
            }
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "error" => $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Leave request ID not provided."]);
    }
}
?>