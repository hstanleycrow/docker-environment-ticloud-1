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
        $('#orderModalTotal').text('$' + total);

        // Muestra la modal
        orderModal.show();
    });

    $('#processOrderButton').click(function () {
        var paymentMethod = $('input[name="payment_method"]:checked').val();
        processOrder();
    });

});



