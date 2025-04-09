<?php
session_start();
include "database/db.php";
// ****************************************************************************************************************************************

// (The Code to RUN ONCE)
// Fetch all employees who are not yet in the users table
// $sql = "SELECT employeeId, name, positionId FROM employees
// WHERE employeeId NOT IN (SELECT employeeId FROM users)";
// $result = $conn->query($sql);
// $adminPositionId = 2;
// //Only run once to create users
// if ($result->num_rows > 0) {
//       while ($row = $result->fetch_assoc()) {
//           $employeeId = $row['employeeId'];
//           $username = strtolower(str_replace(' ', '', $row['name']));
//           $hashedPassword = password_hash("Default@123", PASSWORD_BCRYPT);
//           $positionId = $row['positionId'];
//           // Assign the 'admin' role to the employee with the admin positionId
//           $role = ($positionId == $adminPositionId) ? 'admin' : 'employee';
//           $insertSql = "INSERT INTO users (username, password, role, employeeId) VALUES (?, ?, ?, ?)";
//           $stmt = $conn->prepare($insertSql);
//           $stmt->bind_param("sssi", $username, $hashedPassword, $role, $employeeId);
//           if ($stmt->execute()) {
//               echo "User created: $username with role: $role<br>";
//           } else {
//               echo "Error: " . $stmt->error . "<br>";
//           }
//           $stmt->close();
//       }
//   } else {
//       echo "No new employees found.<br>";
//   }
// ****************************************************************************************************************************************
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $input_password = trim($_POST["password"]);
    if (empty($email) || empty($input_password)) {
        die("Email and password are required!");
    }
    $sql = "SELECT username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $employees = $result->fetch_assoc();
        $storedPassword = $employees['password'];
        $role = $employees['role']; // Get the role from the database
        // Verify password
        if (password_verify($input_password, $storedPassword)) {
            $_SESSION['username'] = $email;
            $_SESSION['role'] = $role;
            // echo "Username " . $_SESSION['username'] . "<br>";
            // echo "Role" .$_SESSION['role'];
            header("Location: ../moderntech/dashboard.php");
            exit();
        } else {
            die("Incorrect password.");
        }
    } else {
        die("No user found with that email.");
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ModernTech Login</title>
    <link rel="stylesheet" href="css/login.css" />
    <link rel="icon" type="image/png" href="assets/moderntech-solutions-high-resolution-logo-removebg-preview.png">
  </head>
  <body>
    <div class="container">
      <div class="left-side"></div>
      <div class="right-side">
        <h1>Welcome to ModernTech</h1>
        <form class="login-form" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST">
          <label for="username">Username/ID:</label>
          <input type="text" id="username" name="email" placeholder="Enter your username" required />
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required />
          <div class="buttons-container">
            <button id="submitButton" type="submit">Login</button>
          </div>
        </form>
        <script>
        // Prevent back navigation to the dashboard after logging out
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
      </div>
    </div>
    <script src="../login/login.js"></script>
  </body>
</html>
