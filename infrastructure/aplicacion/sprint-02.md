# Aplicación EducaBCN: cambios del Sprint 2

La aplicación se trasladó a W-NCC para dejar la base de datos en B-NCC. La diferencia central respecto al prototipo es que PHP ya no debe asumir `localhost` como servidor SQL.

## Preparación del nuevo entorno

Se instalaron Apache, PHP y la extensión para conectar a MySQL. Las pruebas de red y de login SQL se realizaron antes de configurar el acceso de la aplicación. Esta secuencia facilita localizar el origen de los errores: servicio web, conectividad TCP, permisos SQL o código PHP.

![Captura original del documento técnico: fuente p38 instalaci n de apache y php en w ncc](../../media/sprint-02/fuente-p38-instalaci-n-de-apache-y-php-en-w-ncc.png)

## Separación de secretos

El documento describe el traslado de las credenciales a `/etc/educabcn.conf`, fuera del directorio público y del código versionado. El usuario del servidor web debe poder leer el archivo, pero ningún otro usuario sin privilegios debería acceder a él.

```bash
sudo chown root:www-data /etc/educabcn.conf
sudo chmod 640 /etc/educabcn.conf
sudo stat -c "%U %G %a" /etc/educabcn.conf
```

![Captura original del documento técnico: fuente p39 permisos de archivo de configuraci n](../../media/sprint-02/fuente-p39-permisos-de-archivo-de-configuraci-n.png)

## Comprobación técnica

El cliente MySQL en W-NCC permite validar las credenciales de acceso remoto sin confundirlas con errores del script PHP. El funcionamiento del portal deberá comprobarse al finalizar cualquier modificación de las tablas o de la configuración de red.

## Comprobación del destino MySQL tras segmentar la red

Durante la primera etapa, la conexión de PHP apuntaba a la IP de B-NCC de entonces (`172.31.39.133`). La infraestructura de red migrada sitúa B-NCC en `172.31.102.10`. La configuración activa de conexión de EducaBCN debe contrastarse con este valor antes de considerar validada la página tras la migración.

La prueba de `nc` desde W-NCC a `172.31.102.10:3306` fue satisfactoria; **se ha demostrado el acceso TCP**, pero no se incluye en esta ampliación una captura del portal ejecutando consultas contra MySQL después del cambio de dirección. El archivo de configuración debe verificarse sin mostrar ni publicar su contraseña; no se reconstruye ni se sobrescribe aquí.
