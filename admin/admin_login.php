<?php

/* Conexión a la DB Local */
include '../components/connect.php';

/* Inicio de Sesión */
session_start();

/* Registro, validación y login del formulario */
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
    $select_admin->execute([$name, $pass]);
    $row = $select_admin->fetch(PDO::FETCH_ASSOC);

    if ($select_admin->rowCount() > 0) {
        $_SESSION['admin_id'] = $row['id'];
        header('location:dashboard.php');
    } else {
        $message[] = '¡Usuario o contraseña incorrecta!';
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
    <title>Login</title>
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/admin_styles.css">
</head>

<!-- Mensaje de validación-->
<?php
if (isset($message)) {
    foreach ($message as $message) {
        echo '
            <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
    }
}
?>

<body>
    <!-- admin login form section starts -->
    <section class="form-container">
        <form action="" method="POST">
            <h3>Login</h3>
            <p>usuario por defecto = <span>admin</span> & contraseña = <span>111</span></p>
            <input type="text" name="name" maxlength="20" placeholder="Usuario" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="pass" maxlength="20" placeholder="Contraseña" class="box" required oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="Ingresar" name="submit" class="btn">
        </form>
    </section>
    <!-- admin login form section ends -->
</body>

</html>