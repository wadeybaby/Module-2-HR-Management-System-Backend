<?php
// Database connection 
include('../database/db.php');

// Getting the payrollId from the URL
$payrollId = isset($_GET['payrollId']) ? $_GET['payrollId'] : null;
if (!$payrollId) {
    die('No payroll ID provided.');
}
// Query to get the payroll data and employee details
$sql = "SELECT p.payrollId, p.employeeId, p.hoursWorked, p.leaveDeductions, p.finalSalary, e.name, pos.positionName, e.salary
        FROM payroll p
        JOIN employees e ON p.employeeId = e.employeeId
        JOIN positions pos ON e.positionId = pos.positionId
        WHERE p.payrollId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $payrollId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die('Payroll not found.');
}
$payroll = $result->fetch_assoc();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payslip for <?php echo htmlspecialchars($payroll['name']); ?></title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #000000;
            color: #FFFFFF;
            text-align: center;
            margin: 0;
            padding: 20px;
            background-image: url('../assets/195384443_80e5a83e-0a99-494d-9489-4e89a8630084.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .payslip-container {
            background: linear-gradient(120deg, #040046, #030314);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
            max-width: 500px;
            margin: auto;
        }
        h1 {
            font-size: 1.8rem;
            margin-bottom: 20px;
        }
        .payslip-details p {
            font-size: 1.1rem;
            margin: 5px 0;
        }
        .total {
            font-weight: bold;
            font-size: 1.3rem;
            margin-top: 15px;
            color: #FFD700;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #3333FF;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .btn-back:hover {
            background-color: #5555FF;
        }
    </style>
</head>
<body>
    <h1>Payslip for <?php echo htmlspecialchars($payroll['name']); ?></h1>
    <div class="payslip-details">
        <p><strong>Employee ID:</strong> <?php echo $payroll['employeeId']; ?></p>
        <p><strong>Position:</strong> <?php echo $payroll['positionName']; ?></p>
        <p><strong>Hours Worked:</strong> <?php echo $payroll['hoursWorked']; ?> hours</p>
        <p><strong>Leave Deductions:</strong> <?php echo $payroll['leaveDeductions']; ?> hours</p>
        <!-- <p><strong>Final Salary:</strong> R <?php echo number_format($payroll['finalSalary'], 2); ?></p> -->
    </div>
    <div class="total">
        <p><strong>Total Salary:</strong> R <?php echo number_format($payroll['finalSalary'], 2); ?></p>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>