# Revisión técnica del Sprint 2

## Propósito de la fase

Separar la aplicación, la base de datos y el servicio de transferencia entre los nodos W-NCC, B-NCC y F-NCC. Incorporar resolución DNS interna y configuración de DHCP. Conservar la continuidad del catálogo EducaBCN al abandonar el prototipo monolítico.

## Trabajo documentado

- Creación de instancias EC2 para web y FTP y revisión de Security Groups.
- Cambio de hostname y preparación de cuentas de administración.
- Instalación de Apache, PHP y cliente MySQL en W-NCC.
- Desactivación de Apache en el servidor original B-NCC.
- Configuración de conectividad y credenciales de la aplicación fuera del código PHP.
- Instalación y configuración de vsftpd en F-NCC con estructura de directorios.
- Instalación de BIND9 y definición de zona interna.
- Instalación de ISC DHCP y comprobación de estado del servicio.
- Consultas DNS desde los servidores web y de datos.

## Comprobaciones conservadas

Las pruebas y capturas se incluyen en los documentos por componente de `infrastructure/`. El presente registro recoge el alcance de la fase sin sustituir a las instrucciones técnicas.

## Historia de las reuniones

El 28 de octubre se acordó el inicio y alcance del sprint. El 2 de noviembre se priorizaron base de datos, FTP, DNS y DHCP. El 10 de noviembre se informó de la actualización de B-NCC y la configuración en desarrollo de W-NCC y F-NCC. Las capturas posteriores del documento muestran avances adicionales en dichos servicios.

## Resultados de la ampliación: router y seguridad

Tras la distribución inicial de servicios se incorporaron R-NCC, una red WAN, una DMZ y una Intranet. Se registraron la nueva asignación de IP, la salida NAT por `ens5`, el acceso administrativo mediante R-NCC y la sustitución del Security Group compartido por cuatro grupos diferenciados.

Las pruebas conservadas muestran una respuesta HTTPS correcta desde B-NCC, tráfico en `ens7` y `ens5`, accesibilidad de MySQL y FTP desde W-NCC, resolución DNS actualizada para `db.educabcn.local`, y bloqueo observado de ICMP y SSH directo de W-NCC hacia B-NCC. La autenticación SSH del router se reforzó al deshabilitar el acceso directo de root.

Esta revisión diferencia el resultado observado del alcance aún no acreditado: la política `FORWARD ACCEPT` del router no aplica un filtrado interzona granular, F-NCC sigue en Intranet y las capturas de tráfico no relacionan inequívocamente una sola conexión a través del NAT. Se documenta el estado real para que la siguiente decisión técnica sea reproducible.

- [Router, redes y NAT](../../infrastructure/red/sprint-02.md)
- [Reglas de firewall](../../security/configuracion-accesos.md)
- [Pruebas realizadas](../../tests/pruebas-sprint-02-segmentacion.md)
