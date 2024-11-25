var productData = [];

function getSaucesAndExtras(productId, callback) {
    $.ajax({
        url: getSaucesAndExtrasUrl,
        type: 'POST',
        data: {
            product_id: productId
        },
        success: function (data) {
            var responseData = JSON.parse(data);
            var saucesData = responseData.sauces;
            var extrasData = responseData.extras;

            callback(saucesData, extrasData);
        }
    });
}

function fillSaucesAndExtras(saucesData, extrasData) {
    var saucesContainer = $('#saucesContainer');
    var extrasContainer1 = $('#extrasContainer1');
    var extrasContainer2 = $('#extrasContainer2');

    var saucesTitle = $('#saucesTitle');
    var extrasTitle1 = $('#extrasTitle1');
    var extrasTitle2 = $('#extrasTitle2');

    // Limpia los contenedores
    saucesContainer.empty();
    extrasContainer1.empty();
    extrasContainer2.empty();

    if (saucesData.length > 0) {
        saucesContainer.show();
        saucesTitle.show();

        // Llena el contenedor de salsas
        saucesData.forEach(function (sauce, index) {
            var sauceElement = $('<div class="item-container">');
            var sauceId = 'sauce' + sauce.id; // Utiliza el ID de la salsa como parte del ID del elemento
            var sauceRadio = $('<input class="item-input">').attr('type', 'radio').attr('name', 'sauce').attr('id', sauceId).attr('value', sauce.id);
            var sauceLabel = $('<label class="item-label">&nbsp;').attr('for', sauceId).text(sauce.name);
            var sauceImage = $('<img class="img-responsive item-image" width="30">').attr('src', '/' + sauce.image);

            sauceElement.append(sauceImage, sauceRadio, sauceLabel);
            saucesContainer.append(sauceElement);
        });
    } else {
        saucesContainer.hide();
        saucesTitle.hide();
    }
    if (extrasData.length > 0) {
        extrasContainer1.show();
        extrasContainer2.show();
        extrasTitle1.show();
        extrasTitle2.show();

        // Llena el contenedor de extras
        extrasData.forEach(function (extra, index) {
            var extraElement1 = $('<div class="item-container">');
            var extraElement2 = $('<div class="item-container">');
            var extraId1 = 'extra1_' + extra.id; // Utiliza el ID del extra como parte del ID del elemento
            var extraId2 = 'extra2_' + extra.id; // Utiliza el ID del extra como parte del ID del elemento
            var extraRadio1 = $('<input class="item-input">').attr('type', 'radio').attr('name', 'extra1').attr('id', extraId1).attr('value', extra.id);
            var extraRadio2 = $('<input class="item-input">').attr('type', 'radio').attr('name', 'extra2').attr('id', extraId2).attr('value', extra.id);
            var extraLabel1 = $('<label class="item-label">&nbsp;').attr('for', extraId1).text(extra.name);
            var extraLabel2 = $('<label class="item-label">&nbsp;').attr('for', extraId2).text(extra.name);
            var extraImage = $('<img class="img-responsive item-image" width="30">').attr('src', '/' + extra.image);

            extraElement1.append(extraImage.clone(), extraRadio1, extraLabel1);
            extraElement2.append(extraImage, extraRadio2, extraLabel2);
            extrasContainer1.append(extraElement1);
            extrasContainer2.append(extraElement2);
        });
    } else {
        extrasContainer1.hide();
        extrasContainer2.hide();
        extrasTitle1.hide();
        extrasTitle2.hide();
    }
}

function loadProducts(categoryId) {
    $.ajax({
        url: filterProductsUrl,
        type: 'POST',
        data: {
            category_id: categoryId
        },
        success: function (data) {
            var responseData = JSON.parse(data);
            var productData = responseData.products;

            $('#product-list').html(renderProducts(productData));

            $(document).on('click', '.add-to-cart', function (e) {
                e.preventDefault();
                var productId = $(this).data('product-id');
                var product = productData.find(function (product) {
                    return product.id === productId;
                });

                // Llena la modal con la información del producto
                $('#productModalTitle').text(product.name);
                $('#productModalImage').attr('src', '/' + product.image);
                $('#productModalPrice').text('$' + product.price);
                $('#addToCartButton').data('product-id', product.id); // Corrección aquí
                $('#addToCartButton').data('is-editing', false);
                $('#addToCartButton').html('Agregar')

                $('#productQuantity').text('1');

                // Solicita las salsas y extras del producto
                getSaucesAndExtras(productId, function (saucesData, extrasData) {
                    // Llena la modal con las salsas y extras del producto
                    fillSaucesAndExtras(saucesData, extrasData);
                });

                // Muestra la modal
                productModal.show();
            });

            $(document).on('click', '#addToCartButton', function (e) {
                e.preventDefault();
                var quantity = $('#productQuantity').text();
                quantity = Number(quantity);

                var productId = $(this).data('product-id');
                var product = productData.find(function (product) {
                    return product.id === productId;
                });

                var isEditing = $(this).data('is-editing');

                // Verifica si se ha seleccionado alguna salsa
                var sauceSelected = $('input[name="sauce"]:checked').length > 0;

                // Verifica si se ha seleccionado algún extra
                var extraSelected = $('input[name^="extra"]:checked').length > 0;

                // Si hay salsas o extras disponibles pero no se ha seleccionado ninguno, muestra un mensaje de error
                if ($('#saucesContainer').is(':visible') && !sauceSelected) {
                    $('#customizeErrorMessage').text('Por favor, selecciona una salsa.').show();
                    return;
                }
                if (($('#extrasContainer1').is(':visible') || $('#extrasContainer2').is(':visible')) && !extraSelected) {
                    $('#customizeErrorMessage').text('Por favor, selecciona al menos un extra.').show();
                    return;
                }

                var sauceId = $('input[name="sauce"]:checked').val();
                var sauce = {
                    id: sauceId,
                    text: $('label[for="sauce' + sauceId + '"]').text()
                };

                var extras1 = $('input[name="extra1"]:checked').map(function () {
                    var extraId = $(this).val();
                    return {
                        id: extraId,
                        text: $('label[for="extra1_' + extraId + '"]').text()
                    };
                }).get();

                var extras2 = $('input[name="extra2"]:checked').map(function () {
                    var extraId = $(this).val();
                    return {
                        id: extraId,
                        text: $('label[for="extra2_' + extraId + '"]').text()
                    };
                }).get();

                var extras = extras1.concat(extras2);

                addToCart(product, quantity, isEditing, sauce, extras);

                // Cierra la modal
                productModal.hide();
            });
        }
    });
}

function renderProducts(data) {
    var html = '<div class="row">';
    if (data.length === 0) {
        return '<p>No hay productos para esta categoría</p>';
    }
    $.each(data, function (index, product) {
        html += '<div class="col-12 col-sm-6 col-md-4 col-lg-3">';
        html += '<div class="card">';
        html += '<img src="/' + product.image + '" class="card-img-top" alt="' + product.name + '">';
        html += '<div class="card-body">';
        html += '<h5 class="card-title">' + product.name + '</h5>';
        html += '<p class="card-text fw-bold fs-4 text-warning">$' + product.price + '</p>';
        html += '<div class="d-grid gap-2 col-12 mx-auto">';
        html += '<a href="#" class="btn btn-primary btn-lg text-uppercase noroundborder add-to-cart" data-product-id="' + product.id + '">Agregar</a>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
    });
    html += '</div>';
    return html;
}