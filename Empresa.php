<?php

class Empresa{
    private $idEmpresa;
    private $nombre;
    private $direccion;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idEmpresa = 0;
        $this->nombre = "";
        $this->direccion = "";
    }

    /* GETTERS Y SETTERS */

    public function getIdEmpresa()
    {
        return $this->idEmpresa;
    }

    public function setIdEmpresa($idEmpresa)
    {
        $this->idEmpresa = $idEmpresa;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setMensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    /* MÉTODOS SQL INSERTAR, MODIFICAR, ELIMINAR */

    public function cargar($idEmpresa, $nombre,$direccion){
        $this->setIdEmpresa($idEmpresa);
        $this->setNombre($nombre);
        $this->setDireccion($direccion);
    }

    /* utilizo a buscar exclusivamente para buscar a la empresa por id en lugar de modificar los datos. */
    public function Buscar($idEmpresa){
        $base = new BaseDatos(); 
        $consultaEmpresa = "SELECT * FROM empresa WHERE idEmpresa = ".$idEmpresa;
        $resp = false;
        if($base->Iniciar()){ #para cualquier consulta, lo que necesito hacer primero es establacer una conexión.
            if($base->Ejecutar($consultaEmpresa)){ #envío la consulta al gestor de base de datos
                if($registros =$base->Registro()){	 # registro devolverá un arreglo asociativo
				    $this->cargar($idEmpresa, $registros['enombre'], $registros['edireccion']);
					$resp= true;
				}
                
            }else $this->setmensajeoperacion($base->getError());   
        }else $this->setmensajeoperacion($base->getError());
        
        return $resp;
    }

    	/**
	 * podemos buscar a todas las empresas que cumplan determinada condicion 
	 * que dependerá de lo que queremos listar.
	 * la condicion vacía (la que está por defecto) devolverá todas las empresas
	 */
	public function listar($condicion=""){
	    $arregloEmpresa = null;
		$base=new BaseDatos();
		$consultaEmpresas="Select * from empresa "; /* consulta con la condicion vacía */
		if ($condicion!=""){
		    $consultaEmpresas .= ' where '.$condicion;
		}
		// $consultaEmpresas.=" order by idempresa ";
		
		if($base->Iniciar()){/* iniciar la conexión */
			if($base->Ejecutar($consultaEmpresas)){				 /* ejecutar la consulta */
				$arregloEmpresa= array();
				while($registros=$base->Registro()){ #mientras la base de datos me devuelva registros, se seguirán recorriendo
					
					$empresa=new Empresa();
					$empresa->Buscar($registros['idempresa']);
					array_push($arregloEmpresa,$empresa);
	
				}
		 	}else{
		 		$this->setmensajeoperacion($base->getError());
			}
		 }else{
		 	$this->setmensajeoperacion($base->getError());
		 }	
		 return $arregloEmpresa; #n registros que cumplen la condicion
	}	

    public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO empresa(enombre, edireccion) VALUES('".$this->getNombre()."','".$this->getDireccion()."');";

        if($base->Iniciar()){
            if($id = $base->devuelveIDInsercion($consultaInsertar)){
                $this->setIdEmpresa($id);
                $resp = true;
            }else{
                $this->setMensajeoperacion($base->getERROR());
            }
        }else{
            $this->setMensajeoperacion($base->getERROR());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $consulta="UPDATE empresa SET enombre = '".$this->getNombre()."', edireccion = '".$this->getDireccion()."';"; /* WHERE idEmpresa = ".$this->getIdEmpresa(); */

        if($base->Iniciar()){ #iniciamos la conexión
            if($base->Ejecutar($consulta)){
                $resp = true;
            }else{
                $this->setMensajeoperacion($base->getERROR());
            }
        }else{
            $this->setMensajeoperacion($base->getERROR());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();                                    
        $consultaEliminar = "DELETE FROM empresa WHERE idEmpresa = ".$this->getIdEmpresa();

        if($base->Iniciar()){
            if($base->Ejecutar($consultaEliminar)){
                $resp = true;
            }else{
                $this->setMensajeoperacion($base->getERROR());
            }
        }else{
            $this->setMensajeoperacion($base->getERROR());
        }
        return $resp;
    }

    public function __toString()
    {
        return "id empresa: ".$this->getIdEmpresa()."\n".
        "nombre empresa: ".$this->getNombre()."\n".
        "direccion: ".$this->getDireccion();
    }

    
}