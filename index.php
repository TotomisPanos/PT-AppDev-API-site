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

</head>

<body>

    <main>
        <div class="container">
            <header class="d-flex justify-content-center py-3">

                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link active" aria-current="page">Home</a>
                    </li>
                    <li class="nav-item"><a href="CountryLocator.php" <?php
                                                                        session_start();
                                                                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                                            echo "class=\"nav-link\"";
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
    //next example will recieve all messages for specific conversation
    $service_url = 'https://api.nasa.gov/planetary/apod?api_key=7iriqp5CrjB5yliNbXUlboDeyPafjPxQGKFED9Ya';
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $curl_response = curl_exec($curl);
    if ($curl_response === false) {
        $info = curl_getinfo($curl);
        curl_close($curl);
        die('error occured during curl exec. Additioanl info: ' . var_export($info));
    }
    curl_close($curl);
    $decoded = json_decode($curl_response);
    if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
        die('error occured: ' . $decoded->response->errormessage);
    }

    # Data processing to show image
    $rawData = json_decode($curl_response, true);
    $img = $rawData["url"];

    $paragraph = $rawData["explanation"];

    echo "
    <div class=\"d-flex justify-content-between p-4\">
        <div>
            <div class=\"center\"><img src='{$img}' /></div>
        </div>
        <div class=\"d-flex flex-column justify-content-center\">
            <h1>Nasa's Astronomy Picture Of the Day</h1>
            <p class=\"\">$paragraph</p>
        </div>
    </div>";

    ?>

    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>