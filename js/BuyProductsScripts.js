$(function () {

    $.post("../WebApi/endpoints.php",
        { submit: "get_userInfo" },
        function (data) {
            if(data.status) {
                $('#data-name').val(data.name);
                $('#data-surname').val(data.surname);
                $('#data-email').val(data.email);
            } else {
                $('#data-fail').removeAttr('hidden');
            }
        }
    );

    $('#submit-order').on('click', function (e) {
        e.preventDefault();
        $.post("../WebApi/endpoints.php",
            { submit: "submit_order_delete_bag" },
            function (data) {
                $('#form-tag').attr('hidden', true);
                if(data.status) { 
                    $('#success').removeAttr('hidden');
                    $('#fail').attr('hidden', true);
                } else {
                    $('#success').attr('hidden', true);
                    $('#fail').removeAttr('hidden');
                }
                $('#continue').on('click', function (e) {
                    e.preventDefault();
                    open("home.php", "_self");
                });
            }
        );
    });
});