# Planteamiento y objetivos de EducaBCN

## Índice

- [Necesidad identificada](#necesidad-identificada)
- [Usuarios previstos](#usuarios-previstos)
- [Objetivos técnicos](#objetivos-tecnicos)
- [Alcance efectivamente descrito](#alcance-efectivamente-descrito)


## Necesidad identificada

Los conjuntos públicos de datos sobre centros educativos de Barcelona permiten consultar información relevante, pero su formato de origen no está pensado como una aplicación de consulta sencilla para el ciudadano. EducaBCN convierte un CSV en datos almacenados en MySQL y publicados por una aplicación web accesible desde un navegador. El proyecto persigue, además, aprender a gestionar los servicios que permiten ofrecer esa aplicación en una infraestructura de servidores.

## Usuarios previstos

- **Ciudadanos:** consultan el listado de centros, distritos, barrios, direcciones y teléfonos.
- **Personal administrador del sistema:** supervisa la infraestructura, usuarios, servicios y datos.
- **Personal autorizado para archivos:** utiliza el servidor de transferencia según los permisos establecidos.

## Objetivos técnicos

1. Desplegar instancias Linux en AWS EC2, controlar el acceso administrativo y conservar los cambios técnicos en Git.
2. Instalar y configurar Apache y PHP para servir la aplicación EducaBCN.
3. Importar los datos de OpenData BCN en MySQL y consultarlos mediante PHP/PDO.
4. Separar la aplicación y la base de datos en servidores distintos conservando el funcionamiento.
5. Incorporar servicios de transferencia de archivos y resolución de nombres y documentar su configuración.
6. Verificar los servicios con conexiones, consultas y capturas reproducibles.
7. Analizar riesgos de continuidad, seguridad y prevención laboral propios del proyecto.

## Alcance efectivamente descrito

La versión descrita permite consultar registros del conjunto de datos cargado previamente en MySQL. No existe evidencia de actualización automática del CSV, de un sistema de autenticación para ciudadanos ni de un motor de búsqueda avanzado. Estas funcionalidades no se atribuyen al producto actual.

El conjunto de datos cargado figura en la documentación con **2.710 registros**. Esta cifra corresponde a la importación mostrada y no debe interpretarse como un censo actualizado en tiempo real.
