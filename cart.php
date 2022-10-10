<?php

/* Conexión a la DB Local */
include 'components/connect.php';

/* Validar si hay una sesión activa */
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
}

/* Eliminar productos de la Lista de deseos */
if (isset($_POST['delete'])) {

    // Variables POST
    $cart_id = $_POST['cart_id'];

    // Ejecutar DELETE en la BD
    $delete_cart = $conn->prepare(
        "DELETE FROM `cart`
        WHERE id = ?"
    );
    $delete_cart->execute([$cart_id]);

    // Mensaje de confirmación
    $message[] = 'Producto del carrito';
}


/* Eliminar todos los productos de la Lista de deseos */
if (isset($_GET['delete_all'])) {

    // Variables GET
    $delete_all = $_GET['delete_all'];

    // Ejecutar DELETE en la BD
    $delete_all_cart = $conn->prepare(
        "DELETE FROM `cart`
        WHERE user_id = ?"
    );
    $delete_all_cart->execute([$user_id]);

    // Mensaje de confirmación
    $message[] = 'Todos los productos del carrito fueron eliminados';
}

/* Actualizar la cantidad de productos */
if (isset($_POST['update_qty'])) {

    // Variables POST
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);
    $update_qty = $conn->prepare(
        "UPDATE `cart`
        SET quantity = ?
        WHERE id = ?"
    );
    $update_qty->execute([$qty, $cart_id]);

    // Mensaje de confirmación
    $message[] = 'Se actualizó la cantidad';
}

?>

<!-- HTML Doc-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce - Carrito</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/general_style.css">
</head>

<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include 'components/user_header.php' ?>

    <!-- Cart section starts -->
    <section class="products">
        <!-- Título Principal -->
        <h1 class="heading">Carrito</h1>
        <!-- Contenedor Principal -->
        <div class="box-container">
            <!-- Consulta BD - cart -->
            <?php
            $grand_total = 0;
            $select_cart = $conn->prepare(
                "SELECT *
                FROM `cart`
                WHERE user_id = ?"
            );
            $select_cart->execute([$user_id]);

            /* Mostrar información sí hay información */
            if ($select_cart->rowCount() > 0) {
                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <!-- Mostrar productos de la lista de deseos-->
                    <form action="" method="post" class="box">
                        <!-- ID de carrito -->
                        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                        <!-- Vista rápida del producto -->
                        <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
                        <!-- Imagen del producto -->
                        <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="Productos" class="image">
                        <!-- Nombre de producto -->
                        <div class="name"><?= $fetch_cart['name']; ?></div>
                        <!-- Información de producto -->
                        <div class="flex">
                            <!-- Precio de producto -->
                            <div class="price"><span><?= $fetch_cart['price']; ?></span>/-</div>
                            <!-- Cantidad a escoger -->
                            <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" onkeypress="if(this.value.length == 2) return false;">
                            <!-- Botón para actualizar producto -->
                            <button type="submit" class="fas fa-edit" name="update_qty"></button>
                        </div>
                        <!-- Sub Total -->
                        <div class="sub-total">Sub Total: <span>S/ <?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span></div>
                        <!-- Botón de acción -->
                        <input type="submit" value="Eliminar" name="delete" class="delete-btn" onclick="return confirm('¿Desea eliminar este producto del carrito?')">
                    </form>
            <?php
                    $grand_total += $sub_total;
                }
            } else {
                echo '<p class="empty">Tú carrito está vacío</p>';
            }
            ?>
        </div>
        <!-- Precio Total de productos -->
        <div class="grand-total">
            <!-- Mostrar total en soles -->
            <p class="cart-total">Total: <span><?= $grand_total; ?>/-</span></p>
            <!-- Botón de seguir comprando -->
            <a href="shop.php" class="option-btn">Sigue comprando</a>
            <!-- Botón de eliminar todo -->
            <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('¿Desea eliminar todos los productos del carrito?')">Borrar todo</a>
            <!-- Botón de ir a pasarela de pago -->
            <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Pagar</a>
        </div>
    </section>
    <!-- Cart section ends -->

    <!-- Se incluye el pie de página del sitio -->
    <?php include 'components/footer.php' ?>

    <!-- custom JS script link -->
    <script src="js/general_script.js"></script>

</body>

</html>