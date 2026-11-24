# Estudio previo y alternativas


## Necesidad y alternativas
- Portal de datos abiertos original: permite obtener datos, pero exige manejar y filtrar datasets.
- Portal de consulta especializado: simplifica búsquedas y presentación; requiere mantenimiento y actualización.
- Servicios gestionados de nube: reducen tareas de operación, pero pueden aumentar coste y dependencia.

## Comparativa técnica preliminar
| Componente | Solución del proyecto | Alternativas a comparar | Motivo inicial |
|---|---|---|---|
| Alojamiento | AWS EC2 | máquina local, otro proveedor cloud | acceso remoto y control de instancias |
| Web | Apache + PHP | Nginx + PHP-FPM | compatibilidad con la primera versión |
| Base de datos | MySQL | MariaDB, PostgreSQL | modelo relacional e integración con PHP |
| DNS | BIND9 | DNS administrado | control de nombres internos |
| Transferencia | vsftpd | SFTP sobre SSH | incluido en planificación; revisar cifrado |
| Seguimiento | ProofHub + GitHub | GitHub Projects | trazabilidad de tareas y versiones |

## Investigación que falta
Citar fecha y enlace oficial de cada producto, licencias, costes reales, limitaciones de AWS para DHCP en VPC, comparación objetiva de seguridad, alternativas existentes de consulta de equipamientos educativos y motivos de elección basados en requisitos medibles. No se han inventado competidores ni precios.
