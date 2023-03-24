$(function () {
    const params = new URLSearchParams(window.location.search);
    var product_id = params.get('product_id');
    $.get("../WebApi/endpoints.php",
        { submit: "get_product", product_id: product_id },
        function (data) {
            if (data.code == 200) {
                $('#product_name').text(data.product_name);
                $('#img_path').attr("src", data.imgb64);
                $('#product_descr').text(data.product_descr);
                $('#product_price').text(data.product_price + ' €');
                $('#add-wishlist').show();
                $('#add-chart').show();
                addInputCustom();
            }
            else {
                $('#product_name').text(data.product_name);
                $('#img_path').attr("src", "../Images/shared/error-confused-gif.gif");
                $('#product_descr').text(data.message);
                $('#add-wishlist').hide();
                $('#add-chart').hide();
                jQuery('.quantity').each(function () {
                    var spinner = jQuery(this);
                    spinner.hide();
                });
            }

        }
    );

    $('#add-chart').on('click', function() {
        var qty = $('#qty').val();
        console.log(qty);
        $.post("../WebApi/endpoints.php",
            { submit: "add_productshoppingbag", productId: product_id, qty: qty},
            function(data) {
                console.log(data);
                if(data.status){
                    $('#success-addcart').removeAttr('hidden');
                    $('#error-addcart').attr('hidden', true);
                    $('#successText').text(data.message);
                } else {
                    $('#error-addcart').removeAttr('hidden');
                    $('#success-addcart').attr('hidden', true);
                    $('#errorText').text(data.message);
                }
            }
        );
    });

    const addInputCustom = function () {
        //CUSTOM INPUT NUMBER
        jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up">+</div><div class="quantity-button quantity-down">-</div></div>').insertAfter('.quantity input');
        jQuery('.quantity').each(function () {
            var spinner = jQuery(this),
                input = spinner.find('input[type="number"]'),
                btnUp = spinner.find('.quantity-up'),
                btnDown = spinner.find('.quantity-down'),
                min = input.attr('min'),
                max = input.attr('max');

            btnUp.click(function () {
                var oldValue = parseFloat(input.val());
                if (oldValue >= max) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue + 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });

            btnDown.click(function () {
                var oldValue = parseFloat(input.val());
                if (oldValue <= min) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue - 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });

        });
    }
});