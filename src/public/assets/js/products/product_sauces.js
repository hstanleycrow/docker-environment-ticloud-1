$(document).ready(function () {
    // Manejar doble clic en salsas disponibles
    $('#available_sauce_id').on('dblclick', function () {
        var selectedOption = $(this).find('option:selected');
        var sauceId = selectedOption.val();

        var selectedProductOption = $('#product_id').find('option:selected');
        var productId = selectedProductOption.val();

        $.ajax({
            url: '/product_sauces_processing',
            type: 'POST',
            data: {
                action: 'add',
                product_id: productId,
                sauce_id: sauceId
            },
            success: function (response) {
                // Si la respuesta del servidor es exitosa, mover la opción
                $('#selected_sauce_id').append(selectedOption);
                showToast('Salsa agregada.');
            }
        });
    });

    // Manejar doble clic en salsas seleccionadas
    $('#selected_sauce_id').on('dblclick', function () {
        var selectedOption = $(this).find('option:selected');
        var sauceId = selectedOption.val();

        var selectedProductOption = $('#product_id').find('option:selected');
        var productId = selectedProductOption.val();

        $.ajax({
            url: '/product_sauces_processing', // Reemplaza con la ruta a tu endpoint
            type: 'POST',
            data: {
                action: 'remove',
                product_id: productId,
                sauce_id: sauceId
            },
            success: function (response) {
                // Si la respuesta del servidor es exitosa, mover la opción
                $('#available_sauce_id').append(selectedOption);
                showToast('Salsa eliminada.');
            }
        });
    });
});