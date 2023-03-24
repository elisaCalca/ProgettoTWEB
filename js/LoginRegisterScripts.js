$(function () {

    $('#btnAccedi').on("click", LogIn);
    $('#btnRegistrati').on("click", GoToRegister);
    $('#btnRegisterRedirect').on("click", RegisterUser);

    $('#name').on("change", ValidateNameLocal);
    $('#surname').on("change", ValidateSurnameLocal);
    $('#email').on("change", ValidateEmailLocal);
    $('#password').on("change", ValidatePwd);
    $('#confirmpassword').on("change", ValidateConfPwd);

});

var IsValidName = false;
var IsValidSurname = false;
var IsvalidEmail = false;
var IsValidPwd = false;
var IsValidConfPwd = false;

const LogIn = function (e) {
    e.preventDefault();
    var username = $('#usernameLogin')[0].value;
    var password = $('#passwordLogin')[0].value;
    $.post(
        "WebApi/endpoints.php",
        { submit: "login", usr: username, pwd: password },
        function (data) {
            if (data.status) {
                open("Views/home.php", "_self");
            } else {
                $('#errorCredentials').removeAttr('hidden');
                $('#errorText').text(data.message);
            }
        }
    );
};

const GoToRegister = function () {
    open("Views/register.php", "_self");
};

const RegisterUser = function (e) {
    e.preventDefault();
    var name = $('#name')[0].value;
    var surname = $('#surname')[0].value;
    var email = $('#email')[0].value;
    var pwd = $('#password')[0].value;
    var role = $('.role:checked').val();
    $.post(
        "../WebApi/endpoints.php",
        { submit: "register", name: name, surname: surname, email: email, password: pwd, role: role },
        function (data) {
            if (data.status) {
                $('#user-data').hide();
                $('#registration-result-success').removeAttr('hidden');
                $('#text-reg-success').text(data.message);
                $('#goto-login').on('click', function() {
                    open("../index.php", "_self");
                });
            } else {
                $('#user-data').hide();
                $('#registration-result-fail').removeAttr('hidden');
                $('#text-reg-fail').text(data.message);
                $('#reload-reg').on('click', function() {
                    location.reload();
                });
            }
        }
    );
}
/*
Funzioni che gestiscono la validazione lato client e l'attivazione del bottone per la registrazione
*/
const ValidateAll = function () {
    var booleanRenderer = IsValidName && IsValidSurname && IsvalidEmail && IsValidPwd && IsValidConfPwd;
    if (booleanRenderer) {
        $('#btnRegisterRedirect').prop('disabled', false);
    }
    else {
        $('#btnRegisterRedirect').prop('disabled', true);
    }
};

const ValidateNameLocal = function () {
    var name = $('#name')[0].value;
    IsValidName = ValidateText(name);
    if (IsValidName) {
        $('#errorName').attr('hidden', true);
    }
    else {
        $('#errorName').removeAttr('hidden');
    }
    ValidateAll();
};

const ValidateSurnameLocal = function () {
    var surname = $('#surname')[0].value;
    IsValidSurname = ValidateText(surname);
    if (IsValidSurname) {
        $('#errorSurname').attr('hidden', true);
    }
    else {
        $('#errorSurname').removeAttr('hidden');
    }
    ValidateAll();
};

const ValidateEmailLocal = function () {
    var email = $('#email')[0].value;
    IsvalidEmail = ValidateEmail(email);
    if (IsValidSurname) {
        $('#errorEmail').attr('hidden', true);
    }
    else {
        $('#errorEmail').removeAttr('hidden');
    }
    ValidateAll();
};

const ValidatePwd = function () {
    var pwd = $('#password')[0].value;
    IsValidPwd = ValidatePassword(pwd);

    if (IsValidPwd)
        $('#errorPwd').attr('hidden', true);
    else
        $('#errorPwd').removeAttr('hidden');

    ValidateAll();
};

const ValidateConfPwd = function () {
    var confirmpwd = $('#confirmpassword')[0].value;
    IsValidConfPwd = ValidatePassword(confirmpwd);
    var pwd = $('#password')[0].value;

    if (pwd === confirmpwd && IsValidConfPwd) {
        $('#errorConfirmPwd').attr('hidden', true);
    }
    else {
        $('#errorConfirmPwd').removeAttr('hidden');
    }
    ValidateAll();
};

