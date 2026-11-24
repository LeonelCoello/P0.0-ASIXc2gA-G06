# Registro de trabajo del Sprint 2

Las reuniones del equipo establecen la secuencia del trabajo y el documento técnico contiene capturas de instalaciones, configuración de servidores y pruebas. El reparto individual de cada tarea se gestiona en ProofHub, sin atribuciones inventadas.

| Tarea | Explicación y referencia |
|---|---|
| Separar servidores EC2 | Se despliega W-NCC, se conserva B-NCC y se crea F-NCC. Véase `infrastructure/red/sprint-02.md` |
| Migrar el servidor web | Apache y PHP se instalan en W-NCC. Véase `infrastructure/web-ftp/sprint-02.md` |
| Adaptar el acceso a MySQL | Conexión desde W-NCC a B-NCC y permisos de lectura. Véase `infrastructure/base-datos/sprint-02.md` |
| Configurar vsftpd | Servicio, usuarios y directorios con chroot. Véase `infrastructure/web-ftp/sprint-02.md` |
| Configurar DNS | Instalación BIND9, zona y consultas desde nodos. Véase `infrastructure/dns-dhcp/sprint-02.md` |
| Configurar DHCP | Instalación ISC DHCP y estado del demonio. Véase `infrastructure/dns-dhcp/sprint-02.md` |

## Referencias del seguimiento

- Reunión del 28/10/2026: justificación del Sprint 2.
- Reunión del 02/11/2026: planificación de las configuraciones de servicios.
- Reunión del 10/11/2026: actualización de B-NCC y avances en W-NCC y F-NCC.

## Nuevas tareas integradas tras la replanificación

| Tarea | Actuación y referencia | Evidencia disponible |
|---|---|---|
| S2.6 — Router y Redes (antes S3.1) | Creación de subredes WAN/DMZ/Intranet, R-NCC y ENI; IP Forwarding; NAT y migración de instancias. [Procedimiento](../../infrastructure/red/sprint-02.md) | Capturas de interfaces, rutas y tráfico |
| Actualizar DNS tras la segmentación | Adaptar registros `ns1`, `web`, `db` y `ftp` a las nuevas IP. [DNS/DHCP](../../infrastructure/dns-dhcp/sprint-02.md) | Archivo de zona y prueba posterior de `db` |
| S2.7 — Aislamiento (antes S3.2) | Crear grupos SG-BBDD, SG-Web, SG-FTP y SG-Router; ajustar SSH y validar los accesos. [Firewall](../../security/configuracion-accesos.md) | Cuatro capturas de reglas, pruebas desde W-NCC y B-NCC, SSH reforzado |

### Seguimiento y condiciones de cierre

El trabajo se añadió al Sprint 2 por decisión del equipo; los registros originales anteriores no se alteran. Las pruebas existentes documentan restricciones de acceso específicas de los Security Groups. La observación de `FORWARD ACCEPT` en R-NCC y la ubicación de F-NCC en Intranet se conservan como cuestiones técnicas a valorar si el alcance exigido incluye aislamiento interzona a nivel de router o traslado de F-NCC a DMZ. No se inventan responsables individuales, tiempos de ejecución ni fechas de cierre que no figuran en ProofHub.
