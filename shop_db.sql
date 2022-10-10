-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2022 a las 20:47:18
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shop_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admins`
--

CREATE TABLE `admins` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `number`, `message`) VALUES
(1, 'Prueba', 'prueba@gmail.com', '966230000', 'Hola, esto es una prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(1, 1, 'Prueba', '123456789', 'Prueba@gmail.com', 'cash on delivery', '001, Calle de Prueba,Prueba,Prueba,Prueba-11111', 'Monitor Ultra Gear 23.8&#39;&#39; IPS 144HZ 1MS Full HD - G-SYNC(1) -Razer Combo Hello Kitty Mouse + Mouse pad(1) -XIAOMI REDMI 9A 6.53&#39;&#39; 32GB 13MP - Smartphone(5) -', 3164, '2022-10-04', 'pending');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int(10) NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image_01`, `image_02`, `image_03`) VALUES
(1, 'Monitor Ultra Gear 23.8&#39;&#39; IPS 144HZ 1MS Full HD - G-SYNC', 'IPS 1ms (GtG) Ritmo de actualización de 144Hz, HDR10 sRGB 99% (típ.), AMD FreeSync™ Premium.', 1199, 'Monitor_01-01.png', 'Monitor_01-02.png', 'Monitor_01-03.png'),
(2, 'Monitor Ultra Gear 27” IPS 240HZ 1MS NVIDIA G-SYNC', 'IPS 1ms (GtG) Ritmo de actualización de 144Hz, HDR10 sRGB 99% (típ.), AMD FreeSync™ Premium.', 1899, 'Monitor_02-01.png', 'Monitor_02-02.png', 'Monitor_02-03.png'),
(3, 'Monitor Ergo Nano Ultra Gear 27&#39;&#39; IPS 1ms (GtG)', 'Con IPS 1ms comparable a la velocidad TN, proporciona una imagen residual mínima y un tiempo rápido de respuesta.', 2499, 'Monitor_03-01.png', 'Monitor_03-02.png', 'Monitor_03-03.png'),
(4, 'Razer Viper 8KHZ Focus Ambidextrous Mouse - ESL Edition', 'Logra un nuevo nivel de control total con el Razer Viper 8KHz , un mouse ambidiestro para esports con un polling rate de 8000 Hz reales para ofrecer la mayor velocidad y la menor latencia nunca vistas. Mejorado con Switches Ópticos Razer de 2.ª generación, ha llegado el momento de estar a la altura y darlo todo en el terreno de juego.', 460, 'mouse_01-01.jpg', 'mouse_01-02.jpg', 'mouse_01-03.jpg'),
(5, 'Razer Combo Hello Kitty Mouse + Mouse pad', 'Si amas a Hello Kitty estos periféricos Razer son para ti. Presentamos el bundle de Razer que incluye el mouse Deathadder Essential y el mouse pad Goliathus, que presentan un diseño personalizado de Hello Kitty.', 270, 'mouse_02-01.jpg', 'mouse_02-02.jpg', 'mouse_02-03.jpg'),
(6, 'XIAOMI REDMI 9A 6.53&#39;&#39; 32GB 13MP - Smartphone', 'Gracias a su increíble procesador Mediatek Helio G25 Octa-Core, el Redmi 9A te ofrece una experiencia smart mucho más rápida, intuitiva y sólida. Este celular mantiene su rendimiento superior incluso después de un uso exigente.', 339, 'Celular_01-01.jpg', 'Celular_01-02.jpg', 'Celular_01-03.jpg'),
(7, 'RAZER HUNTSMAN ELITE', 'Sensor de luz óptico dentro del interruptor con una distancia de accionamiento de 1,5 mm (un 30% más corta que otros interruptores mecánicos que hacen clic) con solo 45 g de fuerza de accionamiento.', 455, 'razer-01.jpg', 'razer-02.jpg', 'razer-03.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Prueba', 'prueba@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
