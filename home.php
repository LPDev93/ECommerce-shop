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

/* Incluimos la lista de deseos */
include 'components/wishlist_cart.php';

?>

<!-- HTML Doc-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce - Inicio</title>
    <!-- Swiper CDN link -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <!-- Font awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/general_style.css">
</head>

<body>

    <!-- Se incluye la cabecera del sitio -->
    <?php include 'components/user_header.php' ?>

    <!-- Background del Home -->
    <div class="home-bg">
        <section class="home">
            <!-- Home carrusel -->
            <div class="swiper home-slider">
                <!-- Slider Class Swipper CDN -->
                <div class="swiper-wrapper">
                    <!-- Primer Slide -->
                    <div class="swiper-slide slide">
                        <!-- Imagen 01 -->
                        <div class="image">
                            <img src="images/home-img-1.png" alt="Imagen">
                        </div>
                        <!-- Contenido 01 -->
                        <div class="content">
                            <span>Oferta del 50%</span>
                            <h3>Nuevos Smarthphones</h3>
                            <a href="shop.php" class="btn">¡Ver tienda!</a>
                        </div>
                    </div>
                    <!-- Segundo Slide -->
                    <div class="swiper-slide slide">
                        <!-- Imagen 02 -->
                        <div class="image">
                            <img src="images/home-img-2.png" alt="Imagen">
                        </div>
                        <!-- Contenido 02 -->
                        <div class="content">
                            <span>Oferta del 30%</span>
                            <h3>Nuevos Relojes</h3>
                            <a href="shop.php" class="btn">¡Ver tienda!</a>
                        </div>
                    </div>
                    <!-- Tercer Slide -->
                    <div class="swiper-slide slide">
                        <!-- Imagen 03 -->
                        <div class="image">
                            <img src="images/home-img-3.png" alt="Imagen">
                        </div>
                        <!-- Contenido 02 -->
                        <div class="content">
                            <span>Oferta del 50%</span>
                            <h3>Nuevos Audifonos</h3>
                            <a href="shop.php" class="btn">¡Ver tienda!</a>
                        </div>
                    </div>
                </div>
                <!-- Swiper CDN paginación -->
                <div class="swiper-pagination"></div>
            </div>
        </section>
    </div>

    <!-- Categories starts -->
    <section class="home-category">
        <!-- Categoria carrusel -->
        <div class="swiper category-slider">
            <!-- Carrusel principal -->
            <div class="swiper-wrapper">
                <!-- Categoría Laptops -->
                <a href="category.php?category=laptop" class="swiper-slide slide">
                    <img src="images/icon-1.png" alt="Laptops">
                    <h3>Laptops</h3>
                </a>
                <!-- Categoría TV -->
                <a href="category.php?category=monitor" class="swiper-slide slide">
                    <img src="images/icon-2.png" alt="Monitores">
                    <h3>Monitores</h3>
                </a>
                <!-- Categoría Cámaras -->
                <a href="category.php?category=camera" class="swiper-slide slide">
                    <img src="images/icon-3.png" alt="Cámaras">
                    <h3>Cámaras</h3>
                </a>
                <!-- Categoría Mouse -->
                <a href="category.php?category=mouse" class="swiper-slide slide">
                    <img src="images/icon-4.png" alt="Mouse">
                    <h3>Mouse</h3>
                </a>
                <!-- Categoría Refrigeradoras -->
                <a href="category.php?category=fridge" class="swiper-slide slide">
                    <img src="images/icon-5.png" alt="Refrigeradoras">
                    <h3>Refrigeradoras</h3>
                </a>
                <!-- Categoría Lavadoras -->
                <a href="category.php?category=washing" class="swiper-slide slide">
                    <img src="images/icon-6.png" alt="Lavadoras">
                    <h3>Lavadoras</h3>
                </a>
                <!-- Categoría Teléfonos -->
                <a href="category.php?category=smartphone" class="swiper-slide slide">
                    <img src="images/icon-7.png" alt="Smartphones">
                    <h3>Smartphone</h3>
                </a>
                <!-- Categoría Relojes -->
                <a href="category.php?category=watch" class="swiper-slide slide">
                    <img src="images/icon-8.png" alt="Relojes">
                    <h3>Relojes</h3>
                </a>
            </div>
            <!-- Swiper CDN paginación -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- Categories ends -->

    <!-- Products starts-->
    <section class="home-products">
        <!-- Título principal -->
        <h1 class="heading">Últimos productos</h1>
        <!-- Productos Carrusel -->
        <div class="swiper products-slider">
            <!-- Slider Class Swipper CDN -->
            <div class="swiper-wrapper">
                <?php
                $select_products = $conn->prepare(
                    "SELECT *
                    FROM `products`
                    LIMIT 6"
                );
                $select_products->execute();
                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <form action="" method="POST" class="slide swiper-slide">
                            <!-- Pasamos ID de producto -->
                            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                            <!-- Pasamos nombre de producto -->
                            <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                            <!-- Pasamos precio de producto -->
                            <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                            <!-- Pasamos imagen de producto -->
                            <input type="hidden" name="image" value="<?= $fetch_products['image_01']; ?>">
                            <!-- Boton de agregar a lista de deseos -->
                            <button type="submit" name="add_to_wishlist" class="fas fa-heart"></button>
                            <!-- Vista rápida -->
                            <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                            <!-- 1ra imagen de cada producto -->
                            <img src="uploaded_img/<?= $fetch_products['image_01']; ?>" alt="Productos" class="image">
                            <!-- Nombre del productos -->
                            <div class="name"><?= $fetch_products['name']; ?></div>
                            <div class="flex">
                                <!-- Precio del producto -->
                                <div class="price">$ <span><?= $fetch_products['price']; ?></span></div>
                                <!-- Cantidad -->
                                <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
                            </div>
                            <!-- Agregar al carrito -->
                            <input type="submit" value="Agregar al carrito" name="add_to_cart" class="btn">
                        </form>
                <?php
                    }
                } else {
                    echo '<p class="empty">Aún no se han agregado productos</p>';
                }
                ?>
            </div>
            <!-- Swiper CDN paginación -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- Products ends -->

    <!-- Se incluye el pie de página del sitio -->
    <?php include 'components/footer.php' ?>

    <!-- JS Swiper link -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <!-- custom JS script link -->
    <script src="js/general_script.js"></script>

    <!-- Inicializamos Swiper -->
    <script>
        var swiper = new Swiper(".home-slider", {
            loop: true,
            grabCursor: true,
            pagination: {
                el: ".swiper-pagination",
            },
        });

        var swiper = new Swiper(".category-slider", {
            loop: true,
            spaceBetween: 20,
            grabCursor: true,
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                0: {
                    slidesPerView: 2,
                },
                650: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 5,
                },
            },
        });

        var swiper = new Swiper(".products-slider", {
            loop: true,
            spaceBetween: 20,
            grabCursor: true,
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                550: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    </script>

</body>

</html>