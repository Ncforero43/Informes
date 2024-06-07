<?php
require ("../Modelo/CRUD-OBj.php");
if (isset($_POST['valor'])) 
{
$valor = $_POST['valor'];

if ($valor === '1')
    {
//Nombre Tabla
$tablaNombre = $_POST['tableName'];
//Datos Usuarios
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$rol = $_POST['Rol'];
$tipo_DNI = $_POST['Tipo_id'];
$numero_DNI = $_POST['numeroDeIdentificacion'];
$numeroTelef = $_POST['NumeroDeTelefono'];
$correo = $_POST['correoElectronico'];
$contra = $numero_DNI;
$estado = "Alta";

$campos = ["Usu_Nombre", "Usu_Apellido", "Tipo_id", "Usu_Nu_ID", "Usu_Correo", "Usu_Numero_tele", "Usu_ID_Rol", "Usu_contra", 'Usu_status'];
$values = [$nombre, $apellido, $tipo_DNI, $numero_DNI, $correo, $numeroTelef, $rol, $contra, $estado];

$CRUD->Insert($tablaNombre, $campos, $values);
    }
elseif ($valor === '2') 
    {
//Mostrar Usuario Funciona
$request = isset($_POST['request']) ? $_POST['request'] : null;
$tableName = isset($_POST['tableName']) ? $_POST['tableName'] : null;
$campoPK = isset($_POST['valorConsulta'])  ? $_POST['campo'] : null;
$valuePK = isset($_POST['valorConsulta']) ? $_POST['valorConsulta'] : null;
$datoTablaB = ['Rol_nombre','NTDoc'];
$consultaInner = 
    [
        ['usuarios.Usu_ID_Rol','tb_rol.Rol_cod'],
        ['usuarios.Tipo_id','tbl_tip_doc.Cod_Tipo_Doc']
    ];
$tablas = ['tb_rol','tbl_tip_doc'];

$select = $CRUD->Select($request, $tableName, $campoPK, $valuePK, $consultaInner,$datoTablaB,$tablas); 
}
elseif($valor === '4')
    {

//Nombre Tabla
$tablaName = $_POST['tableName'];
//Datos Usuarios
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$rol = isset($_POST['Rol']) ? $_POST['Rol'] : $_POST['Rol_default'];
$tipo_DNI = isset($_POST['Tipo_id']) ? $_POST['Tipo_id'] : $_POST['Tipo_id_default'] ;
$numero_DNI = $_POST['numeroDeIdentificacion'];
$numeroTelef = $_POST['NumeroDeTelefono'];
$correo = $_POST['correoElectronico'];
//campoPKs
$campoPK = $_POST['campoPK'];
//ValorPKs
$valorPK = $_POST['valorPK'];
    
$campos = ["Usu_Nombre", "Usu_Apellido", "Tipo_id", "Usu_Nu_ID", "Usu_Correo", "Usu_Numero_tele", "Usu_ID_Rol",];
$valores = [$nombre, $apellido, $tipo_DNI, $numero_DNI, $correo, $numeroTelef, $rol];
// Ejecutar la función Update()
$resultado = $CRUD->Update($campos, $valores, $tablaName, $campoPK, $valorPK);  
    }
}

if (isset($_GET['valor'])) {
    $valor = $_GET['valor'];
if ($valor === '3')
    $tableName = $_GET['tablaName'];
    $campoPK = $_GET  ['CampoPK'];
    $valorPK = $_GET  ['valorPK'];
    $estado = $_GET   ['status'];
    $campos = ['Usu_Status'];
    $valores = [$estado];

    $CRUD->Update($campos, $valores, $tableName, $campoPK, $valorPK);
}

if (isset($_POST['Usu_ID'])) {
    $UserID = $_POST['Usu_ID'];
    $Estado = 'incompleto'; // Debe ser una cadena, no un array
    $request = 'WHERE'; // Puede ser true si se requiere
    $tableName = 'bitacora';
    $campoPK = ['bitacora.Usu_ID', 'bitacora.estado']; // Campos para la condición
    $valuePK = [$UserID, $Estado]; // Valores correspondientes para los campos
    $datoTablaB = ['usuarios.Usu_id', 'usuarios.Usu_Nombre', 'bitacora.Usu_ID', 'bitacora.estado', 'bitacora.id_bitacora']; 
    $consultaInner = [
        ['bitacora.Usu_ID', 'usuarios.Usu_id']
    ];
    $tablas = ['Usuarios'];

    $select = $CRUD->Select($request, $tableName, $campoPK, $valuePK, $consultaInner, $datoTablaB, $tablas);

    if ($select && is_array($select)) {
        echo "<table border='1'>";
        echo "<tr><th>ID Bitácora</th><th>Usuario</th><th>Estado</th></tr>";
        foreach ($select as $row) {
            echo "<tr>";
            echo "<td>{$row['id_bitacora']}</td>";
            echo "<td>{$row['Usu_Nombre']}</td>";
            echo "<td>{$row['estado']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron registros.";
    }
}


?>
