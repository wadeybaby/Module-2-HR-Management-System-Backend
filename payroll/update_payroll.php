<?php
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
    die("Database connection failed: " . $e->getMessage());
}
// Ensure required data is received
if (isset($_POST['payrollId'], $_POST['hoursWorked'], $_POST['leaveDeductions'], $_POST['monthlySalary'], $_POST['annualSalary'])) {
    $payrollId = $_POST['payrollId'];
    $hoursWorked = $_POST['hoursWorked'];
    $leaveDeductions = $_POST['leaveDeductions'];
    $monthlySalary = $_POST['monthlySalary'];
    $annualSalary = $_POST['annualSalary'];
    // Update the payroll data in the database
    $sql = "UPDATE payroll SET hoursWorked = ?, leaveDeductions = ?, finalSalary = ? WHERE payrollId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dddi", $hoursWorked, $leaveDeductions, $monthlySalary, $payrollId);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Payroll updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error updating payroll']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
}
?>
