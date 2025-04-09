<?php
header('Content-Type: application/json'); 
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
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
try {
    $sql = "SELECT p.payrollId, e.employeeId, e.name, p.hoursWorked, p.leaveDeductions
            FROM payroll p
            JOIN employees e ON p.employeeId = e.employeeId";
    $result = $conn->query($sql);
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode([
        'status' => 'success',
        'data' => $data
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}





