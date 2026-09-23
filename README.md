# Feria Tecnológica - Proyecto colaborativo Frontend

Proyecto base para la materia **Tópicos Selectos de Desarrollo Web**.

## Tecnologías
- HTML5
- CSS3
- Bootstrap 5.3
- JavaScript
- Git / GitHub

## Reglas del proyecto
1. Cada alumno trabaja en una rama `isai`.
2. No trabajar directamente sobre `main`.
3. Respetar Navbar, Footer, tipografía, colores, botones y estructura de carpetas.
4. No modificar componentes comunes sin autorización del docente.
5. Cada alumno debe realizar al menos 3 commits significativos.
6. El trabajo se integra mediante Pull Request.
7. El módulo debe ser responsive y funcionar correctamente.

## Ramas sugeridas
- feature/inicio
- feature/login
- feature/registro
- feature/perfil
- feature/eventos
- feature/proyectos
- feature/proyecto-detalle
- feature/equipos
- feature/integrantes
- feature/ponentes
- feature/evaluadores
- feature/evaluacion
- feature/calificaciones
- feature/horarios
- feature/espacios
- feature/inscripciones
- feature/asistencia
- feature/certificados
- feature/notificaciones
- feature/comentarios
- feature/busqueda
- feature/reportes
- feature/dashboard
- feature/galeria
- feature/contacto
- feature/acerca

## Estructura
```text
feria-tecnologica-web/
├── index.html
├── components/
├── css/
├── js/
├── img/
└── pages/
```

## Flujo Git recomendado
```bash
git clone URL_DEL_REPOSITORIO
git checkout -b isai/inscripciones
# trabajar
git add nombre del archivo modificado.
git commit -m "isai: agrega modulo X"
git push origin isai/nombre-modulo
```

Después, crear un Pull Request hacia la rama indicada por el docente.
