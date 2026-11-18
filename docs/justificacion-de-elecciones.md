# Justificación de las decisiones técnicas

## Índice

- [Criterios de elección](#criterios-de-eleccion)
- [AWS EC2 y Ubuntu Server](#aws-ec2-y-ubuntu-server)
- [Apache + PHP + PDO](#apache-php-pdo)
- [MySQL en B-NCC](#mysql-en-b-ncc)
- [BIND9, ISC DHCP y vsftpd](#bind9-isc-dhcp-y-vsftpd)
- [Herramientas de organización y control de versiones](#herramientas-de-organizacion-y-control-de-versiones)
- [Decisiones que cambiaron entre sprints](#decisiones-que-cambiaron-entre-sprints)
- [Referencias técnicas](#referencias-tecnicas)


## Criterios de elección

La selección de componentes se realizó teniendo en cuenta **los requisitos docentes**, compatibilidad entre servicios, presupuesto disponible, conocimientos del equipo, posibilidad de revisar el entorno por SSH y facilidad para documentar las evidencias. No se utilizó una clasificación de rendimiento basada en benchmarks ni una comparación económica exhaustiva de proveedores.

El [estudio comparativo de tecnologías](estudio-de-tecnologias.md) presenta alternativas; aquí se explica la elección concreta aplicada a EducaBCN.

## AWS EC2 y Ubuntu Server

AWS EC2 permite lanzar servidores Ubuntu accesibles por SSH, asignarles direcciones privadas en una VPC y configurar reglas de acceso por Security Groups. También facilita separar W-NCC, B-NCC y F-NCC sin mantener varios ordenadores físicos. En el primer sprint se utilizó una instancia; en el segundo se diferenció el papel de cada nodo. La elección implica controlar el gasto, las direcciones, la seguridad de acceso y el estado de las instancias.

Ubuntu Server 24.04 LTS ofrece una distribución con soporte prolongado y paquetes apropiados para Apache, PHP, MySQL, BIND9 y vsftpd. Se escogió por familiaridad y documentación. **No** significa que la infraestructura esté automáticamente disponible ante un fallo de EC2 o que exista alta disponibilidad real: no hay balanceador ni redundancia acreditados.

## Apache + PHP + PDO

El requisito de la práctica consiste en una pequeña aplicación que muestre registros. Apache y PHP permiten desplegar `index.php` con pocas dependencias. PDO realiza la conexión a MySQL y recupera los registros. La consulta demostrada es una selección fija limitada a 50 filas: no introduce datos del usuario en la SQL y no es una demostración de consultas preparadas ni de una mitigación completa de inyección SQL.

## MySQL en B-NCC

MySQL permite importar datos CSV y consultarlos con SQL. En el Sprint 1 estaba en la misma máquina que PHP; en el Sprint 2 pasó a ser el servicio principal de B-NCC, con conexión desde W-NCC mediante la cuenta `webapp` de lectura. Este diseño reduce el acoplamiento entre funciones, pero requiere limitar el acceso a TCP/3306 y administrar credenciales fuera del código.

No se afirma que la normalización a distritos, barrios y centros se haya ejecutado. Está propuesta en el backlog, mientras que la evidencia examinada muestra la tabla de centros utilizada en el prototipo.

## BIND9, ISC DHCP y vsftpd

- **BIND9:** elegido para practicar la creación de una zona local `educabcn.local`, registros DNS y consultas entre servidores. La resolución para el futuro router `R-NCC` y `R` sigue sujeta al requisito del enunciado y a la topología final.
- **ISC DHCP:** permite preparar la asignación de direcciones en un segmento de laboratorio; instalar el servicio en una instancia EC2 no equivale a demostrar que reemplaza el DHCP gestionado por AWS. Esa prueba exige una red y clientes compatibles.
- **vsftpd:** servicio clásico para practicar cuentas, permisos, directorios y transferencia FTP. Restringir un usuario con `chroot` **no cifra** el tráfico; FTPS/TLS debe validarse por separado.

## Herramientas de organización y control de versiones

**ProofHub** se utiliza porque el enunciado solicita backlog y tres sprints quincenales. El tablero ayuda a distinguir pendientes, asignadas, en curso, bloqueadas y finalizadas, pero no sustituye las pruebas técnicas de un entregable. **Git y GitHub** reúnen el código y la documentación Markdown, permiten comparar commits y conservar historial. **Google Docs** se ha utilizado en las notas iniciales; el repositorio GitHub debe constituir la entrega navegable.

## Decisiones que cambiaron entre sprints

| Decisión | Sprint 1 | Sprint 2 | Motivo |
|---|---|---|---|
| Ubicación de aplicación | Una instancia con MySQL | W-NCC separado de B-NCC | Separar responsabilidades |
| Conexión PHP | `localhost`, cuenta MySQL `bchecker` | B-NCC, usuario MySQL `webapp` | Evitar usar una cuenta general de comprobación desde la web |
| FTP/DNS/DHCP | No completan el MVP de este sprint | Servicios instalados en F-NCC | Cumplir los roles de servidor de servicios |
| Distribución de datos | Consulta local | Consulta remota por VPC | Comprobar conectividad y privilegios |
| Redes DMZ/intranet | No desplegadas | No desplegadas como segmentos reales | Propuesta para la etapa final, no atribuirla a estos sprints |

## Referencias técnicas

- [AWS: Security Groups para EC2](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ec2-security-groups.html)
- [Ubuntu 24.04 LTS: notas de publicación](https://documentation.ubuntu.com/release-notes/24.04/)
- [AWS: conjuntos de opciones de DHCP para VPC](https://docs.aws.amazon.com/vpc/latest/userguide/DHCPOptionSet.html)
- [ProofHub: tablero Kanban](https://help.proofhub.com/plus/tasks/kanban-view/)
