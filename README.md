# Proyecto P0.0: Portal Ciudadano "EducaBCN" 

## 1. Idea General y Escenario
* **Proyecto:** Desarrollo del portal web público y centralizado **EducaBCN**, destinado a la consulta de los equipamientos educativos de Barcelona utilizando el dataset real de OpenData BCN, complementado con un servidor FTP seguro para que los administradores de los centros suban documentación interna.
* **Escenario Profesional:** Simulamos ser una consultora tecnológica contratada por el Ayuntamiento de Barcelona para desplegar, auditar y documentar esta infraestructura. Ante el tribunal y el cliente, debemos responder a tres preguntas clave: **¿Funciona?**, **¿Está bien organizado?** y **¿Es seguro y fiable?**.

---

## 2. Infraestructura Técnica Final 
El despliegue final contempla los siguientes elementos bajo el usuario estándar de validación `bchecker` (contraseña: `bchecker121`):
* **R-NCC:** Router con 3 redes segmentadas (DMZ, Intranet y NAT).
* **W-NCC:** Servidor Web (Apache o Nginx) ubicado en la DMZ.
* **B-NCC:** Servidor MySQL con los datos del CSV de educación ubicado en la Intranet.
* **F-NCC:** Servidor FTP para la gestión documental.
* **Servicios Base:** DNS (resolviendo R-NCC y R) y DHCP avanzados en el Sprint 2.
* **Acceso Remoto:** SSH configurado en todos los equipos.
* **Hardware Cliente:** 2 PCs de prueba (uno con Windows y otro con Linux).

---

## 3. Estrategia de Sprints y MVPs Independientes
Siguiendo la filosofía Scrum y los MVPs independientes, cada iteración representa un producto completo, funcional y autoeconómico (organizado en su propia rama/carpeta de Git con su README, diagrama y demo):

* **Sprint 1 (Todo en 1 Máquina):** 
  * *Qué funciona:* Una única máquina virtual integrada que incluye el servidor web, MySQL con el CSV cargado, SSH y la mini-app de consulta operativa. Permite validar el valor de los datos desde el primer día.
* **Sprint 2 (Servidores Separados y Red Plana):** 
  * *Qué funciona:* Servidores independientes (Web, BBDD y FTP) comunicándose en red plana. Se incorporan los servicios de DNS y DHCP. La web consulta a la BBDD remota y el FTP permite transferencia de archivos.
* **Sprint 3 (Seguridad y Producción):** 
  * *Qué funciona:* Arquitectura de red definitiva con Router, segmentación DMZ/Intranet/NAT, cortafuegos, certificados SSL/TLS, monitorización, copias de seguridad y ejecución del juego de pruebas completo.

---

## 4. Efectos WOW (Nivel EXPERT)
Para alcanzar la máxima puntuación en la rúbrica, se implementarán las siguientes mejoras avanzadas:
1. **Seguridad en Tránsito:** Certificados SSL/TLS en servidores Web y FTP (HTTPS y FTPS).
2. **Normalización de Base de Datos:** Optimización del CSV original separándolo en tablas relacionales normalizadas (distritos, barrios y tipos de centro).
3. **Automatización (Extra Sprint 3):** Script de despliegue automatizado de infraestructura o configuraciones.

---

## 5. Requisitos Obligatorios de la Rúbrica Integrados
El proyecto contempla y documenta rigurosamente todos los apartados evaluables:
* Estudio de mercado previo y análisis de soluciones existentes.
* Control exhaustivo de tareas mediante el backlog de **ProofHub**.
* Repositorio en **GitHub** con estructura de árbol en Markdown y autenticación mediante intercambio de claves SSH.
* Tabla de identificación de riesgos técnicos y Plan de Prevención de Riesgos Laborales (PRL).
* Definición de criterios de rendimiento y disponibilidad medidos mediante métricas.
* Juego de pruebas enfocado a automatización, contingencia, monitorización y seguridad.
* **Doble documentación técnica:** Manual de Cliente y Manual de Administrador exhaustivo.

---

## 6. Organización Metodológica Scrum
* **Tablero de Control:** Backlog en ProofHub bajo la nomenclatura oficial `P0.0-ASIXc2gC-Gnn`.
* **Ciclo de Sprints:** Planificación al inicio de cada quincena, seguimiento a mitad de período, y sesión de *Review* con demostración y retrospectiva al finalizar.
* **Definición de "Hecho" (Definition of Done):** El componente funciona, está probado, se encuentra documentado en Markdown, cuenta con commits descriptivos en Git y está marcado como completado en ProofHub.
Prueba pull en EC2
