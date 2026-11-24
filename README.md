# EducaBCN

EducaBCN es un proyecto de infraestructura y aplicación web para consultar información pública sobre centros educativos de Barcelona procedente de OpenData BCN. Se desarrolla con AWS EC2, Ubuntu Server, Apache, PHP y MySQL; la segunda fase separa los servicios y añade una máquina FTP y servicios internos DNS/DHCP.

## Estado y evolución del proyecto

- **Sprint 1:** prototipo funcional en una sola instancia: servidor web, PHP, base de datos y portal.
- **Sprint 2:** separación de responsabilidades entre W-NCC, B-NCC y F-NCC; trabajo técnico documentado en los procedimientos correspondientes.

La continuación prevista del proyecto está descrita únicamente en el [plan de trabajo](docs/planificacion.md).

## Estructura del repositorio

| Carpeta | Contenido |
|---|---|
| `architecture/` | Diagrama de diseño y descripción de evolución |
| `docs/` | Objetivos, análisis, recursos, contingencia, riesgos y manuales |
| `infrastructure/` | Procedimientos técnicos por servicio y fase, con capturas en cada paso |
| `media/` | Archivos de las capturas utilizadas dentro de los procedimientos |
| `security/` | Consideraciones y configuraciones de acceso documentadas |
| `tests/` | Pruebas técnicas y criterios de comprobación registrados |
| `sprints/` | Planificación, tareas, reuniones y revisión de cada fase realizada |

## Empezar a leer

1. [Objetivos y alcance](docs/objetivos-y-alcance.md)
2. [Planificación del trabajo](docs/planificacion.md)
3. [Infraestructura inicial](infrastructure/red/sprint-01.md)
4. [Infraestructura distribuida](infrastructure/red/sprint-02.md)
5. [Manual de administración](docs/manual-administrador.md)
6. [Manual de usuario](docs/manual-cliente.md)

## Tratamiento de credenciales

Los procedimientos han sido redactados sin publicar contraseñas ni claves privadas. Las capturas incluidas proceden de la documentación original del equipo; es necesario revisarlas antes de hacer público el repositorio, especialmente cuando se incorporen imágenes nuevas.

## Actualización del alcance del Sprint 2

El Sprint 2 incorporó, después de la separación inicial de servidores, una **segunda etapa de segmentación y protección de la infraestructura**: despliegue de R-NCC, creación de WAN/DMZ/Intranet, migración de direcciones privadas, enrutamiento y NAT, grupos de seguridad individuales y verificaciones de conectividad y bloqueo. Se conserva la documentación de las IP y reglas iniciales para mostrar la evolución real, sin reinterpretarlas como configuración vigente.

- [Evolución de red, router y NAT](infrastructure/red/sprint-02.md)
- [Reglas de acceso por servidor y firewall](security/configuracion-accesos.md)
- [Pruebas y alcance demostrado](tests/pruebas-sprint-02-segmentacion.md)
- [Cambio de registros DNS tras la migración](infrastructure/dns-dhcp/sprint-02.md)

El Sprint 3 queda reservado a la **planificación de mejoras de la aplicación y efectos WOW**; no se documenta como ejecutado ni se crea una carpeta técnica específica.
