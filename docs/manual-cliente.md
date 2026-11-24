# Manual de usuario del portal EducaBCN

## 1. ¿Qué es EducaBCN?

EducaBCN es un portal web para consultar información pública de centros y equipamientos educativos de Barcelona, obtenida del catálogo OpenData BCN. El usuario accede desde un navegador y consulta el listado disponible sin utilizar la consola de administración.

## 2. Requisitos de acceso

Se necesita un navegador actualizado, conexión de red con el servidor web y la dirección de acceso facilitada por el equipo administrador. Durante el desarrollo la dirección pública de AWS puede variar, por lo que el usuario debe utilizar el enlace activo que se comunique en cada demostración.

## 3. Acceder al listado

1. Abrir el navegador.
2. Introducir la dirección del portal EducaBCN proporcionada por el equipo.
3. Esperar a que cargue la página principal.
4. Revisar la tabla con información de los centros educativos.

La primera versión mostraba un máximo de 50 registros mediante una consulta a la base de datos. El catálogo completo almacenado puede ser mayor; este límite corresponde a la presentación inicial y no a la cantidad de registros importados.

## 4. Interpretar la información

Cada fila representa un registro del conjunto de datos utilizado. Las columnas proceden de la base de datos del proyecto y permiten examinar la información publicada de los centros. La disponibilidad y exactitud dependen de la versión del conjunto de datos importada desde OpenData BCN.

## 5. Problemas frecuentes

| Problema | Qué puede hacer el usuario |
|---|---|
| La página no abre | Comprobar la conexión y volver a utilizar el enlace activo |
| El listado aparece vacío | Recargar la página y comunicar el problema al equipo administrador |
| Los caracteres se muestran incorrectamente | Indicar el registro afectado al equipo técnico |
| La página tarda en responder | Esperar unos segundos y notificar la incidencia si se repite |

El usuario no necesita acceso a AWS, MySQL, FTP ni cuentas SSH. Estos accesos pertenecen al equipo administrador y no forman parte de este manual.

## 6. Privacidad y alcance

El portal se basa en datos abiertos sobre equipamientos educativos. No debe usarse para publicar expedientes personales ni credenciales. Si la información de un centro no coincide con la fuente oficial, comunicar la incidencia para que se compruebe el conjunto de datos de origen.
