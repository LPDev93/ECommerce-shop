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

// Validamos formulario
if (isset($_POST['send'])) {

    // Variables POST_
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    // Validar mensaje en la BD
    $select_message = $conn->prepare(
        "SELECT *
        FROM `messages`
        WHERE name = ?
        AND email = ?
        AND number = ?
        AND message = ?"
    );
    // Pasamos parámetros
    $select_message->execute([
        $name,
        $email,
        $number,
        $msg
    ]);
    // Enviamos mensaje a la BD
    $send_message = $conn->prepare(
        "INSERT
            INTO `messages`(name, email, number, message)
            VALUES(?, ?, ?, ?)"
    );
    // Pasamos parámetros
    $send_message->execute([
        $name,        $email,
        $number,
        $msg
    ]);
    // Mensaje de envío
    $message[] = 'Se envío su mensaje. Espere por nuestra respuesta, ¡Gracias!';
}

?>

<!-- HTML Doc-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce - Contacto</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/general_style.css">
</head>

<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include 'components/user_header.php' ?>

    <!-- Contact section starts -->
    <section class="form-container">
        <!-- Título principal -->
        <h3 class="heading">Contacto</h3>
        <!-- Contenedor -->
        <form action="" method="POST" class="box">
            <!-- Título secundario -->
            <h3 class="heading">¡Salúdanos!</h3>
            <!-- Nombre -->
            <input type="text" name="name" placeholder="Ingrese su nombre" maxlength="20" class="box" required>
            <!-- Número -->
            <input type="number" name="number" max="999999999" min="900000000" class="box" placeholder="Ingrese su teléfono" onkeypress="if(this.value.length == 9) return false;" required>
            <!-- Correo -->
            <input type="email" name="email" maxlength="50" class="box" placeholder="Ingrese su correo" required>
            <!-- Mensaje -->
            <textarea name="msg" cols="30" rows="10" class="box" placeholder="Ingrese su mensaje" required></textarea>
            <!-- Botón de enviar -->
            <input type="submit" value="Enviar" class="btn" name="send">
        </form>
    </section>
    <!-- Contact section ends -->

    <!-- Se incluye el pie de página del sitio -->
    <?php include 'components/footer.php' ?>

    <!-- custom JS script link -->
    <script src="js/general_script.js"></script>

</body>

</html>