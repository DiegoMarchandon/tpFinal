<?php

class Viaje{
    private $idViaje;
    private $fecha;
    private $destino;
    private $cantMaxPasajeros;
    private $objEmpresa; /* idEmpresa */
    private $colObjPasajeros; /* resultado de la consulta listar() con select from pasajeros where idViaje = $this...*/
    private $objResponsable; /* numEmpleado */
    private $importe;
    private $mensajeoperacion;

    #la coleccion de pasajeros que nos va a devolver el listar es lo que vamos a setear como atributos de la coleccion de pasajeros

    public function __construct()
    {
        $this->idViaje = 0; /* no */
        $this->fecha;
        $this->destino ="";
        $this->cantMaxPasajeros = "";
        // $this->objEmpresa = "";
        $this->colObjPasajeros = []; /* no */
        // $this->objResponsable = "";
        $this->importe = "";
    }

    /* GETTERS Y SETTERS */

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function getIdViaje()
    {
        return $this->idViaje;
    }

    public function setIdViaje($idViaje)
    {
        $this->idViaje = $idViaje;
    }

    public function getColObjPasajeros()
    {
        return $this->colObjPasajeros;
    }

    public function setColObjPasajeros($colObjPasajeros)
    {
        $this->colObjPasajeros = $colObjPasajeros;
    }

    public function getObjResponsable()
    {
        return $this->objResponsable;
    }

    public function setObjResponsable($objResponsable)
    {
        $this->objResponsable = $objResponsable;
    }

    public function arrToString($coleccion){

        $string = "";
        foreach($coleccion as $elem){
            $string .= $elem."\n";
        }
        return $string;
    }

    public function getMensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setMensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function getDestino()
    {
        return $this->destino;
    }
 
    public function setDestino($destino)
    {
        $this->destino = $destino;
    }

    public function getCantMaxPasajeros()
    {
        return $this->cantMaxPasajeros;
    }

    public function setCantMaxPasajeros($cantMaxPasajeros)
    {
        $this->cantMaxPasajeros = $cantMaxPasajeros;
    }

    public function getObjEmpresa()
    {
        return $this->objEmpresa;
    }

    public function setObjEmpresa($objEmpresa)
    {
        $this->objEmpresa = $objEmpresa;
    }

    public function getImporte()
    {
        return $this->importe;
    }
 
    public function setImporte($importe)
    {
        $this->importe = $importe;
    }

    public function cargar($idViaje, $fecha, $destino, $cantMaxPasajeros, $objEmpresa, $colObjPasajeros, $objResponsable, $importe){
        $this->setIdViaje($idViaje);
        $this->setFecha($fecha);
        $this->setDestino($destino);
        $this->setCantMaxPasajeros($cantMaxPasajeros);
        $this->setObjEmpresa($objEmpresa);
        $this->setColObjPasajeros($colObjPasajeros);
        $this->setObjResponsable($objResponsable);
        $this->setImporte($importe);
    }


    /**
	 * Recupera los datos de un viaje por id (por ser su dato único)
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */	
    public function Buscar($id){
        $base=new BaseDatos();
		$consultaViaje="SELECT * FROM viaje WHERE idViaje=".$id;
		$resp= false;   

        if($base->Iniciar()){#para cualquier acción que vaya a realizar, lo primero que necesito es establecer una conexión
            if($base->Ejecutar($consultaViaje)){
                if($registros = $base->Registro()){
                    $this->setIdViaje($registros['idviaje']);
                    $this->setDestino($registros['vdestino']);
                    $this->setFecha($registros['fecha']);
                    $this->setCantMaxPasajeros($registros['vcantmaxpasajeros']);
                    $this->setObjEmpresa($registros['idempresa']);
                    $this->setObjResponsable($registros['rnumeroempleado']);
                    $this->setImporte($registros['vimporte']);
                    $resp = true;
                }
            }else{
                $this->setMensajeoperacion($base->getError());    
            }
        }else{
            $this->setMensajeoperacion($base->getError());
        }
        return $resp;
    }


