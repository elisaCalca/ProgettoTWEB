<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("head.php"); ?>
    <title>Amazing | Register</title>
</head>

<body class="dark">

    <div class="card page-center bg-dark">
        <div class="card-header text-center">
            <img class="dimlogoregister" src="../Images/logos/facebook_cover_photo_1.png">
        </div>
        <div class="card-body" id="user-data">
            <label class="platinum big">Crea un account:</label>
            <div class="card-text">
                <!-- generic form for users data -->
                <?php include("my-data-form.php"); ?>
                <!-- Password -->
                <div class="form-group">
                    <label class="platinum mt-2" for="password">Password:</label>
                    <input type="password" class="form-control" id="password" placeholder="Inserisci la tua password" required>
                    <small id="errorPwd" class="text-danger" hidden>La password deve contenere numeri, lettere ed essere lunga almeno 8 caratteri.</small>
                </div>
                <!-- Confirm password -->
                <div class="form-group">
                    <label class="platinum mt-2" for="confirmpassword">Conferma la password:</label>
                    <input type="password" class="form-control" id="confirmpassword" placeholder="Conferma la tua password" required>
                    <small id="errorConfirmPwd" class="text-danger" hidden>La conferma password deve essere uguale alla password precedente.</small>
                </div>
            </div>
            <br>
            <div class="form-group">
                <button id="btnRegisterRedirect" disabled="true" value="submit" class="btn btn-primary btn-md btn-block" type="submit">Registrati</button>
            </div>
        </div>
        <br>

        <!-- success create user -->
        <div id="registration-result-success" hidden>
            <div class="alert alert-success mt-3" role="alert">
                <i class="bi bi-person-check-fill"></i>
                <span id="text-reg-success"></span>
            </div>
            <button class="btn btn-secondary" id="goto-login">Vai al LogIn</button>
        </div>
        <!-- fail create user -->
        <div id="registration-result-fail" hidden>
            <div class="alert alert-danger mt-3" role="alert">
                <i class="bi bi-person-x-fill"></i>
                <span id="text-reg-fail"></span>
            </div>
            <button class="btn btn-secondary" id="reload-reg">Riprova la registrazione</button>
        </div>

        <br>
        <div class="card-footer text-muted text-center">
            <p>Hai già un account? <a href="../index.php">Vai al LogIn</a></p>
        </div>
        <br>
    </div>

    <?php include("scripts_ref.php"); ?>
</body>

</html>