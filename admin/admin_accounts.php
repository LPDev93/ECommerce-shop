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
    $delete_admin= $conn->prepare(
        "DELETE FROM `admins`
        WHERE id = ?"
    );
    $delete_admin->execute([$delete_id]);

    // Actlizamos la página una vez realizada la acción
    header('location:admin_accounts.php');
}

?>
<!-- HTML Doc-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuentas Administradores - Admin</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/admin_styles.css">
</head>

<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include '../components/admin_header.php' ?>

    <!-- Admin accounts section starts -->
    <section class="accounts">
        <!-- Título principal -->
        <h1 class="heading">Cuentas Administrativas</h1>
        <!-- Contenedor -->
        <div class="box-container">
            <!-- Registrar un nuevo administrador -->
            <div class="box">
                <p>¿Deseas registrar un nuevo administrador?</p>
                <a href="register_admin.php" class="option-btn">Registro</a>
            </div>
            <!-- Consulta para mostrar todos los usuarios -->
            <?php
            $select_account = $conn->prepare(
                "SELECT *
                FROM `admins`"
            );
            $select_account->execute();
            if ($select_account->rowCount() > 0) {
                while ($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="box">
                        <p>ID: <span><?= $fetch_accounts['id'] ?></span></p>
                        <p>Usuario: <span><?= $fetch_accounts['name'] ?></span></p>
                        <!-- Botones -->
                        <div class="flex-btn">
                            <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('¿Desea borrar está cuenta?');">Borrar</a>                            
                            <?php
                            // Actulizar datos de la cuenta, sí es la misma que ha iniciado sesión
                            if ($fetch_accounts['id'] == $admin_id) {
                                echo '<a href="update_profile.php" class="option-btn">Actualizar</a>';
                            }
                            ?>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty">¡Aún no hay usuarios administrativos!</p>';
            }
            ?>
        </div>
    </section>
    <!-- Admin accounts section ends -->

    <!-- custom JS script link -->
    <script src="../js/admin_script.js"></script>

</body>

</html>