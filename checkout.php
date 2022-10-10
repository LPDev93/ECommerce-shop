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

/* Formulario de pasarela de pago */
if (isset($_POST['order'])) {

    // Variables POST
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $address = $_POST['flat'] . ', ' . $_POST['street'] . ',' . $_POST['city'] . ',' . $_POST['state'] . ',' . $_POST['country'] . '-' . $_POST['pin_code'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $total_products = $_POST['total_products'];
    $total_products = filter_var($total_products, FILTER_SANITIZE_STRING);
    $total_price = $_POST['total_price'];
    $total_price = filter_var($total_price, FILTER_SANITIZE_STRING);

    // Consulta a la BD - carrito
    $check_cart = $conn->prepare(
        "SELECT *
        FROM `cart`
        WHERE user_id = ?"
    );
    $check_cart->execute([$user_id]);

    // Condicional sí hay información se añade la orden
    if ($check_cart->rowCount() > 0) {
        $insert_order = $conn->prepare(
            "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price)
            VALUES(?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $insert_order->execute([
            $user_id,
            $name,
            $number,
            $email,
            $method,
            $address,
            $total_products,
            $total_price
        ]);

        // Mensaje de confirmación
        $message[] = "Tú orden ha sido recibida.";

        // Borramos los productos del carrito una vez completada la orden
        $delete_cart = $conn->prepare(
            "DELETE FROM `cart`
            WHERE user_id = ?"
        );
        $delete_cart->execute([$user_id]);
    } else {
        $message[] = "Tú carrito está vacío";
    }
}

?>

<!-- HTML Doc-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce - Pasarela de Pago</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/general_style.css">
</head>

<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include 'components/user_header.php' ?>

    <!-- Checkout section starts -->
    <section class="checkout">
        <!-- Título Principal -->
        <h1 class="heading">Tus órdenes</h1>
        <!-- Ordenes -->
        <div class="display-orders">
            <!-- Consulta BD - cart -->
            <?php
            $grand_total = 0;
            $cart_items[] = '';
            $select_cart = $conn->prepare(
                "SELECT *
             FROM `cart`
             WHERE user_id = ?"
            );
            $select_cart->execute([$user_id]);

            /* Mostrar información sí hay información */
            if ($select_cart->rowCount() > 0) {
                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                    $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                    $cart_items[] = $fetch_cart['name'] . '(' . $fetch_cart['quantity'] . ') -';
                    $total_products = implode($cart_items);
            ?>
                    <p><?= $fetch_cart['name']; ?> <span>S/. <?= $fetch_cart['price']; ?>/- x <?= $fetch_cart['quantity']; ?></span></p>
            <?php
                }
            } else {
                echo '<p class="empty">Tú carrtio está vacío</p>';
            }
            ?>
        </div>
        <!-- Mostrar total en soles -->
        <p class="grand-total">Total: <span><?= $grand_total; ?>/-</span></p>
        <!-- Formulario de finalizar compra -->
        <form action="" method="POST">
            <!-- Título Principal -->
            <h1 class="heading">Ingresa tus datos</h1>
            <!-- Pasamos el Total de productos y precios -->
            <input type="hidden" name="total_products" value="<?= $total_products; ?>">
            <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
            <!-- Contenedor de Formulario -->
            <div class="flex">
                <!-- Nombre de usuario -->
                <div class="inputBox">
                    <span>Nombre completo: </span>
                    <input type="text" name="name" maxlength="20" placeholder="Ingresa tu nombre" class="box" required>
                </div>
                <!-- Telefono de usuario -->
                <div class="inputBox">
                    <span>Teléfono: </span>
                    <input type="number" name="number" min="0" max="999999999" onkeypress="if(this.value.length == 10) return false;" placeholder="Ingresa tu nombre" class="box" required>
                </div>
                <!-- Correo de usuario -->
                <div class="inputBox">
                    <span>Correo electrónico: </span>
                    <input type="email" name="email" maxlength="50" placeholder="Ingresa tu correo electrónico" class="box" required>
                </div>
                <!-- Método de pago -->
                <div class="inputBox">
                    <span>Método de pago: </span>
                    <select name="method" class="box">
                        <option value="cash on delivery">Pago contra entrega</option>
                        <option value="credit card">Tarjeta de crédito</option>
                        <option value="paypal">Paypal</option>
                    </select>
                </div>
                <!-- Dirección 01 de usuario -->
                <div class="inputBox">
                    <span>Número de domicilio: </span>
                    <input type="text" name="flat" maxlength="50" placeholder="N° de puerta" class="box" required>
                </div>
                <!-- Dirección 02 de usuario -->
                <div class="inputBox">
                    <span>Dirección exacta: </span>
                    <input type="text" name="street" maxlength="50" placeholder="Ingrese la dirección donde vive" class="box" required>
                </div>
                <!-- Dirección 03 de usuario -->
                <div class="inputBox">
                    <span>Distrito: </span>
                    <input type="text" name="city" maxlength="50" placeholder="Ingrese su distrito" class="box" required>
                </div>
                <!-- Dirección 04 de usuario -->
                <div class="inputBox">
                    <span>Ciudad: </span>
                    <input type="text" name="state" maxlength="50" placeholder="Ingrese su ciudad" class="box" required>
                </div>
                <!-- Dirección 05 de usuario -->
                <div class="inputBox">
                    <span>País: </span>
                    <input type="text" name="country" maxlength="50" placeholder="Ingrese su país" class="box" required>
                </div>
                <!-- Dirección 06 de usuario -->
                <div class="inputBox">
                    <span>Código Postal: </span>
                    <input type="number" name="pin_code" min="10000" max="99999" onkeypress="if(this.value.length == 6) return false;" placeholder="15047" class="box" required>
                </div>
            </div>
            <!-- Botón de envío -->
            <input type="submit" value="Confirma tu compra" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" name=" order">
        </form>
    </section>
    <!-- Checkout section ends -->

    <!-- Se incluye el pie de página del sitio -->
    <?php include 'components/footer.php' ?>

    <!-- custom JS script link -->
    <script src="js/general_script.js"></script>

</body>

</html>