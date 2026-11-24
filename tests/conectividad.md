# Verificaciones de conectividad

La documentación original recoge consultas DNS realizadas desde W-NCC y B-NCC, así como pruebas de comunicación hacia MySQL desde la máquina web. El objetivo es comprobar tres niveles de funcionamiento: resolución de nombres, acceso TCP y autenticación SQL.

```bash
getent hosts db.educabcn.local
dig @HOST_DNS web.educabcn.local
nc -vz HOST_B_NCC 3306
mysql -h HOST_B_NCC -u USUARIO_LECTURA -p
```

Los comandos son reproducibles con los nombres y direcciones actuales del entorno. Las capturas de comprobación están intercaladas en [DNS/DHCP](../infrastructure/dns-dhcp/sprint-02.md), [red](../infrastructure/red/sprint-02.md) y [web](../infrastructure/web-ftp/sprint-02.md).

## Traslado de IP y comprobaciones posteriores

Después de la migración a DMZ e Intranet, W-NCC, B-NCC y F-NCC usan `172.31.101.10`, `172.31.102.10` y `172.31.102.20` respectivamente. Las IP antiguas de los comandos iniciales se conservan porque corresponden a la primera fase del Sprint 2. El conjunto de pruebas realizadas posteriormente, incluidas las conexiones permitidas y bloqueadas, aparece en [pruebas de segmentación](pruebas-sprint-02-segmentacion.md).
