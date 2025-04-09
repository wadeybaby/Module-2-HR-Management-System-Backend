ModernTech Solutions HR System - Backend (Module 2)

This is the backend for the ModernTech Solutions HR Management System built using PHP and MySQLi. 
It manages employee data, payroll, time tracking, and performance. The system handles employee records, salary calculations, attendance, leave requests, and generates payslips. It also includes secure authentication and an admin dashboard for managing all modules. AJAX and real-time updates ensure smooth user interactions.

(Visit our frontend @ www.moderntechsolutions.co.za) - Login username: HR, password:admin123*

REQUIREMENTS:
- PHP (Version 7.4 or later recommended)
- MySQL Database
- Apache or any local server (e.g., XAMPP)

SETUP INSTRUCTIONS:

1. Clone or Download the Project
--------------------------------
git clone https://github.com/Zainunesa/Module-2.git  

FOLDER STRUCTURE:

MODERNTECH
├── assets
│    ├── 6402717_3257989.jpg
│    ├── 69603051_uyfydu5.jpg
│    ├── 195384443_80e5a83e-0a99-494d-9489-4e89a8630084.jpg
│    ├── 1591794432208.jpg
│    ├── Case-study-Mar24.jpg
│    ├── depositphotos_48703121-stock-photo-data-management.jpg
│    ├── logo-color.png
│    └── moderntech-solutions-high-resolution-logo-removebg-preview.png
│
├── css
│    ├── dashboard.css
│    ├── employeedirectory.css
│    ├── login.css
│    └── performance.css
│
├── database
│   └── db.php
├── employeedata
│   ├── createemployee.php 
│   ├── employeedata.js            
│   ├── employeedata.php 
│   ├── employeedirectory.php          
│   └── employeeroutes.php              
│
├── js
│   └── performance.js                 
│
├── payroll
│   ├── fetch_employees.php             
│   ├── fetch_payroll.php               
│   ├── generate_payslip.php            
│   ├── payroll.css        
│   ├── payroll.js                      
│   ├── payroll.php                     
│   ├── save_payroll.php                
│   └── update_payroll.php              
│
├── performance
│   └── performance.html
│
├── time
│   ├── admin.js
│   ├── admin.php                  
│   ├── employee.js                    
│   ├── employee.php
│   ├── process_request.php           
│   ├── submit_request.php
│   └── time.css
│
├── auth.php
│
├── dashboard.php
│
├── index.php
│
├── logout.php
│
├── moderntech(final).sql
│
└── README.md                          



2. Configure the Database
-------------------------
- Import the provided `moderntech(final).sql` file into your MySQL database and run it.
- Update `db.php` with your database credentials:
  
  $host = "localhost";
  $user = "your_username";
  $password = "your_password";
  $database = "your_database_name";

  $conn = new mysqli($host, $user, $password, $database);

Files that might require your localhost root password:

db.php
fetch_employees.php
fetch_payroll.php
payroll.php
save_payroll.php
update_payroll.php


3. Start the Server
-------------------
- If using XAMPP, place the project in the `htdocs` folder and start Apache & MySQL from the XAMPP Control Panel.

4. Access the System
--------------------
Open a browser and go to:
  http://localhost/moderntech/index.php

5. Adding Users (Uncomment Code in index.php)
To add new users to the system, follow these steps:

5.1 Uncomment the User Addition Form: In index.php, there is a section of code that handles adding users. This section must be uncommented temporarily to allow user addition:

index.php:
// Uncomment this code

if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $employeeId = $row['employeeId'];
          $username = strtolower(str_replace(' ', '', $row['name'])); 
          $hashedPassword = password_hash("Default@123", PASSWORD_BCRYPT);
          $positionId = $row['positionId']; 

          // Assign the 'admin' role to the employee with the admin positionId
          $role = ($positionId == $adminPositionId) ? 'admin' : 'employee'; 

          $insertSql = "INSERT INTO users (username, password, role, employeeId) VALUES (?, ?, ?, ?)";
          $stmt = $conn->prepare($insertSql);
          $stmt->bind_param("sssi", $username, $hashedPassword, $role, $employeeId);

          if ($stmt->execute()) {
              echo "User created: $username with role: $role<br>";
          } else {
              echo "Error: " . $stmt->error . "<br>";
          }

          $stmt->close();
      }
  } else {
      echo "No new employees found.<br>";
  }

5.2. Once all users were added then you should comment out the code again

5.3. The username for each user must be the employee's full name in lowercase, but with a space between first and last names (e.g. "John Doe" becomes "johndoe").

 -The password for all users should be set as "Default@123" initially.

-Choose the role for each user:
--Admin: Full access
--Employee: Limited access based on the assigned role

Admin Credential for logging in as admin:

username : lungilemoyo
password : Default@123

Employee Credentials for logging in as an employee:
Example for employee login
username : keshavnaidoo
password : Default@123

6. Additional Notes
-The system is designed for an admin to log in and manage employees, payroll data, and time tracking. Ensure you configure proper user roles and authentication via auth.php.
-If any issues arise during setup, check the error logs to ensure all database queries and server configurations are correct.
-AJAX and JavaScript are used extensively in the frontend for smooth user experience; ensure your browser allows JavaScript execution.