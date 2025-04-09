<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Performance Review Form</title>

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="../css/performance.css" />
  </head>

  <body>
    <header>
      <h1>Employee Performance Review</h1>
    </header>

    <div class="container">
      <!-- Review form -->
      <form id="performanceReviewForm">
        <!-- Employee information section -->
        <fieldset>
          <legend>Employee Information</legend>
          <label for="employeeName">Employee Name:</label>
          <input
            type="text"
            id="employeeName"
            name="employeeName"
            required
          /><br /><br />

          <label for="department">Department:</label>
          <input
            type="text"
            id="department"
            name="department"
            required
          /><br /><br />
        </fieldset>

        <!-- Performance evaluation section -->
        <fieldset>
          <legend>Performance Evaluation</legend>
          <label for="communication">Communication Skills:</label><br />
          <select id="communication" name="communication">
            <option value="Excellent">Excellent</option>
            <option value="Good">Good</option>
            <option value="Average">Average</option>
            <option value="Needs Improvement">Needs Improvement</option></select
          ><br /><br />

          <label for="productivity">Productivity:</label><br />
          <select id="productivity" name="productivity">
            <option value="Excellent">Excellent</option>
            <option value="Good">Good</option>
            <option value="Average">Average</option>
            <option value="Needs Improvement">Needs Improvement</option></select
          ><br /><br />
        </fieldset>

        <!-- Additional comments section -->
        <fieldset>
          <legend>Additional Comments</legend>
          <textarea id="comments" name="comments" rows="4" cols="50"></textarea
          ><br /><br />
        </fieldset>

        <button type="submit">Submit Review</button>
      </form>

      <!-- Table for displaying submitted reviews -->
      <h2>Submitted Reviews</h2>
      <table id="reviewsTable" class="table table-bordered">
        <thead>
          <tr>
            <th>Employee Name</th>
            <th>Department</th>
            <th>Communication Skills</th>
            <th>Productivity</th>
            <th>Comments</th>
          </tr>
        </thead>
        <tbody>
          <!-- Dynamically added rows -->
        </tbody>
      </table>
    </div>

    <!-- JavaScript for functionality -->
    <script src="../js/performance.js"></script>
  </body>
</html>