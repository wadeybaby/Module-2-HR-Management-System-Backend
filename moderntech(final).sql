CREATE SCHEMA `moderntech` ;
USE moderntech ;

CREATE TABLE Departments (
    departmentId INT AUTO_INCREMENT PRIMARY KEY,
    departmentName VARCHAR(100) NOT NULL
);

INSERT INTO `moderntech`.`departments` (`departmentName`) VALUES ('Development');
INSERT INTO `moderntech`.`departments` (`departmentName`) VALUES ('HR');
INSERT INTO `moderntech`.`departments` (`departmentName`) VALUES ('QA');
INSERT INTO `moderntech`.`departments` (`departmentName`) VALUES ('Sales');
INSERT INTO `moderntech`.`departments` (`departmentName`) VALUES ('Marketing');
INSERT INTO `moderntech`.`departments` (`departmentName`) VALUES ('Design');
INSERT INTO `moderntech`.`departments` (`departmentName`) VALUES ('IT');
INSERT INTO `moderntech`.`departments` (`departmentName`) VALUES ('Finance');
INSERT INTO `moderntech`.`departments` (`departmentName`) VALUES ('Support');

CREATE TABLE Positions (
    positionId INT AUTO_INCREMENT PRIMARY KEY,
    positionName VARCHAR(100) NOT NULL
);

INSERT INTO `moderntech`.`positions` (`positionName`) VALUES ('Software Engineer');
INSERT INTO `moderntech`.`positions` (`positionName`) VALUES ('HR Manager');
INSERT INTO `moderntech`.`positions` (`positionName`) VALUES ('Quality Analyst');
INSERT INTO `moderntech`.`positions` (`positionName`) VALUES ('Sales Representative');
INSERT INTO `moderntech`.`positions` (`positionName`) VALUES ('Marketing Specialist');
INSERT INTO `moderntech`.`positions` (`positionName`) VALUES ('UI/UX Designer');
INSERT INTO `moderntech`.`positions` (`positionName`) VALUES ('DevOps Engineer ');
INSERT INTO `moderntech`.`positions` (`positionName`) VALUES ('Content Strategist');
INSERT INTO `moderntech`.`positions` (`positionName`) VALUES ('Accountant');
INSERT INTO `moderntech`.`positions` (`positionName`) VALUES ('Customer Support Lead');

CREATE TABLE Employees (
    employeeId INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    positionId INT,
    departmentId INT,
    salary DECIMAL(10, 2),
    contact VARCHAR(100),
	previousPositionStartYear YEAR NOT NULL,
    previousPositionEndYear YEAR NULL,
    FOREIGN KEY (positionId) REFERENCES Positions(positionId),
    FOREIGN KEY (departmentId) REFERENCES Departments(departmentId)
);

INSERT INTO `moderntech`.`employees` (`name`, `salary`, `contact`, `previousPositionStartYear`,`previousPositionEndYear`) VALUES ('Sibongile Nkosi', '70000', 'sibongile.nkosi@moderntech.com','2015', '2018');
INSERT INTO `moderntech`.`employees` (`name`, `salary`, `contact`, `previousPositionStartYear`,`previousPositionEndYear`) VALUES ('Lungile Moyo', '80000', 'lungile.moyo@moderntech.com', '2013', '2017');
INSERT INTO `moderntech`.`employees` (`name`, `salary`, `contact`, `previousPositionStartYear`,`previousPositionEndYear`) VALUES ('Thabo Molefe', '55000', 'thabo.molefe@moderntech.com','2018',NULL);
INSERT INTO `moderntech`.`employees` (`name`, `salary`, `contact`,`previousPositionStartYear`,`previousPositionEndYear`) VALUES ('Keshav Naidoo', '60000', 'keshav.naidoo@moderntech.com','2020',NULL);
INSERT INTO `moderntech`.`employees` (`name`, `salary`, `contact`,`previousPositionStartYear`,`previousPositionEndYear`) VALUES ('Zanele Khumalo', '58000', 'zanele.khumalo@moderntech.com','2019',NULL);
INSERT INTO `moderntech`.`employees` (`name`, `salary`, `contact`,`previousPositionStartYear`,`previousPositionEndYear`) VALUES ('Sipho Zulu', '65000', 'sipho.zulu@moderntech.com','2016',NULL);
INSERT INTO `moderntech`.`employees` (`name`, `salary`, `contact`,`previousPositionStartYear`,`previousPositionEndYear`) VALUES ('Naledi Moeketsi', '72000', 'naledi.moeketsi@moderntech.com','2017',NULL);
INSERT INTO `moderntech`.`employees` (`name`, `salary`, `contact`,`previousPositionStartYear`,`previousPositionEndYear`) VALUES ('Farai Gumbo', '56000', 'farai.gumbo@moderntech.com','2021',NULL);
INSERT INTO `moderntech`.`employees` (`name`, `salary`, `contact`,`previousPositionStartYear`,`previousPositionEndYear`) VALUES ('Karabo Dlamini', '62000','karabo.dlamini@moderntech.com','2018',NULL);
INSERT INTO `moderntech`.`employees` (`name`, `salary`, `contact`,`previousPositionStartYear`,`previousPositionEndYear`) VALUES ('Fatima Patel', '58000','fatima.patel@moderntech.com','2016',NULL);

