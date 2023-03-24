<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php"); ?>
    <title>Amazing | Edit product</title>
</head>

<body class="dark">
    <?php include("navbar.php"); ?>

    <div class="container mt-5">
        <label class="platinum big mb-4" id="create-edit-product-title"></label>
        <div class="row">
            <div class="col-6">
            <label class="platinum">Immagine del prodotto:</label><br>
                <img src="" id="product_img" class="card-img-top"><br>
                <input id="img-input" type="file" class="form-control mt-2" required></input>
            </div>
            <div class="col-6">
                <label class="platinum">Nome:</label><br>
                <input class="platinum big expand-total" id="product_name" required></input>
                <br>
                <label class="platinum">Descrizione:</label><br>
                <textarea class="platinum expand-total" id="product_descr" maxlength="255" required></textarea>
                <br>
                <label class="platinum">Prezzo:</label><br>
                <input class="platinum expand-total" id="product_price" required></input>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mt-5">
                <button class="btn btn-secondary" id="save-myproduct-detail">
                    <i class="bi bi-sd-card-fill"></i>
                </button>
            </div>
            <div class="col-6 mt-5">
                <button class="btn btn-primary" id="trash-myproduct-detail">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </div>
        </div>
        <div class="row">
            <div id="error" class="alert alert-danger mt-3" role="alert" hidden>
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span id="errorText"></span>
            </div>
            <div id="success" class="alert alert-success mt-3" role="alert" hidden>
                <i class="bi bi-check-lg"></i>
                <span id="successText"></span>
            </div>
        </div>
    </div>

    <?php include("scripts_ref.php"); ?>
</body>

</html>