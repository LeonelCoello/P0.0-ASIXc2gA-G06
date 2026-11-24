# Objetivos y alcance de EducaBCN

## Necesidad que aborda el proyecto

EducaBCN pretende facilitar la consulta web de información pública sobre centros educativos de Barcelona, utilizando el conjunto de datos publicado en OpenData BCN. El proyecto también sirve para desplegar y administrar los servicios que permiten que ese catálogo sea accesible mediante una infraestructura de sistemas.

## Objetivo funcional

Importar un conjunto de datos real de equipamientos educativos y ofrecer una interfaz web que pueda consultarlos desde un navegador. El prototipo inicial implementa una tabla de resultados en PHP conectada a MySQL.

## Objetivos técnicos

- Implementar una primera versión funcional en una instancia EC2 con Ubuntu Server 24.04 LTS.
- Configurar Apache, PHP y MySQL y validar una consulta web sobre el dataset.
- Evolucionar de una instalación monolítica a nodos separados para web, datos y FTP.
- Configurar resolución DNS interna y estudiar la asignación DHCP en el entorno.
- Registrar la evolución técnica y las decisiones mediante GitHub y ProofHub.

## Usuarios a los que se dirige

El portal se orienta a ciudadanos que necesitan consultar datos públicos. La administración de instancias, cuentas, bases de datos y servicios está reservada al equipo técnico.

## Alcance de la documentación

Los procedimientos desarrollan las instalaciones, cambios y comprobaciones que aparecen en la memoria de trabajo. Los elementos que se contemplan como continuación del proyecto se describen únicamente en [planificación](planificacion.md), sin atribuirse como servicios ya implantados.
