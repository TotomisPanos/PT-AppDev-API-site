<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors" />
    <meta name="generator" content="Hugo 0.88.1" />
    <title>PT - Application Development</title>

    <link rel="stylesheet" href="style.css" />
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/headers/" />

    <!-- Bootstrap core CSS -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>

    <!-- Custom styles for this template -->
    <link href="headers.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Datepicker -->
    <link href='bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css' rel='stylesheet' type='text/css'>
    <script src='bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js' type='text/javascript'></script>

</head>

<body>

<main>
        <div class="container">
            <header class="d-flex justify-content-center py-3">

                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link" aria-current="page">Home</a>
                    </li>
                    <li class="nav-item"><a href="CountryLocator.php" <?php
                                                                        session_start();
                                                                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                                            echo "class=\"nav-link active\"";
                                                                        } else {
                                                                            echo "class=\"nav-link disabled\"";
                                                                        }
                                                                        ?>>Country Locator</a></li>
                    <li class="nav-item"><a href="chart.php" <?php
                                                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                                    echo "class=\"nav-link\"";
                                                                } else {
                                                                    echo "class=\"nav-link disabled\"";
                                                                }
                                                                ?>>Fireball Chart</a></li>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link">
                            <?php

                            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                echo "Welcome, " . $_SESSION['username'];
                            } else {
                                echo "Sign in";
                            }
                            ?>
                        </a>
                    </li>
                </ul>
            </header>
            <hr />
        </div>
    </main>

    <div id="dp6" data-date="12-02-2012" data-date-format="dd-mm-yyyy"></div>

    <?php
    //  API url
    $url = 'https://gregeoip.com/GeoIP?key=4bddf063c66f92355e4991eae19ea34d&params=location,currency';
    // Collection object
    $data = [
        'collection' => 'RapidAPI'
    ];
    // Initializes a new cURL session
    $curl = curl_init($url);
    // Set the CURLOPT_RETURNTRANSFER option to true
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // Set the CURLOPT_POST option to true for POST request
    curl_setopt($curl, CURLOPT_POST, true);
    // Set the request data as JSON using json_encode function
    curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
    // Set custom headers for RapidAPI Auth and Content-Type header
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'X-RapidAPI-Host: kvstore.p.rapidapi.com',
        'X-RapidAPI-Key: 7xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx',
        'Content-Type: application/json'
    ]);
    // Execute cURL request with all previous settings
    $response = curl_exec($curl);
    // Close cURL session
    curl_close($curl);

    $info = json_decode($response, true);

    //echo "<br/>";
    //echo $response . PHP_EOL;

    $googleMaps = $info["data"];
    //$googleMaps = json_decode($googleMaps);
    $countryName = $googleMaps["countryName"];

    //echo "<br/>";
    //echo "<br/>";

    //echo json_encode($googleMaps);

    echo '
    <div>
        <div class="container-fluid center">
            <div class="gmap_canvas jumbotron jumbotron-fluid"><iframe width="900" height="600" id="gmap_canvas" src="https://maps.google.com/maps?q=' . $countryName . '&t=k&z=5&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><br>
                <style>
                    .gmap_canvas {
                        overflow: hidden;
                        background: none !important;
                        height: 650px;
                        width: 900px;
                    }
                </style>
            </div>
        </div>
        <div>
            <h2>Country Locator</h2>
            <p>
                This Country Locator uses the greip.io API that can collect the user\'s data, such as their IP, country, timezone, region, local currency and much more. Then, the country collected from the API is used in correlation with a Google Maps Embed to display the users country on the map.
            </p>
        </div>
    </div>
    '

    ?>


                

    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>