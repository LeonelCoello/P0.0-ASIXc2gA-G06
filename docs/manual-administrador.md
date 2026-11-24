# Manual de administración de EducaBCN

## 1. Propósito y público

Este manual está dirigido a las personas encargadas de operar EducaBCN. Recoge el inventario de servidores, las tareas de operación habitual, los pasos de comprobación, la gestión de accesos y el diagnóstico de incidencias a partir del despliegue documentado. Los procedimientos históricos paso a paso y sus capturas se encuentran enlazados en cada sección. Las claves, contraseñas y direcciones efímeras no forman parte de la documentación pública.

## 2. Arquitectura del entorno documentado

Durante el primer sprint se utilizó una instancia única que concentraba Apache, PHP, MySQL y el portal. En el segundo sprint se comenzó su separación en nodos con funciones concretas:

| Equipo | Función | Componentes |
|---|---|---|
| W-NCC | Aplicación web | Apache, PHP, PDO y cliente MySQL |
| B-NCC | Persistencia | MySQL Server y datos EducaBCN |
| F-NCC | Transferencias | vsftpd y usuarios de transferencia |

BIND9 e ISC DHCP también aparecen en la documentación técnica. El diagrama de arquitectura de diseño no debe confundirse con una certificación de que todas sus zonas y controles están desplegados.

La evolución y los procedimientos utilizados se encuentran en [red de Sprint 1](../infrastructure/red/sprint-01.md) y [red de Sprint 2](../infrastructure/red/sprint-02.md).

### Alcance de las comprobaciones documentadas

Las capturas muestran instalaciones, estados de servicios y consultas concretas. No prueban por sí mismas que el FTP esté cifrado, que el DHCP de ISC asigne direcciones a instancias AWS, que el puerto MySQL sea inaccesible desde cualquier origen no autorizado o que el modelo relacional propuesto esté desplegado. Estas cuestiones no se presentan como hechos verificados.


## 3. Acceso a instancias AWS EC2

### 3.1. Localizar la instancia correcta

En AWS EC2 identificar el nodo por su nombre y etiquetas antes de ejecutar cambios. Comprobar el estado de la instancia, su grupo de seguridad, su IP privada y el volumen de almacenamiento. La IP pública puede variar con el ciclo de vida de la instancia; no debe darse por permanente sin un recurso específico configurado.

### 3.2. Acceso SSH

Para nuevas conexiones administrativas se recomienda utilizar una clave personal autorizada y el usuario de la instancia. Históricamente, el Sprint 1 también habilitó SSH por contraseña; el siguiente ejemplo muestra el método por clave sin afirmar que el acceso por contraseña se haya desactivado:

```bash
ssh -i RUTA_CLAVE USUARIO@HOST
```

No pegar claves privadas en GitHub ni adjuntarlas a incidencias. Cada usuario administrativo debe disponer de identidad propia. Revisar que el grupo de seguridad admita SSH solo desde los orígenes autorizados.

### 3.3. Identificación del nodo

```bash
hostnamectl
ip -brief address
ip route
whoami
id
```

Comparar el hostname y la dirección con el inventario interno antes de reiniciar servicios.

## 4. Gestión de cuentas y permisos

En el Sprint 1 el usuario Linux `bchecker` recibió permisos administrativos; también se utilizó el nombre `bchecker` para una cuenta SQL del prototipo. No son una única identidad ni tienen necesariamente los mismos privilegios. En el Sprint 2 se documenta la creación de administradores específicos y de `webapp` como usuario SQL para la conexión remota. El criterio recomendado para la operación posterior es reservar `sudo` a administradores y separar las cuentas de servicio de las cuentas de administración. Esta separación se propone como política, sin afirmar que ya se haya aplicado retroactivamente a todos los usuarios.

```bash
getent passwd
getent group sudo
id USUARIO
sudo -l -U USUARIO
```

