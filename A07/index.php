<?php
include('connect.php');

if (isset($_POST['btnAddNewInfo'])) {
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $birthDate = $_POST['birthDate'];
  $addressID = $_POST['addressID'];

  $result = mysqli_query($conn, "SELECT MAX(userID) AS maxID FROM userInfo");
  $row = mysqli_fetch_assoc($result);
  $maxUserID = $row['maxID'];

  $newUserID = $maxUserID ? $maxUserID + 1 : 1;

  $insertQuery = "
    INSERT INTO userInfo (userID, firstname, lastname, birthDate, addressID)
    VALUES ('$newUserID','$firstname', '$lastname', '$birthDate', '$addressID')
  ";
  executeQuery($insertQuery);
}

if (isset($_POST['btnDeleteUser'])) {
  $userID = $_POST['userID'];
  $deleteQuery = "DELETE FROM userInfo WHERE userID = '$userID'";
  executeQuery($deleteQuery);
}

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
    firstname;
";

$result = executeQuery($query);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Information</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f5f5;
      font-family: 'Helvetica Neue', Arial, sans-serif;
      color: #333;
    }

    .container {
      max-width: 1200px;
      margin: auto;
      padding: 20px;
    }

    .header {
      text-align: center;
      margin-bottom: 40px;
      background-color: #864af9;
      width: 100%;
      padding: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      color: white;
    }

    h1 {
      font-size: 40px;
      font-weight: bold;
    }

    .card {
      background-color: #fff;
      border: 1px solid #e0e0e0;
      border-radius: 8px;
      margin-bottom: 20px;
      padding: 20px;
      transition: box-shadow 0.3s ease, transform 0.3s ease, color 0.3s ease, background-color 0.3s ease;
    }

    .card:hover {
      color: #ffe9b1;
      background-color: #3b3486;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
      transform: translateY(-5px);
    }

    .address-list li {
      transition: color 0.3s ease;
    }

    .card:hover .address-list li {
      color: #ffe9b1;
    }

    .address-list {
      font-size: 16px;
      color: #333;
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

    .no-data {
      text-align: center;
      font-size: 19px;
      color: #777;
      margin-top: 20px;
    }

    .address-list {
      font-size: 16px;
      color: #333;
    }

    body {
      background-color: rgba(255, 233, 177, 0.2);
    }
  </style>
</head>

<body>
  <div class="container-fluid header">
    <h1>User Information</h1>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card mb-4">
          <div class="card-body">
            <h5 class="card-title">Add New User</h5>
            <form method="POST" action="">
              <div class="mb-3"><label for="firstname" class="form-label">First Name</label><input type="text"
                  class="form-control" id="firstname" name="firstname" required></div>
              <div class="mb-3"><label for="lastname" class="form-label">Last Name</label><input type="text"
                  class="form-control" id="lastname" name="lastname" required></div>
              <div class="mb-3"><label for="birthDate" class="form-label">Birth Date</label><input type="date"
                  class="form-control" id="birthDate" name="birthDate" required></div>
              <div class="mb-3"><label for="addressID" class="form-label">Address ID</label><input type="number"
                  class="form-control" id="addressID" name="addressID" required></div>
              <button type="submit" name="btnAddNewInfo" class="btn btn-primary">Add User</button>
            </form>
            <div class="mt-4">
              <h6>Available Address IDs:</h6>
              <ul class="address-list">
                <li>17 - Tanauan City, Batangas</li>
                <li>18 - Lipa City, Batangas</li>
                <li>19 - Dasmarinas, Cavite</li>
                <li>20 - Bacoor, Cavite</li>
                <li>21 - Lucena City, Quezon</li>
                <li>22 - Tayabas City, Quezon</li>
                <li>23 - Santa Rosa, Laguna</li>
                <li>24 - Calamba, Laguna</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="row">
          <?php if (mysqli_num_rows($result) > 0) {
            while ($client = mysqli_fetch_assoc($result)) { ?>
              <div class="col-12 col-md-6">
                <div class="card">
                  <p class="card-text"><strong>First Name:</strong> <?php echo $client['firstname'] ?></p>
                  <p class="card-text"><strong>Last Name:</strong> <?php echo $client['lastname'] ?></p>
                  <p class="card-text"><strong>City:</strong> <?php echo $client['cityName'] ?></p>
                  <p class="card-text"><strong>Province:</strong> <?php echo $client['provinceName'] ?></p>
                  <p class="card-text"><strong>Birthday:</strong> <?php echo $client['birthDate'] ?></p>

                  <span>
                    <a href="edit.php?userID=<?php echo $client['userID']; ?>" class="btn btn-secondary"
                      style="margin-top: 10px; padding: 6px 12px; display: inline-block;">Edit</a>
                  </span>

                  <form method="POST" action="" style="margin-top: 10px;">
                    <input type="hidden" name="userID" value="<?php echo $client['userID']; ?>">
                    <button type="submit" name="btnDeleteUser" class="btn btn-danger">Delete User</button>
                  </form>

                </div>
              </div>
            <?php }
          } else {
            echo "<p class='no-data'>No user information available.</p>";
          } ?>
        </div>
      </div>
    </div>
  </div>
</body>

</html>