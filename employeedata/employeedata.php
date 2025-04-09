<?php

    include "../database/db.php";

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    header('Content-Type: application/json');

    // Query to fetch employee data
    $query = "SELECT * FROM employees";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo json_encode(["status" => "error", "message" => "Database query failed: " . mysqli_error($conn)]);
        exit;
    }

    // Fetch employees into an array
    $employees = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $employees[] = $row;
    }

    // To return the employees as JSON
    echo json_encode(["status" => "success", "employees" => $employees]);