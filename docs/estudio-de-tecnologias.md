# Estudio de soluciones y tecnologías

## Índice

- [Enfoque](#enfoque)
- [Alojamiento y virtualización](#alojamiento-y-virtualizacion)
- [Servidor web y aplicación](#servidor-web-y-aplicacion)
- [Persistencia de datos](#persistencia-de-datos)
- [Servicios auxiliares](#servicios-auxiliares)
- [Criterios empleados](#criterios-empleados)
- [Comparación de criterios y conclusiones](#comparacion-de-criterios-y-conclusiones)


## Enfoque

El proyecto utiliza servicios conocidos del entorno de sistemas: infraestructura Linux sobre máquinas virtuales, servidor HTTP, lenguaje de servidor, base de datos relacional y herramientas de administración de red. Las decisiones se justifican por la disponibilidad de herramientas, su documentación y la facilidad de integración con el objetivo del prototipo.

## Alojamiento y virtualización

| Alternativa | Ventajas | Inconvenientes para EducaBCN |
|---|---|---|
| AWS EC2 | Acceso remoto, instancias independientes, Security Groups, integración con VPC | Coste variable, necesidad de gestionar exposición pública y rutas |
| VirtualBox local | Control completo de topologías y DHCP en redes de laboratorio, costes locales previsibles | Accesibilidad desde Internet más compleja, dependencia del equipo anfitrión |
| Servidor físico | Control directo de hardware y redes | Mayor inversión y dependencia de espacio y mantenimiento físico |

**Elección:** AWS EC2 con Ubuntu Server 24.04 LTS. Las capturas del proyecto muestran el uso real de instancias EC2 y sus reglas de seguridad. AWS facilita la separación de máquinas, aunque algunas pruebas de DHCP o de enrutamiento requieren analizar las limitaciones del entorno VPC.

## Servidor web y aplicación

| Alternativa | Observaciones |
|---|---|
| Apache + PHP | Solución utilizada; sencilla para ejecutar `index.php`, administrar servicios por systemd y conectarse a MySQL con PDO |
| Nginx + PHP-FPM | Puede ser eficiente, pero introduce una configuración adicional para el procesado PHP |
| Aplicación con un framework | Útil en portales complejos, pero supone mayor trabajo inicial que el listado requerido en el prototipo |

**Elección:** Apache 2.4 y PHP 8.3. En las capturas se comprueba la instalación, el procesamiento de PHP y la presentación de la tabla de centros.

## Persistencia de datos

MySQL 8.0 permite almacenar los campos del CSV y consultarlos desde PHP. La codificación `utf8mb4` es adecuada para el contenido multilingüe del conjunto de datos. Frente a SQLite, MySQL facilita el escenario de un servidor B-NCC independiente y un cliente remoto W-NCC; frente a otras bases relacionales como PostgreSQL, el equipo ya contaba con experiencia y procedimientos sobre MySQL.

## Servicios auxiliares

- **BIND9:** resolución de nombres de prueba para `educabcn.local`.
- **ISC DHCP:** demonio de asignación de parámetros IP instalado en F-NCC. En EC2, el mecanismo DHCP nativo de AWS debe distinguirse de este servidor de laboratorio.
- **vsftpd:** transferencia de ficheros con usuarios locales, directorios restringidos y puerto de control FTP. La instalación y `chroot` no acreditan por sí solas cifrado de la sesión.
- **Git y GitHub:** control de versiones de la estructura y de la aplicación.
- **ProofHub:** planificación, reparto de tareas, seguimiento y actas del equipo.

## Criterios empleados

Se han tenido en cuenta disponibilidad de software y documentación, compatibilidad con Ubuntu, sencillez de operación, separación de componentes y el presupuesto educativo de AWS. Esta comparación justifica técnicamente la elección, sin afirmar que se hayan realizado benchmarks exhaustivos ni un estudio comercial de precios de todos los proveedores.

## Comparación de criterios y conclusiones

| Dimensión | Criterio relevante | Selección del equipo | Limitación pendiente |
|---|---|---|---|
| Hospedaje | Acceso remoto y VPC | AWS EC2 | Coste y dependencia del proveedor |
| Sistema operativo | Paquetes y documentación | Ubuntu Server LTS | Exige actualizar y mantener cada instancia |
| Web | Compatibilidad con PHP | Apache 2.4 | La escalabilidad no se ha medido |
| Datos | SQL y acceso remoto | MySQL 8 | Ausencia de benchmark y de alta disponibilidad |
| DNS | Zona propia de laboratorio | BIND9 | Verificar los nombres del router en el diseño final |
| DHCP | Servicio de asignación | ISC DHCP | En AWS la VPC utiliza DHCP propio |
| Archivos | Servicio de transferencia | vsftpd | FTP sin TLS no cifra credenciales ni datos |

Fuentes oficiales: [documentación de Ubuntu LTS](https://documentation.ubuntu.com/release-notes/24.04/), [Security Groups de AWS](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ec2-security-groups.html), [DHCP en VPC](https://docs.aws.amazon.com/vpc/latest/userguide/DHCPOptionSet.html). El análisis se limita a características y requisitos verificables; no se inventan precios comparativos ni resultados de ensayos.
