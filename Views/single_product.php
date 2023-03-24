<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php"); ?>
    <title>Amazing | Product details</title>
</head>

<body class="dark">
    <?php include("navbar.php"); ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-6">
                <img src="" id="img_path" class="card-img-top">
            </div>
            <div class="col-6">
                <label class="platinum big" id="product_name"></label>
                <br>
                <label class="platinum" id="product_descr"></label>
                <br>
                <label class="platinum big" id="product_price"></label>
                <br>
                <div class="quantity mt-3">
                    <input id="qty" type="number" min="1" max="99" step="1" value="1">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-5">
                <button id="add-chart" class="btn btn-primary">Aggiungi al carrello</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-3">
            <div id="error-addcart" class="alert alert-danger m-5" role="alert" hidden>
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span id="errorText"></span>
            </div>
            <div id="success-addcart" class="alert alert-success m-5" role="alert" hidden>
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span id="successText"></span>
            </div>
            </div>
        </div>
        <br>
    </div>

    <?php include("scripts_ref.php"); ?>
</body>

</html>