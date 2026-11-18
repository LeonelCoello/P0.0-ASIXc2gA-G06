# Validaciones de la infraestructura distribuida

| ID | Comprobación | Resultado observado | Documento |
|---|---|---|---|
| P2-01 | Creación de W-NCC y F-NCC | Capturas de instancia EC2 | [Red](../infrastructure/red/sprint-02.md) |
| P2-02 | Comunicación W-NCC → B-NCC:3306 | `nc` muestra conexión satisfactoria | [Red](../infrastructure/red/sprint-02.md) |
| P2-03 | Usuario remoto MySQL | Consulta visible desde W-NCC y rechazo de escritura | [MySQL](../infrastructure/base-datos/sprint-02.md) |
| P2-04 | Migración de la web | SCP y copia a `/var/www/html/` registrados | [Web](../infrastructure/web/sprint-02.md) |
| P2-05 | Portal migrado | Listado de centros visualizado desde W-NCC | [Aplicación](../infrastructure/aplicacion/sprint-02.md) |
| P2-06 | FTP | Estado del servicio y sesión de transferencia | [FTP](../infrastructure/ftp/sprint-02.md) |
| P2-07 | BIND9 | Servicio activo y resolución mediante `dig`/`nslookup` | [DNS](../infrastructure/dns-dhcp/sprint-02.md) |
| P2-08 | DNS desde W-NCC y B-NCC | Resolución y `ping` al host de base de datos | [DNS](../infrastructure/dns-dhcp/sprint-02.md) |
| P2-09 | ISC DHCP | Servicio iniciado en F-NCC | [DHCP](../infrastructure/dns-dhcp/sprint-02.md) |

## Alcance de estas validaciones

La instalación de ISC DHCP no demuestra asignación efectiva de una IP a un cliente EC2. La prueba del servicio FTP no acredita negociación TLS. La pantalla del portal por sí sola tampoco demuestra controles restrictivos sobre el puerto MySQL; para eso se deben observar las reglas y los intentos desde orígenes no autorizados.

Se documentan exclusivamente los resultados recogidos en las capturas de los dos primeros sprints.
