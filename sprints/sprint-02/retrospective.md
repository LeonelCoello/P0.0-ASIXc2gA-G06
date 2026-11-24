# Retrospectiva del Sprint 2

## Enfoque adoptado

La separación de servicios se desarrolló por etapas para facilitar el diagnóstico de conectividad. Primero se crearon los nodos y se asignaron los roles; después se verificó la comunicación de la web con MySQL; posteriormente se trabajó en FTP y los servicios DNS/DHCP.

## Observaciones de las reuniones

La reunión del 10/11/2026 documenta que B-NCC estaba actualizado mientras W-NCC y F-NCC continuaban en configuración. El equipo priorizó terminar esas instalaciones e incorporar la resolución de nombres y DHCP.

## Aprendizajes técnicos

Comprobar la conectividad TCP y los permisos de MySQL por separado ayuda a distinguir fallos de red y de autenticación. Conservar la instancia inicial como B-NCC permite reutilizar la base de datos, pero obliga a retirar el servicio web del nodo y a revisar los permisos remotos. Las capturas y procedimientos técnicos se conservan por componente.

## Aprendizajes derivados de la segmentación

La migración mostró la importancia de mantener un registro de direcciones IP antiguas y nuevas: las reglas MySQL y los registros BIND9 no deben seguir apuntando a los nodos anteriores. Se detectó mediante `nslookup` que `web.educabcn.local` seguía resolviendo a la IP antigua, lo que motivó la revisión de la zona DNS.

Las comprobaciones también permitieron distinguir entre permisos de acceso de los Security Groups y servicios que simplemente escuchan en un puerto, entre una respuesta `HTTP 200` y la ruta efectiva seguida por el tráfico, y entre NAT y firewall. Para administrar máquinas sin IP pública, el salto SSH mediante R-NCC evitó repartir claves privadas a ese router.

Por último, la experiencia dejó registrada una limitación: bloquear un ping no prueba todos los puertos; es necesario validar explícitamente las aplicaciones autorizadas y los protocolos no deseados. Las tareas reorganizadas no cambian las actas ni el historial de la primera parte del Sprint 2.
