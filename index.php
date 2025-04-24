<?php
// Iniciar el monitor antes de todo
require_once __DIR__ . '/PHP/load_monitor.php';
$monitor = new LoadMonitor();

// Iniciar la sesión
session_start();

// Verificar si el usuario ya está logueado
if (isset($_SESSION['correo'])) {
    // Si está logueado, no redirigir a login
    // Puedes incluir un mensaje de bienvenida o similar si lo deseas
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casino-Express</title>
    <link rel="stylesheet" type="text/css" href="estilos/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        :root {
            --primary-color: #2C3E50;
            --secondary-color: #3498DB;
            --light-color: #ECF0F1;
            --accent-color: #E74C3C;
            --text-color: #2C3E50;
            --background-color: #F9F9F9;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }
        
        /* Header & Navigation */
        header {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .logo-container {
            height: 60px;
        }
        
        .logo-container img {
            height: 100%;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            margin-left: 1.5rem;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--accent-color);
        }
        
        /* Hero Section */
        .hero {
            position: relative;
            height: 80vh;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        
        #background-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        
        .hero::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }
        
        .hero-content {
            max-width: 800px;
            padding: 2rem;
            z-index: 1;
        }
        
        .hero h2 {
            font-size: 3rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--accent-color);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }
        
        /* Servicios Section */
        .section {
            padding: 4rem 2rem;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-title h2 {
            font-size: 2.2rem;
            color: var(--primary-color);
            position: relative;
            display: inline-block;
            padding-bottom: 1rem;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 3px;
            background-color: var(--accent-color);
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .service-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            padding: 2rem;
        }
        
        .service-card:hover {
            transform: translateY(-5px);
        }
        
        .service-card h3 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-size: 1.5rem;
        }
        
        .service-card p {
            color: #666;
        }
        
        /* Productos Destacados */
        .featured-products {
            background-color: var(--light-color);
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }
        
        .product-card {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
        }
        
        .product-img {
            height: 200px;
            overflow: hidden;
        }
        
        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .product-card:hover .product-img img {
            transform: scale(1.1);
        }
        
        .product-info {
            padding: 1.5rem;
        }
        
        .product-info h3 {
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
            color: var(--primary-color);
        }
        
        .product-info p {
            color: #666;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }
        
        .price {
            font-weight: 600;
            color: var(--accent-color);
            font-size: 1.2rem;
        }
        
        /* Footer */
        footer {
            background-color: white;
            padding-top: 3rem;
        }
        
        .footer-main {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .footer-column h3 {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            display: flex;
            align-items: center;
        }
        
        .footer-column h3 i {
            margin-right: 10px;
            font-size: 1.5rem;
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 0.8rem;
        }
        
        .footer-links a {
            text-decoration: none;
            color: #666;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--accent-color);
        }
        
        .contact-btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        .contact-btn:hover {
            background-color: var(--secondary-color);
        }
        
        .footer-bottom {
            background-color: var(--primary-color);
            color: white;
            padding: 2rem;
            margin-top: 3rem;
            text-align: center;
        }
        
        /* Estilos para los tutoriales */
        #tutorialLinks {
            display: none;
            position: absolute;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            padding: 1rem;
            border-radius: 5px;
            z-index: 100;
        }
        
        #tutorialLinks a {
            display: block;
            padding: 0.5rem;
            color: var(--text-color);
            text-decoration: none;
        }
        
        #tutorialLinks a:hover {
            background-color: var(--light-color);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 1rem;
            }
            
            .logo-container {
                margin-bottom: 1rem;
            }
            
            .nav-links {
                margin-bottom: 1rem;
                flex-direction: column;
                align-items: center;
            }
            
            .nav-links li {
                margin: 0.5rem 0;
            }
            
            .hero h2 {
                font-size: 2rem;
            }
        }
        
        /* Mensajes de confirmación */
        #mensaje-confirmacion {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--accent-color);
            color: white;
            padding: 1rem;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            display: none;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo-container">
                <img src="Logo1.png" alt="Casino-Express">
            </div>
            <ul class="nav-links">
                <li><a href="index.php"><b>Inicio</b></a></li>
                <li><a href="Servicios.html"><b>Servicios</b></a></li>
                <li><a href="PHP/productos.php"><b>Productos</b></a></li>
                <li><a href="Ayuda.html"><b>Ayuda</b></a></li>
                <li>
                    <?php if (isset($_SESSION['correo'])): ?>
                        <a href="PHP/visual_datos.php"><b>Perfil</b></a>
                    <?php else: ?>
                        <a href="login.html"><b>Iniciar Sesión</b></a>
                    <?php endif; ?>
                </li>
            </ul>
        </nav>
    </header>

    <section class="hero">
        <video id="background-video" autoplay loop muted>
            <source src="video1.mp4" type="video/mp4">
        </video>
        <div class="hero-content">
            <h2>Bienvenidos a  Ethos Coffe</h2>
            <p>Tu destino para una experiencia de compra excepcional.</p>
            <a href="PHP/productos.php" class="btn">Ver Productos</a>
        </div>
    </section>

    <section class="section" id="servicios">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros Servicios</h2>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <h3>Productos de Alta Calidad</h3>
                    <p>Ofrecemos una amplia gama de productos con descripciones detalladas para que conozcas exactamente lo que estás comprando.</p>
                </div>
                
                <div class="service-card">
                    <h3>Envío Rápido</h3>
                    <p>Entendemos que quieres recibir tus productos lo antes posible. Te proporcionamos estimaciones realistas de tiempo de entrega.</p>
                </div>
                
                <div class="service-card">
                    <h3>Atención al Cliente</h3>
                    <p>Nuestro equipo está disponible para resolver todas tus dudas y preocupaciones a través de correo electrónico o teléfono.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section featured-products">
        <div class="container">
            <div class="section-title">
                <h2>Productos Destacados</h2>
            </div>
            <div class="products-grid">
                <div class="product-card">
                    <div class="product-img">
                        <img src="/api/placeholder/400/400" alt="Producto 1">
                    </div>
                    <div class="product-info">
                        <h3>Producto Premium</h3>
                        <p>Disfruta de nuestros productos de la más alta calidad.</p>
                        <div class="price">$99.99</div>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-img">
                        <img src="/api/placeholder/400/400" alt="Producto 2">
                    </div>
                    <div class="product-info">
                        <h3>Oferta Especial</h3>
                        <p>Aprovecha nuestras ofertas por tiempo limitado.</p>
                        <div class="price">$79.99</div>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-img">
                        <img src="/api/placeholder/400/400" alt="Producto 3">
                    </div>
                    <div class="product-info">
                        <h3>Recién Llegado</h3>
                        <p>Descubre nuestros productos más recientes.</p>
                        <div class="price">$129.99</div>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-img">
                        <img src="/api/placeholder/400/400" alt="Producto 4">
                    </div>
                    <div class="product-info">
                        <h3>Producto Destacado</h3>
                        <p>Uno de nuestros productos más populares.</p>
                        <div class="price">$149.99</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="mensaje-confirmacion"></div>

    <footer>
        <div class="footer-main">
            <div class="footer-column">
                <h3><i>👤</i> Mi cuenta</h3>
                <ul class="footer-links">
                    <li><a href="login.html">Iniciar sesión</a></li>
                    <li><a href="registro.html">Registrarse</a></li>
                    <li><a href="PHP/visual_datos.php">Mi perfil</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3><i>🏠</i> Nuestros Servicios</h3>
                <ul class="footer-links">
                    <li><a href="Servicios.html">Catálogo de servicios</a></li>
                    <li><a href="Ayuda.html">Ayuda</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3><i>🛒</i> Productos</h3>
                <ul class="footer-links">
                    <li><a href="PHP/productos.php">Ver productos</a></li>
                    <li><a href="#">Métodos de pago</a></li>
                    <li><a href="#">Envíos</a></li>
                    <li><a href="#">Devoluciones</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>¿Necesitas ayuda?</h3>
                <p>Estamos aquí para ayudarte con cualquier duda o problema.</p>
                <a href="Ayuda.html" class="contact-btn">Contáctanos</a>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2024 Casino-Express. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="JavaScript/Java1.js"></script>
</body>
</html>
<?php
// Finalizar el monitoreo al terminar la página
$monitor->finalize(http_response_code());

// Si estamos en modo de prueba, mostrar las métricas (solo para desarrollo)
if (isset($_GET['debug_metrics']) && $_GET['debug_metrics'] === 'true') {
    echo '<div style="background: #f8f9fa; border: 1px solid #ddd; padding: 15px; margin-top: 20px;">';
    echo '<h3>Métricas de Carga (Solo Debug)</h3>';
    echo '<pre>';
    print_r($monitor->getMetrics());
    echo '</pre>';
    echo '</div>';
}
?>