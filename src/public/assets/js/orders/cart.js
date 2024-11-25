var cart = [];
var total = 0;

function addToCart(product, quantity, isEditing, sauce, extras) {
    // Busca el producto en el carrito
    var cartItem = cart.find(function (item) {
        return item.product.id === product.id;
    });

    if (cartItem) {
        if (isEditing) {
            // Si se está editando, reemplaza la cantidad
            cartItem.quantity = quantity;
            cartItem.sauce = sauce;
            cartItem.extras = extras;
        } else {
            // Si no se está editando, suma la cantidad
            cartItem.quantity += quantity;
        }
    } else {
        // Si el producto no está en el carrito, añade un nuevo elemento al carrito
        cart.push({
            product: product,
            quantity: quantity,
            sauce: sauce,
            extras: extras
        });
    }

    // Actualiza la visualización del carrito
    updateCartDisplay();
    showToast(isEditing ? 'Producto editado en el carrito.' : 'Producto agregado al carrito.');
}

// Función para actualizar la visualización del carrito
function updateCartDisplay() {
    // Inicializa el HTML del carrito
    var html = '';
    total = 0;
    // Itera sobre los productos en el carrito
    for (var i = 0; i < cart.length; i++) {
        subtotal = parseFloat(cart[i].product.price) * parseInt(cart[i].quantity);

        // Añade el producto al HTML del carrito
        html += '<div class="productCart">';
        html += '<p class="text-black fw-bold">' + cart[i].product.name + '</p>';
        html += '<p><span class="text-black fw-bold">Cantidad: </span>' + cart[i].quantity + '</p>';
        html += '<p><span class="text-black fw-bold fs-6">Precio: </span>$' + cart[i].product.price + '</p>';

        // Accede a la propiedad `text` de la salsa
        html += '<p><span class="text-black fw-bold">Salsa: </span>' + cart[i].sauce.text + '</p>';

        // Accede a la propiedad `text` de cada extra
        var extrasTexts = cart[i].extras.map(function (extra) {
            return extra.text;
        });
        html += '<p><span class="text-black fw-bold">Extras: </span>' + extrasTexts.join(', ') + '</p>';

        html += '<p><span class="text-black fw-bold">Subtotal: </span><span class="text-danger fw-bolder">$' + subtotal.toFixed(2) + '</span></p>';
        html += '<div class="d-flex justify-content-between">';
        html += '<button class="btn btn-small btn-primary edit-button noroundborder" data-product-id="' + cart[i].product.id + '"><i class="fa-solid fa-pen-to-square"></i></button>';
        html += '<button class="btn btn-small btn-danger delete-button noroundborder" data-product-id="' + cart[i].product.id + '"><i class="fa-solid fa-trash-can"></i></button>';
        html += '</div>';
        html += '<br><br></div>';

        // Añade el precio del producto al total
        total += subtotal;
    }

    // Añade el total al HTML del carrito
    $('#total').html('$' + total.toFixed(2));
    $('#total_amount').val(total.toFixed(2));

    // Actualiza el HTML del carrito
    $('#cart-items').html(html);

    toggleProcessCartButtonEnabled();
}

function toggleProcessCartButtonEnabled() {
    // Habilita o deshabilita el botón de confirmar pedido
    if (cart.length > 0) {
        $('#confirm-order').prop('disabled', false);
    } else {
        $('#confirm-order').prop('disabled', true);
    }
}

// En cart.js
function processOrder(paymentMethods, customerWithContactsData, notes) {
    $.ajax({
        url: processOrderUrl,
        method: 'POST',
        data: { cart: cart, paymentMethods: paymentMethods, customerWithContactsData: customerWithContactsData, notes },
        dataType: 'json',
        success: function (response) {
            orderModal.hide();
            if (response.success) {
                cart = [];
                updateCartDisplay();
                showToast('Pedido procesado con éxito');
            } else {
                // Muestra un mensaje de error genérico al usuario
                showToast('Hubo un error al procesar el pedido, intente nuevamente');
                // Registra el error para revisarlo más tarde
                console.error('Error al procesar el pedido:', response.message);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // Muestra un mensaje de error genérico al usuario
            showToast('Hubo un error al procesar el pedido, intente nuevamente');
            // Registra el error para revisarlo más tarde
            console.error('Error en la petición AJAX:', textStatus, errorThrown);
        }
    });
}

var toastEl = document.getElementById('cart-toast');
var toast = new bootstrap.Toast(toastEl);

function showToast(message) {
    $('#cart-toast .toast-body').text(message);
    toast.show();
}