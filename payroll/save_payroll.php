<?php
// Include the database connection
header('Content-Type: application/json'); 
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Database connection 
$db_server = "localhost";
$db_username = "root";
$db_password = ""; 
$db_name = "moderntech";       
$port = 3306;                  
try {
    $conn = new mysqli($db_server, $db_username, $db_password, $db_name, $port);
} catch (mysqli_sql_exception $e) {
    die(json_encode([ 
        'status' => 'error',
        'message' => 'Database connection failed: ' . $e->getMessage()
    ]));
} 

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die(json_encode(['status' => 'error', 'message' => 'Invalid request method.']));
}
if ($_SERVER["CONTENT_TYPE"] !== "application/json") {
    die(json_encode(['status' => 'error', 'message' => 'Invalid Content-Type. Expected application/json']));
}
$json = file_get_contents("php://input");
$data = json_decode($json, true);
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    die(json_encode(['status' => 'error', 'message' => 'Invalid JSON format: ' . json_last_error_msg()]));
}

if (!isset($data['payrollId'], $data['employeeId'], $data['hoursWorked'], $data['leaveDeductions'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
    exit;
}
// Extract the incoming data
$payrollId = $data['payrollId'];
$employeeId = $data['employeeId'];
$hoursWorked = $data['hoursWorked'];
$leaveDeductions = $data['leaveDeductions'];

if (!is_numeric($hoursWorked) || !is_numeric($leaveDeductions)) {
    echo json_encode(['status' => 'error', 'message' => 'Hours worked and leave deductions must be numeric']);
    exit;
}
// Calculate final salary
$hourlyRate = 379; // Define hourly rate
$finalSalary = ($hoursWorked * $hourlyRate) - $leaveDeductions; 

$sql = "UPDATE payroll SET hoursWorked = ?, leaveDeductions = ?, finalSalary = ? WHERE payrollId = ?";
// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $hoursWorked, $leaveDeductions, $finalSalary, $payrollId);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Payroll data updated']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update payroll data: ' . $stmt->error]);
}
// Close the database connection
$stmt->close();
$conn->close();
?>