UPDATE `moderntech`.`employees` SET `positionId` = '1', `departmentId` = '1' WHERE (`employeeId` = '1');
UPDATE `moderntech`.`employees` SET `positionId` = '2', `departmentId` = '2' WHERE (`employeeId` = '2');
UPDATE `moderntech`.`employees` SET `positionId` = '3', `departmentId` = '3' WHERE (`employeeId` = '3');
UPDATE `moderntech`.`employees` SET `positionId` = '4', `departmentId` = '4' WHERE (`employeeId` = '4');
UPDATE `moderntech`.`employees` SET `positionId` = '5', `departmentId` = '5' WHERE (`employeeId` = '5');
UPDATE `moderntech`.`employees` SET `positionId` = '6', `departmentId` = '6' WHERE (`employeeId` = '6');
UPDATE `moderntech`.`employees` SET `positionId` = '7', `departmentId` = '7' WHERE (`employeeId` = '7');
UPDATE `moderntech`.`employees` SET `positionId` = '8', `departmentId` = '5' WHERE (`employeeId` = '8');
UPDATE `moderntech`.`employees` SET `positionId` = '9', `departmentId` = '8' WHERE (`employeeId` = '9');
UPDATE `moderntech`.`employees` SET `positionId` = '10', `departmentId` = '9' WHERE (`employeeId` = '10');



CREATE TABLE Payroll (
    payrollId INT AUTO_INCREMENT PRIMARY KEY,
    employeeId INT,
    hoursWorked INT,
    leaveDeductions INT,
    finalSalary DECIMAL(10, 2),
    FOREIGN KEY (employeeId) REFERENCES Employees(employeeId)
);

INSERT INTO `moderntech`.`payroll` (`hoursWorked`, `leaveDeductions`, `finalSalary`) VALUES ('160', '8', '69500');
INSERT INTO `moderntech`.`payroll` (`hoursWorked`, `leaveDeductions`, `finalSalary`) VALUES ('150', '10', '79000');
INSERT INTO `moderntech`.`payroll` (`hoursWorked`, `leaveDeductions`, `finalSalary`) VALUES ('170', '4', '54800');
INSERT INTO `moderntech`.`payroll` (`hoursWorked`, `leaveDeductions`, `finalSalary`) VALUES ('165', '6', '59700');
INSERT INTO `moderntech`.`payroll` (`hoursWorked`, `leaveDeductions`, `finalSalary`) VALUES ('158', '5', '57850');
INSERT INTO `moderntech`.`payroll` (`hoursWorked`, `leaveDeductions`, `finalSalary`) VALUES ('168', '2', '64800');
INSERT INTO `moderntech`.`payroll` (`hoursWorked`, `leaveDeductions`, `finalSalary`) VALUES ('175', '3', '71800');
INSERT INTO `moderntech`.`payroll` (`hoursWorked`, `leaveDeductions`, `finalSalary`) VALUES ('160', '0', '56000');
INSERT INTO `moderntech`.`payroll` (`hoursWorked`, `leaveDeductions`, `finalSalary`) VALUES ('155', '5', '61500');
INSERT INTO `moderntech`.`payroll` (`hoursWorked`, `leaveDeductions`, `finalSalary`) VALUES ('162', '4', '57750');

UPDATE `moderntech`.`payroll` SET `employeeId` = '1' WHERE (`payrollId` = '1');
UPDATE `moderntech`.`payroll` SET `employeeId` = '2' WHERE (`payrollId` = '2');
UPDATE `moderntech`.`payroll` SET `employeeId` = '3' WHERE (`payrollId` = '3');
UPDATE `moderntech`.`payroll` SET `employeeId` = '4' WHERE (`payrollId` = '4');
UPDATE `moderntech`.`payroll` SET `employeeId` = '5' WHERE (`payrollId` = '5');
UPDATE `moderntech`.`payroll` SET `employeeId` = '6' WHERE (`payrollId` = '6');
UPDATE `moderntech`.`payroll` SET `employeeId` = '7' WHERE (`payrollId` = '7');
UPDATE `moderntech`.`payroll` SET `employeeId` = '8' WHERE (`payrollId` = '8');
UPDATE `moderntech`.`payroll` SET `employeeId` = '9' WHERE (`payrollId` = '9');
UPDATE `moderntech`.`payroll` SET `employeeId` = '10' WHERE (`payrollId` = '10');


CREATE TABLE Attendance (
    attendanceId INT AUTO_INCREMENT PRIMARY KEY,
    employeeId INT,
    date DATE,
    status ENUM('Present', 'Absent', 'Leave') NOT NULL,
    FOREIGN KEY (employeeId) REFERENCES Employees(employeeId)
);

INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('1', '2024-11-25', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('1', '2024-11-26', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('1', '2024-11-27', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('1', '2024-11-28', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('1', '2024-11-29', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('2', '2024-11-25', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('2', '2024-11-26', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('2', '2024-11-27', 'Absent');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('2', '2024-11-28', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('2', '2024-11-29', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('3', '2024-11-25', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('3', '2024-11-26', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('3', '2024-11-27', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('3', '2024-11-28', 'Absent');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('3', '2024-11-29', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('4', '2024-11-25', 'Absent');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('4', '2024-11-26', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('4', '2024-11-27', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('4', '2024-11-28', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('4', '2024-11-29', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('5', '2024-11-25', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('5', '2024-11-26', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('5', '2024-11-27', 'Absent');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('5', '2024-11-28', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('5', '2024-11-29', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('6', '2024-11-25', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('6', '2024-11-26', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('6', '2024-11-27', 'Absent');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('6', '2024-11-28', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('6', '2024-11-29', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('7', '2024-11-25', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('7', '2024-11-26', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('7', '2024-11-27', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('7', '2024-11-28', 'Absent');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('7', '2024-11-29', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('8', '2024-11-25', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('8', '2024-11-26', 'Absent');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('8', '2024-11-27', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('8', '2024-11-28', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('8', '2024-11-29', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('9', '2024-11-25', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('9', '2024-11-26', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('9', '2024-11-27', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('9', '2024-11-28', 'Absent');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('9', '2024-11-29', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('10', '2024-11-25', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('10', '2024-11-26', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('10', '2024-11-27', 'Absent');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('10', '2024-11-28', 'Present');
INSERT INTO `moderntech`.`attendance` (`employeeId`, `date`, `status`) VALUES ('10', '2024-11-29', 'Present');


CREATE TABLE LeaveRequests (
    leaveRequestId INT AUTO_INCREMENT PRIMARY KEY,
    employeeId INT,
    date DATE,
    reason VARCHAR(255),
    status ENUM('Approved', 'Denied', 'Pending') NOT NULL,
    FOREIGN KEY (employeeId) REFERENCES Employees(employeeId)
);

INSERT INTO `moderntech`.`leaverequests` (`employeeId`, `date`, `reason`, `status`) VALUES ('1', '2024-11-22', 'Sick Leave', 'Approved');
INSERT INTO `moderntech`.`leaverequests` (`employeeId`, `date`, `reason`, `status`) VALUES ('1', '2024-12-01', 'Personal', 'Pending');
INSERT INTO `moderntech`.`leaverequests` (`employeeId`, `date`, `reason`, `status`) VALUES ('2', '2024-11-15', 'Family Responsibility', 'Denied');
INSERT INTO `moderntech`.`leaverequests` (`employeeId`, `date`, `reason`, `status`) VALUES ('2', '2024-12-02', 'Vacation', 'Approved');
INSERT INTO `moderntech`.`leaverequests` (`employeeId`, `date`, `reason`, `status`) VALUES ('3', '2024-11-10', 'Medical Appointment', 'Approved');
INSERT INTO `moderntech`.`leaverequests` (`employeeId`, `date`, `reason`, `status`) VALUES ('3', '2024-12-05', 'Personal', 'Pending');
INSERT INTO `moderntech`.`leaverequests` (`employeeId`, `date`, `reason`, `status`) VALUES ('4', '2024-11-20', 'Bereavment', 'Approved');
INSERT INTO `moderntech`.`leaverequests` (`employeeId`, `date`, `reason`, `status`) VALUES ('5', '2024-12-01', 'Childcare', 'Pending');
INSERT INTO `moderntech`.`leaverequests` (`employeeId`, `date`, `reason`, `status`) VALUES ('6', '2024-11-18', 'Sick Leave', 'Approved');
INSERT INTO `moderntech`.`leaverequests` (`employeeId`, `date`, `reason`, `status`) VALUES ('7', '2024-11-22', 'Vacation', 'Pending');
INSERT INTO `moderntech`.`leaverequests` (`employeeId`, `date`, `reason`, `status`) VALUES ('8', '2024-12-02', 'Medical Appointment', 'Approved');
INSERT INTO `moderntech`.`leaverequests` (`employeeId`, `date`, `reason`, `status`) VALUES ('9', '2024-11-19', 'Childcare', 'Denied');
INSERT INTO `moderntech`.`leaverequests` (`employeeId`, `date`, `reason`, `status`) VALUES ('10', '2024-12-03', 'Vacation', 'Pending');


CREATE TABLE `moderntech`.`users` (
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin', 'employee') NOT NULL,
  `employeeId` INT NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  INDEX `users_ibfk_1_idx` (`employeeId` ASC) VISIBLE,
  CONSTRAINT `users_ibfk_1`
    FOREIGN KEY (`employeeId`)
    REFERENCES `moderntech`.`employees` (`employeeId`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT);

