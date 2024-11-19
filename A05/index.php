<?php  
include('connect.php');

$query = "
SELECT 
    userInfo.firstname,
    userInfo.lastname,
    addresses.addressID,
    cities.cityName,
    provinces.provinceName,
    userInfo.userID, 
    userInfo.birthDate
FROM 
    userInfo
JOIN 
    addresses ON userInfo.addressID = addresses.addressID
JOIN 
    cities ON addresses.cityID = cities.cityID
JOIN 
    provinces ON addresses.provinceID = provinces.provinceID
ORDER BY 
    userInfo.userID;
";

$result = executeQuery($query);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Information</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="shared/css/style.css">
  <style>
    body {
      background-color: #f5f5f5; 
      font-family: 'Helvetica Neue', Arial, sans-serif;
      color: #333;
    }
    .container {
      max-width: 800px; 
      margin: auto;
      padding: 20px;
    }
    .header {
      text-align: center;
      margin-bottom: 40px;
    }
    h1 {
      font-size: 40px;
      font-weight: bold;
      color: #333;
    }
    .card {
      background-color: #fff;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      margin-bottom: 20px; 
      padding: 20px;
      transition: box-shadow 0.3s;
    }
    .card:hover {
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .card-title {
      font-size: 24px;
      margin-bottom: 10px;
      color: #007bff; 
    }
    .card-text {
      font-size: 16px;
      margin: 5px 0;
      line-height: 1.5;
    }

    .header {
      background-color: #0d6efd; 
      width: 100%;
      padding: 10px;
      text-align: center;
      margin-bottom: 40px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      color: white;
    }
    .no-data {
      text-align: center;
      font-size: 19px;
      color: #777;
      margin-top: 20px;
    }
  </style>
</head>

<body>
<div class="container-fluid header color:white;">
      <h1>User Information</h1>
    </div>
  <div class="container">
    <div class="row">
      <?php
      if (mysqli_num_rows($result) > 0) {
        while ($user = mysqli_fetch_assoc($result)) {
      ?>
          <div class="col-12 col-md-6">
            <div class="card">
              <h5 class="card-title">User ID: <?php echo $user['userID']?></h5>
              <p class="card-text"><strong>First Name:</strong> <?php echo $user['firstname']?></p>
              <p class="card-text"><strong>Last Name:</strong> <?php echo $user['lastname']?></p>
              <p class="card-text"><strong>City:</strong> <?php echo $user['cityName']?></p>
              <p class="card-text"><strong>Province:</strong> <?php echo $user['provinceName']?></p>
              <p class="card-text"><strong>Birthday:</strong> <?php echo $user['birthDate']?></p>
            </div>
          </div>
      <?php
        }
      } else {
        echo "<p class='no-data'>No user information available.</p>";
      }
      ?>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
