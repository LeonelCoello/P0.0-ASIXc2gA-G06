# Sprint 2: planificación


## Objetivo
Separar W-NCC, B-NCC y F-NCC; introducir DNS/DHCP y verificar conectividad.

## Periodo y reuniones
28/10, 02/11 y 10/11/2026 (actas disponibles).

## Entregables esperados
- Conservar snapshot del MVP.
- Preparar W-NCC y B-NCC.
- Instalar y configurar F-NCC.
- Resolver nombres internos BIND9.
- Verificar DHCP con cliente real.
- Limitar MySQL a W-NCC.
- Normalizar datos y validar web remota.

## Criterio de cierre
Funcionalidad ejecutada, pruebas registradas, documentación actualizada y tareas cerradas con enlaces al repositorio/ProofHub.

## Ampliación del alcance del Sprint 2

Durante el desarrollo, el equipo decidió incorporar al Sprint 2 dos tareas antes etiquetadas S3.1 y S3.2. El orden original de la separación de servicios y las fechas de las reuniones se mantiene íntegro; el cambio se incorpora como una decisión posterior del backlog.

| Identificador en la planificación revisada | Tarea incorporada | Alcance |
|---|---|---|
| S2.6 | Router y Redes | WAN/DMZ/Intranet, R-NCC, interfaces, tablas de rutas, IP Forwarding, NAT y migración de IP |
| S2.7 | Aislamiento (Firewall) | Security Groups por servicio, protección SSH, pruebas de acceso permitido y bloqueado |

La planificación del tercer sprint pasa a centrarse en efectos WOW de la aplicación. Las funciones futuras no se presentan como tareas ejecutadas.

## Criterios específicos de aceptación incorporados

- Mostrar la evolución de IP original → IP segmentada, sin borrar las anteriores.
- Guardar capturas de las interfaces de R-NCC, rutas y comprobación de tráfico.
- Verificar MySQL, FTP, DNS y accesos SSH que continúan funcionando.
- Documentar un ejemplo de tráfico permitido y otro denegado.
- Explicar límites reales: `FORWARD ACCEPT`, dirección de F-NCC en la Intranet y pruebas que no constan.
