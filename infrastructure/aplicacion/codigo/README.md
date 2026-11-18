# Código PHP documentado por sprint

| Versión | Archivo | Estado |
|---|---|---|
| Sprint 1 | [index.php original reconstruido](sprint-01/index.php) | Basado en el script que aparece en la documentación del primer sprint. Se ha reparado la sintaxis deformada por el formato del PDF y se ha retirado la contraseña literal. |
| Sprint 2 | [index.php provisional](sprint-02/index.php) | Ejemplo provisional con host B-NCC y cuenta MySQL `webapp`, pendiente de sustituir por el archivo real del servidor W-NCC. |

Los archivos se incluyen para **documentación y revisión**, no como demostración de un nuevo despliegue. Las contraseñas deben configurarse fuera del repositorio, y nunca deben subirse en variables, archivos de configuración o capturas visibles.

`getenv('EDUCABCN_DB_PASSWORD')` lee una variable de entorno de PHP. Debe existir en el entorno del proceso web para que el ejemplo funcione. Si el servidor real utiliza `/etc/educabcn.conf`, hay que conservar su mecanismo efectivo y adaptar la transcripción al archivo que se obtenga de W-NCC.
