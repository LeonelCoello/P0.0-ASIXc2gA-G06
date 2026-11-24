# Plan de contingencia y recuperación ante incidentes

## 1. Objetivo

Definir una respuesta organizada ante fallos que afecten al portal EducaBCN, a su base de datos y a la infraestructura de AWS. El plan se basa en el documento original de contingencia del equipo y establece medidas de protección, diagnóstico, recuperación y registro. Los tiempos de recuperación son objetivos definidos en el plan, no resultados medidos.

## 2. Servicios y dependencias

| Servicio | Consecuencia de una caída | Componente relacionado |
|---|---|---|
| Apache/PHP | Portal inaccesible | W-NCC |
| MySQL | No se pueden consultar los datos | B-NCC |
| vsftpd | Transferencias no disponibles | F-NCC |
| BIND9 | Fallan nombres internos | Resolver de la infraestructura |
| AWS EC2 | Pérdida temporal del nodo | Plataforma cloud |

## 3. Principales escenarios de riesgo

- Fallo o bloqueo del proceso Apache.
- Caída o corrupción de la base de datos MySQL.
- Pérdida de conectividad o modificación incorrecta de reglas de seguridad.
- Error de importación o actualización del catálogo CSV.
- Pérdida de una instancia EC2 o de su volumen.
- Exposición no autorizada de credenciales y archivos.

## 4. Objetivos definidos en la memoria

El documento original plantea recuperaciones de menos de cinco minutos para fallos de software, menos de quince minutos para corrupción de datos y menos de veinte minutos para caída total de una instancia. La pérdida máxima de información se planifica con copias regulares y conservación del código versionado. Son valores de diseño y deben tratarse como tales, no como garantías operativas.

## 5. Diagnóstico inicial

Ante cualquier interrupción se identifica el servicio afectado y se evita modificar varios componentes simultáneamente. Se registra la hora, síntomas, usuario que informa y acciones realizadas.

```bash
sudo systemctl status apache2
sudo systemctl status mysql
sudo journalctl -u apache2 -n 50 --no-pager
sudo journalctl -u mysql -n 50 --no-pager
df -h
```

Los comandos de Apache y MySQL se ejecutan en su respectivo nodo.

## 6. Recuperación de un servicio

Si el problema se localiza en un servicio detenido se revisan logs y se aplica un reinicio controlado. Después se comprueba el proceso y el acceso funcional:

```bash
sudo systemctl restart apache2
sudo systemctl status apache2
curl -I http://127.0.0.1/
```

Para MySQL, comprobar `systemctl`, integridad de las tablas y la consulta del catálogo desde W-NCC. No reiniciar indiscriminadamente componentes si el fallo proviene de la red o de credenciales.

## 7. Recuperación de datos

El documento original propone guardar volcados SQL comprimidos y copias fuera de la instancia. Un respaldo de base de datos debe crearse con una cuenta autorizada, sin publicar contraseñas en scripts o argumentos. La restauración de un volcado debe probarse primero en un entorno aislado y con autorización previa; la operación puede sobrescribir información.

Flujo recomendado: conservar CSV de origen, validar último volcado, verificar contenido, restaurar en una base de pruebas y comparar recuentos y consultas representativas antes de sustituir datos del servicio activo.

## 8. Recuperación de instancia AWS

El plan contempla usar una AMI de respaldo o crear una nueva instancia Ubuntu Server, restaurar servicios y datos, reconfigurar Security Groups y validar las conexiones entre nodos. Los nombres de host y direcciones privadas deben comprobarse de nuevo, ya que pueden cambiar durante la recuperación.

## 9. Incidentes de seguridad

Aislar accesos no autorizados, preservar logs, revisar las cuentas comprometidas, rotar secretos y restaurar desde una versión confiable si fuera necesario. No publicar en incidencias capturas con contraseñas ni claves privadas.

## 10. Registro posterior

Registrar causa raíz, servicio afectado, hora de inicio y recuperación, pérdida de datos, acciones realizadas y medidas de prevención. El plan se considera un documento de preparación; su eficacia real solo puede evaluarse mediante ensayos registrados.
