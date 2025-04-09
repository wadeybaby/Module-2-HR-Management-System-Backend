// *****************************************************************************************************************
let employeeData = []; 

// Fetching Employees
async function fetchEmployees() {
  try {
    const response = await fetch(
      "http://localhost/moderntech/employeedata/employeedata.php"
    );

    if (!response.ok) {
      throw new Error(
        `Network response was not ok. Status: ${response.status}`
      );
    }

    const data = await response.json();

    console.log("Fetched Data:", data);

    if (data.status === "success" && Array.isArray(data.employees)) {
      employeeData = data.employees; 
      renderEmployees(employeeData); 
    } else {
      throw new Error("Employee data is not in the expected format.");
    }
  } catch (error) {
    console.error("Error fetching employee data:", error);
    document.getElementById(
      "data-container"
    ).innerHTML = `<p class='text-danger'>Failed to fetch employee data: ${error.message}</p>`;
  }
}

window.onload = fetchEmployees;
// ***************************************************************************************************************
// Render employees in the UI
function renderEmployees(employees) {
  let container = document.getElementById("data-container");
  container.innerHTML = "";

  if (employees.length === 0) {
    container.innerHTML =
      "<p class='text-warning'>No employees to display.</p>";
    return;
  }

  employees.forEach((item) => {
    let card = document.createElement("div");
    card.className = "card m-2";
    card.innerHTML = `
      <div class="card-body">
        <h4 class="card-title"><strong>Name:</strong> ${item.name}</h4>
        <hr>
        <p class="card-text"><strong>Employee ID:</strong> ${item.employeeId}</p>
        <p class="card-text"><strong>Position ID:</strong> ${item.positionId}</p>
        <p class="card-text"><strong>Department ID:</strong> ${item.departmentId}</p>
        <p class="card-text"><strong>Salary:</strong> R ${item.salary}</p>
        <p class="card-text"><strong>Employment Start Year:</strong> ${item.previousPositionStartYear}</p>
        <p class="card-text"><strong>Contact:</strong> ${item.contact}</p>
        <div class="d-flex justify-content-between mt-3">
          <button class="btn btn-light" onclick="deleteEmployee(${item.employeeId})">Delete</button>
        </div>
      </div>
    `;
    container.appendChild(card);
  });
}
// *********************************************************************************************************************
// Adding Employee
document
  .getElementById("addEmployeeForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); 

    const formData = new FormData(this);

    fetch("createemployee.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.text())
      .then((rawResponse) => {
        console.log("Raw Response:", rawResponse);
        return JSON.parse(rawResponse); 
      })
      .then((data) => {
        if (data.status === "success") {
          alert(data.message);
          this.reset(); 
        } else {
          alert(data.message); 
        }
      })
      .catch((error) => {
        console.error("Error:", error);
        alert("An error occurred while adding the employee.");
      });
  });
// *********************************************************************************************************************
// Delete employee
async function deleteEmployee(employeeId) {
  if (confirm("Are you sure you want to delete this employee?")) {
    try {
      const response = await fetch(
        `http://localhost/moderntech/employeedata/employeeroutes.php?action=deleteEmployee&id=${employeeId}`,
        { method: "GET" } // Change to GET for consistency
      );

      // Log the raw response for debugging
      const rawResponse = await response.text();
      console.log("Raw Response:", rawResponse);

      if (!response.ok) {
        throw new Error(
          "Failed to delete employee. Server responded with an error."
        );
      }

      const data = JSON.parse(rawResponse); // Parse the response as JSON
      if (data.status === "success") {
        alert(data.message);
        fetchEmployees(); // Refresh the employee list
      } else {
        alert("Error deleting employee: " + data.message);
      }
    } catch (error) {
      alert("Error: " + error.message);
      console.error("Error deleting employee:", error);
    }
  }
}
// **********************************************************************************************************************
// Search employees locally
function searchEmployee() {
  let searchInput = document
    .getElementById("searchInput")
    .value.trim()
    .toLowerCase();
  let resultsContainer = document.getElementById("data-container");

  if (!searchInput) {
    renderEmployees(employeeData); // Show all employees if search input is empty
    return;
  }

  // Filter employees based on search input
  const filteredEmployees = employeeData.filter((employee) => {
    return employee.employeeId.toString() == searchInput;
  });

  if (filteredEmployees.length === 0) {
    resultsContainer.innerHTML = `<p class='text-warning'>No employees found.</p>`;
  } else {
    renderEmployees(filteredEmployees); // Render filtered employees
  }
}
// *******************************************************************************************************************