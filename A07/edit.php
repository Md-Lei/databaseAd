<?php
include('connect.php');

if (isset($_GET['userID'])) {
    $userID = $_GET['userID'];
    $query = "SELECT * FROM userInfo WHERE userID = '$userID'";
    $result = executeQuery($query);
    $user = mysqli_fetch_assoc($result);
}

if (isset($_POST['btnUpdateUser'])) {
    $userID = $_POST['userID'];
    $firstname = $_POST['firstname'];
    $lastName = $_POST['lastName'];
    $birthDate = $_POST['birthDate'];
    $addressID = $_POST['addressID'];

    $updateQuery = "
    UPDATE userInfo 
    SET firstname = '$firstname', lastName = '$lastName', birthDate = '$birthDate', addressID = '$addressID' 
    WHERE userID = '$userID'
  ";
    executeQuery($updateQuery);
    header("Location: index.php");
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            text-align: center;
            margin-bottom: 40px;
            background-color: #864af9;
            width: 100%;
            padding: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            color: white;
        }
    </style>
</head>

<body>
    <div class="container-fluid header">
        <h1>Edit Information</h1>
    </div>
    <div class="container">
        <form method="POST" action="">
            <input type="hidden" name="userID" value="<?php echo $user['userID']; ?>">
            <div class="mb-3"><label for="firstname" class="form-label">First Name</label><input type="text"
                    class="form-control" id="firstname" name="firstname" value="<?php echo $user['firstname']; ?>"
                    required></div>
            <div class="mb-3"><label for="lastName" class="form-label">Last Name</label><input type="text"
                    class="form-control" id="lastName" name="lastName" value="<?php echo $user['lastName']; ?>"
                    required></div>
            <div class="mb-3"><label for="birthDate" class="form-label">Birth Date</label><input type="date"
                    class="form-control" id="birthDate" name="birthDate" value="<?php echo $user['birthDate']; ?>"
                    required></div>
            <div class="mb-3"><label for="addressID" class="form-label">Address ID</label><input type="number"
                    class="form-control" id="addressID" name="addressID" value="<?php echo $user['addressID']; ?>"
                    required></div>
            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" name="btnUpdateUser" class="btn btn-primary">Update User</button>
            </div>


        </form>
        <div class=" card p-4 mt-4">
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
</body>

</html>