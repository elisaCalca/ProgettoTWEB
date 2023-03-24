$(function () {

    // const ua = navigator.userAgent;
    // if (/Mobile|Android|iP(hone|od)|IEMobile|BlackBerry|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(ua)) {
    //     console.log("mobile");
    // }
    // else {
    //     console.log("desktop");
    // }

    $('#logo-navbar').on('click', function () {
        open("home.php?", "_self");
    });

    $('#shopping-bag').on('click', function () {
        open("shopping_bag.php", "_self");
    });

    $('#form-search').on('submit', function (e) {
        e.preventDefault();
        var prodName = $('#text-to-search').val();

        $.post("../WebApi/endpoints.php",
            { submit: "get_product_byName", prodName: prodName },
            function (data) {
                open("single_product.php?product_id=" + data.ID, "_self");
            }
        );
    });

    $.post("../WebApi/endpoints.php",
        { submit: "get_login_infos" },
        function (data) {
            var url = window.location.href;
            const folders = url.split('/');
            var len = folders.length;
            if (data.status) {
                if (data.role == "Compratore") {
                    
                    if (folders[len - 1] === "my_company.php") {
                        open("index.php?", "_self");
                    } else {
                        $('#nav-my-company').attr('hidden', true);
                    }
                }
            } else if(folders[len - 1] != "register.php"){
                open("../index.php?", "_self");
            }
        }
    );

});