$(function() {

    $('#add-myproduct').on('click', function() {
        var prodId = "";
        open("create_edit_product.php?product_id=" + prodId, "_self");
    });

    $.post("../WebApi/endpoints.php", 
        { submit: "getall_products_byuser"},
        function (data) {
            if(data.status) {
                $('#error-load').attr('hidden', true);
                if(data.products.length > 0)
                {
                    data.products.forEach(prod => {
                        var htmlstring = generateHTMLProduct(prod);
                        $('#products-container').append(htmlstring);
                    });

                    $('.edit-myproduct').each(function() {
                        $(this).on('click', function(e) {
                            e.preventDefault();
                            var prodId = $(this).attr('data-id');
                            open("create_edit_product.php?product_id=" + prodId, "_self");
                        });
                    });
                
                    $('.trash-myproduct').each(function() {
                        $(this).on('click', function(e) {
                            e.preventDefault();
                            var prodId = $(this).attr('data-id');
                            $.post("../WebApi/endpoints.php", 
                            { submit: "delete_productmycompany", prodId : prodId },
                                function (data) {
                                    if(data.status) {
                                        location.reload();
                                    } else {
                                        $('#reload-mycompany').on('click', function() {
                                            location.reload();
                                        });
                                        $('#products-container').attr('hidden', true);
                                        $('#error-ontrash').removeAttr('hidden');
                                    }
                                }
                            );
                        });
                    });
                }
                else {
                    $('#error-load').removeAttr('hidden');
                    $('#error-load-text').text("Non hai ancora messo in vendita nessun prodotto!");
                }
            } else {
                $('#error-load').removeAttr('hidden');
                $('#error-load-text').text(data.message);
            }
        }
    );
});

function generateHTMLProduct(prod) {
    var html = `<div class="card card-body mt-2">
        <div class="row">
            <div class="col-8">
                <label class="big" name="name">`+prod.Name+`</label>
            </div>
            <div class="col-2">
                <button id="button-product`+prod.ID+`" class="btn btn-primary mt-1 edit-myproduct" data-id="`+prod.ID+`">
                    <i class="bi bi-pencil-square"></i>
                </button>
            </div>
            <div class="col-2">
                <button id="button-product`+prod.ID+`" class="btn btn-primary mt-1 trash-myproduct" data-id="`+prod.ID+`">
                    <i class='bi bi-trash-fill'></i>
                </button>
            </div>
        </div>
    </div>`;
    return html;
}