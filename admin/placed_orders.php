<?php

/* Conexión a la DB Local */
include '../components/connect.php';

/* Inicio de sesión & validación */
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

/* Actualizar una orden en la BD */
if (isset($_POST['update_payment'])) {

    // Variables POST
    $order_id = $_POST['order_id'];
    $payment_status = $_POST['payment_status'];

    // Actualizar estado de la órden en la BD
    $update_status = $conn->prepare(
        "UPDATE `orders`
        SET payment_status = ?
        WHERE id = ?"
    );
    $update_status->execute([$payment_status, $order_id]);

    // Mensaje de actualización
    $message[] = '¡El estado se actualizó!';
}

/* Eliminar una órden de la BD */
if (isset($_GET['delete'])) {

    // Variables GET
    $delete_id = $_GET['delete'];

    // Consulta para borrar órden
    $delete_order = $conn->prepare(
        "DELETE FROM `orders`
        WHERE id = ?"
    );
    $delete_order->execute([$delete_id]);

    // Actlizamos la página una vez realizada la acción
    header('location:placed_orders.php');
}

?>
<!-- HTML Doc-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordenes - Admin</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/admin_styles.css">
</head>

<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include '../components/admin_header.php' ?>

    <!-- Placed orders section starts -->
    <section class="placed-orders">
        <!-- Título principal -->
        <h1 class="heading">Órdenes Tomadas</h1>
        <!-- Contenedor -->
        <div class="box-container">
            <!-- Consulta para mostrar todos las órdenes -->
            <?php
            $select_orders = $conn->prepare(
                "SELECT *
                FROM `orders`"
            );
            $select_orders->execute();
            if ($select_orders->rowCount() > 0) {
                while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box">
                        <p>ID: <span><?= $fetch_orders['user_id'] ?></span></p>
                        <p>Fecha: <span><?= $fetch_orders['placed_on'] ?></span></p>
                        <p>Nombre: <span><?= $fetch_orders['name'] ?></span></p>
                        <p>Corre0: <span><?= $fetch_orders['email'] ?></span></p>
                        <p>Teléfono: <span><?= $fetch_orders['number'] ?></span></p>
                        <p>Dirección: <span><?= $fetch_orders['address'] ?></span></p>
                        <p>Products Totales: <span><?= $fetch_orders['total_products'] ?></span></p>
                        <p>Total a pagar: <span><?= $fetch_orders['total_price'] ?>/-</span></p>
                        <p>Método de pago: <span><?= $fetch_orders['method'] ?></span></p>
                        <!-- Formulario para pasar el ID y actualizar estado de pago -->
                        <form action="" method="POST">
                            <!-- ID de producto -->
                            <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                            <!-- Seleccionar estado de pago -->
                            <select name="payment_status" class="drop-down">
                                <option value="" selected disabled>
                                    <?= $fetch_orders['payment_status']; ?>
                                </option>
                                <option value="pending">Pendiente</option>
                                <option value="completed">Completada</option>
                            </select>
                            <!-- Botones -->
                            <div class="flex-btn">
                                <input type="submit" value="actualizar" class="btn" name="update_payment">
                                <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('¿Desea borrar esta orden?');">Borrar</a>
                            </div>
                        </form>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">¡Aún no hay órdenes!</p>';
            }
            ?>

        </div>
    </section>
    <!-- Placed orders section ends -->

    <!-- custom JS script link -->
    <script src="../js/admin_script.js"></script>

</body>

</html>