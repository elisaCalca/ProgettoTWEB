$(function() {

    $.post("../WebApi/endpoints.php",
        { submit: "get_userInfo" },
        function (data) {
            if(data.status) {
                $('#name').val(data.name);
                $('#surname').val(data.surname);
                $('#email').val(data.email);
                $("input[type=radio][value='"+data.roleName+"']").prop("checked",true);
            } else {
                $('#fail').removeAttr('hidden');
            }
        }
    );

    $('#my-data-update').on('click', function(e) {
        e.preventDefault();

        var name = $('#name')[0].value;
        var surname = $('#surname')[0].value;
        var email = $('#email')[0].value;
        var newpwd = $('#data-newpwd')[0].value;
        var oldpwd = $('#data-oldpwd')[0].value;
        var role = $('.role:checked').val();
        //validazione lato client
        var isNameValid = ValidateText(name);
        var isSurnameValid = ValidateText(surname);
        var isEmailValid = ValidateEmail(email);

        if(isNameValid && isSurnameValid && isEmailValid) {
            $('#fail').attr('hidden', true);
            $('#errorName').attr('hidden', true);
            $('#errorSurname').attr('hidden', true);
            $('#errorEmail').attr('hidden', true);
            $.post("../WebApi/endpoints.php",
                { submit: "update_userInfo", name: name, surname: surname, newemail: email,
                    newpwd: newpwd, oldpwd: oldpwd, roleName: role },
                function (data) {
                    console.log(data);
                    if(data.status) {
                        $('#fail').attr('hidden', true);
                        $('#success').removeAttr('hidden');
                        $('#successText').text(data.message);
                        //rifare il login
                        open("logout.php", "_self");
                    } else {
                        $('#fail').removeAttr('hidden');
                        $('#errorText').text(data.message);
                    }
                }
            );
        } else {
            $('#fail').removeAttr('hidden');
            var error = "Errore: rivedere i seguenti campi: ";
            if(!isNameValid){
                error += "Nome ";
                $('#errorName').removeAttr('hidden');
            }
            if(!isSurnameValid){
                error += " Cognome ";
                $('#errorSurname').removeAttr('hidden');
            }
            if(!isEmailValid){
                error += " Email.";
                $('#errorEmail').removeAttr('hidden');
            }
            $('#errorText').text(error);
        }

        
    });

});