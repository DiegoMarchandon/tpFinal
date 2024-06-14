<?php

class Pasajero extends Persona{
    
    private $objViaje;
    private $nroPasaporte;

    public function __construct()
    {
        parent::__construct();
        $this->nroPasaporte = "";
    }

    /* METODOS INSERTAR, MODIFICAR Y ELIMINAR */

    public function cargar($NroD,$Nom,$Ape,$NroTel, $objViaje = null, $nroPasaporte = null){
        $this->setNrodoc($NroD);
		$this->setNombre($Nom);
		$this->setApellido($Ape);
		$this->setTelefono($NroTel);
        if($objViaje != null){
            $this->setObjViaje($objViaje);
        }
        if($nroPasaporte != null){
            $this->setNroPasaporte($nroPasaporte);
        }
    }

    public function Buscar($dni){
        $base = new BaseDatos(); #creo la base de datos
        $consulta = "SELECT * FROM pasajero WHERE pdocumento=".$dni;
        $resp = false;
        if($base->Iniciar()){ # acá me conecto
            if($base->Ejecutar($consulta)){ #envío la consulta al gestor de base de datos
                if($registros = $base->Registro()){
                    parent::Buscar($dni);
                    $this->setObjViaje($registros['idviaje']);
                    $this->setNroPasaporte($registros['nroPasaporte']);
                    $resp = true;
                }
            }else{
                $this->getmensajeoperacion($base->getERROR());
            }
        }else{
            $this->getmensajeoperacion($base->getERROR());
        }
        return $resp;
    }

    public function listar($condicion=""){
	    $arreglo = null;
		$base=new BaseDatos();
		$consulta="Select * from pasajero ";
		if ($condicion!=""){
		    $consulta .=' where '.$condicion;
		}
		$consulta.=" order by nroPasaporte ";
		//echo $consultaPersonas;
		if($base->Iniciar()){ /* iniciar la conexión */
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($row2=$base->Registro()){
					$obj=new Pasajero();
					$obj->Buscar($row2['nrodoc']); /* en clases hijas de Persona, buscamos los atributos restantes con Buscar($dni) y los  */
					array_push($arreglo,$obj);
				}
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }	
		 return $arreglo;
	}

    

    /* GETTERS Y SETTERS */

    public function getObjViaje()
    {
        return $this->objViaje;
    }

    public function setObjViaje($objViaje)
    {
        $this->objViaje = $objViaje;
    }

    public function getNroPasaporte()
    {
        return $this->nroPasaporte;
    }

    public function setNroPasaporte($nroPasaporte)
    {
        $this->nroPasaporte = $nroPasaporte;
    }

    public function __toString()
    {
        return parent::__toString()."\n numero de pasaporte: ".$this->getNroPasaporte()."\n".
        "id del viaje a realizar: ".$this->getobjViaje()->getIdViaje();
    }

}