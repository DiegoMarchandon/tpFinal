<?php
include_once "BaseDatos.php";
class Persona{

	private $nrodoc;
	private $nombre;
	private $apellido;
	private $telefono;
	private $mensajeoperacion;

	public function __construct(){
		
		$this->nrodoc = "";
		$this->nombre = "";
		$this->apellido = "";
		$this->telefono = "";
	}

	public function cargar($NroD,$Nom,$Ape,$NroTel){		
		$this->setNrodoc($NroD);
		$this->setNombre($Nom);
		$this->setApellido($Ape);
		$this->setTelefono($NroTel);
    }
	
	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
	public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
    public function setNrodoc($NroDNI){
		$this->nrodoc=$NroDNI;
	}
	public function setNombre($Nom){
		$this->nombre=$Nom;
	}
	public function setApellido($Ape){
		$this->apellido=$Ape;
	}
	
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
	
	public function getNrodoc(){
		return $this->nrodoc;
	}
	public function getNombre(){
		return $this->nombre ;
	}
	public function getApellido(){
		return $this->apellido ;
	}
	
    public function getTelefono()
    {
        return $this->telefono;
    }

	/**
	 * Recupera los datos de una persona por dni (por ser su dato único)
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($dni){
		$base=new BaseDatos();
		$consultaPersona="SELECT * FROM persona WHERE nroDoc=".$dni;
		$resp= false;
		if($base->Iniciar()){#para cualquier acción que vaya a realizar, lo primero que necesito es establecer una conexión
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){	 # registro devolverá un arreglo asociativo
				    $this->setNrodoc($dni); #$this->setNrodoc($row['nrodoc]);
					$this->setNombre($row2['nombre']);
					$this->setApellido($row2['apellido']);
					$this->setTelefono($row2['nroTelefono']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
    

	/**
	 * podemos buscar a todas las personas que cumplan determinada condicion 
	 * que dependerá de lo que queremos listar.
	 * la condicion vacía (la que está por defecto) devolverá la consulta ya almacenada en consultaPersonas
	 */
	public function listar($condicion=""){
	    $arregloPersona = null;
		$base=new BaseDatos();
		$consultaPersonas="Select * from persona "; /* consulta con la condicion vacía */
		if ($condicion!=""){
		    $consultaPersonas=$consultaPersonas.' where '.$condicion;
		}
		$consultaPersonas.=" order by apellido ";
		//echo $consultaPersonas;
		if($base->Iniciar()){/* iniciar la conexión */
			if($base->Ejecutar($consultaPersonas)){				 /* ejecutar la consulta */
				$arregloPersona= array();
				while($row2=$base->Registro()){ #mientras la base de datos me devuelva registros, se seguirán recorriendo
					
					$NroDoc=$row2['nroDoc'];
					$Nombre=$row2['nombre'];
					$Apellido=$row2['apellido'];
					$nroTel=$row2['nroTelefono'];
					$perso=new Persona();
					$perso->cargar($NroDoc,$Nombre,$Apellido,$nroTel); /* en persona (clase padre) cargamos los datos en el arreglo.*/
					array_push($arregloPersona,$perso);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloPersona; #n registros que cumplen la condicion
	}	
	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO persona(nrodoc, apellido, nombre, nroTelefono) 
				VALUES (".$this->getNrodoc().",'".$this->getApellido()."','".$this->getNombre()."',".$this->getTelefono().")";
		
		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){

			    $resp=  true;

			}	else {
					$this->setmensajeoperacion($base->getError());		
			}
		} else {
				$this->setmensajeoperacion($base->getError());
		}
		return $resp;
	}
	
	
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE persona SET apellido='".$this->getApellido()."',nombre='".$this->getNombre().",nroTelefono=".$this->getTelefono().
		" WHERE nrodoc=". $this->getNrodoc();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM persona WHERE nrodoc=".$this->getNrodoc();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}

	public function __toString(){
	    return "\nNombre: ".$this->getNombre(). "\n Apellido:".$this->getApellido()."\n DNI: ".$this->getNrodoc()."\n Telefono: ".$this->getTelefono();
			
	}
}
?>
