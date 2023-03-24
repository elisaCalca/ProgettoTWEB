<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php"); ?>
    <title>Amazing | My company</title>
</head>

<body class="dark">
    <?php
    include("navbar.php");
    ?>
    <div class="container mt-5">
        <button class="btn btn-primary" id="add-myproduct">Aggiungi un articolo al tuo negozio</button>
        <div class="row">
            <label class="platinum big mt-3">I prodotti del tuo negozio:</label>
        </div>

        <div id="products-container">
        </div>
        <div id="error-ontrash" hidden>
            <div id="error" class="alert alert-danger mt-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span id="errorText">Errore durante la cancellazione del prodotto. Riprova più tardi.</span>
            </div>
            <button class="btn btn-secondary" id="reload-mycompany">Visualizza l'elenco dei prodotti</button>
        </div>
        <div id="error-load" class="alert alert-danger mt-3" role="alert" hidden>
            <i class="bi bi-exclamation-triangle-fill"></i>
            <span id="error-load-text"></span>
        </div>
    </div>

    <?php include("scripts_ref.php"); ?>
</body>

</html>