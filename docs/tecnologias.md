# Tecnologías y justificación


| Tecnología | Uso previsto o documentado | Observación |
|---|---|---|
| Ubuntu Server 24.04 LTS | Sistema operativo de instancias EC2 | Visible en evidencias |
| Apache + PHP | Servir portal EducaBCN | Probado en el prototipo |
| PDO | Acceso de PHP a MySQL | Usar consultas preparadas y tratamiento seguro de errores |
| MySQL | Persistencia del catálogo educativo | Importación documentada |
| AWS EC2 y Security Groups | Despliegue y filtrado | Separación de nodos documentada |
| BIND9 | DNS interno | Instalación y consultas documentadas |
| ISC DHCP Server | Instalación y revisión del servicio | No se ha acreditado una concesión emitida por ISC DHCP; las instancias EC2 obtienen su configuración DHCP de AWS |
| vsftpd | Transferencias mediante FTP en el laboratorio | `chroot` documentado; no hay prueba de FTPS o SFTP ya configurado |
| SSH y Git | Administración y control de versiones | Preferir claves y permisos mínimos |
| ProofHub | Backlog y tareas | Las reuniones hacen referencia a este sistema |

La memoria menciona VPN IPsec, router lógico, Netdata/Prometheus/Grafana y recuperación automática. No se consideran implementados hasta disponer de configuración y pruebas.

## Tecnologías aplicadas durante la segmentación del Sprint 2

| Tecnología | Función comprobada o configurada | Límite de la evidencia |
|---|---|---|
| AWS VPC, subredes y tablas de rutas | Segmentación WAN/DMZ/Intranet; salida de Intranet hacia la ENI de R-NCC | La ruta `local` de AWS exige revisar el recorrido efectivo del tráfico entre subredes |
| Linux R-NCC y Netplan | Tres interfaces `ens5`, `ens6`, `ens7` activas | Las direcciones obtenidas mediante DHCP pueden cambiar si no están fijadas en AWS |
| `sysctl` IP Forwarding | Reenvío IPv4 habilitado (`1`) | La opción no define por sí sola una política de filtrado |
| `iptables` NAT / MASQUERADE | Regla NAT observada con salida por `ens5` | Las capturas de tráfico de entrada y salida muestran destinos distintos; no deben confundirse con una traza única |
| AWS Security Groups individuales | Permisos de acceso por rol y pruebas de tráfico permitido/bloqueado | En R-NCC la política `FORWARD` se observó como `ACCEPT`, sin filtrado granular acreditado |
| OpenSSH / ProxyJump | Administración de instancias privadas desde el equipo local a través de R-NCC | Deben seguir protegidas las claves y revisarse los orígenes autorizados |
