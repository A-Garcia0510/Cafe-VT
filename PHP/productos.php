<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'autoload.php';

// Importar clases necesarias
use App\Core\Database\MySQLDatabase;
use App\Core\Database\DatabaseConfiguration;
use App\Shop\Repositories\ProductRepository;

// Verificar si el usuario está logueado
if (!isset($_SESSION['correo'])) {
    echo "<script>
            alert('Debes iniciar sesión para ver los productos de la tienda.');
            window.location.href='../login.html';
          </script>";
    exit();
}

// Cargar configuración
$config = require_once '../src/Config/Config.php';

// Crear objeto de configuración de base de datos
$dbConfig = new DatabaseConfiguration(
    $config['database']['host'],
    $config['database']['username'],
    $config['database']['password'],
    $config['database']['database']
);

// Crear instancia de la base de datos
$db = new MySQLDatabase($dbConfig);

// Crear instancia del repositorio de productos
$productRepository = new ProductRepository($db);

// Obtener todas las categorías
$categorias = $productRepository->getAllCategories();

// Obtener todos los productos para usar en JavaScript
$productos = $productRepository->findAll();

// Convertir objetos Product a arrays para JSON
$productosArray = [];
foreach ($productos as $producto) {
    $productosArray[] = [
        'producto_ID' => $producto->getId(),
        'nombre_producto' => $producto->getName(),
        'descripcion' => $producto->getDescription(),
        'precio' => $producto->getPrice(),
        'cantidad' => $producto->getStock(),
        'categoria' => $producto->getCategory()
    ];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - Café Aroma</title>
    <style>
        :root {
            --primary-color: #5D4037;
            --secondary-color: #8D6E63;
            --light-color: #EFEBE9;
            --accent-color: #4CAF50;
            --text-color: #3E2723;
            --background-color: #FFF8E1;
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
        
        .logo h1 {
            font-size: 1.8rem;
            color: var(--primary-color);
        }
        
        .logo span {
            color: var(--accent-color);
        }
        
        .main-menu {
            display: flex;
            list-style: none;
        }
        
        .main-menu li {
            margin-left: 1.5rem;
        }
        
        .main-menu a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .main-menu a:hover {
            color: var(--accent-color);
        }
        
        .user-actions {
            display: flex;
            align-items: center;
        }
        
        .user-actions .icon {
            margin-left: 1.2rem;
            cursor: pointer;
            color: var(--secondary-color);
            font-size: 1.2rem;
        }
        
        /* Page Title */
        .page-title {
            text-align: center;
            padding: 2rem 0;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }
        
        .page-title h1 {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        /* Category Bar */
        .categoria-bar {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 3rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            padding: 0 2rem;
        }
        
        .categoria-bar button {
            background-color: white;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .categoria-bar button:hover, 
        .categoria-bar button.active {
            background-color: var(--primary-color);
            color: white;
        }
        
        /* Products Grid */
        #productos {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto 4rem auto;
            padding: 0 2rem;
        }
        
        /* Estilos actualizados para productos sin imágenes */
        .producto-tarjeta {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
            height: 100%;
            padding: 1.5rem;
        }
        
        .producto-tarjeta:hover {
            transform: translateY(-5px);
        }
        
        .producto-info {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .producto-info h2 {
            margin-bottom: 1rem;
            font-size: 1.3rem;
            color: var(--primary-color);
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 0.8rem;
        }
        
        .precio {
            font-weight: 600;
            color: var(--accent-color);
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
        }
        
        .stock {
            color: #666;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        
        .acciones {
            margin-top: auto;
            display: flex;
            gap: 1rem;
        }
        
        .acciones button {
            flex: 1;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .ver-detalle {
            background-color: var(--light-color);
            color: var(--primary-color);
        }
        
        .ver-detalle:hover {
            background-color: #e0d8d3;
        }
        
        .agregar {
            background-color: var(--accent-color);
            color: white;
        }
        
        .agregar:hover {
            background-color: #388E3C;
        }
        
        /* Cart Button */
        .carrito-button {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            z-index: 10;
        }
        
        .carrito-button:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .carrito-logo {
            width: 24px;
            height: 24px;
        }
        
        /* Footer */
        footer {
            background-color: white;
            padding-top: 3rem;
            margin-top: 4rem;
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
        }
        
        .footer-bottom-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }
        
        .footer-info {
            display: flex;
            margin-bottom: 1rem;
        }
        
        .footer-info div {
            margin-right: 2rem;
        }
        
        .footer-info h4 {
            margin-bottom: 0.8rem;
            font-size: 1rem;
        }
        
        .footer-info ul {
            list-style: none;
        }
        
        .footer-info li {
            margin-bottom: 0.5rem;
        }
        
        .footer-info a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-info a:hover {
            color: white;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
        }
        
        .social-links a {
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s;
        }
        
        .social-links a:hover {
            background-color: var(--accent-color);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                padding: 1rem;
            }
            
            .logo {
                margin-bottom: 1rem;
            }
            
            .main-menu {
                margin-bottom: 1rem;
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .main-menu li {
                margin: 0.5rem;
            }
            
            .footer-info {
                flex-direction: column;
            }
            
            .footer-info div {
                margin-bottom: 1.5rem;
            }
            
            .producto-tarjeta {
                max-width: 100%;
            }
        }
        
        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 2rem;
            font-size: 1.1rem;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>Ethos<span>Coffe</span></h1>
            </div>
            <ul class="main-menu">
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../Servicios.html">Sobre Nosotros</a></li>
            </ul>
            <div class="user-actions">
                <div class="icon" title="Mi Cuenta">👤</div>
                <div class="icon" title="Favoritos">❤️</div>
                <div class="icon" title="Carrito" onclick="window.location.href='carrito.php'">🛒</div>
            </div>
        </nav>
    </header>
    
    <div class="page-title">
        <h1>Nuestros Productos</h1>
        <p>Descubre nuestras deliciosas especialidades y preparaciones</p>
    </div>

    <div class="categoria-bar">
        <button id="btn-todos" class="active" onclick="mostrarProductos('todos')">Todos</button>
        <?php foreach ($categorias as $categoria): ?>
            <button id="btn-<?php echo strtolower(str_replace(' ', '-', $categoria)); ?>" onclick="mostrarProductos('<?php echo $categoria; ?>')"><?php echo $categoria; ?></button>
        <?php endforeach; ?>
    </div>
    
    <div id="productos"></div>

    <button id="carrito-btn" class="carrito-button" onclick="window.location.href='carrito.php'">
        <img src="../IMG-2/carro.png" alt="Carrito" class="carrito-logo">
        Ver Carrito
    </button>

    <footer>
        <div class="footer-main">
            <div class="footer-column">
                <h3><i>👤</i> Mi cuenta</h3>
                <ul class="footer-links">
                    <li><a href="#">Iniciar sesión</a></li>
                    <li><a href="#">Registrarse</a></li>
                    <li><a href="#">Mis pedidos</a></li>
                    <li><a href="#">Mis favoritos</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3><i>🏠</i> Nuestros Locales</h3>
                <ul class="footer-links">
                    <li><a href="#">Encuentra tu café</a></li>
                    <li><a href="#">Horarios</a></li>
                    <li><a href="#">Servicios</a></li>
                    <li><a href="#">Eventos</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3><i>🛒</i> Carrito</h3>
                <ul class="footer-links">
                    <li><a href="carrito.php">Ver carrito</a></li>
                    <li><a href="#">Métodos de pago</a></li>
                    <li><a href="#">Envíos</a></li>
                    <li><a href="#">Condiciones</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>¿Necesitas ayuda?</h3>
                <p>Estamos aquí para ayudarte con cualquier duda o problema.</p>
                <a href="#" class="contact-btn">Contáctanos</a>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <div class="footer-info">
                    <div>
                        <h4>Corporate</h4>
                        <ul>
                            <li><a href="#">Sobre Nosotros</a></li>
                            <li><a href="#">Nuestras Marcas</a></li>
                            <li><a href="#">Afiliados</a></li>
                            <li><a href="#">Inversores</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4>Tarjetas Regalo</h4>
                        <ul>
                            <li><a href="#">Comprar Tarjetas</a></li>
                            <li><a href="#">Canjear Tarjetas</a></li>
                        </ul>
                    </div>
                </div>
                
                <div>
                    <div class="social-links">
                        <a href="#"><span>IG</span></a>
                        <a href="#"><span>FB</span></a>
                        <a href="#"><span>YT</span></a>
                        <a href="#"><span>TW</span></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Obtener todos los productos desde el servidor
        const productos = <?php echo json_encode($productosArray); ?>;

        function mostrarProductos(categoria) {
            // Actualizar estado de los botones
            document.querySelectorAll('.categoria-bar button').forEach(btn => {
                btn.classList.remove('active');
            });
            
            if (categoria === 'todos') {
                document.getElementById('btn-todos').classList.add('active');
            } else {
                const btnId = 'btn-' + categoria.toLowerCase().replace(/ /g, '-');
                const btn = document.getElementById(btnId);
                if (btn) btn.classList.add('active');
            }

            const productosDiv = document.getElementById('productos');
            productosDiv.innerHTML = '';
            let productosFiltrados = categoria === 'todos' ? productos : productos.filter(p => p.categoria === categoria);

            if (productosFiltrados.length === 0) {
                productosDiv.innerHTML = '<div class="empty-state">No se encontraron productos en esta categoría.</div>';
                return;
            }

            productosFiltrados.forEach(producto => {
                productosDiv.innerHTML += `
                    <div class='producto-tarjeta'>
                        <div class='producto-info'>
                            <h2>${producto.nombre_producto}</h2>
                            <p class="precio">$${parseFloat(producto.precio).toLocaleString('es-CL', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}</p>
                            <p class="stock">Disponible: ${producto.cantidad} unidades</p>
                            <div class="acciones">
                                <button class="ver-detalle" onclick="verDetalle(${producto.producto_ID})">Ver Detalle</button>
                                <button class="agregar" onclick="agregarAlCarrito(${producto.producto_ID}, 1)">Agregar</button>
                            </div>
                        </div>
                    </div>
                `;
            });
        }

        function verDetalle(productoID) {
            window.location.href = `productoDetalle.php?id=${productoID}`;
        }

        function agregarAlCarrito(productoID, cantidad) {
            fetch('agregar_carro.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ producto_ID: productoID, cantidad: cantidad })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Producto agregado al carrito con éxito.');
                } else {
                    alert('Error al agregar producto: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Mostrar todos los productos al cargar la página
        window.addEventListener('DOMContentLoaded', () => {
            mostrarProductos('todos');
        });
    </script>
</body>
</html>