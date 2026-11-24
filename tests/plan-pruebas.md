# Criterios para validar la instalación documentada

Este documento resume las verificaciones que acompañan a la instalación. No declara una ejecución satisfactoria de pruebas para las que no existen resultados en el PDF original.

| Componente | Cómo se comprueba | Evidencia en procedimientos |
|---|---|---|
| Apache/PHP | Estado del servicio y respuesta desde el navegador | Web, primera fase |
| MySQL | Estado del servicio, recuento y consultas | Base de datos, primera fase |
| Portal | Tabla visible en navegador | Aplicación, primera fase |
| Separación de servidores | Nodos EC2, hostnames, servicios de cada rol | Red, segunda fase |
| Conexión remota a MySQL | Puerto TCP y cliente SQL | Web y base de datos, segunda fase |
| vsftpd | Servicio y directorios de usuario | Web/FTP, segunda fase |
| BIND9 | Estado del demonio y consultas DNS | DNS/DHCP, segunda fase |
| ISC DHCP | Instalación y estado del servicio | DNS/DHCP, segunda fase |

## Pruebas incorporadas al ampliar el Sprint 2

| Componente / objetivo | Comprobación registrada | Estado de la evidencia |
|---|---|---|
| Interfaces de R-NCC | Estado `UP` e IP reales de `ens5`, `ens6`, `ens7` | Captura disponible |
| Enrutamiento | `net.ipv4.ip_forward = 1`, tabla de rutas de Linux | Captura disponible |
| NAT y salida WAN | Regla `MASQUERADE`, `curl` B-NCC, capturas de `ens7` y `ens5` | Parcialmente demostrado: capturas de distintos destinos externos |
| Firewall MySQL | TCP/3306 W-NCC → B-NCC | Acceso permitido comprobado |
| Firewall FTP | TCP/21 W-NCC → F-NCC | Acceso al puerto comprobado |
| DNS tras cambio de IP | `db.educabcn.local` → `172.31.102.10` | Resolución comprobada |
| Bloqueo ICMP y SSH directo | Ping y TCP/22 W-NCC → B-NCC | Sin respuesta y `timed out` |
| Acceso administrativo | Claves y `ProxyJump`; `PermitRootLogin no` en R-NCC | Confirmación de acceso del equipo y captura de configuración SSH |

La evidencia visual y el alcance de cada resultado se encuentran en [pruebas de segmentación](pruebas-sprint-02-segmentacion.md). Los criterios para cifrado, recuperación, métricas y filtrado interzona completo siguen requiriendo pruebas propias.
