<?php
include '../auth.php';
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
    <title>Employee Directory</title>
    <link rel="stylesheet" href="../css/employeedirectory.css">
    <link rel="icon" type="image/png" href="../assets/moderntech-solutions-high-resolution-logo-removebg-preview.png">
</head>


<body>

    <!-- NavBar retrieved from Bootstrap and then modified -->
    <nav class="navbar fixed-top" style="background: linear-gradient(90deg, #040046, #000000);" ;>
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation"
                style="filter: invert(1);">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="../dashboard.php">ModernTech Solutions</a>

            <div class="offcanvas offcanvas-start text-bg-dark opened-nav" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <a href="#"
                        class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <img src="../assets/moderntech-solutions-high-resolution-logo-removebg-preview.png" alt="Logo"
                            style="height: 40px; margin-right: 10px;">
                        <h5 class="offcanvas-title" id="offcanvasLightNavbarLabel">HR Information System</h5>
                    </a>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>

                <!-- Offcanvas content that will slide from the left -->
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link" href="../dashboard.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page"
                                href="../employeedata/employeedirectory.php">Employee Directory</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../payroll/payroll.php">Payroll</a>
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

    <!-- Main Section -->
    <main>
        <section class="container py-5">
            <br>
            <br>
            <h2 class="text-center mb-4">Employee Directory</h2>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex justify-content-center flex-grow-1" style="margin-left: 10%;">
                    <div class="input-group" style="width: 60%;">
                        <input type="text" id="searchInput" class="form-control shadow-sm"
                            placeholder="Search for an employee by ID" aria-label="Search for an employee">
                        <button class="btn btn-primary shadow-sm" onclick="searchEmployee()"
                            style="border-left: 0;">Search</button>
                    </div>
                </div>

                <!-- Performance Review Button -->
                <a href="../performance/performance.php" target="_blank" rel="noopener noreferrer"
                    class="btn btn-success shadow-sm ms-3">
                    Performance Review
                </a>

                <!-- Add Employee Button -->
                <button type="button" class="btn btn-primary shadow-sm ms-3" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">Add a New Employee</button>
            </div>

            <div id="employeeList" class="row row-cols-1 row-cols-md-2 g-4"></div>

            <!-- Modal for adding an employee-->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title fs-5 text-dark" id="exampleModalLabel">Add a New Employee</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form id="addEmployeeForm" method="POST" action="createemployee.php">
    <div class="modal-body">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="name">Name:</label>
                <input  type="text" id="name" name="name" class="form-control" placeholder="Name" required>
            </div>
            <div class="col-md-4">
                <label for="position">Position ID:</label>
                <input type="number" id="position" name="position" class="form-control" placeholder="Position ID" required>
            </div>
            <div class="col-md-4">
                <label for="department">Department ID:</label>
                <input type="number" id="department" name="department" class="form-control" placeholder="Department ID" required>
            </div>
            <div class="col-md-4">
                <label for="salary">Salary:</label>
                <input type="number" id="salary" name="salary" class="form-control" placeholder="Salary" required>
            </div>
            <div class="col-md-4">
                <label for="contact">Contact:</label>
                <input type="text" id="contact" name="contact" class="form-control" placeholder="Contact" required>
            </div>
            <div class="col-md-4">
                <label for="previousPositionStartYear">Start Year:</label>
                <input type="number" id="previousPositionStartYear" name="previousPositionStartYear" class="form-control" placeholder="Start Year" required>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Add</button>
    </div>
</form>
                    </div>
                </div>
            </div>

            <div id="data-container" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-4"></div>
        </section>
    </main>
    <!-- Footer -->
    <script src="employeedata.js"></script>
    <footer>
        <p>&copy; 2024 MODERNTECH SOLUTIONS. All rights reserved.</p>
    </footer>
</body>

</html>