Para un usuario de transferencia, definir la carpeta inicial y los permisos del directorio. En MySQL del Sprint 2 se creó `webapp` con host `%` y posteriormente se restringieron sus privilegios a lectura según el procedimiento original. El host `%` no restringe el origen al servidor W-NCC; las restricciones reales dependen además de los Security Groups. Para una cuenta SQL se recomienda limitar `host`, base de datos y permisos y verificar lo aplicado con `SHOW GRANTS`.

## 5. Servidor web W-NCC

### 5.1. Verificar disponibilidad

```bash
sudo systemctl status apache2
sudo apache2ctl configtest
curl -I http://127.0.0.1/
```

`systemctl` confirma el estado del proceso, `configtest` valida la sintaxis y `curl` comprueba que Apache responde por HTTP. Una respuesta HTTP no demuestra por sí sola que la base de datos sea accesible.

### 5.2. Registros y diagnóstico

```bash
sudo journalctl -u apache2 -n 50 --no-pager
sudo tail -n 50 /var/log/apache2/error.log
sudo ss -ltnp
```

Ante una respuesta 500, revisar primero el error de Apache/PHP y después conectividad SQL. Ante una ausencia de respuesta, comprobar el grupo de seguridad de EC2 y las reglas del sistema operativo.

### 5.3. Despliegue de código

Versionar los archivos fuente en GitHub y desplegar únicamente revisiones identificables. Comprobar la integridad de `index.php` y los permisos de lectura del usuario Apache. No incluir en el repositorio el fichero de secretos de la aplicación.

Los pasos originales se documentan en [web de Sprint 1](../infrastructure/web-ftp/sprint-01.md), [migración de Sprint 2](../infrastructure/web-ftp/sprint-02.md) y [aplicación](../infrastructure/aplicacion/sprint-02.md).

## 6. Base de datos B-NCC

### 6.1. Estado de MySQL

```bash
sudo systemctl status mysql
sudo journalctl -u mysql -n 50 --no-pager
sudo ss -ltnp | grep 3306
```

En el despliegue distribuido, MySQL debe admitir conexiones privadas necesarias desde W-NCC, no conexiones arbitrarias desde Internet.

### 6.2. Comprobación de las tablas

```sql
USE EducaBCN;
SHOW TABLES;
SELECT COUNT(*) FROM centros_educativos;
SELECT * FROM centros_educativos LIMIT 5;
```

Verificar que los resultados conservan la codificación de tildes y caracteres especiales. Para la carga inicial se registraron 2.710 filas; si el catálogo cambia, el recuento debe contrastarse con la fecha y versión de la fuente de datos, no suponerse fijo.

### 6.3. Acceso remoto desde W-NCC

```bash
nc -vz HOST_B_NCC 3306
mysql -h HOST_B_NCC -u USUARIO_LECTURA -p
```

No incluir la contraseña en la línea de comandos. Una conexión TCP correcta puede coexistir con un error de credenciales, y el acceso SQL puede ser correcto aunque la aplicación falle por otro motivo.

### 6.4. Permisos mínimos

El usuario de la aplicación debe poder consultar solo las tablas necesarias. Evitar permisos de superusuario, ALTER, DROP y escritura cuando solo se requiere leer el catálogo. Registrar los cambios de privilegios bajo una cuenta administrativa SQL separada.

El procedimiento original está detallado en [MySQL Sprint 1](../infrastructure/base-datos/sprint-01.md) y [MySQL Sprint 2](../infrastructure/base-datos/sprint-02.md).

## 7. Gestión de datos OpenData BCN

El origen de datos utilizado es el catálogo de equipamientos educativos de OpenData BCN. Antes de sustituir los datos hay que registrar el fichero descargado, su fecha, formato de texto, delimitadores y cabeceras. Se recomienda importar a una tabla intermedia antes de actualizar las tablas públicas.

Flujo de operación:

