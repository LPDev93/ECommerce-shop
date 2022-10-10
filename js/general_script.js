/*---------------------------------
Variables Globales
---------------------------------*/

let profile = document.querySelector(".header .flex .profile");
let navbar = document.querySelector(".header .flex .navbar");
let userBtn = document.querySelector("#user-btn");
let menuBtn = document.querySelector("#menu-btn");
let subImages = document.querySelectorAll(
  ".quick-view .box .image-container .small-images img"
);
let mainImage = document.querySelector(
  ".quick-view .box .image-container .big-image img"
);

/*---------------------------------
Función Abrir opciones de usuario
---------------------------------*/
userBtn.onclick = () => {
  profile.classList.toggle("active");
  navbar.classList.remove("active");
};

/*---------------------------------
  Función botón de hamburguesa
  ---------------------------------*/
menuBtn.onclick = () => {
  navbar.classList.toggle("active");
  profile.classList.remove("active");
};

/*---------------------------------
  Función de scroll
  ---------------------------------*/
window.onscroll = () => {
  profile.classList.remove("active");
  navbar.classList.remove("active");
};

/*---------------------------------
Función de sub-imágenes
---------------------------------*/
subImages.forEach((images) => {
  images.onclick = () => {
    let src = images.getAttribute("src");
    mainImage.src = src;
  };
});
