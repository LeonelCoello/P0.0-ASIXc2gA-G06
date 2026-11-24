# Planificación del proyecto EducaBCN

## Metodología de trabajo

El equipo organiza las actividades mediante sprints y utiliza ProofHub para el backlog y el seguimiento de tareas. GitHub recoge el código, los procedimientos técnicos y la evolución de la infraestructura; Google Docs se utiliza para trabajo colaborativo antes de consolidar las versiones finales.

## Sprint 1: prototipo funcional

Objetivo: una sola instancia EC2 de Ubuntu Server con Apache, PHP, MySQL y el portal EducaBCN. Se completa la importación inicial de los datos de OpenData BCN, se implementa `index.php` y se comprueba la consulta desde el navegador. El material de origen registra el cierre de la primera fase y sus evidencias técnicas.

## Sprint 2: separación de servicios

Objetivo: trasladar la web a W-NCC, dedicar B-NCC a MySQL y disponer de F-NCC para las transferencias. Incorporar BIND9 y DHCP en el entorno de pruebas y documentar la comunicación entre nodos. La separación permite validar conexiones remotas y preparar el diseño de seguridad posterior. La documentación de esta fase recoge las instalaciones y verificaciones realizadas hasta la fecha del informe.

## Reorganización del Sprint 2: segmentación y seguridad

Tras la separación inicial de servicios se acordó incorporar al mismo Sprint 2 las tareas que el borrador identificaba como **S3.1 Router y Redes** y **S3.2 Aislamiento (Firewall)**. Pasan a identificarse en el seguimiento como **S2.6** y **S2.7** respectivamente, sin alterar las tareas originales S2.1–S2.5 ni sus actas. El equipo documentó la creación de R-NCC y las subredes, la migración de máquinas, NAT y los cuatro Security Groups, junto a comprobaciones de conectividad y bloqueo.

Este cambio representa una ampliación del alcance del Sprint 2 y una actualización del backlog, no una repetición de instalaciones. Las capturas y el registro de decisiones permiten reconstruir qué IP y reglas se utilizaron en cada momento.

### Registro histórico de la planificación inicial

Se conserva literalmente la planificación original de esta fase, como registro histórico anterior al cambio de alcance:

> Se prevé evolucionar el entorno hacia zonas DMZ, Intranet y NAT; definir reglas de firewall y acceso entre zonas; habilitar TLS para el portal y transferencias seguras; desplegar monitorización, copias de seguridad y pruebas de contingencia; y completar la batería de pruebas de seguridad, disponibilidad y rendimiento. Estas actividades se describen exclusivamente como objetivos de planificación. No se incluye documentación de ejecución de esta fase.

Esta descripción refleja el **plan inicial**, no el estado vigente: router, subredes y Security Groups se trasladaron al Sprint 2, mientras las restantes mejoras no se presentan como implantadas.

## Sprint 3: planificación de efectos WOW

El tercer sprint se reserva para mejoras avanzadas de la experiencia de EducaBCN, como rediseñar el portal, incorporar búsquedas, filtros por los campos disponibles, fichas de centros, paginación y, previa obtención y validación de coordenadas, un mapa interactivo. Podrán valorarse otras mejoras de observabilidad o automatización si el equipo las prioriza. **Son propuestas; este repositorio no las presenta como ejecutadas.**

No se crea una carpeta de ejecución de Sprint 3 ni archivos técnicos vacíos para funcionalidades futuras.

## Organización y control

Para cada sprint se documentan el objetivo, el backlog, las reuniones, las tareas realizadas y su revisión. Los procedimientos reproducibles se publican por componente en `infrastructure/`, mientras que los acuerdos y el seguimiento se mantienen en `sprints/`. Las capturas se presentan intercaladas en las explicaciones técnicas correspondientes.

## Recursos y limitaciones

El presupuesto de AWS utilizado en el diseño es de 50 USD de crédito; la planificación del equipo prevé apagar instancias cuando no son necesarias y controlar el consumo. Este importe corresponde al presupuesto de referencia del documento, no a una confirmación del gasto efectivo.
