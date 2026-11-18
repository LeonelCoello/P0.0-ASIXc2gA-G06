# GitHub, control de versiones y despliegues

## Índice

- [Objetivo de control de cambios](#objetivo-de-control-de-cambios)
- [Trabajo local y sincronización](#trabajo-local-y-sincronizacion)
- [Recuperar cambios remotos](#recuperar-cambios-remotos)
- [Claves SSH y privacidad](#claves-ssh-y-privacidad)
- [Publicación controlada de la documentación](#publicacion-controlada-de-la-documentacion)
- [Relación con el despliegue observado](#relacion-con-el-despliegue-observado)


## Objetivo de control de cambios

El enunciado exige mantener configuración y documentación en un repositorio Git, con autenticación mediante clave pública/privada y demostración de las operaciones `clone`, `add`, `commit`, `push` y `pull`. El repositorio de referencia del grupo es [P0.0-ASIXc2gA-G06](https://github.com/LeonelCoello/P0.0-ASIXc2gA-G06).

El registro de sprint incluye la creación del repositorio y la documentación inicial. **No se asume que todos los servidores se desplegaran mediante Git**, puesto que el traslado del código del segundo sprint se realizó mediante SCP, tal como muestra su evidencia.

## Trabajo local y sincronización

```bash
git clone git@github.com:LeonelCoello/P0.0-ASIXc2gA-G06.git
cd P0.0-ASIXc2gA-G06
git status
git add README.md docs/ infrastructure/
git commit -m "Documentar infraestructura EducaBCN"
git push origin main
```

- `git clone`: copia un repositorio remoto al equipo; el formato `git@github.com:` usa SSH.
- `cd`: entra en la carpeta clonada.
- `git status`: muestra archivos modificados o preparados.
- `git add`: selecciona los archivos indicados para el siguiente commit.
- `git commit -m`: registra una versión local con el mensaje proporcionado.
- `git push origin main`: envía los commits de la rama local a `origin/main`, **si** la rama y los permisos son esos.

**Son comandos de referencia**. Antes de aplicarlos hay que confirmar el nombre real de la rama (`git branch --show-current`) y revisar que no haya secretos en el área de preparación (`git diff --cached`).

## Recuperar cambios remotos

```bash
git pull --ff-only origin main
git log --oneline -5
git diff
```

- `git pull --ff-only`: obtiene cambios de `origin/main` e integra solo si la rama admite avance directo, evitando fusionar sin revisión.
- `git log --oneline -5`: muestra los cinco commits más recientes en formato breve.
- `git diff`: enseña modificaciones no preparadas en el directorio de trabajo.

**Estado de prueba:** las operaciones anteriores se documentan como procedimiento reproducible, no como histórico verificado de ejecuciones dentro de las instancias. La verificación real debe provenir de la consola o del historial Git del repositorio.

## Claves SSH y privacidad

Cada ordenador o servidor autorizado puede disponer de una clave SSH específica. La clave **privada nunca debe salir del equipo** y no debe añadirse a Git; la pública se registra en el servicio correspondiente. Verificar la identidad de GitHub antes de aceptar claves de host. Consultar [guía oficial de GitHub sobre SSH](https://docs.github.com/en/authentication/connecting-to-github-with-ssh/testing-your-ssh-connection?platform=linux).

No se guardan ficheros `.pem`, contraseñas, tokens ni volcados de una configuración que contenga secretos. La cuenta de validación del profesorado `bchecker` tampoco se utiliza como excusa para publicar su contraseña.

## Publicación controlada de la documentación

1. Comprobar que las imágenes están dentro de `media/` y los enlaces Markdown funcionan.
2. Verificar que el README refleja el estado real de los sprints.
3. Revisar `git status` y `git diff --cached` antes de confirmar los cambios.
4. Realizar un commit con descripción concreta.
5. Publicar con `git push` y abrir GitHub para comprobar el renderizado.
6. Guardar una captura real del historial y de la página publicada si se necesita evidencia evaluable.

## Relación con el despliegue observado

La transferencia del portal de B-NCC a W-NCC se realizó mediante `scp` y copia a `/var/www/html/`. Un futuro despliegue por Git debería diseñar permisos, rama, ruta de despliegue, rollback y exclusión de secretos, y registrarlo como una acción distinta de la transferencia histórica.

- [Migración a W-NCC](../infrastructure/web/sprint-02.md)
- [Accesos y cuentas](../security/configuracion-accesos.md)
- [Guía para integrar documentación](../MIGRACION_A_GITHUB.md)
