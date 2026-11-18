# Sprint 2: revisión y cierre

## Índice

- [Resultado técnico](#resultado-tecnico)
- [Validación](#validacion)
- [Qué queda fuera de la validación documentada](#que-queda-fuera-de-la-validacion-documentada)


El equipo comunicó el cierre del segundo sprint después de verificar el despliegue de la web desde W-NCC. La versión actualizada del PDF incorpora capturas del comando `scp`, de los archivos alojados en Apache y de la tabla de centros educativos vista desde el navegador.

## Resultado técnico

- W-NCC ejecuta la aplicación web separada de la base de datos.
- B-NCC conserva MySQL y acepta consultas remotas desde el servidor web según las pruebas registradas.
- F-NCC contiene vsftpd y los servicios BIND9 e ISC DHCP instalados.
- Las pruebas de DNS muestran resolución de nombres de la zona interna en varios servidores.

## Validación

La [matriz de pruebas](../../tests/pruebas-sprint-02.md) enlaza los procedimientos y capturas correspondientes. Los resultados deben leerse con su alcance concreto: por ejemplo, no se confunde tener ISC DHCP activo con haber demostrado una concesión de IP a un cliente de prueba.

**Resultado:** el portal continuó mostrando datos después de separar los servidores, que era el hito principal de la migración.


## Qué queda fuera de la validación documentada

El cierre del MVP distribuido se apoya en las capturas de las instancias y en el resultado de la aplicación. El tablero muestra asignaciones, no certifica el cierre individual de las tarjetas. La normalización a varias tablas, la concesión DHCP a los dos clientes, las pruebas cuantitativas de rendimiento y el despliegue del portal mediante Git requieren verificaciones adicionales antes de presentarse como completados.

[Tablero real de tareas asignadas](planning.md#evidencia-de-tareas-asignadas-en-proofhub) · [Pruebas del sprint](../../tests/pruebas-sprint-02.md).
