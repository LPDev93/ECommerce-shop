<?php

/* Conexión a la DB Local */
include '../components/connect.php';

/* Inicio de Sesión & validación */
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:admin_login.php');
}

/* Validación del formulario */
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $update_name = $conn->prepare(
        "UPDATE `admins`
        SET name = ?
        WHERE id = ?"
    );

    $update_name->execute([$name, $admin_id]);
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
    $select_old_pass = $conn->prepare(
        "SELECT password
        FROM `admins`
        WHERE id = ?"
    );

    $select_old_pass->execute([$admin_id]);
    $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    if ($old_pass == $empty_pass) {
        $message[] = 'Ingrese su contraseña antigua';
    } elseif ($old_pass != $prev_pass) {
        $message[] = 'La contraseña previa no es identica.';
    } elseif ($new_pass != $confirm_pass) {
        $message[] = 'Las contraseñas nuevas no son iguales.';
    } else {
        if ($new_pass != $empty_pass) {
            $update_admin_pass = $conn->prepare(
                "UPDATE `admins`
                SET password = ?
                WHERE id = ?"
            );
            $update_admin_pass->execute([$confirm_pass, $admin_id]);
            $message[] = 'Se actualizó su contraseña';
        } else {
            $message[] = 'Ingrese una la nueva contraseña.';
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
    <title>Actualizar Perfil - Admin</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/admin_styles.css">
</head>

<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include '../components/admin_header.php' ?>

    <!-- admin user update section starts -->
    <section class="form-container">
        <!-- Formulario de actualización -->
        <form action="" method="POST">
            <h3>actualizar perfil</h3>
            <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
            <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" required placeholder="Ingrese su nombre de usuario" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="old_pass" placeholder="Ingrese contraseña vieja" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="new_pass" placeholder="Ingrese nueva contraseña" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="confirm_pass" placeholder="confirme nueva contraseña" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Registrarse" name="submit" class="btn">
        </form>
    </section>
    <!-- admin user update section ends -->

    <!-- custom JS script link -->
    <script src="../js/admin_script.js"></script>

</body>

</html>