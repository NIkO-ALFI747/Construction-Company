<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My CI App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Inter', sans-serif; /* Using Inter font as per instructions */
      background-color: #f8f9fa; /* Light background */
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh; /* Full viewport height */
      margin: 0;
    }
    .container {
      background-color: #ffffff;
      border-radius: 15px; /* More rounded corners */
      box-shadow: 0 8px 16px rgba(0,0,0,0.15); /* More pronounced shadow */
      padding: 40px;
      text-align: center;
      max-width: 500px; /* Max width for better readability */
      width: 90%; /* Fluid width */
    }
    h1 {
      color: #0d6efd; /* Bootstrap primary color */
      margin-bottom: 20px;
    }
    .btn {
      border-radius: 8px; /* Slightly more rounded buttons */
      padding: 12px 25px;
      font-size: 1.1em;
      transition: all 0.3s ease; /* Smooth transitions for hover effects */
    }
    .btn-success:hover {
      transform: translateY(-2px); /* Slight lift on hover */
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    #output {
      margin-top: 20px;
      font-size: 1.2em;
      color: #6c757d; /* Muted text color */
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="text-primary">Hello from CodeIgniter + Bootstrap!</h1>
    <button id="clickBtn" class="btn btn-success mt-3">Click Me</button>
    <p id="output" class="mt-3"></p>
    <hr class="my-4">
    <p>To initialize the database, visit:</p>
    <a href="/setup/seed" class="btn btn-info mt-2">Set up Database</a>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Ensure jQuery is loaded before using $
      if (typeof jQuery != 'undefined') {
        $('#clickBtn').on('click', function() {
          $('#output').text('You clicked the button!');
        });
      } else {
        console.error("jQuery not loaded!");
      }
    });
  </script>
</body>
</html>
