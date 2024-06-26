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
        $this->objEmpresa = null;
        $this->colObjPasajeros = []; /* no */
        $this->objResponsable = null;
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
        $pasajeros = new Pasajero();
        $colPasajeros = $pasajeros->listar('idviaje = '.$this->getIdViaje());
        return $colPasajeros;
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
                    $empresa = new Empresa();
                    $empresa->Buscar($registros['idempresa']);
                    $this->setObjEmpresa($empresa);                    
                    $responsable = new ResponsableV();
                    $this->setObjResponsable($responsable->listar("rnumeroempleado = ".$registros['rnumeroempleado'])[0]);
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
        $consultaViajes = "SELECT * FROM viaje "; /* consulta con la condicion vacía */
        if($condicion != ""){
            $consultaViajes .= ' WHERE '. $condicion;
        }
        $consultaViajes.= ' ORDER BY idviaje;';
    
        if($base->Iniciar()){ /* iniciar la conexión */
            if($base->Ejecutar($consultaViajes)){ #envío la consulta al gestor de base de datos
                $arregloViaje = [];
                while($registros = $base->Registro()){ #mientras la base de datos me devuelva registros, se seguirán recorriendo
                    $objResponsable = new ResponsableV();
                    $objEmpresa = new Empresa();
                    $idviaje = $registros['idviaje'];
                    $destino = $registros['vdestino'];
                    $fecha = $registros['fecha'];
                    $cantmax = $registros['vcantmaxpasajeros'];
                    $idempresa = $registros['idempresa'];
                    $numEmpleado = $registros['rnumeroempleado'];
                    $importe = $registros['vimporte'];
                    #creo una instancia de pasajero para poder acceder a sus métodos
                    $pasajero = new Pasajero();
                    #almaceno en colPasajeros los pasajeros que tengan ese idViaje
                    $colPasajeros = $pasajero->listar('idviaje = '.$this->getIdViaje());
                    $viaje = new Viaje();
                    $responsable = $objResponsable->listar('rnumeroempleado = '.$numEmpleado)[0]; 
                    $objEmpresa->Buscar($idempresa);
                    $viaje->cargar($idviaje,$fecha,$destino,$cantmax,$objEmpresa, $colPasajeros, $responsable,$importe);
                    $arregloViaje[] = $viaje;
                }
            }else $this->setmensajeoperacion($base->getERROR());
        } else $this->setmensajeoperacion($base->getERROR());
        return $arregloViaje;
    }

    /**
     * devuelve la cantidad de pasajeros de un viaje a través de una consulta sql.
     * DUDA sobre implementarlo o no, por ser prácticamente igual al listar() de Pasajero. 
     * */
    /* public function listarPasajeros(){
        $colPasajeros = null;
        $base = new BaseDatos();
        $consultaCantPasajeros = "SELECT * FROM pasajeros WHERE idviaje = ".$this->getIdViaje();
        if($base->Iniciar()){
            if($base->Ejecutar($consultaCantPasajeros)){ #si la consulta se pudo ejecutar...
                $colPasajeros = [];
                while($registros = $base->Registro()){ # se devolverán todos los registros de pasajeros que tengan ese idViaje
                    $pasajero = new Pasajero();
					$pasajero->Buscar($registros['nrodoc']); 
					$colPasajeros[] = $pasajero;
                }
                 
            }else $this->setmensajeoperacion($base->getError());
        }else $this->setmensajeoperacion($base->getError());
        return $colPasajeros;
    } */

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
        $numEmpleado = $this->getObjResponsable()->getNumEmpleado();
        $consultaModificar = "UPDATE viaje SET vdestino= '".$this->getDestino()."', fecha= '".$this->getFecha()."' ,vcantmaxpasajeros=".$this->getCantMaxPasajeros().
        ", idempresa=".$this->getObjEmpresa()->getIdEmpresa().", rnumeroempleado=".$numEmpleado.", vimporte=".$this->getImporte()."
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

    public function eliminar($idviaje){
        $base = new BaseDatos();
        $resp = false;
        if($base->Iniciar()){ # 1) iniciamos la conexión
            $consultaEliminar = "DELETE FROM viaje WHERE idViaje = ".$idviaje.";";
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
        "\n pasajeros: \n".((count($this->getColObjPasajeros()) == 0) ? "\n| No hay pasajeros en el viaje |\n" :
         "Hay ".count($this->getColObjPasajeros())." pasajeros. Sus datos son: \n-----------------------\n".
         $this->arrToString($this->getColObjPasajeros())."\n-----------------------").
        "\n Responsable del viaje: ".$this->getObjResponsable().
        "\n Importe del viaje: $".$this->getImporte();
    }

}