1. Descargar el archivo desde la fuente oficial y conservar una copia original.
2. Revisar la codificación del CSV y su estructura de columnas.
3. Comprobar recuento, duplicados y valores vacíos en el entorno de importación.
4. Aplicar la carga y consultar una muestra representativa.
5. Abrir EducaBCN y contrastar su vista con los resultados SQL.

No ejecutar importaciones destructivas sobre las tablas activas sin respaldo verificado.

## 8. Servicio FTP F-NCC

### 8.1. Estado y configuración

```bash
sudo systemctl status vsftpd
sudo journalctl -u vsftpd -n 50 --no-pager
sudo grep -E '^(anonymous_enable|local_enable|write_enable|chroot_local_user)' /etc/vsftpd.conf
```

Se documentaron usuarios de transferencia y directorios restringidos. Comprobar que la cuenta utilizada solo puede acceder a su ámbito autorizado y no a rutas del sistema.

### 8.2. Transferencias y seguridad

Las capturas del laboratorio muestran vsftpd operativo, usuarios y directorios con `chroot`; no demuestran que FTPS o SFTP estén habilitados. `chroot` no cifra la transferencia. Las sesiones FTP sin cifrar no deben utilizarse con credenciales o documentos sensibles. Como medida de seguridad recomendada, antes de un uso real con esos archivos debe configurarse y probarse FTPS o SFTP, además de limitar los orígenes de acceso en AWS.

### 8.3. Diagnóstico

Si un cliente no conecta, comprobar el estado de vsftpd, el puerto y la ruta de red. Si el login funciona pero la subida falla, inspeccionar permisos del directorio y restricciones de `chroot`. En modo pasivo, las reglas de firewall deben coincidir con el rango definido en la configuración.

Consultar [procedimiento del servidor FTP](../infrastructure/web-ftp/sprint-02.md).

## 9. DNS y DHCP

### 9.1. DNS BIND9

```bash
sudo systemctl status bind9
sudo named-checkconf
dig @HOST_DNS web.educabcn.local
```

Si la resolución no funciona, comprobar primero la zona y el servicio DNS, después que el cliente use el resolver apropiado y finalmente el acceso de red al puerto 53. El nombre consultado debe existir en el archivo de zona y apuntar a la IP privada prevista.

### 9.2. DHCP

```bash
sudo systemctl status isc-dhcp-server
cat /etc/default/isc-dhcp-server
sudo journalctl -u isc-dhcp-server -n 50 --no-pager
```

Se documentan la instalación de ISC DHCP Server y la comprobación del proceso, pero no una concesión DHCP entregada por este servidor a un cliente. AWS proporciona el mecanismo DHCP de las instancias EC2 en la VPC; por ello no se debe afirmar que ISC DHCP esté asignando las direcciones de esas instancias. La descripción se refiere al servicio instalado en el laboratorio.

Ver [procedimiento DNS/DHCP](../infrastructure/dns-dhcp/sprint-02.md) con capturas originales de instalación y consultas.

## 10. Configuración de la aplicación y secretos

El acceso PHP a MySQL se separó del código y se colocó en `/etc/educabcn.conf` con permisos restrictivos. La aplicación no debe imprimir contraseñas, trazas de conexión detalladas ni rutas internas en errores visibles al visitante.

```bash
sudo stat -c '%U:%G %a %n' /etc/educabcn.conf
sudo test -r /etc/educabcn.conf && echo 'El administrador puede leer el fichero'
```

La comprobación de lectura por parte de Apache debe realizarse con el usuario real del proceso sin mostrar el contenido secreto. Nunca publicar un volcado del archivo para demostrar permisos.

## 11. Operación y mantenimiento

### 11.1. Comprobación al iniciar una jornada

1. Verificar las instancias EC2 y grupos de seguridad.
2. Comprobar SSH, Apache, MySQL, vsftpd, BIND9 y DHCP en el nodo correspondiente.
3. Consultar el portal desde un navegador de prueba.
4. Ejecutar una consulta SQL de solo lectura y una consulta DNS interna.
5. Revisar espacio en disco, memoria y eventos relevantes de logs.
6. Registrar toda incidencia en el tablero de trabajo.

