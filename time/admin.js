document.addEventListener("DOMContentLoaded", function () {
  const pendingRequestsTable = document.querySelector("#pendingRequests tbody");

  // Approve/Deny button event listeners
  pendingRequestsTable.addEventListener("click", function (event) {
    if (event.target.tagName === "BUTTON") {
      event.preventDefault();
      const button = event.target;
      const form = button.closest("form");
      const formData = new FormData(form);

      formData.append(button.name, button.value);

      fetch("process_request.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.text()) 
        .then((text) => {
          console.log("Raw Response:", text); 
          try {
            return JSON.parse(text); 
          } catch (error) {
            throw new Error("Invalid JSON response: " + text);
          }
        })
        .then((data) => {
          console.log("Parsed JSON:", data); 

          if (data.success) {
            const row = button.closest("tr");
            row.remove();
            showMessage(
              `The request was ${data.status.toLowerCase()}.`,
              "success"
            );
          } else {
            showMessage(`Error: ${data.error}`, "danger");
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          showMessage(`Error: ${error.message}`, "danger");
        });
    }
  });

  // Function to display messages
  function showMessage(message, type) {
    const msgDiv = document.createElement("div");
    msgDiv.className = `alert alert-${type}`;
    msgDiv.textContent = message;
    document.querySelector(".container").prepend(msgDiv);
    setTimeout(() => {
      msgDiv.remove();
    }, 3000);
  }
});
