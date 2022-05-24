<!DOCTYPE HTML>
<html>

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

    <?php
    session_start();
    $service_url = 'https://ssd-api.jpl.nasa.gov/fireball.api?req-alt=true';
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

    $rawData = json_decode($curl_response, true);
    ?>

    <!-- Script to visualize data fetch from the API -->
    <script>
        window.onload = function() {
            var dataPoints = [];

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                zoomEnabled: true,
                title: {
                    text: "Recorded Fireball Occurances"
                },
                axisY: {
                    title: "Altitude",
                    titleFontSize: 24,
                    suffix: "km"
                },
                data: [{
                    type: "line",
                    yValueFormatString: "#,##0.00km",
                    dataPoints: dataPoints
                }]
            });

            function addData(data) {
                var dps = data.data;

                for (var i = 0; i < dps.length; i++) {
                    dataPoints.push({
                        x: (new Date(dps[i][0])),
                        y: parseFloat(dps[i][7])
                    });
                    console.log(new Date(dps[i][0]));
                    console.log(dps[i][7]);
                }
                chart.render();
            }

            addData(<?php echo $curl_response; ?>);
        }
    </script>
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

                                                                        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                                            echo "class=\"nav-link\"";
                                                                        } else {
                                                                            echo "class=\"nav-link disabled\"";
                                                                        }
                                                                        ?>>Country Locator</a></li>
                    <li class="nav-item"><a href="chart.php" <?php
                                                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                                                                    echo "class=\"nav-link active\"";
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

    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <div>
        <h2>What are Fireballs?</h2>
        <p>
            An Earth-grazing fireball (or Earth grazer) is a fireball, a very bright meteor that enters Earth’s atmosphere and leaves again.
            Some fragments may impact Earth as meteorites, if the meteor starts to break up or explodes in mid-air.
            These phenomena are then called Earth-grazing meteor processions and bolides.
            On the chart above, you can see the altitude of each recorded fireball from 1997 till today.
        </p>
    </div>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
</body>

</html>