```bash
df -h
free -h
uptime
sudo journalctl -p warning -n 30 --no-pager
```

### 11.2. Actualizaciones

Planificar una ventana de mantenimiento, revisar dependencias antes de actualizar, guardar un respaldo cuando el cambio pueda afectar a datos o disponibilidad y comprobar funcionalidad tras cada reinicio.

```bash
sudo apt update
apt list --upgradable
```

La instalación masiva de actualizaciones debe hacerse únicamente después de evaluar el impacto.

## 12. Tabla de incidencias frecuentes

| Síntoma | Comprobación | Posible intervención |
|---|---|---|
| No carga la web | `systemctl status apache2`, `curl`, Security Group | Revisar Apache, puertos y logs |
| Respuesta HTTP 500 | Logs de Apache/PHP | Revisar error de aplicación y conexión SQL |
| PHP no consulta MySQL | `nc` puerto 3306, usuario SQL | Revisar red privada, permisos SQL, configuración PDO |
| DNS no resuelve | `named-checkconf`, `dig` | Corregir zona, resolver o acceso de red |
| FTP rechaza credenciales | Logs vsftpd, estado de cuenta | Revisar usuario, chroot y permisos |
| FTP no permite escribir | Permisos de carpeta | Corregir propietario y directorio autorizado |
| Disco casi lleno | `df -h`, logs | Retirar archivos temporales tras revisión |
| Instancia inaccesible | Estado EC2, IP, reglas SSH | Revisar red y acceso desde consola AWS |

## 13. Recuperación y continuidad

El [plan de contingencia](plan-contingencia.md) describe escenarios, responsables, prioridades de recuperación y objetivos de tiempo propuestos. **Las pruebas de restauración y los tiempos indicados no se consideran resultados demostrados** hasta que existan sus registros. No ejecutar procedimientos destructivos sin copia verificada ni autorización de la persona responsable.

## 14. Historial técnico y fuentes internas

- [Procedimientos de red](../infrastructure/red/README.md)
- [Servidor web y FTP](../infrastructure/web-ftp/README.md)
- [Base de datos](../infrastructure/base-datos/README.md)
- [Servicios DNS y DHCP](../infrastructure/dns-dhcp/README.md)
- [Portal PHP](../infrastructure/aplicacion/README.md)
- [Seguimiento del Sprint 1](../sprints/sprint-01/review.md)
- [Seguimiento del Sprint 2](../sprints/sprint-02/review.md)

Las capturas se encuentran dentro de los procedimientos de instalación, inmediatamente después del paso que documentan.

## 15. Operación de la infraestructura segmentada (segunda etapa del Sprint 2)

### 15.1. Identificación de nodos y direcciones actuales

El administrador debe distinguir las IP antiguas, preservadas en el registro de la primera etapa, de las direcciones vigentes tras la migración:

| Servidor | Ubicación documentada | IP privada |
|---|---|---|
| R-NCC (WAN) | `ens5` / `172.31.100.0/24` | `172.31.100.10` |
| R-NCC (DMZ) | `ens6` / `172.31.101.0/24` | `172.31.101.254` |
| R-NCC (Intranet) | `ens7` / `172.31.102.0/24` | `172.31.102.254` |
| W-NCC | DMZ | `172.31.101.10` |
| B-NCC | Intranet | `172.31.102.10` |
| F-NCC | Intranet | `172.31.102.20` |

Las IP de R-NCC se observaron en la interfaz Linux y constan en las pruebas. La puerta de enlace `172.31.102.1` comunicada en B-NCC corresponde al DHCP/routing de AWS y no debe confundirse con la IP de R-NCC.

### 15.2. Administración por salto SSH

Desde el equipo local se configura OpenSSH para acceder primero a la IP pública autorizada de R-NCC y después a las direcciones privadas de los servidores. Se recomienda utilizar `ProxyJump` y conservar todas las claves privadas **solo en el equipo local**, nunca en el router o el repositorio.

