<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="views/css/styles.css">   
    <title>Mammoth's Kitchen</title>    
</head>
<body>    
    <header>
        <?php
            include_once ("headers/header.php");
        ?>       
    </header>
    <main>
        <!-- Sección del banner principal -->
        <section class="banner-principal">
            <div class="banner-principal-texto">
                <!-- Título y descripción del banner principal -->
                <p class="banner-principal-titulo">RECETAS PARA LA SALUD</p>
                <p class="banner-principal-p">Nuevas recetas saludables</p>
                <a href="productos.php">Ver recetas</a> <!-- Enlace a la página de productos -->
            </div> 
        </section>

        <!-- Sección de introducción sobre el restaurante -->
        <section class="title-section">
            <h1>Mammoth’s Kitchen, restaurante de comida saludable y recetas fit</h1>
            <p>Mammoth’s Kitchen es tu restaurante de confianza para entrega a domicilio...</p> <!-- Descripción del restaurante -->
            
            <!-- Lista de características del restaurante -->
            <ul>
                <li class="title-caracteristicas">
                    <img src="views/img/icons/estrellas.webp" alt="">
                    <h3>CLIENTES SATISFECHOS</h3>
                </li>
                <li class="title-caracteristicas">
                    <img src="views/img/icons/carta.webp" alt="">
                    <h3>MEJOR CARTA DE RECETAS</h3>
                </li>
                <li class="title-caracteristicas">
                    <img src="views/img/icons/ingredientes.webp" alt="">
                    <h3>PRODUCTOS DE CERCANÍA</h3>
                </li>
                <li class="title-caracteristicas">
                    <img src="views/img/icons/reloj.webp" alt="">
                    <h3>CITA PRÉVIA PARA RESTAURANTE</h3>
                </li>
                <li class="title-caracteristicas">
                    <img src="views/img/icons/entrega.webp" alt="">
                    <h3>ENTREGA A DOMICILO GRATIS</h3>
                </li>
            </ul>
        </section>

        <!-- Sección de imágenes de comida -->
        <section id="grid-comidas"> 
            <div class="container text-left">
                <div id="row1" class="row">
                    <!-- Imagen de comida baja en hidratos -->
                    <div class="col">
                        <img src="views/img/banners/comida1.webp" alt="">
                        <a href="?url=productos">
                            <div>
                                <p>COMIDA BAJA EN <strong>HIDRATOS</strong></p>
                                <img class="arrow" src="views/img/icons/arrow.svg" alt="">
                            </div>
                        </a>
                    </div>
                    <!-- Imagen de comida alta en proteínas -->
                    <div class="col">
                        <img src="views/img/banners/comida2.webp" alt="">
                        <a href="productos.php">
                            <div>
                                <p>COMIDA ALTA EN <strong>PROTEÍNAS</strong></p>
                                <img class="arrow" src="views/img/icons/arrow.svg" alt="">
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Segunda fila de imágenes de comida -->
                <div id="row2" class="row">
                    <!-- Comida sin calorías -->
                    <div class="col">
                        <img src="views/img/banners/comida3.webp" alt="">
                        <a href="productos.php">
                            <div>
                                <p>COMIDA SIN <strong>CALORÍAS</strong></p>
                                <img class="arrow" src="views/img/icons/arrow.svg" alt="">
                            </div>
                        </a>
                    </div>
                    <!-- Comida tipo Food -->
                    <div class="col">
                        <img src="views/img/banners/comida4.webp" alt="">
                        <a href="productos.php">
                            <p class="colocar">.</p>
                            <div>
                                <p>COMIDA <strong>TIPO FOOD</strong></p>
                                <img class="arrow" src="views/img/icons/arrow.svg" alt="">
                            </div>
                        </a>
                    </div>
                    <!-- Comida sin grasas -->
                    <div class="col">
                        <img src="views/img/banners/comida5.webp" alt="">
                        <a href="productos.php">
                            <div>
                                <p>COMIDA SIN <strong>GRASAS</strong></p>
                                <img class="arrow" src="views/img/icons/arrow.svg" alt="">
                            </div>                            
                        </a>
                    </div>
                </div>
            </div>  
        </section>

        <!-- Sección del carrusel con ofertas -->
        <section class="section-carousel">
            <h2>Las mejores ofertas en el restaurante</h2>
            
            <!-- Carrusel de ofertas -->
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- Primera diapositiva del carrusel -->
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-center gap-3">
                            <div class="carousel-card">
                                <a href="?url=finalizar">
                                    <div class="discount">
                                        <span>HASTA <strong>50</strong>%</span>
                                    </div>
                                    <img src="views/img/banners/carousel-img1.webp" alt="">
                                    <div class="deadline">
                                        <img src="views/img/icons/clock.svg" alt="">
                                        <p>Con el código <strong>navidad</strong> rebaja del <strong>50%</strong></p>
                                    </div>
                                </a>
                            </div>
                            <!-- Segunda tarjeta de oferta -->
                            <div class="carousel-card">
                                <a href="?url=finalizar">
                                    <div class="discount">
                                        <span>HASTA <strong>60</strong>%</span>
                                    </div>
                                    <img src="views/img/banners/carousel-img2.webp" alt="">
                                    <div class="deadline">
                                        <img src="views/img/icons/clock.svg" alt="">
                                        <p>Con el código <strong>navidad</strong> rebaja del <strong>50%</strong></p>
                                    </div>
                                </a>
                            </div>
                            <!-- Tercera tarjeta de oferta -->
                            <div class="carousel-card">
                                <a href="?url=finalizar">
                                    <div class="discount">
                                        <span>HASTA <strong>50</strong>%</span>
                                    </div>
                                    <img src="views/img/banners/carousel-img3.webp" alt="">
                                    <div class="deadline">
                                        <img src="views/img/icons/clock.svg" alt="">
                                        <p>Con el código <strong>navidad</strong> rebaja del <strong>50%</strong></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex justify-content-center gap-3">
                            <div class="carousel-card">
                                <a href="?url=finalizar">
                                    <div class="discount">
                                        <span>HASTA <strong>70</strong>%</span>
                                    </div>
                                    <img src="views/img/banners/carousel-img2.webp" alt="">
                                    <div class="deadline">
                                        <img src="views/img/icons/clock.svg" alt="">
                                        <p>Con el código <strong>navidad</strong> rebaja del <strong>50%</strong></p>
                                    </div>
                                </a>
                            </div>
                            <div class="carousel-card">
                                <a href="?url=finalizar">
                                    <div class="discount">
                                        <span>HASTA <strong>60</strong>%</span>
                                    </div>
                                    <img src="views/img/banners/carousel-img1.webp" alt="">
                                    <div class="deadline">
                                        <img src="views/img/icons/clock.svg" alt="">
                                        <p>Con el código <strong>navidad</strong> rebaja del <strong>50%</strong></p>
                                    </div>
                                </a>
                            </div>
                            <div class="carousel-card">
                                <a href="?url=finalizar">
                                    <div class="discount">
                                        <span>HASTA <strong>50</strong>%</span>
                                    </div>
                                    <img src="views/img/banners/carousel-img3.webp" alt="">
                                    <div class="deadline">
                                        <img src="views/img/icons/clock.svg" alt="">
                                        <p>Con el código <strong>navidad</strong> rebaja del <strong>50%</strong></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="d-flex justify-content-center gap-3">
                            <div class="carousel-card">
                                <a href="?url=finalizar">
                                    <div class="discount">
                                        <span>HASTA <strong>70</strong>%</span>
                                    </div>
                                    <img src="views/img/banners/carousel-img3.webp" alt="">
                                    <div class="deadline">
                                        <img src="views/img/icons/clock.svg" alt="">
                                        <p>Con el código <strong>navidad</strong> rebaja del <strong>50%</strong></p>
                                    </div>
                                </a>
                            </div>
                            <div class="carousel-card">
                                <a href="?url=finalizar">
                                    <div class="discount">
                                        <span>HASTA <strong>60</strong>%</span>
                                    </div>
                                    <img src="views/img/banners/carousel-img1.webp" alt="">
                                    <div class="deadline">
                                        <img src="views/img/icons/clock.svg" alt="">
                                        <p>Con el código <strong>navidad</strong> rebaja del <strong>50%</strong></p>
                                    </div>
                                </a>
                            </div>
                            <div class="carousel-card">
                                <a href="?url=finalizar">
                                    <div class="discount">
                                        <span>HASTA <strong>50</strong>%</span>
                                    </div>
                                    <img src="views/img/banners/carousel-img2.webp" alt="">
                                    <div class="deadline">
                                        <img src="views/img/icons/clock.svg" alt="">
                                        <p>Con el código <strong>navidad</strong> rebaja del <strong>50%</strong></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>        
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>        
            <a href="views/productos.php" class="ofertas-button">
                <p>Más ofertas de Restaurante</p>
                <img class="arrow" src="views/img/icons/arrow.svg" alt="">
            </a>
        </section>    
        <!-- seccion de alimentos  -->
        <section class="alimentos">
            <h2>Proteínas, grasas e hidratos de carbono</h2>
            <p>Conviertete en un verdadero chef con todos los conocimientos de cocina. Lleva tu nutrición al siguiente nivel con nuestro sistema de edición y creación de menús guiado y personalizado. Prepárate para conseguir la mejor salud con la mejor calidad de comida</p>
            <div class="container text-center">
                <div class="row">
                    <div class="col">
                        <a href="views/productos.php">
                            <img src="views/img/banners/carne.webp" alt="">
                            <span>Carnes</span>
                        </a>
                    </div>
                    <div class="col">
                        <a href="views/productos.php">
                            <img src="views/img/banners/pescado.webp" alt="">
                            <span>Pescados</span>
                        </a>
                    </div>
                    <div class="col">
                        <a href="views/productos.php">
                            <img src="views/img/banners/pasta.webp" alt="">
                            <span>Pasta</span>
                        </a>
                    </div>
                    <div class="col">
                        <a href="views/productos.php">
                            <img src="views/img/banners/legumbres.webp" alt="">
                            <span>Legumbres</span>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="views/productos.php">
                            <img src="views/img/banners/frutos-secos.webp" alt="">
                            <span>Frutos secos</span>
                        </a>
                    </div>
                    <div class="col">
                        <a href="views/productos.php">
                            <img src="views/img/banners/lacteos.webp" alt="">
                            <span>Lácteos</span>
                        </a>
                    </div>
                    <div class="col">
                        <a href="views/productos.php">
                            <img src="views/img/banners/frutas-verduras.webp" alt="">
                            <span>Frutas y verduras</span>
                        </a>
                    </div>
                    <div class="col">
                        <a href="views/productos.php">
                            <img src="views/img/banners/otros.webp" alt="">
                            <span>Otros alimentos</span>
                        </a>
                    </div>
                </div>
            </div>            
        </section>
    </main>
    <footer>
        <?php
            include("views/footer/footer.php");
        ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>