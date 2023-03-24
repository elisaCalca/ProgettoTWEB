<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php"); ?>
    <title>Amazing | Buy products</title>
</head>

<body class="dark">
    <?php include("navbar.php"); ?>

    <div class="card page-center bg-dark">
        <div class="card-body">
            <label class="platinum big">Procedi con l'ordine:</label>
            <div id="data-fail" class="alert alert-danger mt-3" role="alert" hidden>
                <i class="bi bi-send-x-fill"></i>
                <span id="error-data">Non è stato possibile precompilare i dati. Per favore inseriscili a mano.</span>
            </div>
            <div id="success" class="alert alert-success mt-3" role="alert" hidden>
                <i class="bi bi-send-check-fill"></i>
                Complimenti! L'ordine è stato ricevuto dal nostro sistema. Riceverai un avviso quando verrà spedito.
            </div>
            <div id="fail" class="alert alert-danger mt-3" role="alert" hidden>
                <i class="bi bi-send-x-fill"></i>
                Attenzione! Si è verificato un errore nell'elaborazione dell'ordine. Riprova.
            </div>
            <button id="continue" class="btn btn-primary mt-3" hidden>Continua lo shopping <i class="bi bi-graph-up-arrow"></i></button>

            <div class="card-text" id="form-tag">
                <div class="form-group mt-2">
                    <label class="platinum" for="name">Nome:</label><br>
                    <input id="data-name" class="expand-total" type="text" name="name">
                </div>
                <div class="form-group mt-2">
                    <label class="platinum" for="surname">Cognome:</label><br>
                    <input id="data-surname" class="expand-total" type="text" name="surname" >
                </div>
                <div class="form-group mt-2">
                    <label class="platinum" for="email">Email:</label><br>
                    <input id="data-email" class="expand-total" type="email" name="email" >
                </div>
                <div class="form-group mt-3">
                    <label class="platinum" for="address">Indirizzo:</label><br>
                    <textarea class="expand-total" name="address" required></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary mt-5" id="submit-order">ORDINA <i class="bi bi-send-fill"></i></button>
                </div>
            </div>
        </div>
    </div>


    <?php include("scripts_ref.php"); ?>
</body>

</html>