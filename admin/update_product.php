<?php

/* Conexión a la DB Local */
include '../components/connect.php';

/* Inicio de sesión & validación */
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

/* Actualizar un producto en la BD */
if (isset($_POST['update'])) {

    // Variables POST
    $pid = $_POST['pid'];
    $name = $_POST['name'];
    $name = filter_var(
        $name,
        FILTER_SANITIZE_STRING
    );
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $details = $_POST['details'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    // Actualizar producto de la BD
    $update_product = $conn->prepare(
        "UPDATE `products`
        SET name = ?, details = ?, price = ?
        WHERE id=?"
    );
    $update_product->execute([$name, $details, $price, $pid]);

    // Mensaje de actualización
    $message[] = '¡El produto se actualizó!';

    // Actualizar imágenes - 01
    $old_image_01 = $_POST['old_image_01'];
    $image_01 = $_FILES['image_01']['name'];
    $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
    $image_size_01 = $_FILES['image_01']['size'];
    $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
    $image_folder_01 = '../uploaded_img/' . $image_01;

    if (!empty($image_01)) {
        if ($image_size_01 > 2000000) {
            $message[] = '¡La imagen es muy pesada!';
        } else {
            $update_image_01 = $conn->prepare(
                "UPDATE `products` 
                SET image_03 = ? 
                WHERE id = ?"
            );
            $update_image_01->execute([$image_01, $pid]);
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            unlink('../uploaded_img/' . $old_image_01);
            $message[] = '¡El produto se actualizó!';
        }
    }

    // Actualizar imágenes - 02
    $old_image_02 = $_POST['old_image_02'];
    $image_02 = $_FILES['image_02']['name'];
    $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
    $image_size_02 = $_FILES['image_02']['size'];
    $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
    $image_folder_02 = '../uploaded_img/' . $image_02;

    if (!empty($image_02)) {
        if ($image_size_02 > 2000000) {
            $message[] = '¡La imagen es muy pesada!';
        } else {
            $update_image_02 = $conn->prepare(
                "UPDATE `products` 
                SET image_03 = ? 
                WHERE id = ?"
            );
            $update_image_02->execute([$image_02, $pid]);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            unlink('../uploaded_img/' . $old_image_02);
            $message[] = '¡El produto se actualizó!';
        }
    }

    // Actualizar imágenes - 03
    $old_image_03 = $_POST['old_image_03'];
    $image_03 = $_FILES['image_03']['name'];
    $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
    $image_size_03 = $_FILES['image_03']['size'];
    $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
    $image_folder_03 = '../uploaded_img/' . $image_03;

    if (!empty($image_03)) {
        if ($image_size_03 > 2000000) {
            $message[] = '¡La imagen es muy pesada!';
        } else {
            $update_image_03 = $conn->prepare(
                "UPDATE `products` 
                SET image_03 = ? 
                WHERE id = ?"
            );
            $update_image_03->execute([$image_03, $pid]);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            unlink('../uploaded_img/' . $old_image_03);
            $message[] = '¡El produto se actualizó!';
        }
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
    <title>Actualizar Productos - Admin</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/admin_styles.css">
</head>

<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include '../components/admin_header.php' ?>

    <!-- Update products section starts -->
    <section class="update-product">
        <!-- Título principal -->
        <h1 class="heading">actualizar producto</h1>
        <!-- Consulta para mostrar todos los productos -->
        <?php
        /* Conseguimos el id del producto */
        $update_id = $_GET['update'];
        $show_products = $conn->prepare(
            "SELECT *
            FROM `products`
            WHERE id=?"
        );
        $show_products->execute([$update_id]);
        if ($show_products->rowCount() > 0) {
            while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <!-- Creación del formulario de actualización -->
                <form action="" method="POST" enctype="multipart/form-data">
                    <!-- Mandamos información antigua a actualizar -->
                    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                    <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
                    <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
                    <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">
                    <!-- Contenedor de imágenes -->
                    <div class="image-container">
                        <div class="main-image">
                            <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                        </div>
                        <div class="sub-images">
                            <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
                            <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt="">
                            <img src="../uploaded_img/<?= $fetch_products['image_03']; ?>" alt="">
                        </div>
                    </div>
                    <!-- Nombre de producto -->
                    <span>Actualizar nombre: </span>
                    <input type="text" name="name" maxlength="100" class="box" placeholder="Ingresa el nombre del producto" value="<?= $fetch_products['name']; ?>">
                    <!-- Precio de producto -->
                    <span>Actualizar precio: </span>
                    <input type="number" name="price" min="0" max="999999999" class="box" placeholder="Ingresa el precio del producto" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>">
                    <!-- Detalles del producto -->
                    <span>Actualizar detalles: </span>
                    <textarea name="details" cols="30" rows="10" maxlength="500" class="box"><?= $fetch_products['details']; ?></textarea>
                    <!-- Imagen de producto 01 -->
                    <span>Actualizar imagen 01: </span>
                    <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                    <!-- Imagen de producto 02 -->
                    <span>Actualizar imagen 02: </span>
                    <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                    <!-- Imagen de producto 03 -->
                    <span>Actualizar imagen 03: </span>
                    <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
                    <!-- Botones -->
                    <div class="flex-btn">
                        <input type="submit" value="Actualizar" class="btn" name="update">
                        <a href="products.php" class="option-btn">Regresar</a>
                    </div>
                </form>
        <?php
            }
        } else {
            echo '<p class="empty">¡Aún no has agregado ningún producto!</p>';
        }
        ?>
    </section>
    <!-- Update products section ends -->

    <!-- custom JS script link -->
    <script src="../js/admin_script.js"></script>

</body>

</html>