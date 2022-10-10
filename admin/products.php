<?php

/* Conexión a la DB Local */
include '../components/connect.php';

/* Inicio de sesión & validación */
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

/* Crear un producto en la BD */
if (isset($_POST['add_product'])) {

    // Variables POST
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    // Variables para transformar imágenes
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_01_size = $_FILES['image_01']['size'];
    $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
    $image_01_folder = '../uploaded_img/' . $image_01;

    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_02_size = $_FILES['image_02']['size'];
    $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
    $image_02_folder = '../uploaded_img/' . $image_02;

    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_03_size = $_FILES['image_03']['size'];
    $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
    $image_03_folder = '../uploaded_img/' . $image_03;

    // Seleccionar producto de la BD
    $select_products = $conn->prepare(
        "SELECT *
        FROM `products`
        WHERE name = ?"
    );
    $select_products->execute([$name]);

    // Validación de producto & insercción
    if ($select_products->rowCount() > 0) {
        $message[] = 'El producto ya ha sido agregado.';
    } else {
        if (
            $image_01_size > 2000000 or
            $image_02_size > 2000000 or
            $image_03_size > 2000000
        ) {
            $message[] = '¡La imagen pesa mucho!';
        } else {
            move_uploaded_file($image_01_tmp_name, $image_01_folder);
            move_uploaded_file($image_02_tmp_name, $image_02_folder);
            move_uploaded_file($image_03_tmp_name, $image_03_folder);
            // Insertamos producto a la BD
            $insert_product = $conn->prepare(
                "INSERT INTO `products`(name, details, price, image_01, image_02, image_03)
                VALUES(?,?,?,?,?,?)"
            );
            $insert_product->execute([
                $name,
                $details,
                $price,
                $image_01,
                $image_02,
                $image_03
            ]);
            $message[] = '¡Producto nuevo agregado!';
        }
    }
}

// Eliminar producto
if (isset($_GET['delete'])) {
    // Obtenemos ID del producto para eliminar las imágenes enlazadas
    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare(
        "SELECT *
        FROM `products`
        WHERE id = ?"
    );
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_img/' . $fetch_delete_image['image_01']);
    unlink('../uploaded_img/' . $fetch_delete_image['image_02']);
    unlink('../uploaded_img/' . $fetch_delete_image['image_03']);

    // Obtenemos ID para eliminar producto
    $delete_product = $conn->prepare(
        "DELETE FROM `products`
        WHERE id=?"
    );
    $delete_product->execute([$delete_id]);

    // Eliminamos cualquier producto que esté en un carrito
    $delete_cart = $conn->prepare(
        "DELETE FROM `cart`
        WHERE pid=?"
    );
    $delete_cart->execute([$delete_id]);

    // Eliminamos cualquier producto que esté en la lista de deseo
    $delete_wishlist = $conn->prepare(
        "DELETE FROM `wishlist`
        WHERE pid=?"
    );
    $delete_wishlist->execute([$delete_id]);

    // Actlizamos la página una vez realizada la acción
    header('location:products.php');
}

?>
<!-- HTML Doc-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Admin</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/admin_styles.css">
</head>

<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include '../components/admin_header.php' ?>

    <!-- Add products section starts -->
    <section class="add-products">
        <!-- Título principal -->
        <h1 class="heading">agregar producto</h1>
        <!-- Formulario de productos -->
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="flex">
                <!-- Nombre de producto -->
                <div class="inputBox">
                    <span>Nombre del producto (requerido)</span>
                    <input type="text" name="name" maxlength="100" class="box" placeholder="Ingresa el nombre del producto" required>
                </div>
                <!-- Precio de producto -->
                <div class="inputBox">
                    <span>Precio del producto (requerido)</span>
                    <input type="number" name="price" min="0" max="999999999" class="box" placeholder="Ingresa el precio del producto" onkeypress="if(this.value.length == 10) return false; " required>
                </div>
                <!-- Imagen de producto 01 -->
                <div class="inputBox">
                    <span>Imagen 01 del producto (requerido)</span>
                    <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
                </div>
                <!-- Imagen de producto 02 -->
                <div class="inputBox">
                    <span>Imagen 02 del producto (requerido)</span>
                    <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
                </div>
                <!-- Imagen de producto 03 -->
                <div class="inputBox">
                    <span>Imagen 03 del producto (requerido)</span>
                    <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
                </div>
                <!-- Detalles del producto -->
                <div class="inputBox">
                    <span>Detalles del producto</span>
                    <textarea name="details" cols="30" rows="10" maxlength="500" class="box" placeholder="Ingrese todos los detalles del producto" required></textarea>
                </div>
                <!-- Botón de agregar producto -->
                <input type="submit" value="Agregar producto" name="add_product" class="btn">
            </div>
        </form>
    </section>
    <!-- Add products section ends -->

    <!-- Show products section starts -->
    <section class="show-products">
        <!-- Título principal -->
        <h1 class="heading">Productos añadidos</h1>
        <!-- Contenedor de productos -->
        <div class="box-container">
            <!-- Consulta para mostrar todos los productos -->
            <?php
            $show_products = $conn->prepare(
                "SELECT *
                FROM `products`"
            );
            $show_products->execute();
            if ($show_products->rowCount() > 0) {
                while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box">
                        <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                        <div class="name"><?= $fetch_products['name']; ?></div>
                        <div class="price">S/ <span><?= $fetch_products['price']; ?>.00</span>/-</div>
                        <div class="details"><span><?= $fetch_products['details']; ?></span></div>
                        <div class="flex-btn">
                            <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Actualizar</a> 
                            <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('¿Desea borrar este producto?');">Borrar</a>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">¡Aún no has agregado ningún producto!</p>';
            }
            ?>
        </div>
    </section>
    <!-- Show products section ends -->

    <!-- custom JS script link -->
    <script src="../js/admin_script.js"></script>

</body>

</html>