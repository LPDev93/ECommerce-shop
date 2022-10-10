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

/* Se incluye la lista de deseos activa */
include 'components/wishlist_cart.php';

/* Eliminar productos de la Lista de deseos */
if (isset($_POST['delete'])) {

    // Variables POST
    $wishlist_id = $_POST['wishlist_id'];

    // Ejecutar DELETE en la BD
    $delete_wishlist = $conn->prepare(
        "DELETE FROM `wishlist`
        WHERE id = ?"
    );
    $delete_wishlist->execute([$wishlist_id]);

    // Mensaje de confirmación
    $message[] = 'Producto de la lista de deseos eliminada';
}


/* Eliminar todos los productos de la Lista de deseos */
if (isset($_GET['delete_all'])) {

    // Variables GET
    $delete_all = $_GET['delete_all'];

    // Ejecutar DELETE en la BD
    $delete_all_wishlist = $conn->prepare(
        "DELETE FROM `wishlist`
        WHERE user_id = ?"
    );
    $delete_all_wishlist->execute([$user_id]);

    // Mensaje de confirmación
    $message[] = 'Lista de deseos eliminada';
}

?>

<!-- HTML Doc-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce - Lista de Deseos</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/general_style.css">
</head>

<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include 'components/user_header.php' ?>

    <!-- Wishlist section starts -->
    <section class="products">
        <!-- Título Principal -->
        <h1 class="heading">Lista de deseos</h1>
        <!-- Contenedor Principal -->
        <div class="box-container">
            <!-- Consulta BD - Wishlist -->
            <?php
            $grand_total = 0;
            $select_wishlist = $conn->prepare(
                "SELECT *
                FROM `wishlist`
                WHERE user_id = ?"
            );
            $select_wishlist->execute([$user_id]);
            /* Mostrar información sí hay información */
            if ($select_wishlist->rowCount() > 0) {
                while ($fetch_wishlist = $select_wishlist->fetch(PDO::FETCH_ASSOC)) {
                    // Se suman los precios de los productos
                    $grand_total += $fetch_wishlist['price'];
            ?>
                    <!-- Mostrar productos de la lista de deseos-->
                    <form action="" method="post" class="box">
                        <!-- Pasamos PID de producto -->
                        <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
                        <!-- Pasamos Nombre de producto -->
                        <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
                        <!-- Pasamos precio de producto -->
                        <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
                        <!-- Pasamos imagen de producto -->
                        <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
                        <!-- Pasamos Id de fila -->
                        <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
                        <!-- Vista rápida del producto -->
                        <a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
                        <!-- Imagen del producto -->
                        <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="Productos" class="image">
                        <!-- Nombre de producto -->
                        <div class="name"><?= $fetch_wishlist['name']; ?></div>
                        <!-- Información de producto -->
                        <div class="flex">
                            <!-- Precio de producto -->
                            <div class="price"><span><?= $fetch_wishlist['price']; ?></span>/-</div>
                            <!-- Cantidad a escoger -->
                            <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
                        </div>
                        <!-- Botón de acción -->
                        <input type="submit" value="Añadir al carrito" name="add_to_cart" class="btn">
                        <input type="submit" value="Elminar" name="delete" class="delete-btn" onclick="return confirm('¿Desea eliminar este producto de su lista de deseos?')">
                    </form>
            <?php
                }
            } else {
                echo '<p class="empty">Tú lista de deseos está vacía</p>';
            }
            ?>
        </div>
        <!-- Precio Total de productos -->
        <div class="grand-total">
            <!-- Mostrar total en soles -->
            <p class="wishlist-total">Total: <span><?= $grand_total; ?>/-</span></p>
            <!-- Botón de seguir comprando -->
            <a href="shop.php" class="option-btn">Sigue comprando</a>
            <!-- Botón de eliminar todo -->
            <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('¿Desea eliminar toda la lista de deseos?')">Borrar todo</a>
        </div>
    </section>
    <!-- Wishlist section ends -->

    <!-- Se incluye el pie de página del sitio -->
    <?php include 'components/footer.php' ?>

    <!-- custom JS script link -->
    <script src="js/general_script.js"></script>

</body>

</html>