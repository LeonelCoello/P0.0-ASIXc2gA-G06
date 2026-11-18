<?php
/**
 * EducaBCN — Sprint 2 (plantilla PROVISIONAL: sustituir por el código real de W-NCC).
 * No es una transcripción verificada del index.php actual de W-NCC.
 * Se basa en la estructura observada en el Sprint 1 y en los cambios de conexión documentados en el Sprint 2.
 * Se ha retirado la contraseña incrustada por seguridad.
 * Definir EDUCABCN_DB_PASSWORD en el entorno del servicio web.
 */
$host = getenv('EDUCABCN_DB_HOST') ?: '172.31.39.133';
$dbname = 'EducaBCN';
$user = 'webapp';
$password = getenv('EDUCABCN_DB_PASSWORD');
if ($password === false || $password === '') {
    http_response_code(503);
    exit('Configuración de base de datos no disponible.');
}

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $user,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM centros_educativos LIMIT 50");
    $centros = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log('EducaBCN / Sprint 2: error al consultar MySQL.');
    http_response_code(503);
    exit('No se han podido consultar los centros educativos.');
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Centros Educativos - EducaBCN</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f9; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; background: #fff; margin-top: 15px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>
    <h1>Listado de Centros Educativos (EducaBCN)</h1>
    <?php if (!empty($centros)): ?>
        <table>
            <thead><tr>
                <?php foreach (array_keys($centros[0]) as $columna): ?>
                    <th><?php echo htmlspecialchars($columna, ENT_QUOTES, 'UTF-8'); ?></th>
                <?php endforeach; ?>
            </tr></thead>
            <tbody>
                <?php foreach ($centros as $centro): ?>
                    <tr>
                        <?php foreach ($centro as $valor): ?>
                            <td><?php echo htmlspecialchars((string)($valor ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron registros en la base de datos.</p>
    <?php endif; ?>
</body>
</html>
