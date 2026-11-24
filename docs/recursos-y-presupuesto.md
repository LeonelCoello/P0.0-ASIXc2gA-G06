# Recursos y presupuesto


## Recursos técnicos
AWS EC2, Ubuntu Server, Security Groups, red virtual, volúmenes EBS, repositorio Git y tablero ProofHub. Para pruebas se contemplan clientes Windows y Linux.

## Dimensionamiento preliminar de la memoria
| Rol | CPU prevista | RAM prevista | Disco previsto |
|---|---|---|---|
| Instancia inicial | 2 vCPU | 2–4 GB | 20 GB |
| Servidor web | 2 vCPU | 2 GB | 15 GB |
| Base de datos | 2 vCPU | 4 GB | 30 GB |
| FTP | 1 vCPU | 1–2 GB | 50 GB |
| Router lógico futuro | 1 vCPU | 1 GB | 8 GB |

Estas cifras proceden de la propuesta, no de una comprobación de tamaños efectivamente contratados.

## Seguimiento del coste
Registrar fecha, servicio, unidades, precio unitario, subtotal, crédito disponible y saldo. Revisar cuotas de IP públicas y transferencias. Apagar instancias de prácticas cuando no se utilicen, sin confundir esta medida con un modelo de disponibilidad de producción.
