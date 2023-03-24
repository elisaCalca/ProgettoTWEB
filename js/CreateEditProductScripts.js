$(function () {
    const params = new URLSearchParams(window.location.search);
    var product_id = params.get('product_id');
    
    if(product_id)
    {
        $('#create-edit-product-title').text("Modifica il tuo prodotto:");

        $.get("../WebApi/endpoints.php",
        { submit: "get_product", product_id: product_id },
        function (data) {
            if (data.status) {
                $('#product_name').attr('value', data.product_name);
                $('#product_img').attr("src", data.imgb64);
                $('#product_descr').val(data.product_descr);
                $('#product_price').attr('value', data.product_price);
                $('#save-myproduct-detail').show();
                $('#trash-myproduct-detail').show();
            }
            else {
                $('#product_name').text("Uh-Oh!");
                $('#product_img').attr("src", "../Images/shared/error-confused-gif.gif");
                $('#product_descr').text(data.message);
                $('#product_price').hide();
                $('#save-myproduct-detail').hide();
                $('#trash-myproduct-detail').hide();
            }
        });
    }
    else
    {
        console.log("prod id" + product_id);
        $('#trash-myproduct-detail').hide();
        $('#save-myproduct-detail').show();
        $('#create-edit-product-title').text("Inserisci un nuovo prodotto:");
        $('#product_name').attr('value', '');
        $('#product_img').attr("src", '');
        $('#product_descr').val('');
        $('#product_price').attr('value', '');
    }

    $('#img-input').on('change', function(input) {
        $('#success').attr('hidden', true);
        $('#error').attr('hidden', true);
        if(input.target.files && input.target.files[0]){
            var reader = new FileReader();
            reader.onloadend = function(e) {
                $('#product_img').attr('src', e.target.result);
                //console.log(e.target.result);   //src of base64 img: "data:image/png;base64, ..."
            };
            reader.readAsDataURL(input.target.files[0]);
        }
    });

    $('#save-myproduct-detail').on('click', function(e) {
        e.preventDefault();

        var img_prod = $('#product_img').attr('src');
        var name_prod = $('#product_name').val();
        var descr_prod = $('#product_descr').val();
        var price_prod = $('#product_price').val();
        $.post(
            "../WebApi/endpoints.php",
            { submit: "createeditproduct", id: product_id, name: name_prod, descr: descr_prod, price: price_prod, img: img_prod},
            function (data) {
                console.log(data);
                if(data.status) {
                    $('#success').removeAttr('hidden');
                    $('#error').attr('hidden', true);
                    $('#successText').text(data.message);
                } else {
                    $('#error').removeAttr('hidden');
                    $('#success').attr('hidden', true);
                    $('#errorText').text(data.message);
                }
            }
        );
    });
    
    $('#trash-myproduct-detail').on('click', function(e) {
        e.preventDefault();
        
        $.post("../WebApi/endpoints.php", 
        { submit: "delete_productmycompany", prodId : product_id },
            function (data) {
                if(data.status) {
                    open("my_company.php", "_self");
                } else {
                    $('#error').removeAttr('hidden');
                    $('#success').attr('hidden', true);
                    $('#errorText').text(data.message);
                }
            }
        );
    });


});