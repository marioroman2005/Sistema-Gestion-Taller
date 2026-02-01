# Sistema de Gestión de Taller

Bienvenido al **Sistema de Gestión de Taller**, una aplicación web diseñada para administrar las operaciones diarias de un taller mecánico. Este sistema permite gestionar clientes, vehículos y reparaciones de manera eficiente y centralizada.

## 🚀 Tecnologías Utilizadas

Este proyecto ha sido desarrollado utilizando las siguientes tecnologías:

*   **Servidor Web**: XAMPP (Apache, MySQL, PHP)
*   **Backend**: PHP
*   **Base de Datos**: MySQL (MariaDB)
*   **Frontend**: HTML5, CSS3, JavaScript
*   **Librerías JS**: jQuery
*   **Estilos**: CSS personalizado

## 📋 Características Principales

El sistema cuenta con los siguientes módulos funcionales:

*   **Autenticación**: Sistema de Login seguro para administradores.
*   **Gestión de Clientes**:
    *   Registro de nuevos clientes.
    *   Listado y búsqueda de clientes.
    *   Edición y eliminación de registros.
*   **Gestión de Vehículos**:
    *   Asociación de vehículos a clientes existentes.
    *   Registro de marca, modelo y matrícula.
*   **Gestión de Reparaciones**:
    *   Creación de órdenes de reparación.
    *   Seguimiento de estados (Pendiente, En curso, Finalizada).
    *   Asignación de precios y fechas.

## 🛠️ Instalación y Configuración

Sigue estos pasos para poner en marcha el proyecto en tu entorno local:

1.  **Entorno**: Asegúrate de tener instalado [XAMPP](https://www.apachefriends.org/index.html).
2.  **Archivos**:
    *   Copia la carpeta del proyecto `Proyecto-PA` dentro del directorio `htdocs` de tu instalación de XAMPP (por defecto `/Applications/XAMPP/xamppfiles/htdocs` en macOS o `C:\xampp\htdocs` en Windows).
3.  **Base de Datos**:
    *   Abre **PHPMyAdmin** (http://localhost/phpmyadmin).
    *   Crea una nueva base de datos (opcional, el script puede crearla si tienes permisos).
    *   Importa el archivo `taller.sql` que se encuentra en la raíz del proyecto. Esto creará la base de datos `proyecto_pa_taller` y las tablas necesarias.
4.  **Configuración**:
    *   Verifica el archivo `includes/conexion.php`. Por defecto está configurado para `root` sin contraseña. Si tu MySQL tiene contraseña, edita este archivo.

## 🔑 Credenciales de Acceso

Para acceder al sistema por primera vez, utiliza el usuario administrador predeterminado creado por el script SQL:

*   **Email**: `admin@taller.com`
*   **Contraseña**: `admin123`

## 📂 Estructura del Proyecto

*   `/clientes`: Scripts para gestión de clientes (alta, baja, modificación, listado).
*   `/vehiculos`: Scripts para gestión de vehículos.
*   `/reparaciones`: Scripts para gestión de órdenes de trabajo.
*   `/includes`: Archivos compartidos (conexión a BD, validaciones, cabeceras).
*   `/css`: Hojas de estilo.
*   `/js`: Scripts JavaScript y validaciones con jQuery.