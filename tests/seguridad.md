# Comprobaciones de seguridad registradas

La documentación registra grupos de seguridad de AWS, acceso mediante SSH, permisos de un archivo externo de configuración de la aplicación y cuentas SQL para consultas remotas. Son medidas de configuración y verificaciones puntuales; no constituyen una auditoría de penetración.

## Controles observables

- Revisión de los Security Groups de las máquinas EC2.
- Separación de la instancia SQL de la instancia web.
- Archivo de configuración de la aplicación bajo `/etc/` con permisos restringidos.
- Usuario de base de datos limitado a las funciones de lectura del catálogo.
- Directorios restringidos para los usuarios de FTP.

## Riesgos que se identificaron durante el laboratorio

En el material aparecen reglas temporales amplias y configuraciones de MySQL con alcance excesivo. Es necesario restringir los orígenes permitidos y evitar FTP sin cifrar antes de emplear datos sensibles. Los detalles de cada componente figuran en `infrastructure/`.

## Aislamiento observado tras la replanificación del Sprint 2

Los grupos compartidos de la primera etapa se sustituyeron por Security Groups específicos para router, web, base de datos y FTP/DNS. Se comprobaron MySQL y FTP accesibles desde W-NCC, resolución DNS correcta, y ausencia de respuesta a ICMP y SSH directo hacia B-NCC. R-NCC también fue reforzado con autenticación mediante clave y acceso directo de root deshabilitado.

La descripción completa de reglas y sus capturas originales está en [configuración de acceso](../security/configuracion-accesos.md); el resultado de los comandos figura en [pruebas de segmentación](pruebas-sprint-02-segmentacion.md). En el router se observó una política `FORWARD ACCEPT`, por lo que este registro no afirma filtrado interzona exhaustivo con `iptables`.
