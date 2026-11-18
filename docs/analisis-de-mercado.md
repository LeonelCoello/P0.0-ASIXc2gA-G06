# Necesidad, entorno y análisis de soluciones existentes

## Índice

- [Problema que aborda el proyecto](#problema-que-aborda-el-proyecto)
- [Público objetivo y alcance](#publico-objetivo-y-alcance)
- [Soluciones existentes que permiten comparar](#soluciones-existentes-que-permiten-comparar)
- [Oportunidad y valor diferencial del prototipo](#oportunidad-y-valor-diferencial-del-prototipo)
- [Limitaciones del análisis](#limitaciones-del-analisis)
- [Fuentes verificables](#fuentes-verificables)


## Problema que aborda el proyecto

La información de los equipamientos educativos de Barcelona está publicada como datos abiertos. Sin embargo, un CSV no ofrece directamente una interfaz que una persona sin conocimientos de bases de datos pueda consultar con comodidad. EducaBCN convierte una selección de datos en una página web y, paralelamente, funciona como proyecto educativo de administración de sistemas para practicar servicios web, bases de datos, red y control de versiones.

No se ha realizado una encuesta a ciudadanos ni se dispone de analítica de usuarios. Por tanto, la necesidad es una **hipótesis razonada**, no una demanda de mercado estadísticamente demostrada.

## Público objetivo y alcance

| Público | Necesidad razonable | Funcionalidad comprobada |
|---|---|---|
| Ciudadanía y alumnado | Consultar información básica de centros | Listado web de registros de centros educativos |
| Personal técnico | Verificar servicio HTTP y consulta a MySQL | Página PHP y conexión remota documentadas |
| Profesorado evaluador | Revisar configuración, cuentas y entregas | Cuenta de validación `bchecker`, procedimientos y capturas |
| Equipo de proyecto | Asignar y rastrear tareas | Backlog y tableros de ProofHub |

La primera versión presenta hasta 50 registros según `SELECT * FROM centros_educativos LIMIT 50`; **no** se documentó un buscador completo, filtros por distrito o un sistema de matrículas.

## Soluciones existentes que permiten comparar

| Recurso consultado | Qué ofrece | Diferencia y aprendizaje para EducaBCN |
|---|---|---|
| [OpenData BCN — Equipamientos educativos](https://datos.gob.es/es/catalogo/l01080193-listado-de-equipamientos-de-educacion-de-la-ciudad-de-barcelona) | Dataset de equipamientos como fuente de datos reutilizable | EducaBCN incorpora un ejercicio de importación y presentación web; depende de la calidad y actualidad de esa fuente |
| [Consorci d'Educació — Mapa escolar](https://www.edubcn.cat/es/el_consorcio/transparencia/planificacion/mapa_escolar) | Herramientas de consulta de la oferta educativa de Barcelona | Es una alternativa institucional más completa; nuestro prototipo no debe confundirse con un buscador oficial |
| [Generalitat — Directorio de centros](https://educacio.gencat.cat/ca/serveis-tramits/directoris-centres/index.html) | Información institucional sobre centros educativos autorizados | Muestra la importancia de validar la procedencia y actualidad de los datos |

Estos proyectos son **alternativas de consulta o fuentes públicas**, no competidores empresariales a los que se atribuyan cuotas de mercado o precios ficticios.

## Oportunidad y valor diferencial del prototipo

**Valor actual:** una aplicación sencilla que demuestra la integración de Apache/PHP y MySQL con un dataset oficial, y una infraestructura administrada con evidencias reproducibles. No busca competir en funcionalidades con los portales institucionales.

**Mejoras posibles (no implementadas en los dos primeros sprints):** buscador por nombre, filtros por distrito y barrio, paginación real, mapa, actualización automática del CSV, pruebas con usuarios, accesibilidad y medición de uso. Una aplicación pública requeriría además política de actualización, control de errores y cumplimiento de protección de datos cuando proceda.

## Limitaciones del análisis

No constan investigación de campo, presupuestos comerciales ni datos de tráfico y adopción. La comparación es **cualitativa y documental**. Evitamos presentar estimaciones inventadas como resultados. Para mejorar esta sección en el futuro se podrían realizar entrevistas breves y documentar criterios, muestra y resultados.

## Fuentes verificables

- [Catálogo del conjunto de datos municipal en datos.gob.es](https://datos.gob.es/es/catalogo/l01080193-listado-de-equipamientos-de-educacion-de-la-ciudad-de-barcelona)
- [Mapa escolar del Consorci d'Educació](https://www.edubcn.cat/es/el_consorcio/transparencia/planificacion/mapa_escolar)
- [Directorio de centros de la Generalitat](https://educacio.gencat.cat/ca/serveis-tramits/directoris-centres/index.html)
