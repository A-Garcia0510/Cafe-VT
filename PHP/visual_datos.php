<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'autoload.php';

use App\Auth\AuthFactory;
use App\Core\Database\DatabaseConfiguration;
use App\Core\Database\MySQLDatabase;

// Cargar configuración
$config = require_once '../src/Config/Config.php';
$dbConfig = new DatabaseConfiguration(
    $config['database']['host'],
    $config['database']['username'],
    $config['database']['password'],
    $config['database']['database']
);

try {
    // Crear conexión a la base de datos
    $database = new MySQLDatabase($dbConfig);
    
    // Crear el autenticador
    $authenticator = AuthFactory::createAuthenticator($database);
    
    // Verificar si el usuario está autenticado
    if (!$authenticator->isAuthenticated()) {
        header("Location: ../login.html");
        exit();
    }
    
    // Obtener email del usuario actual
    $correo = $authenticator->getCurrentUserEmail();
    
    // Obtener los datos del usuario
    $userRepository = AuthFactory::createUserRepository($database);
    $user = $userRepository->findByEmail($correo);
    
    if (!$user) {
        echo "Error: No se pudieron recuperar los datos del usuario.";
        exit();
    }
    
    $nombre = $user->getNombre();
    $apellidos = $user->getApellidos();
    
} catch (Exception $e) {
    echo "Error en el sistema: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café Aroma - Mi Cuenta</title>
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
        
        /* User Data Section */
        .user-data-section {
            flex: 1;
            padding: 3rem 2rem;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 2rem;
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
        
        .welcome-message {
            text-align: center;
            font-size: 1.4rem;
            margin-bottom: 2rem;
            color: var(--secondary-color);
        }
        
        .user-data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2.5rem;
        }
        
        .user-data-table th,
        .user-data-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .user-data-table th {
            background-color: var(--light-color);
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .user-data-table tr:last-child td {
            border-bottom: none;
        }
        
        .user-data-table tr:hover {
            background-color: rgba(239, 235, 233, 0.3);
        }
        
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }
        
        .btn {
            display: inline-block;
            padding: 0.8rem 2rem;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            text-align: center;
            min-width: 200px;
        }
        
        .primary-btn {
            background-color: var(--accent-color);
            color: white;
        }
        
        .primary-btn:hover {
            background-color: #388E3C;
        }
        
        .secondary-btn {
            background-color: var(--primary-color);
            color: white;
        }
        
        .secondary-btn:hover {
            background-color: var(--secondary-color);
        }
        
        /* Footer */
        footer {
            background-color: white;
            padding: 1.5rem 0;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
            margin-top: auto;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }
        
        .footer-links a {
            text-decoration: none;
            color: var(--text-color);
            margin-left: 1rem;
            font-size: 0.9rem;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--accent-color);
        }
        
        .copyright {
            font-size: 0.9rem;
            color: #666;
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
            
            .user-data-section {
                padding: 2rem 1rem;
            }
            
            .container {
                padding: 1.5rem;
            }
            
            .section-title h2 {
                font-size: 1.8rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .footer-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .footer-links a {
                margin: 0 0.5rem;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <h1>Café<span>Aroma</span></h1>
            </div>
            <ul class="main-menu">
                <li><a href="../index.php#inicio">Inicio</a></li>
                <li><a href="../index.php#menu">Menú</a></li>
                <li><a href="../index.php#locales">Locales</a></li>
                <li><a href="../index.php#nosotros">Sobre Nosotros</a></li>
                <li><a href="../index.php#blog">Blog</a></li>
            </ul>
            <div class="user-actions">
                <div class="icon">👤</div>
                <div class="icon">❤️</div>
                <div class="icon">🛒</div>
            </div>
        </nav>
    </header>
    
    <section class="user-data-section">
        <div class="container">
            <div class="section-title">
                <h2>Mi Cuenta</h2>
            </div>
            <p class="welcome-message">¡Bienvenido, <?php echo htmlspecialchars($nombre); ?>!</p>
            
            <table class="user-data-table">
                <thead>
                    <tr>
                        <th>Datos</th>
                        <th>Información</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Nombre:</td>
                        <td><?php echo htmlspecialchars($nombre); ?></td>
                    </tr>
                    <tr>
                        <td>Apellidos:</td>
                        <td><?php echo htmlspecialchars($apellidos); ?></td>
                    </tr>
                    <tr>
                        <td>Correo:</td>
                        <td><?php echo htmlspecialchars($correo); ?></td>
                    </tr>
                </tbody>
            </table>
            
            <div class="action-buttons">
                <a href="cerrar_sesion.php" class="btn secondary-btn">Cerrar sesión</a>
                <a href="../index.php" class="btn primary-btn">Página Principal</a>
            </div>
        </div>
    </section>
    
    <footer>
        <div class="footer-content">
            <div class="copyright">
                © 2025 Café Aroma. Todos los derechos reservados.
            </div>
            <div class="footer-links">
                <a href="#">Privacidad</a>
                <a href="#">Términos</a>
                <a href="#">Ayuda</a>
                <a href="#">Contacto</a>
            </div>
        </div>
    </footer>
</body>
</html>