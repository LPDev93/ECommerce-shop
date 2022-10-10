<?php

// Agregar producto a la lista de deseos
if (isset($_POST['add_to_wishlist'])) {

    // Validamos si hay una sesión abierta
    if ($user_id == '') {
        header('location:user_login.php');
    } else {
        // Variables POST
        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $image = $_POST['image'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);

        // Consulta a la BD - Lista de deseos
        $check_wishlist_numbers = $conn->prepare(
            "SELECT *
            FROM `wishlist`
            WHERE name = ?
            AND user_id = ?"
        );
        $check_wishlist_numbers->execute([$name, $user_id]);

        // Consulta a la BD - Carrito
        $check_cart_numbers = $conn->prepare(
            "SELECT *
            FROM `cart`
            WHERE name = ?
            AND user_id = ? "
        );
        $check_cart_numbers->execute([$name, $user_id]);

        // Validamos sí los productos ya están añadidos
        if ($check_wishlist_numbers->rowCount() > 0) {
            $message[] = 'El producto ya está en tu lista de deseos';
        } else if ($check_cart_numbers->rowCount() > 0) {
            $message[] = 'El producto ya está en tu carrito';
        } else {
            // Insertamos los valores a la lista de deseos
            $insert_wishlist = $conn->prepare(
                "INSERT
                INTO `wishlist`(user_id, pid, name, price, image)
                VALUES(?, ?, ?, ? ,?)"
            );
            $insert_wishlist->execute([$user_id, $pid, $name, $price, $image]);
            $message[] = 'Producto añadido a la lista de deseos';
        }
    }
}

// Agregar producto al carrito
if (isset($_POST['add_to_cart'])) {

    // Validamos si hay una sesión abierta
    if ($user_id == '') {
        header('location:user_login.php');
    } else {
        // Variables POST
        $pid = $_POST['pid'];
        $pid = filter_var($pid, FILTER_SANITIZE_STRING);
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $price = $_POST['price'];
        $price = filter_var($price, FILTER_SANITIZE_STRING);
        $image = $_POST['image'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $qty = $_POST['qty'];
        $qty = filter_var($qty, FILTER_SANITIZE_STRING);

        // Consulta a la BD - Carrito
        $check_cart_numbers = $conn->prepare(
            "SELECT *
            FROM `cart`
            WHERE name = ?
            AND user_id = ? "
        );
        $check_cart_numbers->execute([$name, $user_id]);

        // Validamos si el producto está ya en el carrito
        if ($check_cart_numbers->rowCount() > 0) {
            $message[] = "Producto ya el carrito";
        } else {
            // Consulta a la BD - Lista de deseo
            $check_wishlist_numbers = $conn->prepare(
                "SELECT * 
                FROM `wishlist` 
                WHERE name = ? 
                AND user_id = ?"
            );
            $check_wishlist_numbers->execute([$name, $user_id]);
            // Eliminamos producto de la lista de deseos sí se compra   
            if ($check_wishlist_numbers->rowCount() > 0) {
                $delete_wishlist = $conn->prepare(
                    "DELETE
                FROM `wishlist`
                WHERE name = ?
                AND user_id = ?"
                );
                $delete_wishlist->execute([$name, $user_id]);
            }
            // Insertamos los valores al carrito
            $insert_cart = $conn->prepare(
                "INSERT
                INTO `cart`(user_id, pid, name, price, quantity, image)
                VALUES(?, ?, ?, ? ,?, ?)"
            );
            $insert_cart->execute([$user_id, $pid, $name, $price, $qty, $image]);
            $message[] = 'Producto añadido al carrito';
        }
    }
}
