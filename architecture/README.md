# Arquitectura actualmente documentada

En el primer sprint se empleó una sola instancia EC2 con los servicios web y de datos. Durante el segundo se trasladó la aplicación a W-NCC, se mantuvo MySQL en B-NCC y se incorporó F-NCC con FTP, DNS y DHCP. La documentación identifica estas direcciones privadas:

| Nodo | Función principal | IP privada documentada |
|---|---|---|
| W-NCC | Apache + PHP, portal EducaBCN | `172.31.31.159` |
| B-NCC | MySQL, base de datos EducaBCN | `172.31.39.133` |
| F-NCC | vsftpd, BIND9 e ISC DHCP | `172.31.16.170` |

Las IP privadas son las observadas en la documentación recibida y pueden variar si se recrean las instancias.

```text
Ciudadano / navegador
          |
  Internet y acceso AWS
          |
       W-NCC
  Apache + PHP + app
          |
   MySQL TCP/3306
          |
       B-NCC
  BD EducaBCN, CSV

       F-NCC
  vsftpd + BIND9 + ISC DHCP
   (servicios auxiliares)
```

Esta representación no presupone que exista un router EC2 dedicado, una VPN en producción ni subredes DMZ/Intranet ya segmentadas. Esas funciones se recogen exclusivamente como propuesta en el documento de planificación. La ubicación exacta de las instancias en las subredes se valida desde la consola VPC, y no se deduce de la tercera cifra de la IP.

## Comunicación de servicios

1. El navegador accede al portal servido por Apache en W-NCC.
2. PHP establece una conexión PDO hacia el servicio MySQL de B-NCC.
3. MySQL devuelve los registros y PHP genera la tabla HTML.
4. F-NCC resuelve nombres internos mediante BIND9 y ofrece el servicio FTP configurado para las pruebas.
5. Los Security Groups controlan el tráfico permitido; el éxito de un ping o una conexión de prueba no acredita por sí solo una política de aislamiento completa.

[Registros de las pruebas de conectividad](../tests/pruebas-sprint-02.md).
