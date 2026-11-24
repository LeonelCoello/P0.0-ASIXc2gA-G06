# Aplicación EducaBCN: Sprint 1

La primera aplicación es un portal PHP que consulta información pública sobre centros educativos de Barcelona. Fue desplegada y verificada en la arquitectura de un solo servidor.

## Recorrido de una petición

1. El navegador solicita `index.php` al servidor Apache.
2. PHP obtiene la configuración de la conexión a la base de datos local.
3. PDO abre una sesión SQL y ejecuta una consulta de lectura sobre `centros_educativos`.
4. La consulta limita la salida a un subconjunto de registros.
5. PHP genera una tabla HTML y escapa los valores antes de mostrarlos.

## Consulta utilizada en el prototipo

```sql
SELECT * FROM centros_educativos LIMIT 50;
```

Se eligió un listado sencillo para verificar la carga de registros antes de incorporar mejoras de usabilidad o un modelo de datos más amplio. En el código publicado deben eliminarse secretos y usar un fichero de configuración protegido.

## Resultado observado

La captura original muestra el portal desplegado y la tabla generada a partir de los registros importados.

![Captura original del documento técnico: fuente p31 vista inicial de educabcn](../../media/sprint-01/fuente-p31-vista-inicial-de-educabcn.png)
