# Curso CodeIgniter 4 — Proyecto de Referencia

Proyecto de código fuente que acompaña el curso de **CodeIgniter 4** de [Libre Desarrollo](https://desarrollolibre.net). Cubre desde los fundamentos del framework hasta la construcción de un sistema propio de CRUD automatizados, REST API, manejo de imágenes, caché, autenticación y más.

## Requisitos

- PHP >= 7.4
- Composer
- MySQL / MariaDB
- Servidor web (Apache / Nginx) o PHP built-in server

## Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/libredesarrollo/curso-codeigniter-4
cd curso-codeigniter-4

# 2. Instalar dependencias
composer install

# 3. Copiar y configurar el entorno
cp env .env
# Editar .env con tus credenciales de base de datos

# 4. Ejecutar migraciones
php spark migrate

# 5. Ejecutar seeders (datos de prueba)
php spark db:seed MovieSeeder

# 6. Levantar servidor de desarrollo
php spark serve
```

La aplicación estará disponible en `http://localhost:8080`.

## Estructura del Proyecto

```
app/
├── Controllers/
│   ├── CRUDBaseController.php    ← Controlador base del sistema de CRUD automatizado
│   ├── CategoryAutoCRUD.php      ← Ejemplo de CRUD automático para películas
│   ├── Category.php              ← CRUD manual de categorías
│   ├── Movie.php                 ← CRUD manual de películas
│   ├── MyLibraries.php           ← Demos de librerías del framework
│   ├── ImageManipulation.php     ← Manipulación de imágenes
│   ├── RestMovie.php             ← API REST para películas
│   └── MyRestApi.php             ← Cliente cURL para APIs externas
├── Models/
│   ├── MovieModel.php
│   └── CategoryModel.php
├── Views/
│   ├── Custom/
│   │   └── CRUDBaseController/   ← Vistas del sistema CRUD automatizado
│   │       ├── index.php         ← Listado con tabla dinámica
│   │       ├── edit.php          ← Formulario de edición
│   │       ├── new.php           ← Formulario de creación
│   │       └── _form.php         ← Partial compartido de campos
│   └── dashboard/
│       └── templates/            ← Header y footer del dashboard
└── Config/
    ├── Routes.php
    └── Validation.php
```

## Sistema de CRUD Automatizado

El componente más destacado del proyecto es `CRUDBaseController`, un controlador genérico que automatiza la construcción de CRUDs completos. Para crear un CRUD funcional en segundos:

```php
class CategoryAutoCRUD extends CRUDBaseController
{
    public function __construct()
    {
        $db = \Config\Database::connect();

        // 1. Definir el modelo (para escrituras y paginación)
        $this->setModel(new MovieModel());

        // 2. Definir la consulta (para el listado y metadata de columnas)
        $query = $db->query('SELECT * FROM movies');
        $this->setQuery($query);

        // 3. Labels personalizados para la tabla y formularios
        $this->listName = [
            'id'          => 'Id',
            'category_id' => 'Categoría',
            'title'       => 'Título',
            'description' => 'Descripción',
            'price'       => 'Precio'
        ];

        // 4. Activar paginación (opcional)
        $this->paginated = true;

        // 5. Relaciones foráneas para campos select (opcional)
        $this->setRelationOneToMany('category_id', new CategoryModel(), 'id', 'title');

        // 6. Nombre del grupo de validaciones (opcional)
        $this->nameValidation = "movies";

        // 7. Cargar header y footer del layout
        $this->HTMLheader = view("dashboard/templates/header", ['title' => "CRUD Movie"]);
        $this->HTMLfooter = view("dashboard/templates/footer");
    }
}
```

### Características del sistema CRUD

| Característica | Descripción |
|---|---|
| Listado automático | Genera la tabla HTML a partir de la consulta SQL |
| Tipado de campos | Detecta automáticamente si un campo debe ser `text`, `number` o `textarea` |
| Relaciones foráneas | Genera `<select>` automáticos para campos FK |
| Selección por defecto | En edición, pre-selecciona la opción actual del select |
| Campo ID oculto | El campo primario se oculta automáticamente en formularios |
| Paginación | Activable con `$paginated = true` |
| Labels personalizados | Configurables con el array `$listName` |
| Validaciones | Soporta grupos de validación de CodeIgniter 4 |
| Modal de confirmación | Modal de Bootstrap para confirmar eliminaciones |
| Valor anterior | Usa `old()` para recuperar valores tras fallo de validación |

### Rutas requeridas

Registra el controlador con rutas de recursos en `app/Config/Routes.php`:

```php
$routes->resource('categoryautocrud', ['controller' => 'CategoryAutoCRUD']);
```

## Temas cubiertos en el curso

- Peticiones HTTP con cURL (GET, POST, PUT, DELETE)
- Detección del User Agent (dispositivo, navegador, robot)
- Envío de emails con SMTP y Mailtrap
- Encriptación de datos con OpenSSL
- Clase `Time` para fechas y zonas horarias
- Manipulación de URIs
- Clase `File` y operaciones con archivos
- Procesamiento de imágenes (fit, crop, quality, rotate, resize)
- Caché de páginas y caché de datos
- Configuraciones personalizadas con `BaseConfig`
- Sistema de logs
- Internacionalización (i18n) y detección de idioma
- El objeto Request y sus métodos
- Transacciones de base de datos
- Metadata de base de datos
- Métodos PUT/PATCH/DELETE en formularios HTML
- Helpers (array, filesystem, number, text, url)
- **Sistema propio de CRUD automatizados** (sección principal)
- API REST con CodeIgniter 4
- Autenticación y middleware

## Licencia

MIT — Ver archivo [LICENSE](LICENSE) para más detalles.
