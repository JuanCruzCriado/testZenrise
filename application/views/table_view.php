<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Excel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
        }
        table th, table td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        table th {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <h1>Tabla de Excel</h1>
    <?php if (!empty($tableData['columns']) && !empty($tableData['rows'])): ?>
        <table>
            <thead>
                <tr>
                    <?php foreach ($tableData['columns'] as $column): ?>
                        <th><?php echo $column->nombre_columna; ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tableData['rows'] as $row): ?>
                    <tr>
                        <?php foreach ($row as $cell): ?>
                            <td><?php echo $cell; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>   
    <?php else: ?>
        <p>No hay datos disponibles.</p>
    <?php endif; ?>
    <div style="position: fixed; bottom: 20px; left: 20px;">
        <a href="<?php echo base_url('Inicio'); ?>" style="text-decoration: none; background-color: #007bff; color: #fff; padding: 10px 20px; border-radius: 5px;">Volver al Inicio</a>
    </div>
</body>
</html>
