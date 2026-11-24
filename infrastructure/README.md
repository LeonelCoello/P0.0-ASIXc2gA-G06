# Procedimientos técnicos


La infraestructura está dividida por funciones. Cada servicio tiene documentación por sprint y un README. Se conservan configuraciones históricas sin presentar las versiones anteriores como definitivas. Para desplegar un entorno nuevo se debe usar la arquitectura vigente y consultar el manual de administración.

## Ampliación del Sprint 2

La segmentación WAN/DMZ/Intranet, el router R-NCC, NAT y la migración de IP privadas están incorporados a [red/sprint-02.md](red/sprint-02.md). La adaptación de BIND9 figura en [dns-dhcp/sprint-02.md](dns-dhcp/sprint-02.md). El detalle de acceso se documenta en [firewall y Security Groups](../security/configuracion-accesos.md) y las verificaciones en [pruebas de segmentación](../tests/pruebas-sprint-02-segmentacion.md). Las configuraciones iniciales permanecen como histórico.
