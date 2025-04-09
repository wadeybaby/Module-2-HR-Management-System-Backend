<?php
session_start();
include 'auth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap 5.3.3 Linking -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <!-- Page Title -->
  <title>Dashboard</title>
  <!-- Linking CSS -->
  <link rel="stylesheet" href="css/dashboard.css">
  <link rel="icon" type="image/png" href="assets/moderntech-solutions-high-resolution-logo-removebg-preview.png">

</head>

<body>
  <br>
  <br>


  <header>
    <h1>HR Information System Dashboard</h1>
  </header>



  <!-- Nav bar extracted and modified from Bootstrap -->
  <nav class="navbar fixed-top" style="background: linear-gradient(90deg, #040046, #000000)" ;>
    <div class="container-fluid">
      <!-- Move the navbar toggler button to the left -->
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
        aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation" style="filter: invert(1);">
        <span class="navbar-toggler-icon"></span>
      </button>


      <!-- Move the navbar brand to the left -->
      <a class="navbar-brand" href="dashboard.php">ModernTech Solutions</a>

      <!-- Offcanvas content that will slide from the left -->
      <div class="offcanvas offcanvas-start  text-bg-dark opened-nav" tabindex="-1" id="offcanvasDarkNavbar"
        aria-labelledby="offcanvasDarkNavbarLabel">
        <div class="offcanvas-header">
          <div>
            <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
              <img src="assets/moderntech-solutions-high-resolution-logo-removebg-preview.png" alt="Logo"
                style="height: 40px; margin-right: 10px;">
              <h5 class="offcanvas-title" id="offcanvasLightNavbarLabel">HR Information System</h5>
            </a>
          </div>
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <br>

          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="employeedata/employeedirectory.php">Employee Directory</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="payroll/payroll.php">Payroll</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="time/admin.php">Manage Leave Requests </a>
            </li>
             <li class="nav-item">
              <a class="nav-link" href="time/employee.php">Submit Leave request</a>
            </li>
            <div class="position-absolute bottom-0 end-0 translate-middle-x text-center  pb-3">
              <a href="logout.php">
               <button type="button" class="btn btn-danger logout-btn">Logout</button>
                </a>
            </div>
        </div>
      </div>
    </div>
  </nav>


  <!--MAIN-->
  <main>

    <section class="container py-5">
      <!-- Summary Cards using Bootstrap-->

<div class="row row-cols-1 row-cols-md-3 g-4">
    <!-- First Row -->
    <div class="col">
        <div class="card h-50 text-center card-padding">
            <div class="card-body">
                <h2 class="card-title">Employee Directory</h2>
                <p class="card-text">View and manage the list of all employees in the directory.</p>
                <a href="employeedata/employeedirectory.php" class="btn btn-primary">Go to Employee Directory</a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card h-50 text-center card-padding">
            <div class="card-body">
                <h2 class="card-title">Payroll</h2>
                <p class="card-text">Access payroll details and manage employee salaries.</p>
                <a href="payroll/payroll.php" class="btn btn-primary">Go to Payroll</a>
            </div>
        </div>

        <!-- Distinction Separator -->
        <!-- <hr class="mt-4 mb-3" style="border-top: 3px solid #000; opacity: 0.8;"> -->

        <!-- New Card (Below Payroll) -->
        <div class="card h-50 text-center card-padding">
            <div class="card-body">
                <h2 class="card-title">Submit Leave Request</h2>
                <p class="card-text">Employees portal for leave request submission.</p>
                <a href="time/employee.php" class="btn btn-primary">Submit a request</a>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card h-50 text-center card-padding">
            <div class="card-body">
                <h5 class="card-title">Time and attendance</h5>
                <p class="card-text">Track employee attendance and manage leave requests.</p>
                <a href="time/admin.php" class="btn btn-primary">Go to Time and Attendance</a>
            </div>
        </div>
    </div>
</div>

    </section>
  </main>
<script>
        // Prevent users from using the "Back" button to return after logging out
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
  <!-- Footer -->
  <footer>
    <p>&copy; 2024 MODERNTECH SOLUTIONS. All rights reserved.</p>
  </footer>

  <!-- <script src="dashboard/dashboard.js"></script> -->
</body>

</html>