<?php

class Pasajero extends Persona{
    
    private $objViaje;
    private $nroPasaporte;

    public function __construct()
    {
        parent::__construct();
        $this->objViaje = null;
        $this->nroPasaporte = '';
    }

    /* METODOS INSERTAR, MODIFICAR Y ELIMINAR */

    public function cargar($NroD,$Nom,$Ape,$NroTel, $objViaje = null, $nroPasaporte = null){
        parent::cargar($NroD,$Nom,$Ape,$NroTel);
        if($objViaje != null){
            $this->setObjViaje($objViaje);
        }
        if($nroPasaporte != null){
            $this->setNroPasaporte($nroPasaporte);
        }
    }

    /**
	 * Recupera los datos de una persona por dni (por ser su dato único)
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */	

    public function Buscar($dni){
        $base = new BaseDatos(); #creo la base de datos
        $consulta = "SELECT * FROM pasajero WHERE pdocumento=".$dni;
        $resp = false;
        if($base->Iniciar()){ # acá me conecto
            if($base->Ejecutar($consulta)){ #envío la consulta al gestor de base de datos
                if($registros = $base->Registro()){
                    parent::Buscar($dni);
                    $viaje = new Viaje();
                    $viaje->Buscar($registros['idviaje']);
                    $this->setObjViaje($viaje);
                    $this->setNroPasaporte($registros['nroPasaporte']);
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
		$base=new BaseDatos();
		$consulta="Select * from pasajero ";
		if ($condicion!=""){
		    $consulta .=' where '.$condicion;
		}
		$consulta.=" order by nroPasaporte ";

        if($base->Iniciar()){ 
		    if($base->Ejecutar($consulta)){				
			    $arreglo= array();
				while($registros=$base->Registro()){
					$obj = new Pasajero();
					$obj->Buscar($registros['pdocumento']); 
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

    public function insertar(){
        $base = new BaseDatos();
        $resp = false;

        $consultaInsertar = "INSERT INTO pasajero VALUES (".$this->getNrodoc().",".$this->getObjViaje()->getIdViaje().",".$this->getNroPasaporte().")";

        if ($base->Iniciar()){
            parent::insertar();
            if ($base->Ejecutar($consultaInsertar)){
                $resp = true;
            } else $this->setmensajeoperacion($base->getERROR());
        } else $this->setmensajeoperacion($base->getERROR());

        return $resp;
    }

    public function modificar(){
        $base = new BaseDatos();
        $resp = false;

        $consultaModificar = "UPDATE pasajero SET idviaje=".$this->getObjViaje()->getIdViaje().", nroPasaporte=".$this->getNroPasaporte().
        " WHERE pdocumento = " . $this->getNrodoc();

        if ($base->Iniciar()){
            parent::modificar();
            if ($base->Ejecutar($consultaModificar)){
                $resp = true;
            } else $this->setmensajeoperacion($base->getERROR());
        } else $this->setmensajeoperacion($base->getERROR());

        return $resp;
    }

    public function eliminar(){
        $resp = false;
        if(parent::eliminar()){
            $resp = true;
        }
        return $resp;
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
        "id del viaje a realizar: ".$this->getObjViaje()->getIdViaje();
    }

}