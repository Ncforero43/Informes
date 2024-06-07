<?php
require("claseConexion.php");
class CRUD extends connectionDB
{   
    //Conexion base de datos
    //(
        private $conexion;
    //)

    //Insert
    //(
        private $Insert; //Consulta
        private $nameTable;
        private $campos;
        private $valores;
    //)

    //Select
    //(
        private $request;
        private $consulted;
        private $selectConsult;
        private $ExecuteConsultSelect;
        private $datoTablaB;
        private $consultaInner;
        private $campoPKs;
        private $valuePKs;
    //)

    //Delete
    //(
        private $CampoPK;
        private $ValuePK;
        private $delete;
    //)

    //Update
    //(
        private $Campos;
        private $Valores;
        private $table;
        private $campoPK;
        private $valorPK;
    //)


    public function __construct() {
        $this->conected = new connectionDB;
        $this->conexion = $this->conected->getConnect();
    }

    public function Insert($nameTableJioned, $caposJioned, $valoresJioned) {   
        $this->nameTable = $nameTableJioned;
        $this->Insert = "INSERT INTO " . $this->nameTable . "(" . implode(',', $caposJioned) . ") 
        VALUES ('" . implode("','", $valoresJioned) . "')";
        
        if ($this->conexion->query($this->Insert) === TRUE) 
        {
            return $this->conexion->insert_id;
        } 
        else 
        {
            echo "Error al insertar datos: " . $this->conexion->error;
        }
    }

    public function Select($request,$nameTable,$campoPK, $valorPK, $consultaInner, $datoTablaB,$tablas)
    {
        $this->campoPKs = $campoPK;
        $this->valuePKs = $valorPK;
        $this->nameTable = $nameTable;
        $this->request = $request;
        $this->consultaInner = $consultaInner;
        $this->datoTablaB = $datoTablaB;

        if($this->consultaInner != null && ($this->valuePKs==NULL or $this->request=='JOIN'))
        {
            //Join
            $joins = '';
            foreach ($consultaInner as $index => $join) {
                $joins .= " INNER JOIN {$tablas[$index]} ON {$join[0]} = {$join[1]}";
            }
            //Se debe ejecutar por default
            $this->selectConsult = 'SELECT ' .$this->nameTable  . '.*, '. implode(', ',$this->datoTablaB) . ' FROM ' . $this->nameTable
            . ' ' . $joins;  
        }
        elseif($this->consultaInner !== null && $this->request==='WHERE')
        {
            //Join
            $joins = '';
            foreach ($consultaInner as $index => $join) {
                $joins .= " INNER JOIN {$tablas[$index]} ON {$join[0]} = {$join[1]}";
            }
            //Muchas condiciones

            $condicionesMulti = [];
            for($i=0; $i < count($this->valuePKs); $i++ )
            {
            $condicionesMulti[] = $campoPK[$i] . "='" . $valorPK[$i] . "'";
            }
            $condicionesWhere = implode(' AND ', $condicionesMulti);
            //Se debe ejecutar por default
            $this->selectConsult = 'SELECT ' .$this->nameTable  . '.*, '. implode(', ',$this->datoTablaB) . ' FROM ' . $this->nameTable
            . ' ' . $joins . ' WHERE ' . $condicionesWhere;
        }
        elseif($this->request==true)
        {
            //Se debe ejecutar por default
            $this->selectConsult = 'SELECT * FROM ' . $this->nameTable;
            
        }elseif($this->request==false)
        {
            //Se debera ejecutar cuando se envie un parametro
            $this->selectConsult = 'SELECT * FROM ' . $this->nameTable
            . ' WHERE ' . $this->campoPKs . ' = "' . $this->valuePKs . '"' ;
        }

        
        //Consulta Ejecutada
        $this->ExecuteConsultSelect = $this->conexion->query($this->selectConsult);

        if($this->ExecuteConsultSelect)
        {
            if ($this->ExecuteConsultSelect->num_rows >= 0)
            {
                $values = []; 
                while ($row = $this->ExecuteConsultSelect->fetch_assoc())
                {   
                    $values[] = $row; 
                }     
                return $values; 
            }else
            {
                $values = "No se a encontrado valores";

                return $values;
            }

            
        }
         
    }

    public function Update($campos, $valores, $tabla, $campoPK, $valorPK) {
        $this->Campos = $campos;
        $this->Valores = $valores;
        $this->table = $tabla;
        $this->CampoPK = $campoPK;
        $this->ValorPK = $valorPK;
    
        $setValues = [];
        for ($i = 0; $i < count($this->Campos); $i++) {
            $setValues[] = "`" . $this->Campos[$i] . "`='" . $this->Valores[$i] . "'";
        }
    
        $updateQuery = "UPDATE " . $this->table . " SET " . implode(',', $setValues) . " WHERE {$this->CampoPK}='{$this->ValorPK}'";
    
        if(mysqli_query($this->conexion, $updateQuery)) {
            echo "Se modificó con éxito";
        } else {
            echo "Error al ejecutar la consulta: " . mysqli_error($this->conexion);
        }
        
        mysqli_close($this->conexion);
    }

    public function Delete($nameTable, $CampoPK, $ValuePK) {
        $this->nameTable = $nameTable;
        $this->CampoPK = $CampoPK;
        $this->ValuePK = $ValuePK;
    
        $this->delete = "DELETE FROM ".$this->nameTable. " WHERE ".$this->CampoPK." = '".$this->ValuePK."'";
    
        if(mysqli_query($this->conexion, $this->delete)) {
            $Responde = "Se eliminó con éxito";
            return $Responde;
        } else {
            $Responde = "Error: No se ha podido eliminar";
            return $Responde;
        }
        mysqli_close($this->conexion);
    }
}
?>
