# Registro de decisiones técnicas

| Decisión | Motivo | Consecuencia documentada |
|---|---|---|
| AWS EC2 con Ubuntu Server | Disponer de infraestructura Linux administrable de forma remota | Despliegue del prototipo y de nodos separados |
| Apache + PHP | Tecnologías adecuadas para una aplicación PHP ligera | Publicación inicial de `index.php` |
| MySQL | Persistencia relacional del catálogo abierto | Importación inicial y consultas SQL |
| PDO | Acceso SQL desde el código PHP | Conexión y ejecución de consultas en el portal |
| Primera fase en una sola máquina | Validación del circuito completo con menor complejidad | Prototipo inicial funcional |
| Separar W-NCC, B-NCC y F-NCC | Reducir acoplamiento y administrar roles por separado | Evolución de red y servicios del segundo sprint |
| Configuración de conexión fuera del código | Evitar almacenar contraseñas directamente en `index.php` | Archivo privado `/etc/educabcn.conf` |
| BIND9 y DNS interno | Utilizar nombres lógicos en vez de direcciones de red en el código | Instalación y consultas DNS registradas |
| ProofHub y GitHub | Control de tareas, código y documentos | Backlog y trazabilidad del trabajo |

## Decisiones incorporadas durante la ampliación del Sprint 2

| Decisión | Justificación | Consecuencia y evidencia |
|---|---|---|
| Trasladar router y firewall al Sprint 2 | Completar la infraestructura distribuida y protegida antes de las mejoras de aplicación | Se añaden S2.6 y S2.7 al seguimiento manteniendo el historial de tareas |
| Organizar las máquinas en WAN, DMZ e Intranet | Diferenciar exposición web, persistencia y tráfico de salida | Nuevas subredes y direcciones privadas documentadas en [red del Sprint 2](../infrastructure/red/sprint-02.md) |
| Emplear R-NCC como router NAT y salto SSH | Facilitar acceso administrativo a instancias sin IP pública y salida de red | Pruebas de reenvío IPv4, regla MASQUERADE y accesos mediante `ProxyJump` |
| Sustituir el Security Group compartido por grupos individuales | Restringir por función los accesos entrantes | `SG-BBDD-EducaBCN`, `SG-Web-EducaBCN`, `SG-FTP-EducaBCN` y `SG-Router-EducaBCN` |
| Actualizar la zona DNS tras cambiar las IP | Evitar resolver los nombres internos hacia direcciones de la topología anterior | Registros `web`, `db`, `ftp` y `ns1` revisados en F-NCC |

El equipo conserva como historial los antiguos rangos IP y las reglas amplias usadas durante la implantación; no se recomienda reutilizarlas como política definitiva. Las pruebas solo avalan los casos concretos capturados.
