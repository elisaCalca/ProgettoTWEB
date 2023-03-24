$(function () {

    $.post("../WebApi/endpoints.php",
        { submit: "getall_shoppingbag" },
        function (data) {
            if (data.status) {
                $('#gaming-container').removeAttr("hidden");
                $('#error-shoppingbag').attr('hidden', true);
                console.log(data.shoppings.length);
                if(data.shoppings.length === 0) {
                    $('#gaming-container').attr('hidden', true);
                    $('#error-shoppingbag').removeAttr("hidden");
                    $('#errorText').text("Non sono presenti prodotti nel tuo carrello!");
                } else {
                    data.shoppings.forEach(shop => {
                        var htmlstring = generateHTMLShop(shop);
                        let doc = new DOMParser().parseFromString(htmlstring, 'text/html');
                        let divs = doc.body.querySelectorAll('.item');  //deve essere un Node
    
                        $('#cart').append(divs);
                        // select the item element
                        const items = document.querySelectorAll('.item');
                        // attach the dragstart event handler
                        if (items != null) {
                            items.forEach(item => {
                                item.addEventListener('dragstart', dragStart);
                            });
                        }
                    });
                }
            } else {
                $('#gaming-container').attr('hidden', true);
                $('#error-shoppingbag').removeAttr("hidden");
                $('#errorText').text(data.message);
            }
        }
    );

    $('.buy').on('click', function (e) {
        e.preventDefault();
        open("buy_products.php?", "_self");
    });

    const boxes = document.querySelectorAll('.box');
    if (boxes !== null) {
        boxes.forEach(box => {
            box.addEventListener('dragenter', dragEnter)
            box.addEventListener('dragover', dragOver);
            box.addEventListener('dragleave', dragLeave);
            box.addEventListener('drop', drop);
        });
    }

});

function generateHTMLShop(shop) {
    var html = `<div class="item" id="` + shop.ID + `" draggable="true">
        <img src="`+ shop.Imageb64 + `" class="img-smallest" src="">
        <label class="middle">`+ shop.Name + `</label>
    </div>`;
    return html;
}

// handle the dragstart
const dragStart = function dragStart(e) {
    //console.log('drag starts...' + e.target.id);
    e.dataTransfer.setData('text/plain', e.target.id);
}

const dragEnter = function dragEnter(e) {
    e.preventDefault();
    // console.log("entrato nel box");
    e.target.classList.add('drag-over');
}

const dragLeave = function dragLeave(e) {
    // console.log("uscito dal box");
    e.target.classList.remove('drag-over');
}

const dragOver = function dragOver(e) {
    e.preventDefault();
    // console.log("Tengo l'item con il puntatore del mouse dentro al box");
    e.target.classList.add('drag-over');
}

const drop = function drop(e) {
    e.target.classList.remove('drag-over');
    //console.log("Ho mollato il mouse" + e.dataTransfer);
    // get the draggable element
    var prodId = e.dataTransfer.getData('text/plain');
    // console.log("ID del prodotto" + prodId);
    var boxDestination = e.currentTarget.id;
    var draggable = document.getElementById(prodId);
    // console.log('product id', prodId);
    // console.log('box destination', boxDestination);
    // add it to the drop target
    e.target.appendChild(draggable);

    $.post("../WebApi/endpoints.php",
        { submit: "delete_product_shoppingbag", prodId: prodId },
        function (data) {
            if (data.status) {
                //il prodotto è stato eliminato
                //hide the element
                if (boxDestination === "trash") {
                    draggable.classList.add('hide');
                }
            } else {
                //se il prodotto non è stato eliminato lo rimetto nel carrello
                $('#cart').append(draggable);
            }
        }
    );
}

