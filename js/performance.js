document.getElementById("performanceReviewForm").addEventListener("submit", function (event) {
    // Prevent the default form submission
    event.preventDefault(); 
  

    let employeeName = document.getElementById("employeeName").value;
    let department = document.getElementById("department").value;
    let communication = document.getElementById("communication").value;
    let productivity = document.getElementById("productivity").value;
    let comments = document.getElementById("comments").value;
  

    if (!employeeName || !communication || !productivity) {
        alert("Please fill all required fields.");
        return;
    }
  
    const newRow = document.createElement("tr");
  
    newRow.innerHTML = `
        <td>${employeeName}</td>
        <td>${department}</td>
        <td>${communication}</td>
        <td>${productivity}</td>
        <td>${comments}</td>
    `;
  
    // Append the new row to the table
    document.querySelector("#reviewsTable tbody").appendChild(newRow);
  
    document.getElementById("performanceReviewForm").reset();
  

    alert("Review submitted successfully!");
  });