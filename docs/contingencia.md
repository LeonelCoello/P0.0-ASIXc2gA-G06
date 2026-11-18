# Plan de continuidad y recuperación

## Índice

- [Objetivo y alcance](#objetivo-y-alcance)
- [Riesgos principales](#riesgos-principales)
- [Comprobaciones iniciales](#comprobaciones-iniciales)
- [Recuperación controlada](#recuperacion-controlada)
- [Propuesta de copias de seguridad](#propuesta-de-copias-de-seguridad)
- [Objetivos de recuperación](#objetivos-de-recuperacion)
- [Seguridad durante un incidente](#seguridad-durante-un-incidente)
- [Metas cuantificadas del documento de diseño](#metas-cuantificadas-del-documento-de-diseno)
- [Ensayo de restauración seguro (pendiente)](#ensayo-de-restauracion-seguro-pendiente)
- [Registro propuesto de incidentes](#registro-propuesto-de-incidentes)


## Objetivo y alcance

El objetivo es minimizar la interrupción del portal EducaBCN y proteger la integridad de los datos de los centros. En el estado documentado, la solución utiliza W-NCC para Apache/PHP, B-NCC para MySQL y F-NCC para los servicios auxiliares. Los procedimientos siguientes son un **plan de actuación**, no una prueba de recuperación ejecutada.

## Riesgos principales

| Incidencia | Efecto esperado | Primera respuesta |
|---|---|---|
| Apache detenido en W-NCC | La web no responde | Consultar `systemctl status apache2` y los logs del servicio |
| MySQL detenido en B-NCC | Errores PDO / datos no disponibles | Revisar `systemctl status mysql`, discos y logs |
| Corte entre W-NCC y B-NCC | La web no puede consultar los centros | Verificar resolución/ruta, Security Groups y TCP/3306 |
| Error en DNS interno | Fallo de nombres `educabcn.local` | Revisar BIND9, zona y `dig` |
| Problema en FTP | Fallos de transferencia | Revisar vsftpd, usuario, chroot y puertos pasivos |
| Error de importación de CSV | Datos alterados o incompletos | Validar una copia, comparar recuentos y restaurar información íntegra |

## Comprobaciones iniciales

En W-NCC:

```bash
sudo systemctl status apache2
sudo journalctl -u apache2 -n 50 --no-pager
curl -I http://127.0.0.1/
```

En B-NCC:

```bash
sudo systemctl status mysql
sudo journalctl -u mysql -n 50 --no-pager
sudo mysql -e 'SELECT COUNT(*) FROM EducaBCN.centros_educativos;'
```

En F-NCC:

```bash
sudo systemctl status vsftpd bind9 isc-dhcp-server
sudo journalctl -u bind9 -n 50 --no-pager
```

`sudo mysql` presupone acceso administrativo local por socket; si la instalación utiliza otro método hay que emplear las credenciales correspondientes sin incrustarlas en comandos ni capturas públicas.

## Recuperación controlada

1. Identificar el servicio afectado y guardar los mensajes relevantes de error.
2. Comprobar recursos del sistema (`df -h`, `free -h`, `uptime`) y conectividad de red.
3. Corregir la causa antes de reiniciar: permisos, configuración, disco lleno, reglas o credenciales.
4. Reiniciar únicamente el servicio afectado, por ejemplo `sudo systemctl restart apache2`.
5. Comprobar el resultado desde el servidor y desde un cliente externo.
6. Registrar fecha, incidencia, causa, actuación y validación posterior.

## Propuesta de copias de seguridad

La documentación de diseño contempla volcados comprimidos de MySQL y copias de volumen de AWS. Antes de operar con producción, definir un almacenamiento separado del servidor origen y probar restauraciones periódicas. Como ejemplo de un volcado manual sin contraseña en la línea de comandos:

```bash
mysqldump --single-transaction --quick -u usuario_autorizado -p EducaBCN | gzip > educabcn-$(date +%F).sql.gz
```

El comando pregunta la contraseña; debe ejecutarse en un entorno adecuado, guardar el fichero con permisos restringidos y verificarse el resultado. No se publica como un backup automatizado ya probado.

## Objetivos de recuperación

El PDF de trabajo propone valores de RTO y RPO, pero no contiene una medición que permita garantizarlos. Los objetivos se deben contrastar con una prueba restaurando una copia y midiendo la duración; hasta entonces se consideran metas de diseño.

## Seguridad durante un incidente

Ante un acceso no autorizado, restringir temporalmente el tráfico con Security Groups, preservar registros y cambiar las credenciales afectadas. No exponer contraseñas ni claves privadas en GitHub. Tras la revisión, restaurar solo los accesos imprescindibles y comprobar el portal.

## Metas cuantificadas del documento de diseño

En la memoria original se proponen como **metas** un RTO inferior a 5 minutos ante fallo de servicio, inferior a 15 minutos para restauración de la base de datos y un máximo de 24 horas de pérdida de datos para copias diarias. También se menciona recuperación de instancia desde imagen en menos de 20 minutos. **Ninguna de estas metas tiene una prueba cronometrada registrada**, por lo que no deben presentarse como tiempos garantizados.

## Ensayo de restauración seguro (pendiente)

1. Crear una base de datos aislada de pruebas; nunca ensayar un borrado destructivo sobre `EducaBCN` en uso.
2. Comprobar que existe una copia legible y registrar la hora de inicio.
3. Restaurar el archivo en el entorno aislado y comparar número de tablas y filas.
4. Consultar varias filas para verificar legibilidad y codificación.
5. Registrar duración, incidencias y si cumple el objetivo previsto.
6. Conservar el reporte y una captura que no muestre contraseñas.

**Estado:** procedimiento recomendado, no ejecutado según las evidencias de Sprints 1 y 2.

## Registro propuesto de incidentes

| Campo | Valor a registrar |
|---|---|
| Fecha e inicio | Momento observado del problema |
| Servicio afectado | Apache, PHP, MySQL, FTP, DNS, DHCP, red o acceso |
| Síntomas | HTTP, código de error, mensaje y alcance |
| Diagnóstico | Comandos revisados y resultado sin secretos |
| Acción | Cambio aplicado y persona responsable |
| Recuperación | Hora de restablecimiento y prueba posterior |
| Prevención | Cambio de procedimiento o regla documentado |
