<!DOCTYPE html>
<html>

<head>
  <title>Database Setup</title>
  <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .container {
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
      padding: 40px;
      text-align: center;
      max-width: 600px;
      width: 90%;
    }

    .alert {
      border-radius: 10px;
    }
  </style>
</head>

<body>
  <div class='container'>
    <h1 class='mb-4'>Database Setup</h1>
    <div class=<?php echo "'alert alert-" . ($status === 'success' ? 'success' : 'danger') . "'" ?> role='alert'>
      <?php echo $message ?>
    </div>
    <a href='/' class='btn btn-primary mt-3'>Back to Home</a>
  </div>
</body>

</html>