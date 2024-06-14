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

    public function buscar($dni){
        $base = new BaseDatos(); #creo la base de datos
        $consulta = "SELECT * FROM pasajero WHERE pdocumento=".$dni;
        $resp = false;
        if($base->Iniciar()){ # acá me conecto
            if($base->Ejecutar($consulta)){ #envío la consulta al gestor de base de datos
                if($registros = $base->Registro()){
                    parent::Buscar($dni);
                    $this->setObjViaje($registros['idviaje']);
                    $this->setNroPasaporte($registros['']);
                    /* hasta acá */
                }
            }
        }
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