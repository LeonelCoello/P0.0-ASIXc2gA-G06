# Cuentas, permisos y controles de acceso

## Índice

- [Inventario de cuentas](#inventario-de-cuentas)
- [Reglas y seguridad de red](#reglas-y-seguridad-de-red)
- [Credenciales de aplicación](#credenciales-de-aplicacion)
- [Puntos que requieren una interpretación exacta](#puntos-que-requieren-una-interpretacion-exacta)
- [Cuenta de validación del profesorado](#cuenta-de-validacion-del-profesorado)


## Inventario de cuentas

| Cuenta | Sistema | Uso documentado |
|---|---|---|
| `ubuntu` | Linux EC2 | Cuenta inicial de administración de Ubuntu |
| `bchecker` | Linux | Cuenta creada durante el primer despliegue, con permisos `sudo` en las capturas |
| `bchecker` | MySQL | Cuenta inicial de acceso a la base de datos del primer prototipo |
| `bdd_admin` | Linux en B-NCC | Administración de la instancia de base de datos |
| `web_admin` | Linux en W-NCC | Administración del servidor web |
| `ftp_admin` | Linux en F-NCC | Administración del servicio FTP y servicios auxiliares |
| `ftpuser` | Linux / vsftpd | Cuenta destinada a transferencias de archivos |
| `webapp` | MySQL | Acceso remoto de lectura desde la aplicación PHP |

La coincidencia de nombre no convierte a una cuenta Linux en una cuenta MySQL; tienen contraseñas y permisos gestionados por sistemas diferentes.

## Reglas y seguridad de red

El equipo añadió reglas ICMP de prueba y habilitó el tráfico necesario para la web, FTP y MySQL. Para un uso sostenido debe limitarse el puerto 3306 de B-NCC exclusivamente al origen W-NCC (idealmente su Security Group), y SSH a los orígenes autorizados. Los registros de las capturas no permiten afirmar que esos límites ya se hayan aplicado de forma exhaustiva.

## Credenciales de aplicación

El archivo `/etc/educabcn.conf` se preparó para almacenar la configuración fuera del directorio público. Se documentan propietario `root:www-data` y modo `640`, con lectura para el proceso web. Cualquier cambio en la credencial MySQL debe reflejarse también en esa configuración, siempre que PHP la esté utilizando realmente.

## Puntos que requieren una interpretación exacta

- `bind-address=0.0.0.0` hace que MySQL escuche en interfaces IPv4; no filtra orígenes.
- Un usuario MySQL declarado con host `%` admite intentos de conexión desde varios orígenes; los controles externos deben reducir la superficie.
- `chroot` limita la navegación del usuario FTP, pero no cifra FTP.
- Habilitar `PasswordAuthentication yes` facilita el acceso de prueba; no es equivalente a autenticación exclusiva por claves.
- `PDO` permite consultas preparadas, pero el uso de una consulta `query()` simple no demuestra que todas las entradas futuras estén parametrizadas.

Estas observaciones separan los hechos del proyecto de las recomendaciones habituales de administración segura.

## Cuenta de validación del profesorado

El enunciado requiere una cuenta denominada `bchecker` que permita a los profesores acceder a los equipos y verificar la práctica. Se creó en los servidores documentados y debe comprobarse su acceso según los permisos autorizados en cada máquina. No publicar la contraseña exigida por el enunciado ni incluirla en capturas, scripts o ficheros del repositorio.

**Identidades diferentes:** el usuario Linux `bchecker` habilita la validación de servidores; la cuenta MySQL `bchecker` utilizada al principio es independiente de Linux; en el segundo sprint la conexión PHP remota utiliza `webapp` con permisos de lectura. No se deben confundir ni dar por probados privilegios de una cuenta a partir de los de otra.

Para verificar la existencia de la cuenta Linux, el administrador puede ejecutar `id bchecker` en cada servidor. `id` muestra el UID, GID y grupos de la cuenta. Para comprobar la cuenta MySQL se revisan los privilegios desde una sesión administrativa autorizada, sin mostrar credenciales en pantalla.
