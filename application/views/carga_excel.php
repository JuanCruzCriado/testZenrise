<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Carga de Excel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h1 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"],
        select,
        textarea,
        input[type="file"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div <?php if (!empty($errorMsj)) { echo 'style="background-color: #FF0000; color: #FFFFFF; padding: 10px; text-align: center;"'; } ?>>
            <?php echo $errorMsj; ?>
        </div>
        <h1>Carga de Excel</h1>
        <form action="<?php echo base_url('Inicio/carga_excel'); ?>" method="post" enctype="multipart/form-data">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            
            <label for="texto_previo">Texto previo:</label>
            <textarea id="texto_previo" name="texto_previo" rows="4" required></textarea>
            
            <label for="mes">Mes:</label>
            <select id="mes" name="mes" required>
                <option value="1">Enero</option>
                <option value="2">Febrero</option>
                <option value="3">Marzo</option>
                <option value="4">Abril</option>
                <option value="5">Mayo</option>
                <option value="6">Junio</option>
                <option value="7">Julio</option>
                <option value="8">Agosto</option>
                <option value="9">Septiembre</option>
                <option value="10">Octubre</option>
                <option value="11">Noviembre</option>
                <option value="12">Diciembre</option>
            </select>
            
            <label for="ano">Año:</label>
            <select id="ano" name="ano" required>
                <?php
                $ano_actual = date("Y");
                for ($ano = 1980; $ano <= $ano_actual; $ano++) {
                    echo "<option value=\"$ano\">$ano</option>";
                }
                ?>
            </select>
            
            <label for="excel">Carga Excel:</label>
            <input type="file" id="excel" name="excel" accept=".xlsx, .xls" required>
            
            <button type="submit">Confirmar</button>
        </form>
        <a href="<?php echo base_url('Inicio/previewTable'); ?>">Ir a Vista Previa</a>
    </div>
</body>
</html>
