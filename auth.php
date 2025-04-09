<?php

// Start session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Define allowed pages for each role
$allowed_pages = [
    "admin" => ["dashboard.php", "employeedirectory.php", "payroll.php", "admin.php", "employee.php"],
    "employee" => ["dashboard.php", "employee.php"] 
];

// Get current page name
$current_page = basename($_SERVER['PHP_SELF']);

// If user is not logged in, redirect to login page
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
   
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
    header("Pragma: no-cache");
    header("Location: index.php"); 
    exit();
}

// Get the role from session
$role = $_SESSION['role'] ?? null;

// Check if the role exists in session and if it's valid
if (!$role || !isset($allowed_pages[$role])) {
    header("Location: index.php"); // Redirect if role is invalid
    exit();
}

// Check if the user is trying to access a page that is not allowed based on their role
if (!in_array($current_page, $allowed_pages[$role])) {
    // Display access denied message
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Access Denied</title>
        <style>
            body {
                margin: 0;
                padding: 0;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background: url('../assets/195384443_80e5a83e-0a99-494d-9489-4e89a8630084.jpg') no-repeat center center fixed;
                background-size: cover;
                font-family: Arial, sans-serif;
                color: white;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <script>
            setTimeout(function() {
                alert('Access Denied: You do not have permission to view this page.');
                window.location.href = 'http://localhost/moderntech/dashboard.php'; // Redirect after alert
            }, 500);
        </script>
    </body>
    </html>";
    exit();
}


?>
