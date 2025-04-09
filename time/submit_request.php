<?php
include '../database/db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  

    if (isset($_POST['employeeId'], $_POST['date'], $_POST['reason'])) {
        $employeeId = $_POST['employeeId'];
        $date = $_POST['date'];
        $reason = $_POST['reason'];
        $status = 'Pending';  // Default status

        // Insert the leave request into the database
        $query = "INSERT INTO leaverequests (employeeId, date, reason, status) 
                  VALUES ('$employeeId', '$date', '$reason', '$status')";

        if ($conn->query($query) === TRUE) {
            echo "Leave request submitted successfully.";
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        echo "Something went wrong. Missing required fields.";
    }
}
?>





