$(document).ready(function () {
    $('#categories').on('click', '.fila', function () {
        var id = $(this).attr('id').split('-')[1];
        $('.fila').removeClass('selected');
        $(this).addClass('selected');
        $('#category-name').html($(this).find('span').html());
        loadProducts(id);
    });

    // Simula un clic en la primera categoría
    $('#categories .fila:first').click();

    $(document).on('click', '#increaseQuantity', function (e) {
        e.preventDefault();
        var quantity = $('#productQuantity').text();
        quantity = Number(quantity);
        quantity++;
        $('#productQuantity').text(quantity);
    });

    $(document).on('click', '#decreaseQuantity', function (e) {
        e.preventDefault();
        var quantity = $('#productQuantity').text();
        quantity = Number(quantity);
        if (quantity > 1) { // Evita que la cantidad sea menor a 1
            quantity--;
        }
        $('#productQuantity').text(quantity);
    });

    $(document).on('click', '.edit-button', function (e) {
        e.preventDefault();
        var productId = $(this).data('product-id');
        var cartItem = cart.find(function (item) {
            return item.product.id === productId;
        });

        // Llena la modal con la información del producto y la cantidad
        $('#productModalTitle').text(cartItem.product.name);
        $('#productModalImage').attr('src', '/' + cartItem.product.image);
        $('#productModalPrice').text('$' + cartItem.product.price);
        $('#productQuantity').text(cartItem.quantity);
        $('#addToCartButton').data('product-id', cartItem.product.id);
        $('#addToCartButton').data('is-editing', true);
        $('#addToCartButton').html('Editar')

        // Solicita las salsas y extras del producto
        getSaucesAndExtras(productId, function (saucesData, extrasData) {
            // Llena la modal con las salsas y extras del producto
            fillSaucesAndExtras(saucesData, extrasData);

            // Marca las salsas y extras que se habían seleccionado previamente
            var sauceId = cartItem.sauce.id;

            // Selecciona la salsa
            $('#sauce' + sauceId).prop('checked', true);

            // Selecciona los extras
            var extras = cartItem.extras;
            extras.forEach(function (extra, index) {
                var extraId = extra.id;
                $('#extra' + (index + 1) + '_' + extraId).prop('checked', true);
            });
        });

        // Muestra la modal
        productModal.show();
    });

    $(document).on('click', '.delete-button', function (e) {
        e.preventDefault();
        var productId = $(this).data('product-id');

        // Busca el índice del producto en el carrito
        var index = cart.findIndex(function (item) {
            return item.product.id === productId;
        });

        if (index !== -1) {
            // Si el producto está en el carrito, lo elimina
            cart.splice(index, 1);
        }

        // Actualiza la visualización del carrito
        updateCartDisplay();
        showToast('Producto eliminado del carrito.');
    });

    $(document).on('click', '#cancel-order-btn', function (e) {
        e.preventDefault();

        // Vacía el carrito
        cart = [];

        // Actualiza la visualización del carrito
        updateCartDisplay();
    });

    // Función para manejar el clic en el botón de confirmar pedido
    $('#confirm-order').click(function (e) {
        //processOrder();
        e.preventDefault();

        // Llena la modal con la información del producto y la cantidad
        $('#amount_efectivo').val(total.toFixed(2));
        $('#orderModalTotal').text('$' + total.toFixed(2));
        $('#total_amount').val(total.toFixed(2));

        // Muestra la modal
        orderModal.show();
    });

    /* $('#processOrderButton').click(function () {
        console.log('Procesando pedido...');
        processOrder();
    }); */

    $('#processOrderButton').click(function () {
        var paymentMethods = [];
        $('.payment-amount').not('#total_amount').each(function () {
            var id = $(this).attr('name').split('_')[1];
            var amount = $(this).val();
            paymentMethods.push({ id: id, amount: amount });
        });
        var notes = $('#notes').val();
        /*var customerId = $('#customer_id').val();
        var customerName = $('#customer_name').val();
        var customerPhone = $('#customer_phone').val();
        var customerAddress = $('#customer_address').val();
        var customerReferencePoint = $('#customer_reference_point').val();*/
        processOrder(paymentMethods, customerWithContactsData, notes);
    });

    $('.payment-amount').on('input', function () {
        // Inicializa el total a 0
        var totalPaymentMethods = 0;

        // Suma las cantidades de todos los campos de entrada
        $('.payment-amount').not('#total_amount').each(function () {
            totalPaymentMethods += Number($(this).val());
        });

        // Redondea el total a dos decimales
        totalPaymentMethods = Number(totalPaymentMethods.toFixed(2));

        // Actualiza el campo de entrada total
        $('#total_amount').val(totalPaymentMethods);

        // Redondea el total a dos decimales
        var roundedTotal = Number(total.toFixed(2));

        // Habilita o deshabilita el botón según si el total coincide con el total a pagar
        if (totalPaymentMethods === roundedTotal) {
            $('#processOrderButton').prop('disabled', false);
        } else {
            $('#processOrderButton').prop('disabled', true);
        }
    });
});