<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php"); ?>
    <title>Amazing | Personal data</title>
</head>

<body class="dark">
    <?php
    include("navbar.php");
    ?>
    <div class="card page-center bg-dark">
        <div class="card-body">
            <label class="platinum big">Aggiorna i tuoi dati:</label>
            <div class="card-text">
                <div id="success" class="alert alert-success" role="alert" hidden>
                    <i class="bi bi-send-check-fill"></i>
                    <span id="successText"></span>
                </div>

                <div id="fail" class="alert alert-danger" role="alert" hidden>
                    <i class="bi bi-send-x-fill"></i>
                    <span id="errorText"></span>
                </div>

                <div id="data-container">
                    <!-- generic form for users data -->
                    <?php include("my-data-form.php"); ?>
                    <div class="form-group mt-2">
                        <label class="platinum" for="new-password">Nuova password:</label><br>
                        <input id="data-newpwd" class="expand-total" type="password" name="new-password" placeholder="Inserici la nuova password"><br>
                        <small id="errorPwd" class="platinum">La password deve contenere numeri, lettere maiuscole e minuscole, ed essere lunga almeno 8 caratteri.</small>
                    </div>
                    <div class="form-group mt-3">
                        <label class="platinum" for="old-password">Inserisci la vecchia password per continuare:</label><br>
                        <input id="data-oldpwd" class="expand-total" type="password" name="old-password" required>
                    </div>
                    <div class="form-group">
                        <button id="my-data-update" class="btn btn-primary mt-5" type="submit">Applica modifiche</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("scripts_ref.php"); ?>
</body>

</html>