```sshconfig
Host r-ncc
    HostName IP_PUBLICA_R_NCC
    User ubuntu
    IdentityFile RUTA_PRIVADA_DE_LA_CLAVE
    IdentitiesOnly yes

Host w-ncc
    HostName 172.31.101.10
    User ubuntu
    IdentityFile RUTA_PRIVADA_DE_LA_CLAVE
    IdentitiesOnly yes
    ProxyJump r-ncc
```

Esta configuración es ilustrativa y debe adaptarse a los usuarios y las claves efectivamente autorizados de cada instancia. Evitar subir el archivo de configuración local si incluye datos sensibles.

### 15.3. Comprobar el router antes de intervenir

```bash
ip -br -4 a
ip route
sudo sysctl net.ipv4.ip_forward
sudo iptables -t nat -L POSTROUTING -n -v
sudo iptables -L FORWARD -n -v
```

- Las tres interfaces deben estar levantadas en sus subredes.
- `net.ipv4.ip_forward` debe devolver `1` para reenviar IPv4.
- `POSTROUTING` muestra si existe `MASQUERADE` por `ens5`.
- `FORWARD` muestra la política y contadores; durante las comprobaciones quedó en `ACCEPT` sin reglas adicionales, lo que no equivale a un aislamiento completo.

Antes de cambiar rutas o reglas, conservar una sesión SSH abierta y documentar una forma de recuperación mediante AWS para evitar perder la administración.

### 15.4. Revisar los Security Groups individuales

Los permisos actuales descritos en [firewall](../security/configuracion-accesos.md) no deben confundirse con el antiguo grupo compartido. Los cuatro grupos son `SG-Router-EducaBCN`, `SG-Web-EducaBCN`, `SG-BBDD-EducaBCN` y `SG-FTP-EducaBCN`.

En R-NCC hay que revisar las asociaciones de **cada ENI**, no solo la instancia. Su regla SSH desde `0.0.0.0/0` es una exposición residual; la autenticación por clave reduce el riesgo pero no elimina los intentos de conexión externos. En R-NCC se verificó `PasswordAuthentication no`, `KbdInteractiveAuthentication no` y `PermitRootLogin no`; esto no certifica la misma configuración para todos los nodos.

### 15.5. Verificar las comunicaciones imprescindibles

Desde W-NCC:

```bash
nc -zv -w 5 172.31.102.10 3306
nc -zv -w 5 172.31.102.20 21
nslookup db.educabcn.local 172.31.102.20
ping -c 4 172.31.102.10
```

Esperado según las pruebas registradas: MySQL y FTP accesibles a nivel TCP; `db.educabcn.local` resuelve a `172.31.102.10`; no hay respuesta al ping de W-NCC a B-NCC. Desde B-NCC, `curl -4 -I --max-time 10 https://example.com` devolvió `HTTP/2 200`.

### 15.6. Verificar DNS tras cambios de IP

La zona de F-NCC es `/etc/bind/db.educabcn.local`. Se conservan los registros históricos de la primera etapa y se documenta la nueva configuración en [DNS/DHCP del Sprint 2](../infrastructure/dns-dhcp/sprint-02.md). Tras cualquier cambio incrementar el `Serial`, validar con `named-checkzone`, recargar con `rndc reload` y consultar de nuevo desde un cliente. El nombre `db` sí fue observado resolviendo a su IP nueva tras el cambio.

### 15.7. Límites que debe conocer el administrador

Las pruebas no certifican transferencia FTP cifrada, asignación DHCP de AWS por ISC DHCP, rendimiento medido, restauraciones comprobadas ni un filtrado completo por `iptables` entre todas las zonas. F-NCC aparece todavía en Intranet en las evidencias; una reubicación futura requiere replantear las reglas SSH/FTP/DNS y repetir las pruebas. La guía no presenta estas tareas como finalizadas.
