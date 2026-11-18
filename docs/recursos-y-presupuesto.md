# Recursos, calendario y presupuesto

## Índice

- [Recursos humanos y metodología](#recursos-humanos-y-metodologia)
- [Cronología basada en las reuniones](#cronologia-basada-en-las-reuniones)
- [Inventario técnico](#inventario-tecnico)
- [Presupuesto de AWS](#presupuesto-de-aws)
- [Estimación de dimensionamiento: hipótesis, no mediciones](#estimacion-de-dimensionamiento-hipotesis-no-mediciones)
- [Dependencias, riesgos y reservas](#dependencias-riesgos-y-reservas)
- [Evidencia relacionada](#evidencia-relacionada)


## Recursos humanos y metodología

La documentación de reuniones registra a **Leonel Coello y Oussama Boukhali** como asistentes. Las responsabilidades de tareas concretas deben mantenerse tal como aparezcan en ProofHub; no atribuimos a cada integrante actividades que las capturas no permitan verificar. El grupo trabaja con backlog, planificación por sprint, ejecución y revisión.

El enunciado fija **seis semanas**, finalización prevista el **18 de noviembre**, y **tres sprints quincenales** de unas **10 horas de trabajo cada uno** (cinco horas semanales). Este documento registra los dos primeros; el tercero se trata solo como planificación.

## Cronología basada en las reuniones

| Fecha | Hito anotado | Sprint |
|---|---|---|
| 07/10/2026 | Inicio y reparto inicial; alta del backlog | 1 |
| 13/10/2026 | Seguimiento de infraestructura, Git y MySQL | 1 |
| 20/10/2026 | Previsión de Apache/PHP, CSV e interfaz | 1 |
| 21/10/2026 | Se registra el portal mostrando los datos | 1 |
| 27/10/2026 | Cierre y revisión de la documentación del primer sprint | 1 |
| 28/10/2026 | Arranque y planificación del segundo sprint | 2 |
| 02/11/2026 | Preparación de B-NCC, FTP, DNS y DHCP | 2 |
| 10/11/2026 | B-NCC actualizado; W-NCC y F-NCC en curso | 2 |

Son fechas de **actas y registros**, no una reconstrucción de horas exactas de cada tarea. Si ProofHub aporta fechas y duraciones precisas, podrán enlazarse a las fichas originales.

## Inventario técnico

| Recurso | Uso | Situación documentada |
|---|---|---|
| AWS EC2 / VPC | Instancias y comunicación privada | Utilizado en ambos sprints |
| Ubuntu Server 24.04 LTS | Sistema operativo de los servidores | Utilizado |
| W-NCC | Apache + PHP + cliente MySQL | Sprint 2 |
| B-NCC | MySQL y datos importados | Máquina reutilizada del Sprint 1 |
| F-NCC | vsftpd, BIND9, ISC DHCP | Sprint 2 |
| GitHub y Git | Repositorio y control de cambios | Utilizado; algunas operaciones requieren evidencia adicional |
| ProofHub | Backlog, asignación y seguimiento | Utilizado; hay capturas originales de los dos sprints |
| Router y PCs de prueba | Requisitos de la arquitectura final | No se documentan como completados en Sprints 1 y 2 |

## Presupuesto de AWS

La planificación aportada por el grupo establece un **límite educativo de 50 USD** y la práctica de detener instancias al finalizar la sesión. **No hay una factura o captura del consumo real** en las evidencias revisadas; por tanto, no se presenta un gasto efectivo calculado.

Para controlar el límite, el equipo debe revisar periódicamente: horas de EC2, almacenamiento EBS aprovisionado, snapshots conservados, transferencia de salida y direcciones IPv4 públicas cuando sean facturables. Parar EC2 evita el coste de cómputo mientras está detenida, pero no necesariamente todos los cargos de discos o direcciones.

## Estimación de dimensionamiento: hipótesis, no mediciones

| Rol | CPU/RAM orientativa | Disco inicial orientativo | Observación |
|---|---|---|---|
| Prototipo todo en uno | 2 vCPU, 2–4 GiB | 20 GiB | Diseño ilustrativo incluido en la memoria |
| W-NCC | 2 vCPU, 2 GiB | 15 GiB | Depende de tráfico real y tamaño de Apache |
| B-NCC | 2 vCPU, 4 GiB | 30 GiB | Depende de índices, CSV, logs y copias |
| F-NCC | 1 vCPU, 1–2 GiB | 50 GiB | Capacidad condicionada a ficheros FTP |

Estas cifras son **hipótesis del plan**, no inventario contrastado con la consola de AWS. La selección real de tipo de instancia, discos y volumen de transferencia debe verificarse para calcular un coste exacto.

## Dependencias, riesgos y reservas

| Dependencia | Consecuencia de fallo | Medida de control |
|---|---|---|
| W-NCC → B-NCC por TCP 3306 | Portal sin información | Probar conectividad, usuario y consulta antes de migrar |
| Web → datos del CSV | Información vacía o incorrecta | Contar y comparar registros importados |
| DNS de F-NCC | Nombres locales sin resolver | Consultas directas a zona y IP |
| Proveedor de AWS | Coste o parada involuntaria | Seguimiento de consumo y documentación de arranque/parada |
| Documentación y credenciales | Fugas de secretos | No subir contraseñas y revisar capturas antes de commit |
| Equipo de trabajo | Tareas sin asignar ni cerrar | Revisar tablero de ProofHub y registrar incidencias |

## Evidencia relacionada

- [Planificación del Sprint 1](../sprints/sprint-01/planning.md)
- [Planificación del Sprint 2](../sprints/sprint-02/planning.md)
- [Criterios de rendimiento y disponibilidad](../tests/criterios-rendimiento-disponibilidad.md)
- [Plan de contingencia](contingencia.md)
