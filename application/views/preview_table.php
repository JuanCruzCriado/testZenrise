<!DOCTYPE html>
<html>
<head>
    <title>Tabla de Datos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 80%; /* Ancho de la tabla */
            margin: 0 auto; /* Centrar la tabla horizontalmente */
            border-collapse: collapse;
            border-spacing: 0;
            margin-top: 20px; /* Espaciado superior */
        }

        th, td {
            padding: 10px; /* Espaciado interno de celdas */
            text-align: center;
            border: 1px solid #ccc; /* Borde de celdas */
        }

        th {
            background-color: #f2f2f2; /* Color de fondo para la fila de encabezado */
        }

        td button {
            padding: 5px 10px; /* Espaciado interno de botones */
            background-color: #3498db; /* Color de fondo de botones */
            color: #fff; /* Color de texto de botones */
            border: none;
            cursor: pointer;
        }

        td button:hover {
            background-color: #2980b9; /* Color de fondo al pasar el mouse sobre botones */
        }
    </style>
</head>
<body>
    <h1>Tabla de Datos</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Título</th>
                <th>Texto Previo</th>
                <th>Mes</th>
                <th>Año</th>
                <th>Columnas</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($data as $row): ?>
                <tr>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['previousText']; ?></td>
                    <td><?php echo $row['month']; ?></td>
                    <td><?php echo $row['year']; ?></td>
                    <td>
                        <ul>
                            <?php foreach ($row['columns'] as $column): ?>
                                <li><?php echo $column->nombre_columna; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                    <td>
                        <a href="<?php echo base_url('Inicio/viewExcel/' . $row['id']); ?>">
                            <button>Ver Excel</button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div style="position: fixed; bottom: 20px; left: 20px;">
        <a href="<?php echo base_url('Inicio'); ?>" style="text-decoration: none; background-color: #007bff; color: #fff; padding: 10px 20px; border-radius: 5px;">Volver al Inicio</a>
    </div>
</body>
</html>