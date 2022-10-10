<?php

/* Conexión a la DB Local */
include 'components/connect.php';

/* Validar si hay una sesión activa */
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

?>

<!-- HTML Doc-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce - Órdenes</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/general_style.css">
</head>


<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include 'components/user_header.php' ?>

    <!-- Orders section starts -->
    <section class="show-orders">
        <!-- Título principal -->
        <h1 class="heading">órdenes</h1>
        <!-- Contenedor -->
        <div class="box-container">
            <!-- Consulta a la BD - Orders -->
            <?php
            $show_orders = $conn->prepare(
                "SELECT *
                FROM `orders` 
                WHERE user_id = ?"
            );
            $show_orders->execute([$user_id]);

            // Condicional para mostrar órdenes
            if ($show_orders->rowCount() > 0) {
                while ($fetch_orders = $show_orders->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <!-- Contenedor - órdenes -->
                    <div class="box">
                        <!-- Número de órden -->
                        <h2 class="sub-heading">Órden N°<?= ($fetch_orders['id'] > 9) ? '' : '<span>0</span>'; ?><span><?= $fetch_orders['id']; ?></span></h2>
                        <!-- Fecha de pedido -->
                        <p>Fecha de pedido: <span><?= $fetch_orders['placed_on']; ?></span></p>
                        <!-- Nombre de usuario -->
                        <p>Nombes completos: <span><?= $fetch_orders['name']; ?></span></p>
                        <!-- Númbero de usuario -->
                        <p>Teléfono: <span><?= $fetch_orders['number']; ?></span></p>
                        <!-- Correo de usuario -->
                        <p>Correo electrónico: <span><?= $fetch_orders['email']; ?></span></p>
                        <!-- Productos -->
                        <p>Productos pedidos: <span><?= $fetch_orders['total_products']; ?></span></p>
                        <!-- Total pagado -->
                        <p>Total pagado: <span>S/ <?= $fetch_orders['total_price']; ?></span>/-</p>
                        <!-- Método de pago -->
                        <p>Método de pago: <span><?= $fetch_orders['method']; ?></span></p>
                        <!-- Estado de órden -->
                        <p>Estado: <span class="<?= ($fetch_orders['payment_status'] == 'pending') ? 'pending' : 'completed'; ?>"><?= $fetch_orders['payment_status']; ?></span></p>
                    </div>

            <?php
                }
            } else {
                echo '<p class="empty">No hay órdenes actualmente.</p>';
            }
            ?>
        </div>
    </section>
    <!-- Orders section ends -->

    <!-- Se incluye el pie de página del sitio -->
    <?php include 'components/footer.php' ?>

    <!-- custom JS script link -->
    <script src="js/general_script.js"></script>

</body>

</html>