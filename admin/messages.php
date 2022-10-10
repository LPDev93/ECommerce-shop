<?php

/* Conexión a la DB Local */
include '../components/connect.php';

/* Inicio de sesión & validación */
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

/* Eliminar un mensaje de la BD */
if (isset($_GET['delete'])) {

    // Variables GET
    $delete_id = $_GET['delete'];

    // Consulta para borrar mensaje
    $delete_message = $conn->prepare(
        "DELETE FROM `messages`
        WHERE id = ?"
    );
    $delete_message->execute([$delete_id]);

    // Actlizamos la página una vez realizada la acción
    header('location:messages.php');
}

?>
<!-- HTML Doc-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes - Admin</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/admin_styles.css">
</head>

<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include '../components/admin_header.php' ?>

    <!-- Messages Section starts -->
    <section class="messages">
        <!-- Título principal -->
        <h1 class="heading">Mensajes</h1>
        <!-- Contenedor -->
        <div class="box-container">
            <!-- Consulta para mostrar mensajes -->
            <?php
            $select_messages = $conn->prepare(
                "SELECT *
                FROM `messages`"
            );
            $select_messages->execute();
            if ($select_messages->rowCount() > 0) {
                while ($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box">
                        <p>ID: <span><?= $fetch_messages['id'] ?></span></p>
                        <p>Nombre: <span><?= $fetch_messages['name'] ?></span></p>
                        <p>Correo: <span><?= $fetch_messages['email'] ?></span></p>
                        <p>Teléfono: <span><?= $fetch_messages['number'] ?></span></p>
                        <p>Mensaje: <span><?= $fetch_messages['message'] ?></span></p>
                        <a href="messages.php?delete=<?= $fetch_messages['id']; ?>" class="delete-btn" onclick="return confirm('¿Borrar este mensaje?');">Borrar</a>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">¡Aún no hay mensajes!</p>';
            }
            ?>
        </div>
    </section>
    <!-- Messages Section ends -->

    <!-- custom JS script link -->
    <script src="../js/admin_script.js"></script>

</body>

</html>