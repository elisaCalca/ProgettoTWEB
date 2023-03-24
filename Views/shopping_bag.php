<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php"); ?>
    <title>Amazing | Shopping bag</title>
</head>

<body class="dark">
    <?php include("navbar.php"); ?>

    <div class="container mt-5" id="gaming-container">
        <button class="btn btn-primary buy">Acquista gli articoli nel carrello</button>
        <div class="drop-targets">
            <div class="row">
                <div class="col-6">
                    <div class="box box-big bg-cart" id="cart">

                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="box box-big bg-trash" id="trash">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="error-shoppingbag" class="alert alert-danger m-5" role="alert" hidden>
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span id="errorText"></span>
    </div>

    <?php include("scripts_ref.php"); ?>
</body>

</html>