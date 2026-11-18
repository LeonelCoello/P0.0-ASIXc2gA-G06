# Integración del paquete de documentación en GitHub

## Índice

- [Qué contiene la carpeta](#que-contiene-la-carpeta)
- [Cómo incorporarla al repositorio existente](#como-incorporarla-al-repositorio-existente)
- [Importante sobre el código PHP](#importante-sobre-el-codigo-php)
- [Referencias](#referencias)


## Qué contiene la carpeta

`EducaBCN/` incluye un README general, la documentación de análisis y gestión, los procedimientos técnicos, capturas originales, pruebas, documentación de sprints, seguridad y dos ejemplos de código PHP. Solo se documentan como realizadas las fases 1 y 2; el diseño de la fase 3 aparece como planificación.

## Cómo incorporarla al repositorio existente

1. Crear una copia local de seguridad del repositorio Git actual.
2. Comparar el contenido del ZIP con los archivos del repositorio para evitar sobrescribir código o documentos del equipo que sean más recientes.
3. Copiar las carpetas y documentos seleccionados a la raíz correcta del repositorio.
4. Abrir `README.md` en una vista Markdown y seguir sus enlaces internos.
5. Revisar cualquier captura que contenga información sensible antes de publicarla.
6. Revisar `git diff` y preparar un commit descriptivo; no agregar archivos `.pem`, contraseñas, tokens ni configuraciones secretas.

## Importante sobre el código PHP

Los archivos `infrastructure/aplicacion/codigo/sprint-01/index.php` y `sprint-02/index.php` se incluyen para documentación. El primero se ha reconstruido a partir del script del PDF, retirando el secreto; el segundo es **provisional y pendiente de sustitución** por el código real de W-NCC. **No copiarlos a `/var/www/html/` sin revisar el mecanismo actual de credenciales y probarlo.**

## Referencias

- [Control de versiones explicado](docs/control-versiones.md)
- [Portada del proyecto](README.md)
