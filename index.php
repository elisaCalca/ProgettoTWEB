<!--
    Author: Elisa Calcaterra
    The Login page for Amazing Shop
-->

<!DOCTYPE html>
<html lang="en">
<?php
if (!isset($_SESSION)) { session_start(); }
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="Images/logos/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="css/styles.css?v=1.0">
    <title>Amazing | Login</title>
</head>

<body class="dark">
    <div class="container margintop">
        <div class="row ">
            <div class="col-md-6">
                <div class="hover01 column">
                    <figure>
                        <img class="dimlogologin" src="Images/logos/facebook_cover_photo_1.png">
                    </figure>
                </div>
            </div>
            <div class="col-md-6">
                <form>
                    <div class="form-group">
                        <label class="platinum mt-2" for="username">Username:</label>
                        <input type="email" class="form-control" id="usernameLogin" placeholder="name@example.com">
                    </div>
                    <div class="form-group">
                        <label class="platinum mt-2" for="password">Password:</label>
                        <input type="password" class="form-control" id="passwordLogin" placeholder="your password">
                    </div>
                    <button id="btnAccedi" class="btn btn-primary btn-md btn-block mt-2" type="submit">Accedi</button>
                </form>
                <div id="errorCredentials" class="alert alert-danger mt-3" role="alert" hidden>
                    <i class="bi bi-x-circle-fill"></i>
                    <span id="errorText"></span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 ">
                <label class="platinum platinum-margin-sub big">Ci sono cose che non si possono comprare, per tutto il resto c'è Amazing Shop.</label>
            </div>
            <div class="col-md-6 ">
                <div class="row">
                    <div class="col-md-12 ">
                        <label class="platinum platinum-margin">Non sei ancora un cliente Amazing?</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button id="btnRegistrati" class="btn btn-secondary btn-md btn-block">Iscriviti ora</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="js/LoginRegisterScripts.js"></script>
    <script src="js/ValidationScripts.js"></script>
</body>

</html>