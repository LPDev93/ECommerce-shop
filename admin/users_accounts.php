<?php

/* Conexión a la DB Local */
include '../components/connect.php';

/* Inicio de sesión & validación */
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

/* Eliminar una cuenta de la BD */
if (isset($_GET['delete'])) {

    // Variables GET
    $delete_id = $_GET['delete'];

    // Consulta para borrar usuarios
    $delete_user = $conn->prepare(
        "DELETE FROM `users`
        WHERE id = ?"
    );
    $delete_user->execute([$delete_id]);

    // Consulta para borrar órdenes de usuarios
    $delete_order = $conn->prepare(
        "DELETE FROM `orders`
        WHERE user_id = ?"
    );
    $delete_order->execute([$delete_id]);

    // Consulta para borrar carrito
    $delete_cart = $conn->prepare(
        "DELETE FROM `cart`
        WHERE user_id = ?"
    );
    $delete_cart->execute([$delete_id]);

    // Consulta para borrar mensajes
    $delete_messages = $conn->prepare(
        "DELETE FROM `messages`
        WHERE user_id = ?"
    );
    $delete_messages->execute([$delete_id]);

    // Consulta para borrar lista de deseos
    $delete_wishlist = $conn->prepare(
        "DELETE FROM `wishlist`
        WHERE user_id = ?"
    );
    $delete_wishlist->execute([$delete_id]);

    // Actlizamos la página una vez realizada la acción
    header('location:users_accounts.php');
}

?>
<!-- HTML Doc-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuentas Usuarios - Admin</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/admin_styles.css">
</head>

<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include '../components/admin_header.php' ?>

    <!-- User accounts section starts -->
    <section class="accounts">
        <!-- Título principal -->
        <h1 class="heading">Cuentas de Usuarios</h1>
        <!-- Contenedor -->
        <div class="box-container">
            <!-- Consulta para mostrar todos los usuarios -->
            <?php
            $select_account = $conn->prepare(
                "SELECT *
                FROM `users`"
            );
            $select_account->execute();
            if ($select_account->rowCount() > 0) {
                while ($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box">
                        <p>ID: <span><?= $fetch_accounts['id'] ?></span></p>
                        <p>Usuario: <span><?= $fetch_accounts['name'] ?></span></p>
                        <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return('¿Borrar este usuario?');">Borrar</a>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">¡Aún no hay usuarios!</p>';
            }
            ?>
        </div>
    </section>
    <!-- Admin accounts section ends -->

    <!-- custom JS script link -->
    <script src="../js/admin_script.js"></script>

</body>

</html>