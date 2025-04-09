$(document).ready(function () {
  $("#timeOffForm").submit(function (event) {
    event.preventDefault();

    // Get form data
    let employeeID = $("#employeeId").val();
    let date = $("#date").val();
    let reason = $("#reason").val();

    // Create a new request object to send to PHP
    let formData = {
      employeeId: employeeID,
      date: date,
      reason: reason,
    };

    // Submit data to the server using AJAX
    $.ajax({
      url: "submit_request.php",
      type: "POST",
      data: formData,
      success: function (response) {
        alert(response); 
        $("#timeOffForm")[0].reset(); 
      },
      error: function () {
        alert("An error occurred while submitting your request.");
      },
    });
  });
});
