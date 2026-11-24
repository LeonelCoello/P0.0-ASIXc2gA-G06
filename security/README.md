# Seguridad de acceso y servicios

Los controles descritos se limitan a los procedimientos que constan en la documentación: reglas de seguridad de AWS, autenticación SSH, separación de nodos, permisos de acceso SQL, protección de la configuración PHP y restricciones de directorios en FTP.

- [Acceso administrativo SSH](ssh.md)
- [Pruebas y consideraciones de seguridad](../tests/seguridad.md)
- [Manual de administración](../docs/manual-administrador.md)

Las políticas generales de seguridad y continuidad se abordan en la documentación de análisis y de contingencia, sin presentar como ejecutadas funciones que todavía no constan en los registros.

## Segunda etapa del Sprint 2

- [Firewall y Security Groups por servidor](configuracion-accesos.md): reglas aplicadas y alcance.
- [Acceso SSH actualizado de R-NCC](ssh.md): autenticación mediante clave y `PermitRootLogin no`.
- [Comprobaciones del nuevo aislamiento](../tests/pruebas-sprint-02-segmentacion.md): pruebas de conexiones permitidas y bloqueadas.

Se conserva como histórico la descripción de los Security Groups compartidos de la primera etapa.
