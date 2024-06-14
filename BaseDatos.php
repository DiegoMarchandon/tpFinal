<?php
/* tiene el objetivo de brindarle a nuestra aplicación 
la conexión entre el motor de base de datos y la aplicación */

class BaseDatos{
/* caracteristicas de una base de datos: */
    private $HOSTNAME; /* lugar físico donde se encuentre. IP de la máquina */
    private $BASEDATOS; /* nombre de la db a acceder (porque podemos tener un montón de db en el host) */
    private $USUARIO; /* credencial */
    private $CLAVE; /* credencial. Me permiten acceder a la DB */
    private $CONEXION;
    private $QUERY;
    private $RESULT;
    private $ERROR;

    /*sin get ni set: result, conexion, query. Sin set: error */

    public function __construct()
    {
        $this->HOSTNAME = "127.0.0.1";
        $this->BASEDATOS = "bdviajes";
        /* credenciales por defecto: */
        $this->USUARIO = "root";
        $this->CLAVE = ""; 
        /* variables instancia utilizadas para guardar información en la implementación de la clase: */
        $this->RESULT = 0; /* guardamos los resultados de la operación realizada en el motor de bd */
        $this->QUERY = ""; /* para almacenar la query ejecutada */
        $this->ERROR = ""; /* guardar información del error que puede ocurrir */
    }

    /**
     * retorna una cadena con una pequeña descripción del error si lo hubiera
     * 
     * @return string
     */
    public function getERROR(){
        return "\n".$this->ERROR;
    }

    public function setERROR($ERROR){
        $this->ERROR = $ERROR;
    }

    /**
     * obtiene el hostname.
     */ 
    public function getHOSTNAME()
    {
        return $this->HOSTNAME;
    }

    /**
     * Setea el valor de HOSTNAME
     */ 
    public function setHOSTNAME($HOSTNAME)
    {
        $this->HOSTNAME = $HOSTNAME;
    }

    /**
     * obtiene la base de datos.
     */ 
    public function getBASEDATOS()
    {
        return $this->BASEDATOS;
    }

    /**
     * setea la base de datos.
     */ 
    public function setBASEDATOS($BASEDATOS)
    {
        $this->BASEDATOS = $BASEDATOS;
    }

    /**
     * obtiene el usuario.
     */ 
    public function getUSUARIO()
    {
        return $this->USUARIO;
    }

    /**
     * Setea el usuario.
     */ 
    public function setUSUARIO($USUARIO)
    {
        $this->USUARIO = $USUARIO;
    }

    /**
     * Obtiene la clave.
     */ 
    public function getCLAVE()
    {
        return $this->CLAVE;
    }

    /**
     * Setea la clave.
     */ 
    public function setCLAVE($CLAVE)
    {
        $this->CLAVE = $CLAVE;
    }

    /**
     * Teniendo los datos anteriores, iniciamos la conexión con el servidor y la base de datos mysql.
     * Retorna True si la conexión con el servidor se pudo establecer y false en caso contrario.
     * @return boolean
     */
    public function Iniciar(){
        $resp = false;
        /* función predefinida de php que le manda a mysql los siguientes datos: */
        $conexion = mysqli_connect($this->getHOSTNAME(),$this->getUSUARIO(),$this->getCLAVE(),$this->getBASEDATOS());
        if($conexion){#cuando se pudo establecer la conexion
            // mysqli_select_db(connection, dbname); connection: especifica la conexión MYSQL a usar. dbname: especifica la base de datos por defecto que se utilizaxrá
            if(mysqli_select_db($conexion,$this->getBASEDATOS())){ #se utiliza para cambiar la base de datos predeterminada para la conexión
                $this->CONEXION = $conexion; #la guardamos en la variable instancia.
                            
                //porqué unset de esas variables
                unset($this->QUERY); #eliminamos estas propiedades porque se pudo establecer una conexión exitosa
                unset($this->ERROR);
                $resp = true;
            }else{#no se pudo cambiar la base de datos.
                #si devuelve FALSE. Puede deberse a: error en la conexión, nombre de db incorrecto, permisos insuficientes, problemas de configuración en mysql
                // $this->ERROR = mysqli_errno($conexion). ": " .mysqli_error($conexion);
                $this->setERROR(mysqli_errno($conexion). ": " .mysqli_error($conexion));
            }
        }else{# no se pudo establecer la conexión
            $this->setERROR(mysqli_errno($conexion). ": " .mysqli_error($conexion));
        }
        return $resp;
    }

    /**
     * Ejecuta una consulta en la Base de Datos. Instrucciones SQL.
     * Recibe la consulta en una cadena enviada por parámetro.
     * @param string $consulta
     * @return boolean
     */
    public function Ejecutar($consulta){
        $resp = false;
        unset($this->ERROR); /* seteamos la variable error para "limpiarla" y almacenar un nuevo error, en caso de que lo hubiera. */
        $this->QUERY = $consulta; /* asignamos la consulta por parámetro a la variable para indicar la query ejecutada */
        // realiza una consulta a la base de datos
        // mysqli_query(mysqli $link, string $query); link: enlace devuelto por mysqli_connect() o mysqli_init(). 
        //  query: string de consulta. Los datos dentro de la consulta deberían estar adecuadamente escapados (https://www.php.net/manual/es/mysqli.real-escape-string.php).
        if($this->RESULT = mysqli_query($this->CONEXION,$consulta)){ #accedemos a esta conexion y ejecutamos la consulta.
            $resp = true; /* se pudo ejecutar la consulta */
        }else{
            $this->setERROR(mysqli_errno($this->CONEXION). ": " .mysqli_error($this->CONEXION));
        }
        return $resp;
    }

    /**
     * Devuelve un registro retornado por la ejecución de una consulta.
     * El puntero se desplaza al siguiente registro de la consulta.
     * 
     *  
     */
    public function Registro(){
        $resp = null;
        if($this->RESULT){
            unset($this->ERROR);
            // mysqli_fetch_assoc(result); obtiene una fila de resultados como arreglo asociativo
            // result: Necesario. identificadores de resultados devueltos por mysqli_query(), mysqli_store_result() o mysqli_use_result()
            $temp = mysqli_fetch_assoc($this->RESULT);
                if($temp){
                $resp = $temp;
            }else{
                // liberamos la memoria asociada al resultado. Se hace cuando el objeto resultado ya no es necesario.
                mysqli_free_result($this->RESULT);
            }
        }else{
            $this->setERROR(mysqli_errno($this->CONEXION). ": " .mysqli_error($this->CONEXION));
                
        }
        return $resp;
    }

    /**
     * Devuelve el id de un campo autoincrement utilizado como clave de una tabla.
     * Retorna el id numerico del registro insertado. Devuelve null en caso de que la ejecución de la consulta falle.
     * Cada vez que insertemos un registro en esa tabla el valor que se va a insertar es consecutivo al que se insertó.
     * @param string $consulta;
     * @return int id de la tupla insertada 
     */
    public function devuelveIDInsercion($consulta){ #utilizada cuando hacemos una inserción y una de sus columnas es un autoincrement
        $resp = null;
        unset($this->ERROR);
        $this->QUERY = $consulta;
        if($this->RESULT = mysqli_query($this->CONEXION,$consulta)){
            $id = mysqli_insert_id($this->CONEXION); #obtenemos el ultimo id y lo guardamos en una variable
            $resp = $id;
        }else{
            $this->setERROR(mysqli_errno($this->CONEXION). ": " .mysqli_error($this->CONEXION));
        }
        return $resp;
    }

}

?>