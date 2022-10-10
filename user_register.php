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

/* Validar registro */
if (isset($_POST['submit'])) {

    // Variables POST
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

    // Consulta BD - Usuarios
    $select_user = $conn->prepare(
        "SELECT *
        FROM `users`
        WHERE email = ?"
    );
    $select_user->execute([$email]);

    // Validación de credenciales
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        $message[] = 'El usuario ya existe.';
    } else {
        // Validación de contraseñas iguales
        if ($pass != $cpass) {
            $message[] = '¡Las contraseñas no son iguales';
        } else {
            $insert_user = $conn->prepare(
                "INSERT 
                INTO `users`(name, email, password)
                VALUES(?, ?, ?)"
            );
            $insert_user->execute([$name, $email, $pass]);
            $message[] = '¡Usuario registrado con éxito!';
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
    <title>E-Commerce - Registro</title>
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
            <h3>Regístrate ahora</h3>
            <!-- Nombre de usuario -->
            <input type="text" maxlength="50" name="name" placeholder="Ingrese su nombre" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
            <!-- Email de usuario -->
            <input type="email" maxlength="50" name="email" placeholder="Ingrese su correo" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
            <!-- Password de usuario -->
            <input type="password" maxlength="20" name="pass" placeholder="Ingrese su contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
            <!-- RE-Password de usuario -->
            <input type="password" maxlength="20" name="cpass" placeholder="Confirme su contraseña" class="box" oninput="this.value = this.value.replace(/\s/g, '')" required>
            <!-- Botón de log in -->
            <input type="submit" value="Registrar" class="btn" name="submit">
            <!-- Registro nuevo -->
            <p>¿Ya estás registrado?</p>
            <a href="user_login.php" class="option-btn">Ingresa</a>
        </form>
    </section>
    <!-- User Create Section Ends -->

    <!-- Se incluye el pie de página del sitio -->
    <?php include 'components/footer.php' ?>

    <!-- custom JS script link -->
    <script src="js/general_script.js"></script>

</body>

</html>