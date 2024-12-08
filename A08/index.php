<?php
include("connect.php");


$airlineNameFilter = $_GET['airlineName'];
$aircraftTypeFilter = $_GET['aircraftType'];
$sort = $_GET['sort'];
$order = $_GET['order'];

$airportQuery = "SELECT pilotName, aircraftType, flightNumber, departureDatetime, arrivalDatetime, flightDurationMinutes, airlineName, passengerCount FROM flightlogs";

if ($airlineNameFilter != '' || $aircraftTypeFilter != '') {
    $airportQuery = $airportQuery ." WHERE";

    if ($airlineNameFilter != '') {
        $airportQuery = $airportQuery . " airlineName='$airlineNameFilter'";
    }

    if ($airlineNameFilter != '' && $aircraftTypeFilter != '') {
        $airportQuery = $airportQuery . " AND";
    }

    if ($aircraftTypeFilter != '') {
        $airportQuery = $airportQuery . " aircraftType='$aircraftTypeFilter'";
    }
}

if ($sort != '') {
    $airportQuery = $airportQuery . " ORDER BY $sort";

    if ($order != '') {
        $airportQuery = $airportQuery . " $order";
    }
}

$airportResults = executeQuery($airportQuery);

$airlineQuery = "SELECT DISTINCT(airlineName) FROM flightlogs";
$airlineResults = executeQuery($airlineQuery);

$aircraftQuery = "SELECT DISTINCT(aircraftType) FROM flightlogs";
$aircraftResults = executeQuery($aircraftQuery);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Airport Logs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            text-align: center;
        }

        h1 {
            font-family: "Raleway", Arial, sans-serif;
            letter-spacing: 6px;
        }

        select {
            text-align: center;
            display: flex;
            height: auto;
        }

        select:hover {
            border-color: #007bff;
            color: #000;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            transform: scale(1.02);
        }
    </style>
</head>

<body>

    <h1 class="top-bar text-white text-left py-4" style="background-color:#000000;"><strong>
            PUP AIRPORT
        </strong>
     </h1>

    <div class="container">
        <div class="row my-5">
            <div class="col-12">
                <form>
                    <div class="card p-4 rounded-5">
                        <div class="h5">
                            Filter
                        </div>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-md-3">
                                <label for="airlineNameSelect">Airline Name</label>
                                <select id="airlineNameSelect" name="airlineName" class="form-control">
                                    <option value="">Any</option>
                                    <?php
                                    if (mysqli_num_rows($airlineResults) > 0) {
                                        while ($airlineRow = mysqli_fetch_assoc($airlineResults)) {
                                            ?>
                                            <option <?php if ($airlineNameFilter == $airlineRow['airlineName']) {
                                                echo "selected";
                                            } ?> value="<?php echo $airlineRow['airlineName'] ?>">
                                                <?php echo $airlineRow['airlineName'] ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <label for="aircraftTypeSelect">Aircraft Type</label>
                                <select id="aircraftTypeSelect" name="aircraftType" class="form-control">
                                    <option value="">Any</option>
                                    <?php
                                    if (mysqli_num_rows($aircraftResults) > 0) {
                                        while ($aircraftRow = mysqli_fetch_assoc($aircraftResults)) {
                                            ?>
                                            <option <?php if ($aircraftTypeFilter == $aircraftRow['aircraftType']) {
                                                echo "selected";
                                            } ?> value="<?php echo $aircraftRow['aircraftType'] ?>">
                                                <?php echo $aircraftRow['aircraftType'] ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <label for="sort">Sort By</label>
                                <select id="sort" name="sort" class="form-control">
                                    <option value="">None</option>
                                    <option <?php if ($sort == "flightNumber") {
                                        echo "selected";
                                    } ?>
                                        value="flightNumber">Flight Number</option>
                                    <option <?php if ($sort == "departureDatetime") {
                                        echo "selected";
                                    } ?>
                                        value="departureDatetime">Departure Datetime</option>
                                    <option <?php if ($sort == "arrivalDatetime") {
                                        echo "selected";
                                    } ?>
                                        value="arrivalDatetime">Arrival Datetime</option>
                                    <option <?php if ($sort == "flightDurationMinutes") {
                                        echo "selected";
                                    } ?>
                                        value="flightDurationMinutes">Flight Duration</option>
                                    <option <?php if ($sort == "passengerCount") {
                                        echo "selected";
                                    } ?>
                                        value="passengerCount">Passenger Count</option>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-md-3">
                                <label for="order">Order</label>
                                <select id="order" name="order" class="form-control">
                                    <option <?php if ($order == "ASC") {
                                        echo "selected";
                                    } ?> value="ASC">Ascending
                                    </option>
                                    <option <?php if ($order == "DESC") {
                                        echo "selected";
                                    } ?> value="DESC">Descending
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <button class="btn btn-primary">Submit</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>




        <div class="container-fluid">
            <div class="row my-5">
                <div class="col">
                    <div class="card p-4 rounded-5">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Pilot Name</th>
                                        <th scope="col">Aircraft Type</th>
                                        <th scope="col">Flight Number</th>
                                        <th scope="col">Departure Datetime</th>
                                        <th scope="col">Arrival Datetime</th>
                                        <th scope="col">Flight Duration (Minutes)</th>
                                        <th scope="col">Airline Name</th>
                                        <th scope="col">Passenger Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($airportResults) > 0) {
                                        while ($flightRow = mysqli_fetch_assoc($airportResults)) {
                                            echo "<tr>
                                            <td>{$flightRow['pilotName']}</td>
                                            <td>{$flightRow['aircraftType']}</td>
                                            <td>{$flightRow['flightNumber']}</td>
                                            <td>{$flightRow['departureDatetime']}</td>
                                            <td>{$flightRow['arrivalDatetime']}</td>
                                            <td>{$flightRow['flightDurationMinutes']}</td>
                                            <td>{$flightRow['airlineName']}</td>
                                            <td>{$flightRow['passengerCount']}</td>
                                        </tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</body>

</html>