<?php
include '../database/db.php'; 
include '../auth.php';


// Fetch pending time-off requests
$requestQuery = "SELECT * FROM leaverequests WHERE status = 'Pending'";
$requestResult = $conn->query($requestQuery);

// Fetch weekly attendance logs by joining attendance with employees
$attendanceQuery = "
    SELECT Employees.employeeId, Employees.name, Attendance.date, Attendance.status
    FROM Attendance
    JOIN Employees ON Attendance.employeeId = Employees.employeeId
    WHERE Attendance.date BETWEEN '2024-11-25' AND '2024-11-29'
    ORDER BY Employees.employeeId, Attendance.date;
";
$attendanceResult = $conn->query($attendanceQuery);

// Fetch approved or denied leave dates
$leaveQuery = "
    SELECT Employees.employeeId, Employees.name, leaverequests.date, leaverequests.status
    FROM leaverequests
    JOIN Employees ON leaverequests.employeeId = Employees.employeeId
    WHERE leaverequests.status IN ('Approved', 'Denied')
    ORDER BY Employees.employeeId, leaverequests.date;
";
$leaveResult = $conn->query($leaveQuery);

// Process attendance into a structured array
$attendanceData = [];
while ($row = $attendanceResult->fetch_assoc()) {
    $attendanceData[$row['employeeId']]['name'] = $row['name'];
    $attendanceData[$row['employeeId']]['dates'][$row['date']] = $row['status'];
}

// Process leave dates into the structured array
while ($row = $leaveResult->fetch_assoc()) {
    $attendanceData[$row['employeeId']]['leavedates'][] = [
        'date' => date("d/m/y", strtotime($row['date'])),
        'status' => $row['status']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - Time and Attendance Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="time.css">
    <link rel="icon" type="image/png" href="../assets/moderntech-solutions-high-resolution-logo-removebg-preview.png">

</head>
<body>
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

    <div class="container mt-5 pt-5">
        <div id="employeeSection" class="card">
            <h3 class="text-center">Employee Dashboard</h3>
            <div class="card-body">
                <h4>Request Time Off</h4>
                <form method="POST" action="submit_request.php" id="timeOffForm">
                    <div class="form-group">
                        <label for="employeeId">Enter Employee ID:</label>
                        <input type="text" name="employeeId" id="employeeId" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Date of Time Off</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="reason">Reason for Time Off</label>
                        <textarea id="reason" name="reason" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </form>
            </div>
        </div>

      
         

    <footer>
        <p>&copy; 2024 ModernTech Solutions. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="employee.js"></script>
</body>
</html>
