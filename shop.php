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

include 'components/wishlist_cart.php';

?>

<!-- HTML Doc-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce - Tienda</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/general_style.css">
</head>


<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include 'components/user_header.php' ?>

    <!-- Shop section starts -->
    <section class="products">
        <!-- Título principal -->
        <h1 class="heading">Tienda</h1>
        <!-- contenedor -->
        <div class="box-container">
            <?php
            $select_products = $conn->prepare(
                "SELECT *
                FROM `products`"
            );
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <form action="" method="POST" class="box">
                        <!-- Pasamos ID de producto -->
                        <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                        <!-- Pasamos nombre de producto -->
                        <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                        <!-- Pasamos precio de producto -->
                        <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                        <!-- Pasamos imagen de producto -->
                        <input type="hidden" name="image" value="<?= $fetch_products['image_01']; ?>">
                        <!-- Boton de agregar a lista de deseos -->
                        <button type="submit" name="add_to_wishlist" class="fas fa-heart"></button>
                        <!-- Vista rápida -->
                        <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                        <!-- 1ra imagen de cada producto -->
                        <img src="uploaded_img/<?= $fetch_products['image_01']; ?>" alt="Productos" class="image">
                        <!-- Nombre del productos -->
                        <div class="name"><?= $fetch_products['name']; ?></div>
                        <div class="flex">
                            <!-- Precio del producto -->
                            <div class="price">$ <span><?= $fetch_products['price']; ?></span></div>
                            <!-- Cantidad -->
                            <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
                        </div>
                        <!-- Agregar al carrito -->
                        <input type="submit" value="Agregar al carrito" name="add_to_cart" class="btn">
                    </form>
            <?php
                }
            } else {
                echo '<p class="empty">No hay productos por el momento</p>';
            }
            ?>
        </div>
    </section>
    <!-- Shop section ends -->

    <!-- Se incluye el pie de página del sitio -->
    <?php include 'components/footer.php' ?>

    <!-- custom JS script link -->
    <script src="js/general_script.js"></script>

</body>

</html>