    /**
	 * podemos buscar a todos los viajes que cumplan determinada condicion 
	 * que dependerá de lo que queremos listar.
	 * la condicion vacía (la que está por defecto) devolverá la consulta ya almacenada en consultaInsertar
	 */
    public function listar($condicion = ""){
        $arregloViaje = null;
        $base = new BaseDatos();
        $consultaViajes = "SELECT * FROM viaje"; /* consulta con la condicion vacía */
        if($condicion != ""){
            $consultaViajes .= 'WHERE '. $condicion;
        }
        $consultaViajes.= 'ORDER BY idviaje';
    
        if($base->Iniciar()){ /* iniciar la conexión */
            if($base->Ejecutar($consultaViajes)){
                $arregloViaje = array();
                while($registros = $base->Registro()){ #mientras la base de datos me devuelva registros, se seguirán recorriendo
                    $idviaje = $registros['idviaje'];
                    $destino = $registros['destino'];
                    $fecha = $registros['fecha'];
                    $cantmax = $registros['vcantmaxpasajeros'];
                    $idempresa = $registros['idempresa'];
                    $numEmpleado = $registros['rnumeroempleado'];
                    $importe = $registros['vimporte'];
                    #la coleccion de pasajeros que nos va a devolver el listar es lo que vamos a setear como atributos de la coleccion de pasajeros
                    /* $cantPasajeros = utilizar el count */
                    $viaje = new Viaje();
                    $viaje->cargar($idviaje,$fecha,$destino,$cantmax,$idempresa);
                }
            }
        }
    }

    /* MÉTODOS SQL INSERTAR, MODIFICAR, ELIMINAR */

    public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO viaje(vdestino, fecha ,vcantmaxpasajeros,idempresa,rnumeroempleado,vimporte) 
        VALUES ("."'".$this->getDestino()."', '".$this->getFecha()."' ,".$this->getCantMaxPasajeros().",".$this->getObjEmpresa()->getIdEmpresa().",".$this->getObjResponsable()->getNumEmpleado().",".$this->getImporte().");";

        /*1) si se inicia la conexión*/
        if($base->Iniciar()){

            if($id = $base->devuelveIDInsercion($consultaInsertar)){/* si se ejecuta la consulta */
                $this->setIdViaje($id);
                $resp = true;
            }else{/* si no se ejecuta la consulta */
                $this->setMensajeoperacion($base->getERROR());
            }
        }else{/* si no se inicia la conexión */
            $this->setMensajeoperacion($base->getERROR());
        }
        return $resp;
    }

    /* hacer que se puedan pedir modificaciones personalizadas*/
    public function modificar(){
        $base = new BaseDatos();
        $resp = false;
        $consultaModificar = "UPDATE viaje SET vdestino= '".$this->getDestino()."', fecha= '".$this->getFecha()."' ,vcantmaxpasajeros=".$this->getCantMaxPasajeros().
        ", idempresa=".$this->getObjEmpresa()->getIdEmpresa().", rnumeroempleado=".$this->getObjResponsable()->getNumEmpleado().", vimporte=".$this->getImporte()."
        WHERE idViaje = ".$this->getIdViaje().";";
        if($base->iniciar()){ # 1) iniciamos la conexión
            if($base->Ejecutar($consultaModificar)){#ejecutamos la consulta
                $resp = true;
            }else{
                $this->setMensajeoperacion($base->getERROR()); #si no se pudo ejecutar la consulta
            }
        }else{
            $this->setMensajeoperacion($base->getERROR()); #si no se pudo iniciar la conexión
        }
        return $resp;
    }

    public function eliminar(){
        $base = new BaseDatos();
        $resp = false;
        if($base->Iniciar()){ # 1) iniciamos la conexión
            $consultaEliminar = "DELETE FROM viaje WHERE idViaje = ".$this->getIdViaje().";";
            if($base->Ejecutar($consultaEliminar)){#ejecutamos la consulta
                $resp = true;
            }else{
                $this->setMensajeoperacion(($base->getERROR()));
            }
        }else{
            $this->setMensajeoperacion($base->getERROR());
        }
        return $resp;
    }

    public function __toString()
    {
        return "id del viaje: ".$this->getIdViaje()."\n Destino: ".$this->getDestino().
        "\n Fecha: ".$this->getFecha().
        "\n Cantidad maxima de pasajeros: ".$this->getCantMaxPasajeros().
        "\n id de la empresa: ".$this->getObjEmpresa()->getIdEmpresa().
        "pasajeros: \n".$this->arrToString($this->getColObjPasajeros()).
        "\n Responsable del viaje: ".$this->getObjResponsable().
        "\n Importe del viaje: ".$this->getImporte();
    }

}