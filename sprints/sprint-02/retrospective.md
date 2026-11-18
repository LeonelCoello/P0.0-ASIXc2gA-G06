# Sprint 2: retrospectiva

## Índice

- [Aspectos positivos](#aspectos-positivos)
- [Dificultades técnicas observables](#dificultades-tecnicas-observables)
- [Aprendizajes](#aprendizajes)


## Aspectos positivos

Se conservó el servidor de datos de la primera fase y se pudo desplazar el portal a otra instancia. Las pruebas de conexión al puerto 3306 antes de copiar la aplicación ayudaron a aislar problemas de red de posibles fallos de PHP.

## Dificultades técnicas observables

La migración exigió dejar de utilizar `localhost` para MySQL, distinguir usuarios Linux y MySQL y adaptar las reglas AWS. En la configuración de FTP y DNS fue necesario revisar permisos, rutas de archivos y servicios de systemd.

## Aprendizajes

La división en servidores requiere no solo instalar programas, sino comprobar puertos, cuentas, permisos y resolución de nombres. La revisión también permitió detectar afirmaciones de seguridad que debían diferenciarse de las funciones efectivamente probadas.
