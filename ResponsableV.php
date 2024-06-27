<?php

class ResponsableV extends Persona{
    private $numEmpleado;
    private $numLicencia;

    public function __construct()
    {
        parent::__construct();
        $this->numEmpleado = "";
        $this->numLicencia = "";
    }

    /* METODOS SQL */
    public function cargar($NroD,$Nom,$Ape,$NroTel, $numEmpleado = null, $numLicencia = null){
        parent::cargar($NroD,$Nom,$Ape,$NroTel);
        if($numEmpleado != null){
            $this->setNumEmpleado($numEmpleado);
        }
        if($numLicencia != null){
            $this->setNumLicencia($numLicencia);
        }
    }

    public function Buscar($dni){
        $base = new BaseDatos(); #creo la base de datos
        $consulta = "SELECT * FROM responsable WHERE rnrodoc =".$dni;
        $resp = false;
        if($base->Iniciar()){ # acá me conecto
            if($base->Ejecutar($consulta)){ #envío la consulta al gestor de base de datos
                if($registros = $base->Registro()){
                    parent::Buscar($dni);
                    $this->setNumEmpleado($registros['rnumeroempleado']);
                    $this->setNumLicencia($registros['rnumerolicencia']);
                    $resp = true;
                }
            }else{
                $this->setmensajeoperacion($base->getERROR());
            }
        }else{
            $this->setmensajeoperacion($base->getERROR());
        }
        return $resp;
    }

    public function listar($condicion=""){
	    $arreglo = null;
		$base = new BaseDatos();

		$consulta = "SELECT * FROM responsable";
		if ($condicion!=""){
		    $consulta .=  " WHERE " .$condicion;
		}
		// $consulta.=" ORDER BY rnumeroempleado";

        if($base->Iniciar()){ 
		    if($base->Ejecutar($consulta)){				
			    $arreglo = [];
				while($registros=$base->Registro()){
					$obj=new ResponsableV();
					$obj->Buscar($registros['rnrodoc']); 
					$arreglo[] = $obj;
				}
		 	}	else $this->setmensajeoperacion($base->getError());
		 }	else $this->setmensajeoperacion($base->getError());
         
         
		return $arreglo;
	}

    public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO responsable VALUES (".$this->getNumEmpleado().",".$this->getNumLicencia().",".$this->getNrodoc().")";

        if ($base->Iniciar()){
            if ($base->Ejecutar($consultaInsertar)){
                $resp = true;
            } else $this->setmensajeoperacion($base->getERROR());
        } else $this->setmensajeoperacion($base->getERROR());

        return $resp;
    }

    public function modificar(){
        $base = new BaseDatos();
        $resp = false;

        $consultaModificar = "UPDATE responsable SET rnumeroempleado=".$this->getNumEmpleado().", rnumerolicencia=".$this->getNumLicencia().
        " WHERE rnrodoc = " . $this->getNrodoc();

        if ($base->Iniciar()){
            if ($base->Ejecutar($consultaModificar)){
                $resp = true;
            } else $this->setmensajeoperacion($base->getERROR());
        } else $this->setmensajeoperacion($base->getERROR());

        return $resp;
    }

    public function eliminar(){
        $resp = false;
        if (parent::eliminar()){
            $resp = true;
        }
        return $resp;
    }

    /* GETTERS Y SETTERS */

    public function getNumEmpleado()
    {
        return $this->numEmpleado;
    }

    public function setNumEmpleado($numEmpleado)
    {
        $this->numEmpleado = $numEmpleado;
    }

    public function getNumLicencia()
    {
        return $this->numLicencia;
    }

    public function setNumLicencia($numLicencia)
    {
        $this->numLicencia = $numLicencia;
    }

    public function __toString()
    {
        return parent::__toString()."\n Numero de empleado: ".$this->getNumEmpleado()."\n".
        "numero de licencia: ".$this->getNumLicencia();
    }
}