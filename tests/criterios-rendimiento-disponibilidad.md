# Criterios de rendimiento, disponibilidad y seguridad

## Índice

- [Distinción entre objetivo y resultado](#distincion-entre-objetivo-y-resultado)
- [Criterios propuestos](#criterios-propuestos)
- [Procedimiento de rendimiento web (por ejecutar)](#procedimiento-de-rendimiento-web-por-ejecutar)
- [Disponibilidad, contingencia y seguridad (por verificar)](#disponibilidad-contingencia-y-seguridad-por-verificar)
- [Evidencias disponibles](#evidencias-disponibles)


## Distinción entre objetivo y resultado

Este documento establece un **plan de aceptación** para que futuras comprobaciones sean repetibles. Las capturas del Sprint 1 y Sprint 2 permiten validar funciones concretas, pero **no documentan una serie de mediciones de latencia, concurrencia, disponibilidad histórica o pruebas de recuperación**. Por eso no se declara ningún porcentaje de disponibilidad conseguido ni un tiempo de respuesta real.

## Criterios propuestos

| Aspecto | Criterio de aceptación propuesto | Cómo comprobarlo | Resultado actual |
|---|---|---|---|
| HTTP | Respuesta 200 al solicitar la web | `curl -I` y navegador | Visualización funcional acreditada, no serie estadística |
| MySQL | Consulta desde W-NCC con cuenta de lectura | Cliente `mysql` y `SELECT COUNT(*)` | Conexión y consulta documentadas |
| Datos | Cantidad de registros coherente con importación | `SELECT COUNT(*)` y comprobación CSV | Dataset importado; reconstruir número exacto desde consulta actual |
| DNS | Resolver nombres configurados de `educabcn.local` | `dig` o `nslookup` desde nodos | Pruebas DNS documentadas |
| DHCP | Cliente obtiene concesión del servidor previsto | `dhclient -v`, servidor y registro lease | No demostrado en un cliente AWS o externo |
| FTP | Inicio de sesión y transferencia de prueba | Cliente FTP, listado, carga, lectura | Instalación y pruebas recogidas |
| Seguridad | MySQL no expuesto globalmente y cuenta web sin escritura | Reglas EC2, permisos SQL | Cuenta `webapp` de lectura documentada; revisar SG final |
| Disponibilidad | Uptime y recuperación medidos durante un período | Monitorización y registro de incidencias | No se dispone de registros longitudinales |

## Procedimiento de rendimiento web (por ejecutar)

1. Elegir una dirección de ensayo y un momento de uso sin afectar a terceros.
2. Registrar tipo de EC2, CPU, memoria y hora del ensayo.
3. Medir varias peticiones con `curl` y calcular media, máximo y percentil 95; no basta con una sola medición.
4. Documentar el número de peticiones, condiciones de red y errores HTTP.
5. Repetir después de cambios significativos y comparar resultados en una tabla con fechas.

Ejemplo de **comando de diagnóstico propuesto**, no ejecutado al preparar estos documentos:

```bash
curl -sS -o /dev/null -w 'HTTP %{http_code}; total %{time_total}s\n' http://127.0.0.1/index.php
```

`-sS` reduce mensajes pero conserva errores, `-o /dev/null` descarta el cuerpo, y `-w` imprime código HTTP y tiempo total. El diagnóstico se ejecutaría en W-NCC; medir localmente no sustituye medir desde un cliente real.

## Disponibilidad, contingencia y seguridad (por verificar)

- **Disponibilidad:** registrar fecha, duración y causa de cada interrupción. No prometer «99,9 %» sin período y datos.
- **Restauración:** ejecutar una restauración controlada de copia de prueba y registrar tiempos. Los objetivos RTO/RPO del plan son metas, no resultados.
- **Accesos:** verificar Security Groups, autenticación SSH y acceso docente mediante `bchecker` sin publicar credenciales.
- **DNS:** comprobar los nombres del router `R-NCC` y `R` cuando la topología esté desplegada.
- **DHCP:** distinguir el daemon ISC-DHCP en F-NCC del DHCP que administra AWS en la VPC.
- **FTP:** cuando se configure FTPS, comprobar explícitamente la negociación TLS; `chroot` no es cifrado.

## Evidencias disponibles

[Pruebas del Sprint 1](pruebas-sprint-01.md) · [Pruebas del Sprint 2](pruebas-sprint-02.md) · [Contingencia](../docs/contingencia.md).
