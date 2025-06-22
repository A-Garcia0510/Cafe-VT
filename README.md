# Café-VT 🎓☕

## Descripción
Café-VT es una plataforma web moderna diseñada específicamente para la comunidad universitaria, ofreciendo un sistema completo de pedidos, gestión de productos de cafetería y un programa de fidelización avanzado. Desarrollada con una arquitectura híbrida PHP-Python, proporciona una experiencia de usuario intuitiva y eficiente.

## Características Principales 🌟

### Para Estudiantes y Personal
- 🛍️ **Catálogo de productos** con categorías y búsqueda avanzada
- 🛒 **Carrito de compras inteligente** con cálculo automático de IVA (19%)
- ☕ **Sistema de café personalizado** - Crea tu bebida ideal
- 💎 **Programa de fidelización** con puntos, niveles y recompensas
- 👤 **Sistema de autenticación seguro** con roles diferenciados
- 📱 **Diseño responsivo** para todos los dispositivos
- 💳 **Gestión de pedidos** en tiempo real
- ⭐ **Sistema de reseñas y calificaciones** para productos
- 📊 **Dashboard personal** con estadísticas de consumo

### Para Administradores
- 📊 **Panel de control avanzado** para gestión integral
- 📈 **Control de inventario** con alertas automáticas
- 👥 **Gestión de usuarios** con roles y permisos
- 📝 **Registro de ventas** y estadísticas detalladas
- 🛡️ **Sistema de moderación** para reseñas
- 🎯 **Gestión de recompensas** y configuración de fidelización

## Tecnologías Utilizadas 🛠️

### Backend Principal (PHP)
- **PHP 8.x** con arquitectura MVC
- **MySQL** para base de datos principal
- **Composer** para gestión de dependencias

### API de Fidelización (Python)
- **FastAPI** para API REST de alta performance
- **Pydantic** para validación de datos
- **SQLAlchemy** para ORM
- **Pytest** para testing automatizado

### Frontend
- **HTML5, CSS3, JavaScript** moderno
- **Responsive Design** con CSS Grid y Flexbox
- **AJAX** para interacciones dinámicas

## Arquitectura del Sistema 🏗️

```
Café-VT/
├── app/                    # Aplicación PHP principal (MVC)
│   ├── config/            # Configuraciones
│   ├── controllers/       # Controladores
│   ├── models/           # Modelos
│   ├── views/            # Vistas
│   ├── services/         # Servicios de negocio
│   ├── middleware/       # Middleware de autenticación
│   └── helpers/          # Helpers y utilidades
├── src/loyalty/          # API de Fidelización (Python/FastAPI)
│   ├── routes/           # Endpoints de la API
│   ├── services/         # Lógica de negocio
│   ├── models/           # Modelos Pydantic
│   ├── tests/            # Tests automatizados
│   └── utils/            # Utilidades
├── public/               # Archivos públicos
│   ├── css/              # Estilos
│   ├── js/               # Scripts
│   └── img/              # Imágenes
└── vendor/               # Dependencias PHP
```

## Funcionalidades Avanzadas 🚀

### ☕ Sistema de Café Personalizado
- **Constructor visual** de bebidas
- **Componentes modulares**: bases, leches, endulzantes, toppings
- **Recetas guardadas** para reutilización
- **Control de stock** automático
- **Cálculo de precios** en tiempo real

### 💎 Programa de Fidelización
- **Sistema de puntos** por compras
- **4 niveles de membresía**: Bronce, Plata, Oro, Diamante
- **Recompensas canjeables** con descuentos
- **Historial de transacciones** detallado
- **API REST** independiente para escalabilidad

### ⭐ Sistema de Reseñas
- **Calificaciones** de 1 a 5 estrellas
- **Moderación automática** y manual
- **Reportes** de contenido inapropiado
- **Dashboard de moderación** para administradores

### 🛒 Carrito Inteligente
- **Cálculo automático** de IVA (19%)
- **Desglose detallado**: subtotal, IVA, total
- **Historial de acciones** (deshacer/rehacer)
- **Persistencia** de sesión

## Requisitos del Sistema 📋

### Para la Aplicación PHP
- PHP 8.0 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)
- Composer

### Para la API de Fidelización
- Python 3.8 o superior
- pip (gestor de paquetes Python)
- Base de datos MySQL (compartida)

## Instalación 🚀

### 1. Clonar el repositorio
```bash
git clone https://github.com/tu-usuario/cafe-vt.git
cd cafe-vt
```

### 2. Configurar la aplicación PHP
```bash
# Instalar dependencias PHP
composer install

# Configurar base de datos
# Importar INFO/MER_completo.sql
# Importar INFO/loyalty_system_final.sql
```

### 3. Configurar la API de Fidelización
```bash
cd src/loyalty

# Crear entorno virtual
python -m venv venv
source venv/bin/activate  # En Windows: venv\Scripts\activate

# Instalar dependencias
pip install -r requirements.txt

# Configurar variables de entorno
cp env.example .env
# Editar .env con las credenciales de base de datos
```

### 4. Configurar el servidor web
- Apuntar el DocumentRoot a la carpeta `public/`
- Asegurarse de que mod_rewrite esté habilitado (Apache)

### 5. Iniciar servicios
```bash
# Iniciar la API de fidelización
cd src/loyalty
py -m uvicorn main:app --host 0.0.0.0 --port 8000

# La aplicación PHP se ejecuta a través del servidor web
```

## Testing 🧪

### Tests de la API de Fidelización
```bash
cd src/loyalty
python -m pytest tests/
```

### Tests de carga y rendimiento
```bash
cd src/loyalty
python run_tests.py
```

## Estructura de Base de Datos 📊

### Tablas Principales (PHP)
- `Usuario` - Gestión de usuarios y autenticación
- `Producto` - Catálogo de productos
- `Compra` / `Detalle_Compra` - Sistema de ventas
- `Carro` - Carrito de compras
- `custom_coffee_*` - Sistema de café personalizado
- `product_reviews` - Sistema de reseñas

### Tablas de Fidelización (Python)
- `loyalty_users` - Usuarios del programa de fidelización
- `loyalty_transactions` - Historial de transacciones
- `loyalty_rewards` - Recompensas disponibles
- `loyalty_user_rewards` - Recompensas canjeadas

## API Endpoints 📡

### Fidelización (Python/FastAPI)
- `GET /api/v1/loyalty/profile/{user_id}` - Perfil del usuario
- `GET /api/v1/loyalty/rewards` - Lista de recompensas
- `POST /api/v1/loyalty/redeem-reward` - Canjear recompensa
- `POST /api/v1/loyalty/earn-points` - Ganar puntos

### Aplicación Principal (PHP)
- `GET /cart` - Carrito de compras
- `POST /cart/add` - Agregar al carrito
- `GET /loyalty` - Dashboard de fidelización
- `GET /custom-coffee` - Constructor de café

## Contribuir 🤝

Las contribuciones son bienvenidas. Por favor, sigue estos pasos:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

### Guías de Contribución
- Sigue las convenciones de código existentes
- Incluye tests para nuevas funcionalidades
- Actualiza la documentación según sea necesario
- Verifica que los tests pasen antes de hacer commit

## Licencia 📄

Este proyecto está bajo la Licencia MIT - ver el archivo [LICENSE](LICENSE) para más detalles.

## Contacto 📧

- Equipo de Desarrollo: [equipo@cafe-vt.com](mailto:equipo@cafe-vt.com)
- Sitio Web: [www.cafe-vt.com](https://www.cafe-vt.com)

---
Desarrollado con ❤️ para todo el Mundo
