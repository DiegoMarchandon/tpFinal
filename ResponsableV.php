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
        $this->setNrodoc($NroD);
		$this->setNombre($Nom);
		$this->setApellido($Ape);
		$this->setTelefono($NroTel);
        if($numEmpleado != null){
            $this->setNumEmpleado($numEmpleado);
        }
        if($numLicencia != null){
            $this->setNumLicencia($numLicencia);
        }
    }

    public function Buscar($dni){
        $base = new BaseDatos(); #creo la base de datos
        $consulta = "SELECT * FROM empleado WHERE pdocumento=".$dni;
        $resp = false;
        if($base->Iniciar()){ # acá me conecto
            if($base->Ejecutar($consulta)){ #envío la consulta al gestor de base de datos
                if($registros = $base->Registro()){
                    parent::Buscar($dni);
                    $this->setNrodoc()
                }
            }
        }
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