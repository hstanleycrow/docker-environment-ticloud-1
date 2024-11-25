<?php
$this->layout(
    'Layouts/dashboard',
    [
        "title" => $title,
        "h1" => $h1,
        "useDataTablesResources" => true
    ]
);
?>
<div class="row">
    <div class="col-12 col-md-6">
        <h3>Ventas por sucursal</h3>
        <canvas id="salesPerBranch"></canvas>
    </div>

    <div class="col-12 col-md-6">
        <h3>Top 10 productos mas vendidos</h3>
        <canvas id="salesPerProduct"></canvas>
    </div>

    <div class="col-12 col-md-6">
        <h3>Top 3 productos mas vendidos por sucursal</h3>
        <canvas id="productSalesPerBranch"></canvas>
    </div>
</div>
<?php $this->start('scripts') ?>
<script>
    const ctxBranch = document.getElementById('salesPerBranch');

    new Chart(ctxBranch, {
        type: 'bar',
        data: {
            labels: ['Sucursal 1', 'Sucursal 2', 'Sucursal 3', 'Sucursal 4'], // Reemplaza esto con los nombres de tus sucursales
            datasets: [{
                label: 'Ventas',
                data: [12, 19, 3, 5], // Reemplaza esto con los datos de ventas de tus sucursales
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 99, 132, 0.6)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctxProduct = document.getElementById('salesPerProduct');
    new Chart(ctxProduct, {
        type: 'bar',
        data: {
            labels: ['Producto 1', 'Producto 2', 'Producto 3', 'Producto 4', 'Producto 5', 'Producto 6', 'Producto 7', 'Producto 8', 'Producto 9', 'Producto 10'], // Reemplaza esto con los nombres de tus productos
            datasets: [{
                label: 'Ventas',
                data: [12, 19, 3, 5, 2, 3, 7, 8, 9, 10], // Reemplaza esto con los datos de ventas de tus productos
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)',
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctxProductsBranch = document.getElementById('productSalesPerBranch');

    new Chart(ctxProductsBranch, {
        type: 'bar',
        data: {
            labels: ['Sucursal 1', 'Sucursal 2', 'Sucursal 3'], // Reemplaza esto con los nombres de tus sucursales
            datasets: [{
                label: 'Producto 1',
                data: [12, 19, 3], // Reemplaza esto con los datos de ventas del producto 1 en cada sucursal
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }, {
                label: 'Producto 2',
                data: [5, 2, 3], // Reemplaza esto con los datos de ventas del producto 2 en cada sucursal
                backgroundColor: 'rgba(255, 206, 86, 0.6)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }, {
                label: 'Producto 3',
                data: [7, 8, 9], // Reemplaza esto con los datos de ventas del producto 3 en cada sucursal
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
<?php $this->stop() ?>