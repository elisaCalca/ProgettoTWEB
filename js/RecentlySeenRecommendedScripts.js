$(function () {

    GetProductRandom();

    $('#refresh').on('click', function () {
        $('#product-random').html("");
        GetProductRandom();
    });

    $('#visualizza-recommend').on('click', function () {
        var prodId = $('#product_id_dynamic')[0].innerText;
        open("single_product.php?product_id=" + prodId, "_self");
    });

});

function GetProductRandom() {
    $.post("../WebApi/endpoints.php",
        { submit: "get_randomproduct" },
        function (data) {
            var stringRandomProductHTML = generateHTMLRandomProduct(data.ID, data.Name, data.Description, data.Price, data.ImageData);
            $('#product-random').append(stringRandomProductHTML);
            if (data.status) {
                $('#visualizza-recommend').removeAttr('hidden');
            } else {
                $('#price-p').attr('hidden', true);
                $('#visualizza-recommend').attr('hidden', true);
            }
        }
    );
}

function generateHTMLRandomProduct(ID, Name, Description, Price, ImageData) {
    var html = `<img src="` + ImageData + `" class="card-img-top">
    <div class="card-body">
      <h5 class="card-title mt-1">`+ Name + `</h5>
      <p id="product_id_dynamic" hidden>`+ ID + `</p>
      <p class="card-text">`+ Description + `</p>`;
        if(Price) {
            html += `<p id="price-p" class="card-text">`+ Price + ` €</p>`;
        }
    html += `</div>`;
    return html;
}