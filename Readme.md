ModernTech Solutions HR Management System - Backend (Module 2)


This is the backend for the ModernTech Solutions HR Management System, built using PHP and MySQLi. It manages employee data, payroll, time tracking, and performance. The system handles employee records, salary calculations, attendance, leave requests, and generates payslips. It also includes secure authentication and an admin dashboard for managing all modules. AJAX and real-time updates ensure smooth user interactions.

(Visit our frontend here)
Login username: HR, password: admin123*

## Table of Contents
- [Live Demo](#live-demo)
- [Technologies Used](#technologies-used)
- [Setup Instructions](#setup-instructions)
- [File Structure](#file-structure)
- [Key Features](#key-features)
- [Credits](#credits)
- [Authors](#authors)

## Live Demo
Link to live deployed website

## Technologies Used
* Back-end: PHP (Version 7.4 or later recommended), MySQLi

* Front-end: HTML, JavaScript, AJAX

* Styling: Custom CSS

* Server: Apache (e.g., XAMPP)

## Setup Instructions
Follow these steps to run the HR system backend locally:

## Prerequisites:

* PHP (Version 7.4 or later recommended)

* MySQL Database

* Apache or any local server (e.g., XAMPP)

1. **Clone or Download the Project:**
git clone https://github.com/Zainunesa/Module-2.git
cd Module-2

3. **Configure the Database:**

* Import the provided moderntech(final).sql file into your MySQL database and run it.

* Update database/db.php with your database credentials:

$host = "localhost";
$user = "your_username";
$password = "your_password";
$database = "your_database_name";
$conn = new mysqli($host, $user, $password, $database);

4. **Start the Server:**

* If using XAMPP, place the project in the htdocs folder and start Apache & MySQL from the XAMPP Control Panel.

5. **Access the System:**

* Open a browser and go to:

http://localhost/moderntech/index.php

Adding Users (Uncomment Code in index.php): To add new users to the system, follow these steps:

6.1. **Uncomment the User Addition Form:** In index.php, uncomment the section of code that handles adding users temporarily.

6.2. **User Credentials:**

* The username for each user must be the employee's full name in lowercase (e.g., "John Doe" becomes "johndoe").

* The password for all users should be set as "Default@123" initially.

* Assign roles based on the employee's position (admin or employee).

**Admin Credentials:**

* Username: lungilemoyo

* Password: Default@123

**Employee Example:**

* Username: keshavnaidoo

* Password: Default@123

## File Structure:

MODERNTECH
├── assets
├── css
├── database
├── employeedata
├── js
├── payroll
├── performance
├── time
├── auth.php
├── dashboard.php
├── index.php
├── logout.php
├── moderntech(final).sql
└── README.md
Additional Notes:

The system is designed for an admin to log in and manage employees, payroll data, and time tracking. Ensure proper user roles and authentication via auth.php.

If any issues arise during setup, check the error logs to ensure all database queries and server configurations are correct.

AJAX and JavaScript are used for a smooth user experience, so make sure JavaScript is enabled in your browser.

## Key Features
This HR management system backend includes:

Employee Management: Manage employee records and create new entries.

Payroll Management: Handle salary data and generate payslips.

Time Tracking: Manage employee attendance and time-off requests.

Authentication: Secure login and role-based access (Admin and Employee).

Admin Dashboard: Overview of employee data, payroll, and time tracking.

AJAX Integration: Real-time updates for a smooth user experience.

## Credits
PHP/MySQLi for the backend

HTML/CSS/JS for frontend and AJAX integration

## Authors
Wade Britz

Zainunesa Magmoed

Rafiek Booysen

Sinoyolo Ngavu
