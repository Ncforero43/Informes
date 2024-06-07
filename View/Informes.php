<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form id="Informes" >
    <p>Seleccione al usuario al cual le desea realizar una consulta</p>
    <select name="Usu" id="Usu" onchange="MakeConsult(this.value)">
    <option value="" disabled selected>Seleccione un usuario</option>
    <?php
    require ("../Modelo/CRUD-OBj.php");
    $request = true;
    $tableName = 'Usuarios';
    $campoPK = null; 
    $valuePK = null;
    $datoTablaB = null;
    $consultaInner = null;
    $tablas = null;
    $select = $CRUD->Select($request, $tableName, $campoPK, $valuePK, $consultaInner, $datoTablaB,$tablas);
    foreach ($select as $row):
  ?>
      <option value="<?php echo $row['Usu_id']; ?>"><?php echo $row['Usu_Nombre']; ?></option>
  <?php
    endforeach;
  ?>
</select>
    </form>

    <div id="informe">

    </div>
</body>
</html>