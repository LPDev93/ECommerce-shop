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

?>

<!-- HTML Doc-->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce - Nosotros</title>
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

    <!-- About section starts -->
    <section class="about">
        <!-- Fila -->
        <div class="row">
            <!-- Imagen de presentación -->
            <div class="image">
                <img src="images/about-img.svg" alt="Acerca de nosotros">
            </div>
            <!-- Contenido principal -->
            <div class="content">
                <h3>¿Por que comprar aquí?</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, labore eveniet. Temporibus aperiam mollitia eaque et in, sapiente totam sunt voluptatem neque optio maxime, quaerat culpa vel tempore ab rerum animi ullam similique possimus? Excepturi expedita nihil, dolorem, obcaecati unde iusto neque consequuntur, mollitia quisquam nam reiciendis? Officiis, doloribus nostrum.</p>
                <a href="contact.php" class="btn">Contáctanos</a>
            </div>
        </div>
    </section>
    <!-- About section ends -->

    <!-- Reviews section starts -->
    <section class="reviews">
        <!-- Título Principal -->
        <h1 class="heading">Comentarios de clientes</h1>
        <!-- .Contenedor de Swipper -->
        <div class="swiper reviews-slider">
            <div class="swiper-wrapper">
                <!-- Slider 01 -->
                <div class="slide swiper-slide">
                    <!-- Cliente -->
                    <img src="images/pic-1.png" alt="Comentario">
                    <!-- Reseña -->
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iusto deleniti sapiente iste voluptas amet, magni laudantium necessitatibus inventore reprehenderit est.</p>
                    <!-- Puntaje -->
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <!-- Nombre -->
                    <h3>Jhon Deo</h3>
                </div>
                <!-- Slider 02 -->
                <div class="slide swiper-slide">
                    <!-- Cliente -->
                    <img src="images/pic-2.png" alt="Comentario">
                    <!-- Reseña -->
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iusto deleniti sapiente iste voluptas amet, magni laudantium necessitatibus inventore reprehenderit est.</p>
                    <!-- Puntaje -->
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <!-- Nombre -->
                    <h3>Kristen Deo</h3>
                </div>
                <!-- Slider 03 -->
                <div class="slide swiper-slide">
                    <!-- Cliente -->
                    <img src="images/pic-3.png" alt="Comentario">
                    <!-- Reseña -->
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iusto deleniti sapiente iste voluptas amet, magni laudantium necessitatibus inventore reprehenderit est.</p>
                    <!-- Puntaje -->
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <!-- Nombre -->
                    <h3>Mark Deo</h3>
                </div>
                <!-- Slider 05 -->
                <div class="slide swiper-slide">
                    <!-- Cliente -->
                    <img src="images/pic-4.png" alt="Comentario">
                    <!-- Reseña -->
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iusto deleniti sapiente iste voluptas amet, magni laudantium necessitatibus inventore reprehenderit est.</p>
                    <!-- Puntaje -->
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <!-- Nombre -->
                    <h3>María Deo</h3>
                </div>
                <!-- Slider 01 -->
                <div class="slide swiper-slide">
                    <!-- Cliente -->
                    <img src="images/pic-5.png" alt="Comentario">
                    <!-- Reseña -->
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iusto deleniti sapiente iste voluptas amet, magni laudantium necessitatibus inventore reprehenderit est.</p>
                    <!-- Puntaje -->
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <!-- Nombre -->
                    <h3>Martín Deo</h3>
                </div>
                <!-- Slider 06 -->
                <div class="slide swiper-slide">
                    <!-- Cliente -->
                    <img src="images/pic-6.png" alt="Comentario">
                    <!-- Reseña -->
                    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Iusto deleniti sapiente iste voluptas amet, magni laudantium necessitatibus inventore reprehenderit est.</p>
                    <!-- Puntaje -->
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <!-- Nombre -->
                    <h3>Sophia Deo</h3>
                </div>
            </div>
            <!-- Swiper CDN paginación -->
            <div class="swiper-pagination"></div>
        </div>
    </section>
    <!-- Reviews section ends -->


    <!-- Se incluye el pie de página del sitio -->
    <?php include 'components/footer.php' ?>

    <!-- custom JS script link -->
    <script src="js/general_script.js"></script>

    <!-- JS Swiper link -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

    <!-- Iniciamos Swipper -->
    <script>
        var swiper = new Swiper(".reviews-slider", {
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