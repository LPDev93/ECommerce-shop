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

<!-- Cabecera -->
<header class="header">
    <!-- Componentes de la cabecera -->
    <section class="flex">
        <!-- Logo -->
        <a href="home.php" class="logo"><span>G</span>Shop</a>
        <!-- Barra de navegación -->
        <nav class="navbar">
            <a href="home.php">Inicio</a>
            <a href="about.php">Nosotros</a>
            <a href="shop.php">Tienda</a>
            <a href="orders.php">Órdenes</a>
            <a href="contact.php">Contacto</a>
        </nav>
        <!-- Iconos de navegación -->
        <div class="icons">
            <!-- Consulta para contar los productos en Wishlist & Carrito -->
            <?php
            // Wishlist contador
            $count_wishlist_items = $conn->prepare(
                "SELECT *
                FROM `wishlist`
                WHERE user_id = ?"
            );
            $count_wishlist_items->execute([$user_id]);
            $total_wishlist_items = $count_wishlist_items->rowCount();

            // Carrito contador
            $count_cart_items = $conn->prepare(
                "SELECT *
                FROM `cart`
                WHERE user_id = ?"
            );
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
            ?>
            <!-- Íconos -->
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php"><i class="fas fa-search"></i></a>
            <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_items; ?>)</span></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
            <div id="user-btn" class="fas fa-user"></div>
        </div>
        <!-- Perfil de usuario -->
        <div class="profile">
            <!-- Consulta para obtener datos de usuario -->
            <?php
            $select_profile = $conn->prepare(
                "SELECT *
                FROM `users` 
                WHERE id = ?"
            );
            $select_profile->execute([$user_id]);
            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
            ?>
                <!-- Nombre de usuario -->
                <p><?= $fetch_profile['name']; ?></p>
                <!-- Actualizar usuario -->
                <a href="update_user.php" class="btn">actualizar perfil</a>
                <!-- Botones -->
                <div class="flex-btn">
                    <a href="user_register.php" class="option-btn">registro</a>
                    <a href="user_login.php" class="option-btn">ingresar</a>
                </div>
                <!-- Desconectar cuenta -->
                <a href="components/user_logout.php" class="delete-btn" onclick="return confirm('¿Cerrar sesión?');">Salir</a>
            <?php
            } else {
            ?>
                <p>Ingresa a tu cuenta primero</p>
                <!-- Botones -->
                <div class="flex-btn">
                    <a href="user_register.php" class="option-btn">registro</a>
                    <a href="user_login.php" class="option-btn">ingresar</a>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
</header>