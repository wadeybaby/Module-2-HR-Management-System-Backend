<?php
include '../auth.php';
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
    // Return error in JSON format
    die(json_encode([
        'status' => 'error',
        'message' => 'Database connection failed: ' . $e->getMessage()
    ]));
}

$hourlyRate = 379;

if (isset($_GET['payrollId'])) {
    $payrollId = $_GET['payrollId'];
    // Validate if payrollId is numeric (to prevent SQL injection)
    if (is_numeric($payrollId)) {
        
        $sql = "SELECT hoursWorked, leaveDeductions FROM payroll WHERE payrollId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $payrollId);
        $stmt->execute();
        $result = $stmt->get_result();
      
        if ($result && $row = $result->fetch_assoc()) {
            $hoursWorked = $row['hoursWorked'];
            $leaveDeductions = $row['leaveDeductions'];
            
            if (isset($hourlyRate)) {

                // Calculate the monthly and annual salary
                $monthlySalary = ($hoursWorked * $hourlyRate) - $leaveDeductions;
                $annualSalary = $monthlySalary * 12;
                // Return the results in JSON format
                echo json_encode([
                    'status' => 'success',
                    'monthlySalary' => $monthlySalary,
                    'annualSalary' => $annualSalary
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Hourly rate is not set']);
            }
        } else {
          
            echo json_encode(['status' => 'error', 'message' => 'No data found for this payrollId']);
        }
    } else {
      
        echo json_encode(['status' => 'error', 'message' => 'Invalid payrollId']);
    }
} else {
   
    echo json_encode(['status' => 'error', 'message' => 'Payroll ID is missing']);
}
// *******************************************************************************
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Payroll System</title>
  <link rel="stylesheet" href="../payroll/payroll.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</head>
<body id="body">
  <!-- NavBar retrieved from Bootstrap and then modified -->
  <nav class="navbar fixed-top" style="background: linear-gradient(90deg, #040046, #000000);">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
        aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation" style="filter: invert(1);">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="../dashboard.php">ModernTech Solutions</a>
      <!-- Offcanvas content that will slide from the left -->
      <div class="offcanvas offcanvas-start text-bg-dark opened-nav" tabindex="-1" id="offcanvasDarkNavbar"
        aria-labelledby="offcanvasDarkNavbarLabel">
        <div id="offcanvas-header" class="offcanvas-header">
          <div>
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
              <img src="../assets/moderntech-solutions-high-resolution-logo-removebg-preview.png" alt="Logo"
                style="height: 40px; margin-right: 10px;">
              <h5 class="offcanvas-title" id="offcanvasLightNavbarLabel">HR Information System</h5>
            </a>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
        </div>
        <div id="offcanvas-body" class="offcanvas-body">
          <hr style="width: 80%; margin: 0 auto;">
          <br>
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link" href="../dashboard.php" style="font-size: 18px;">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../employeedata/employeedirectory.php"
                style="font-size: 18px;">Employee Directory</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="../payroll/payroll.php" style="font-size: 18px;">Payroll</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="../time/admin.php">Manage Leave Requests</a>
             </li>
            <li class="nav-item">
              <a class="nav-link" href="../time/employee.php">Submit Leave Requests</a>
            </li>
            <div class="position-absolute bottom-0 end-0 translate-middle-x text-center pb-3">
             <a href="../logout.php">
             <button type="button" class="btn btn-danger logout-btn">Logout</button>
              </a>
            </div>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <br>
  <header>
    <h1>Payroll Management System</h1>
  </header>
  <!-- Table to display payroll data -->
  <table id="payrollTable">
    <thead>
      <tr>
        <th>Employee ID</th>
        <th>Employee Name</th>
        <th>Hours Worked</th>
        <th>Leave Deductions</th>
        <th>Monthly Salary</th>
        <th>Annual Salary</th>
        <th>Payslip</th>
      </tr>
    </thead>
    <tbody id="payrollTableBody">
  <?php
  // Fetch payroll data from the database
  $sql = "SELECT p.payrollId, e.employeeId, e.name, p.hoursWorked, p.leaveDeductions, e.salary
          FROM payroll p
          JOIN employees e ON p.employeeId = e.employeeId";
  $result = $conn->query($sql);
  // Display the data in the table
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employeeId = $row['employeeId'];
        $employeeName = $row['name'];
        $hoursWorked = $row['hoursWorked'];
        $leaveDeductions = $row['leaveDeductions'];
        $monthlySalary = $row['salary'];
        $annualSalary = $monthlySalary * 12;
        $payrollId = $row['payrollId'];
        echo "<tr>";
        echo "<td>$employeeId</td>";
        echo "<td>$employeeName</td>";
        echo "<td><input type='number' class='form-control' id='hoursWorked_$payrollId' value='$hoursWorked'></td>";
        echo "<td><input type='number' class='form-control' id='leaveDeductions_$payrollId' value='$leaveDeductions'></td>";
        echo "<td id='monthlySalary_$payrollId'>$monthlySalary</td>";
        echo "<td id='annualSalary_$payrollId'>$annualSalary</td>";
        echo "<td><button onclick=\"generatePayslip($payrollId)\" class=\"btn btn-primary\">Generate Payslip</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No data available.</td></tr>";
}
  ?>
</tbody>
  </table>
  <!-- ****************************************** -->
  <script>
const hourlyRate = <?php echo $hourlyRate; ?>; 
// Add an event listener to update both Monthly and Annual Salary 
document.querySelectorAll('.form-control').forEach(function(input) {
  input.addEventListener('input', function() {
    const payrollId = this.id.split('_')[1]; 
    const hoursWorked = parseFloat(document.getElementById('hoursWorked_' + payrollId).value);
    const leaveDeductions = parseFloat(document.getElementById('leaveDeductions_' + payrollId).value);
    
    let monthlySalary = hoursWorked * hourlyRate; 
 
    document.getElementById('monthlySalary_' + payrollId).innerText = monthlySalary.toFixed(2);
   
    const annualSalary = monthlySalary * 12 - leaveDeductions;
  
    document.getElementById('annualSalary_' + payrollId).innerText = annualSalary.toFixed(2);
    
    updatePayrollData(payrollId, hoursWorked, leaveDeductions, monthlySalary, annualSalary);
  });
});
// Function to update the payroll data in the database
function updatePayrollData(payrollId, hoursWorked, leaveDeductions, monthlySalary, annualSalary) {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "update_payroll.php", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  const data = `payrollId=${payrollId}&hoursWorked=${hoursWorked}&leaveDeductions=${leaveDeductions}&monthlySalary=${monthlySalary}&annualSalary=${annualSalary}`;
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
      console.log("Payroll data updated successfully.");
    }
  };
  xhr.send(data);
}
</script>
  <!-- ********************************************* -->
  <script src="../payroll/payroll.js"></script>
</body>
<footer>
  <p>&copy; 2024 MODERNTECH SOLUTIONS. All rights reserved.</p>
</footer>
</html>