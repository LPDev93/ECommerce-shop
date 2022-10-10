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

// Validar actualizar datos
if (isset($_POST['submit'])) {

    // Variables POST
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $update_profile = $conn->prepare(
        "UPDATE `users`
        SET name = ?, email = ?
        WHERE id = ?"
    );
    $update_profile->execute([$name, $email, $user_id]);
    header('location:home.php');

    // Variables contraseña
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709'; // vacío
    $select_prev_pass = $conn->prepare(
        "SELECT password
        FROM `users`
        WHERE id = ?"
    );
    $select_prev_pass->execute([$user_id]);
    $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

    // Validar contraseña antigua
    if ($old_pass == $empty_pass) {
        $message[] = 'Por favor, ingrese la contraseña anterior.';
    } elseif ($old_pass != $prev_pass) {
        $message[] = 'La contraseña antigüa no es la correcta.';
    } elseif ($new_pass != $confirm_pass) {
        $message[] = 'Las contraseñas no son iguales.';
    } else {
        if ($new_pass != $empty_pass) {
            $update_user_pass = $conn->prepare(
                "UPDATE `users`
                SET password = ?
                WHERE id = ?"
            );
            $update_user_pass->execute([$confirm_pass, $user_id]);
            $message[] = 'Se actualizó la contraseña';
            header('location:components/user_logout.php');
        } else {
            $message[] = '¡Por favor, ingrese una contraseña nueva!';
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
    <title>E-Commerce - Actualizar Perfil</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/general_style.css">
</head>


<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include 'components/user_header.php' ?>

    <!-- User Create Section Starts -->
    <section class="form-container">
        <!-- Formulario de inicio de sesión -->
        <form action="" method="POST">
            <!-- Título principal -->
            <h3>Actualizar datos</h3>
            <!-- Contraseña antigüa -->
            <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">
            <!-- Nombre de usuario -->
            <input type="text" maxlength="50" name="name" placeholder="Ingrese su nombre" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile['name']; ?>" required>
            <!-- Email de usuario -->
            <input type="email" maxlength="50" name="email" placeholder="Ingrese su correo" class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile['email']; ?>" required>
            <!-- Password Antigüo de usuario -->
            <input type="password" maxlength="20" name="old_pass" placeholder="Ingrese su contraseña anterior" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <!-- Password  Nuevo de usuario -->
            <input type="password" maxlength="20" name="new_pass" placeholder="Ingrese su contraseña nueva" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <!-- R-Password  Nuevo de usuario -->
            <input type="password" maxlength="20" name="confirm_pass" placeholder="Confirme su contraseña nueva" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
            <!-- Botón de log in -->
            <input type="submit" value="Actualizar" class="btn" name="submit">
        </form>
    </section>
    <!-- User Create Section Ends -->

    <!-- Se incluye el pie de página del sitio -->
    <?php include 'components/footer.php' ?>

    <!-- custom JS script link -->
    <script src="js/general_script.js"></script>

</body>

</html>