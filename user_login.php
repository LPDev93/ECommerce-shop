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

/* Validar si iniciaron sesión */
if (isset($_POST['submit'])) {

    // Variables POST
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    // Consulta BD - Usuarios
    $select_user = $conn->prepare(
        "SELECT *
        FROM `users`
        WHERE email = ?
        AND password = ?"
    );
    $select_user->execute([$email, $pass]);

    // Validación de credenciales
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        $_SESSION['user_id'] = $row['id'];
        header('location:home.php');
    } else {
        $message[] = "Correo o contraseña incorrectos";
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
    <title>E-Commerce - Ingresar</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/general_style.css">
</head>

<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include 'components/user_header.php' ?>

    <!-- User Login Section Starts -->
    <section class="form-container">
        <!-- Formulario de inicio de sesión -->
        <form action="" method="POST" class="user-login">
            <!-- Título principal -->
            <h3>Ingresa ahora</h3>
            <!-- Email de usuario -->
            <input type="email" maxlength="50" name="email" placeholder="Ingrese su correo" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
            <!-- Password de usuario -->
            <input type="password" maxlength="20" name="pass" placeholder="Ingrese su contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
            <!-- Botón de log in -->
            <input type="submit" value="Ingresar" class="btn" name="submit">
            <!-- Registro nuevo -->
            <p>¿No estás registrado?</p>
            <a href="user_register.php" class="option-btn">Regístrate</a>

        </form>
    </section>
    <!-- User Login Section Ends -->

    <!-- Se incluye el pie de página del sitio -->
    <?php include 'components/footer.php' ?>

    <!-- custom JS script link -->
    <script src="js/general_script.js"></script>

</body>

</html>