$(document).ready(function () {
    // Manejar doble clic en salsas disponibles
    $('#available_extra_id').on('dblclick', function () {
        var selectedOption = $(this).find('option:selected');
        var extraId = selectedOption.val();

        var selectedProductOption = $('#product_id').find('option:selected');
        var productId = selectedProductOption.val();

        $.ajax({
            url: '/product_extras_processing',
            type: 'POST',
            data: {
                action: 'add',
                product_id: productId,
                extra_id: extraId
            },
            success: function (response) {
                // Si la respuesta del servidor es exitosa, mover la opción
                $('#selected_extra_id').append(selectedOption);
                showToast('Extra agregado.');
            }
        });
    });

    // Manejar doble clic en salsas seleccionadas
    $('#selected_extra_id').on('dblclick', function () {
        var selectedOption = $(this).find('option:selected');
        var extraId = selectedOption.val();

        var selectedProductOption = $('#product_id').find('option:selected');
        var productId = selectedProductOption.val();

        $.ajax({
            url: '/product_extras_processing', // Reemplaza con la ruta a tu endpoint
            type: 'POST',
            data: {
                action: 'remove',
                product_id: productId,
                extra_id: extraId
            },
            success: function (response) {
                // Si la respuesta del servidor es exitosa, mover la opción
                $('#available_extra_id').append(selectedOption);
                showToast('Extra eliminado.');
            }
        });
    });
});