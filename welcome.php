<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
        }
    </style>
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
                                                                    echo "class=\"nav-link\"";
                                                                } else {
                                                                    echo "class=\"nav-link disabled\"";
                                                                }
                                                                ?>>Fireball Chart</a></li>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link active">
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

    <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to my site.</h1>
    <p>
        <a href="index.php" class="btn btn-danger ml-3">Home</a>
        <a href="reset-password.php" class="btn btn-warning ml-3">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger ml-3">Sign Out</a>
    </p>
</body>

</html>