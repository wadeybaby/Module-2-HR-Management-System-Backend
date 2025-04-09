<?php
include '../database/db.php'; 
include '../auth.php';

session_start(); 


// Fetch pending time-off requests with employee names
$requestQuery = "
    SELECT leaverequests.*
    FROM leaverequests 
    WHERE leaverequests.status = 'Pending'";

$requestResult = $conn->query($requestQuery);
echo "<script>console.log(" . json_encode($requestResult) . ");</script>";

// Fetch weekly attendance logs by joining attendance with employees
$attendanceQuery = "
    SELECT employees.employeeId, employees.name, attendance.date, attendance.status
    FROM attendance
    JOIN employees ON attendance.employeeId = employees.employeeId
    WHERE attendance.date BETWEEN '2024-11-25' AND '2024-11-29'
    ORDER BY employees.employeeId, attendance.date";
$attendanceResult = $conn->query($attendanceQuery);

// Fetch approved or denied leave dates
$leaveQuery = "
    SELECT Employees.employeeId, Employees.name, leaverequests.date, leaverequests.status
    FROM leaverequests
    JOIN Employees ON leaverequests.employeeId = Employees.employeeId
    WHERE leaverequests.status IN ('Approved', 'Denied')
    ORDER BY Employees.employeeId, leaverequests.date";
    
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
    <title>Admin Dashboard - Time and Attendance Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

<!-- Main Content -->
<div class="container mt-5 pt-5">

    <!-- HR Section -->
    <div id="hrSection" class="card">
        <h3 class="text-center">HR Dashboard</h3>
        <div class="card-body">
            <h4>Pending Time Off Requests</h4>
            <table id="pendingRequests" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Date</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $requestResult->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row["employeeId"]) ?></td>
                            <td><?= htmlspecialchars($row["date"]) ?></td>
                            <td><?= htmlspecialchars($row["reason"]) ?></td>
                            <td><span class="badge bg-warning"><?= htmlspecialchars($row["status"]) ?></span></td>
                            <td>
                                <form method="post" action="process_request.php">
                                    <input type="hidden" name="leaveRequestId" value="<?= $row['leaveRequestId'] ?>">
                                    <button type="submit" name="approve" class="btn btn-success btn-sm">Approve</button>
                                    <button type="submit" name="deny" class="btn btn-danger btn-sm">Deny</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Attendance Summary Chart -->
    <div class="card mt-4">
        <h3 class="text-center">Attendance Summary (Bar Chart)</h3>
        <canvas id="attendanceChart" width="400" height="200"></canvas>
    </div>
 <br>
    <!-- Weekly Attendance Log -->
    <div class="card mt-4">
        <h3 class="text-center">Weekly Attendance Log</h3>
        <table id="attendanceTable" class="table table-striped table-bordered attendance-table">
            <thead>
                <tr>
                    <th>Employee Name</th>
                    <th>Nov 25, 2024</th>
                    <th>Nov 26, 2024</th>
                    <th>Nov 27, 2024</th>
                    <th>Nov 28, 2024</th>
                    <th>Nov 29, 2024</th>
                    <th>Leave Dates</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendanceData as $employee): ?>
                    <tr>
                        <td><?= htmlspecialchars($employee["name"]) ?></td>
                        <td><span class="status <?= strtolower($employee['dates']['2024-11-25'] ?? 'N/A') ?>">
                            <?= $employee['dates']['2024-11-25'] ?? 'N/A' ?>
                        </span></td>
                        <td><span class="status <?= strtolower($employee['dates']['2024-11-26'] ?? 'N/A') ?>">
                            <?= $employee['dates']['2024-11-26'] ?? 'N/A' ?>
                        </span></td>
                        <td><span class="status <?= strtolower($employee['dates']['2024-11-27'] ?? 'N/A') ?>">
                            <?= $employee['dates']['2024-11-27'] ?? 'N/A' ?>
                        </span></td>
                        <td><span class="status <?= strtolower($employee['dates']['2024-11-28'] ?? 'N/A') ?>">
                            <?= $employee['dates']['2024-11-28'] ?? 'N/A' ?>
                        </span></td>
                        <td><span class="status <?= strtolower($employee['dates']['2024-11-29'] ?? 'N/A') ?>">
                            <?= $employee['dates']['2024-11-29'] ?? 'N/A' ?>
                        </span></td>
                        <td>
                            <?php if (isset($employee["leavedates"])): ?>
                                <?php foreach ($employee["leavedates"] as $leave): ?>
                                    <span class="leave-<?= strtolower($leave['status']) ?>">
                                        <?= htmlspecialchars($leave['date']) ?> (<?= htmlspecialchars($leave['status']) ?>)
                                    </span><br>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<!-- Footer -->
<footer>
    <p>&copy; 2024 ModernTech Solutions. All rights reserved.</p>
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="admin.js"></script>
<script>

    $(document).ready(function() {
        $('#attendanceTable').DataTable();

        // Ensure Chart.js runs only after the page is fully loaded
        $(window).on('load', function () {
            var ctx = document.getElementById('attendanceChart').getContext('2d');

            // Check if there is an existing chart instance and destroy it
            if (window.attendanceChart instanceof Chart) {
                window.attendanceChart.destroy();
            }

            var presentCounts = [
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-25'] ?? '') === 'Present')) ?>,
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-26'] ?? '') === 'Present')) ?>,
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-27'] ?? '') === 'Present')) ?>,
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-28'] ?? '') === 'Present')) ?>,
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-29'] ?? '') === 'Present')) ?>
            ];

            var absentCounts = [
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-25'] ?? '') === 'Absent')) ?>,
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-26'] ?? '') === 'Absent')) ?>,
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-27'] ?? '') === 'Absent')) ?>,
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-28'] ?? '') === 'Absent')) ?>,
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-29'] ?? '') === 'Absent')) ?>
            ];

            var leaveCounts = [
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-25'] ?? '') === 'Leave')) ?>,
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-26'] ?? '') === 'Leave')) ?>,
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-27'] ?? '') === 'Leave')) ?>,
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-28'] ?? '') === 'Leave')) ?>,
                <?= count(array_filter($attendanceData, fn($e) => ($e['dates']['2024-11-29'] ?? '') === 'Leave')) ?>
            ];

            window.attendanceChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Nov 25', 'Nov 26', 'Nov 27', 'Nov 28', 'Nov 29'],
                    datasets: [
                        {
                            label: 'Present',
                            data: presentCounts,
                            backgroundColor: '#28a745',
                            borderColor: '#155724',
                            borderWidth: 1
                        },
                        {
                            label: 'Absent',
                            data: absentCounts,
                            backgroundColor: '#dc3545',
                            borderColor: '#721c24',
                            borderWidth: 1
                        },
                        {
                            label: 'Leave',
                            data: leaveCounts,
                            backgroundColor: '#ffc107',
                            borderColor: '#856404',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });

    });

</script>

</body>
</html>
