<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "../database/db.php";

header('Content-Type: application/json'); 
ob_start(); 

$response = ["status" => "error", "message" => "Unknown error occurred."]; // Default error message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['name'], $_POST['position'], $_POST['department'], $_POST['salary'], $_POST['contact'], $_POST['previousPositionStartYear'])) {
        
        $name = $_POST['name'];
        $position = (int)$_POST['position'];
        $department = (int)$_POST['department'];
        $salary = (float)$_POST['salary'];
        $contact = $_POST['contact'];
        $previousPositionStartYear = (int)$_POST['previousPositionStartYear'];

        $stmt = $conn->prepare("INSERT INTO employees (name, positionId, departmentId, salary, contact, previousPositionStartYear) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siidsi", $name, $position, $department, $salary, $contact, $previousPositionStartYear);

        if ($stmt->execute()) {
            $response = ["status" => "success", "message" => "Employee added successfully."];
        } else {
            $response = ["status" => "error", "message" => "Error adding employee: " . $stmt->error];
        }

        $stmt->close();
    } else {
        $response = ["status" => "error", "message" => "All fields are required."];
    }
} else {
    $response = ["status" => "error", "message" => "Invalid request method."];
}

$conn->close();
ob_clean(); 
echo json_encode($response);
exit; 
?>
