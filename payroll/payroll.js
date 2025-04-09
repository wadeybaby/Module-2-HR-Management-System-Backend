
const hourly_rate = 379;
let payrollData = [];
let employeeInfo = [];
let dataLoaded = false;

// Fallback function 
function getSafeValue(value, fallback = "N/A") {
  return value !== null && value !== undefined ? value : fallback;
}
// ********************************************************************************
async function loadData() {
  try {
    const [payrollRes, employeeRes] = await Promise.all([
      fetch("../payroll/fetch_payroll.php")
        .then((response) => {
          if (!response.ok) throw new Error("Failed to fetch payroll");
          return response.json();
        })
        .then((data) => {
          if (data.status === "error") throw new Error(data.message);
          return data;
        }),
      fetch("../payroll/fetch_employees.php")
        .then((response) => {
          if (!response.ok) throw new Error("Failed to fetch employees");
          return response.json();
        })
        .then((data) => {
          if (data.status === "error") throw new Error(data.message);
          return data;
        }),
    ]);
    payrollData = payrollRes.data || [];
    employeeInfo = employeeRes.data || [];
    console.log("Payroll Data:", payrollData);
    console.log("Employee Info:", employeeInfo);
    dataLoaded = true;
    displayPayrollTable();
  } catch (error) {
    console.error("Failed to load data:", error);
    alert("Error: " + error.message); // Show user-friendly error
  }
}
// ********************************************************************************
// Function to show the payroll data table
function displayPayrollTable() {
  const tableBody = document.querySelector("#payrollTable tbody");
  if (!tableBody) return;

  tableBody.innerHTML = payrollData
    .map((payroll) => {
    
      const employee =
        employeeInfo.find((e) => e.employeeId === payroll.employeeId) || {};
      const monthlySalary = calculateSalary(
        payroll.hoursWorked,
        payroll.leaveDeductions
      );
      const annualSalary = monthlySalary * 12;
      return `
        <tr>
            <td>${getSafeValue(payroll.employeeId)}</td>
            <td>${getSafeValue(employee.name)}</td>
            <td>
                <select class="hours" data-id="${payroll.employeeId}">
                    ${generateOptions(payroll.hoursWorked, 0, 200)}
                </select>
            </td>
            <td>
                <select class="deductions" data-id="${payroll.employeeId}">
                    ${generateOptions(
                      payroll.leaveDeductions,
                      0,
                      payroll.hoursWorked
                    )}
                </select>
            </td>
            <td id="salary-${payroll.employeeId}">R ${monthlySalary.toFixed(
        2
      )}</td>
            <td id="annual-salary-${
              payroll.employeeId
            }">R ${annualSalary.toFixed(2)}</td>
            <td><button onclick="generatePayslip(${
              payroll.employeeId
            })">Generate Payslip</button></td>
        </tr>
      `;
    })
    .join("");

  addDropdownListeners();
}
// *********************************************************************************
// Function to generate options for the dropdowns
function generateOptions(selectedValue, min, max) {
  let options = "";
  for (let i = min; i <= max; i++) {
    options += `<option value="${i}" ${
      i === selectedValue ? "selected" : ""
    }>${i}</option>`;
  }
  return options;
}
// **********************************************************************************
// Function to attach listeners for real-time updates
function addDropdownListeners() {
  const hoursDropdowns = document.querySelectorAll(".hours");
  const deductionsDropdowns = document.querySelectorAll(".deductions");
 
  hoursDropdowns.forEach((dropdown) => {
    dropdown.addEventListener("change", (event) => {
      const employeeId = parseInt(event.target.dataset.id, 10);
      const newHoursWorked = parseInt(event.target.value, 10) || 0;
     
      const payroll = payrollData.find((p) => p.employeeId === employeeId);
      if (payroll) {
        payroll.hoursWorked = newHoursWorked;
        const newSalary = calculateSalary(payroll.hoursWorked, payroll.leaveDeductions);
        payroll.finalSalary = newSalary;
        document.getElementById(`salary-${employeeId}`).textContent = `R ${newSalary.toFixed(2)}`;
        savePayrollData(payroll);
      }
    });
  });

  // Attach listener for changes in leave deductions
  deductionsDropdowns.forEach((dropdown) => {
    dropdown.addEventListener("change", (event) => {
      const employeeId = parseInt(event.target.dataset.id, 10);
      const newLeaveDeductions = parseInt(event.target.value, 10) || 0;
     
      const payroll = payrollData.find((p) => p.employeeId === employeeId);
      if (payroll) {
     
        if (newLeaveDeductions > payroll.hoursWorked) {
          alert("Leave deductions cannot exceed hours worked.");
          event.target.value = payroll.leaveDeductions;
          return;
        }

payroll.leaveDeductions = newLeaveDeductions;
        const newSalary = calculateSalary(payroll.hoursWorked, payroll.leaveDeductions);
        payroll.finalSalary = newSalary;
        document.getElementById(`salary-${employeeId}`).textContent = `R ${newSalary.toFixed(2)}`;
        savePayrollData(payroll);
      }
    });
  });
}
// **************************************************************************************
  // Attach listener for changes in leave deductions
  function addDropdownListeners() {
  const hoursDropdowns = document.querySelectorAll(".hours");
  const deductionsDropdowns = document.querySelectorAll(".deductions");

  if (hoursDropdowns.length === 0 || deductionsDropdowns.length === 0) {
    console.warn("No dropdowns found for hours or deductions.");
    return;
  }
  // Attach listener for changes in hours worked
  hoursDropdowns.forEach((dropdown) => {
    dropdown.addEventListener("change", (event) => {
      const employeeId = parseInt(event.target.dataset.id, 10);
      const newHoursWorked = parseInt(event.target.value, 10) || 0;
      const payroll = payrollData.find((p) => p.employeeId === employeeId);
      if (payroll) {
        payroll.hoursWorked = newHoursWorked;
        const newSalary = calculateSalary(payroll.hoursWorked, payroll.leaveDeductions);
        payroll.finalSalary = newSalary;
        document.getElementById(`salary-${employeeId}`).textContent = `R ${newSalary.toFixed(2)}`;
        savePayrollData(payroll);
      }
    });
  });
  // Attach listener for changes in leave deductions
  deductionsDropdowns.forEach((dropdown) => {
    dropdown.addEventListener("change", (event) => {
      const employeeId = parseInt(event.target.dataset.id, 10);
      const newLeaveDeductions = parseInt(event.target.value, 10) || 0;
      const payroll = payrollData.find((p) => p.employeeId === employeeId);
      if (payroll) {
    
        if (newLeaveDeductions > payroll.hoursWorked) {
          alert("Leave deductions cannot exceed hours worked.");
          event.target.value = payroll.leaveDeductions;
          return;
        }
        payroll.leaveDeductions = newLeaveDeductions;
        const newSalary = calculateSalary(payroll.hoursWorked, payroll.leaveDeductions);
        payroll.finalSalary = newSalary;
        document.getElementById(`salary-${employeeId}`).textContent = `R ${newSalary.toFixed(2)}`;
        savePayrollData(payroll);
      }
    });
  });
}
// *******************************************************************************************
// Function to calculate the salary based on hours worked and deductions
function calculateSalary(hoursWorked, leaveDeductions) {
  const hourly_rate = 379; 
  const adjustedHours = Math.max(0, hoursWorked - leaveDeductions);
  
  const monthlySalary = adjustedHours * hourly_rate;
  
  const annualSalary = monthlySalary * 12;
  return { monthlySalary, annualSalary };
}
// ***********************************************************************************************
async function savePayrollData(payroll) {
  try {
    const response = await fetch("save_payroll.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        payrollId: payroll.payrollId, 
        employeeId: payroll.employeeId,
        hoursWorked: payroll.hoursWorked,
        leaveDeductions: payroll.leaveDeductions,
        hourlyRate: hourly_rate, 
      }),
    });
    const result = await response.json();
    if (result.status === "success") {
      console.log("Payroll data saved successfully.");
    } else {
      console.error("Error saving data:", result.message);
    }
  } catch (error) {
    console.error("Error:", error);
  }
}
// ************************************************************************************************************
// Function to fetch payroll data

