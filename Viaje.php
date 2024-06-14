<?php

class Viaje{
    
    private $idViaje;
    private $destino;
    private $cantMaxPasajeros;
    private $objEmpresa; /* idEmpresa */
    private $colObjPasajeros;
    private $objResponsable; /* numEmpleado */
    private $importe;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idViaje = 0; /* no */
        $this->destino ="";
        $this->cantMaxPasajeros = "";
        // $this->objEmpresa = "";
        $this->colObjPasajeros = []; /* no */
        // $this->objResponsable = "";
        $this->importe = "";
    }

    /* GETTERS Y SETTERS */

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

    /* MÉTODOS SQL INSERTAR, MODIFICAR, ELIMINAR */

    public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO viaje(vdestino,vcantmaxpasajeros,idempresa,rnumeroempleado,vimporte) 
        VALUES ("."'".$this->getDestino()."',".$this->getCantMaxPasajeros().",".$this->getObjEmpresa()->getIdEmpresa().",".$this->getObjResponsable()->getNumEmpleado().",".$this->getImporte().");";

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

    public function modificar(){
        $base = new BaseDatos();
        $resp = false;
        $consultaModificar = "UPDATE viaje SET vdestino='".$this->getDestino()."',vcantmaxpasajeros=".$this->getCantMaxPasajeros().
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
        "\n Cantidad maxima de pasajeros: ".$this->getCantMaxPasajeros().
        "\n id de la empresa: ".$this->getObjEmpresa()->getIdEmpresa().
        "pasajeros: \n".$this->arrToString($this->getColObjPasajeros()).
        "\n Responsable del viaje: ".$this->getObjResponsable().
        "\n Importe del viaje: ".$this->getImporte();
    }


}