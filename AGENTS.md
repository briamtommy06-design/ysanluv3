# AI Agent Instructions for `ysanluv3`

This app is a custom PHP MVC-style application with lightweight routing and AJAX endpoints.

## What to know
- `index.php` is the front controller.
- `controladores/` contains controller classes.
- `modelos/` contains model classes and DB access.
- `ajax/` contains AJAX endpoint scripts that return JSON.
- `vistas/plantilla.php` is the main layout.
- `modelos/conexion.php` creates a PDO MySQL connection.
- Routing is handled by `.htaccess` rewriting paths to `index.php?ruta=$1`.
- There is no Composer, npm, or automated build/test system in this app.

## Conventions
- Controllers are named `Controlador...` and use methods like `ctr...`.
- Models are named `Modelo...` and use methods like `mdl...`.
- AJAX classes are typically `Ajax...` and do not render full HTML pages.
- Data access belongs in `modelos/`, request handling belongs in `controladores/`, and JSON response logic belongs in `ajax/`.
- Keep view/layout changes confined to `vistas/` and static assets.
- Use prepared statements and PDO; avoid interpolating untrusted SQL identifiers.

## Best practices for AI edits
- Preserve the existing include/require structure and relative paths.
- Do not assume a framework like Laravel or Symfony.
- Maintain clean JSON output in AJAX endpoints.
- When updating DB queries, keep table and column names consistent with the app's naming.
- Avoid refactoring large structural patterns unless the user explicitly requests it.