async function fetchPayrollData() {
  try {
    const response = await fetch("fetch_payroll.php");
    if (!response.ok) throw new Error("HTTP error: " + response.status);
    const data = await response.json();
    if (data.status === "error") throw new Error(data.message);
    payrollData = data.data || [];
    console.log("Payroll data loaded:", payrollData);
  } catch (error) {
    console.error("Error fetching payroll data:", error);
    alert("Failed to load payroll data: " + error.message);
  }
}
// Updated fetchEmployeeInfo()
async function fetchEmployeeInfo() {
  try {
    const response = await fetch("fetch_employees.php");
    if (!response.ok) throw new Error("HTTP error: " + response.status);
    const data = await response.json();
    if (data.status === "error") throw new Error(data.message);
    employeeInfo = data.data || [];
    console.log("Employee info loaded:", employeeInfo);
  } catch (error) {
    console.error("Error fetching employee info:", error);
    alert("Failed to load employee data: " + error.message);
  }
}
// Fetch both sets of data before calling generatePayslip()
async function initializeData() {
  await fetchPayrollData();
  await fetchEmployeeInfo();
}

// Function to generate the payslip in a new tab
function generatePayslip(employeeId) {
  console.log("Generating payslip for Employee ID:", employeeId);
  console.log("Available Payroll Data:", JSON.stringify(payrollData, null, 2));

  const payroll = payrollData.find((p) => {
      console.log("Checking payroll entry:", p);
      return Number(p.employeeId) === Number(employeeId);
  });
  if (!payroll) {
      console.error("Payroll data not found for Employee ID:", employeeId);
      alert("Payroll data not found.");
      return;
  }
  console.log("Payroll found:", payroll);
 
  const payslipUrl = `generate_payslip.php?payrollId=${payroll.payrollId}`;
  window.open(payslipUrl, "_blank");
}

initializeData();
  fetch("save_payroll.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ employeeId: "1", positionId: "1" }),
  });