<?php
/* NOTAS 

revisar el "método de seguridad". Porque el id sigue autoincrementándose y el método me deja cambiar datos igual

*/


/* 1. Ejecute el script sql provisto para crear la base de datos bdviajes y sus tablas.

2. Implementar dentro de la clase TestViajes una operación que permita ingresar, modificar
y eliminar la información de la empresa de viajes.

3. Implementar dentro de la clase TestViajes una operación que permita ingresar, modificar
y eliminar la información de un viaje, teniendo en cuenta las particularidades expuestas
en el dominio a lo largo del cuatrimestre. */
include 'Persona.php';
include 'Empresa.php';
include 'Pasajero.php';
include 'ResponsableV.php';
include 'Viaje.php';
// include_once 'Datos.php';

/* generador de caracteres random */
$caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 

/* --------------------------------- REPONSABLES PRECARGADOS ------------------------------------------------------------ */

/* 
$persona1 = new Persona();
$persona1->cargar(42539876,"jorge","rodriguez",299432123);
$persona1->insertar();
$responsable1 = new ResponsableV();
$responsable1->cargar($persona1->getNrodoc(),$persona1->getNombre(),$persona1->getApellido(),$persona1->getTelefono(),682,7070);
$insercion1 = $responsable1->insertar();

$persona2 = new Persona();
$persona2->cargar(41321642,"luis","ramirez",298456432);
$persona2->insertar();
$responsable2 = new ResponsableV();
$responsable2->cargar($persona2->getNrodoc(),$persona2->getNombre(),$persona2->getApellido(),$persona2->getTelefono(),359,8888);
$insercion2 = $responsable2->insertar();

$persona3 = new Persona();
$persona3->cargar(43120306,"pedro","sanchez",299143543);
$persona3->insertar();
$responsable3 = new ResponsableV();
$responsable3->cargar($persona3->getNrodoc(),$persona3->getNombre(),$persona3->getApellido(),$persona3->getTelefono(),787,1230);
$insercion3 = $responsable3->insertar();

$persona4 = new Persona();
$persona4->cargar(42980781,"blas","parera",299694362);
$persona4->insertar();
$responsable4 = new ResponsableV();
$responsable4->cargar($persona4->getNrodoc(),$persona4->getNombre(),$persona4->getApellido(),$persona4->getTelefono(),890,5531);
$insercion4 = $responsable4->insertar();

$persona5 = new Persona();
$persona5->cargar(42984421,"juan","nandez",297654933);
$persona5->insertar();
$responsable5 = new ResponsableV();
$responsable5->cargar($persona5->getNrodoc(),$persona5->getNombre(),$persona5->getApellido(),$persona5->getTelefono(),743,5839);
$insercion5 = $responsable5->insertar();

$persona6 = new Persona();
$persona6->cargar(43214265,"jose","manuel",298463218);
$persona6->insertar();
$responsable6 = new ResponsableV();
$responsable6->cargar($persona6->getNrodoc(),$persona6->getNombre(),$persona6->getApellido(),$persona6->getTelefono(),348,9537);
$insercion6 = $responsable6->insertar();

$persona7 = new Persona();
$persona7->cargar(43002932,"miguel","soria",298949823);
$persona7->insertar();
$responsable7 = new ResponsableV();
$responsable7->cargar($persona7->getNrodoc(),$persona7->getNombre(),$persona7->getApellido(),$persona7->getTelefono(),442,5847);
$insercion7 = $responsable7->insertar();

$persona8 = new Persona();
$persona8->cargar(41219004,"samuel","hernandez",299894887);
$persona8->insertar();
$responsable8 = new ResponsableV();
$responsable8->cargar($persona8->getNrodoc(),$persona8->getNombre(),$persona8->getApellido(),$persona8->getTelefono(),263,9843);
$insercion8 = $responsable8->insertar();

 */
// echo $responsable1->listar('rnumeroempleado = 496')[0]->getNumEmpleado();

/* ------------------------------------------------------------------------------------------------------------------------------------------- */
function solicitarNumeroEntre($min, $max){
    //int $numero
    $numero = trim(fgets(STDIN));

    while (!(is_numeric($numero) && ($numero >= $min && $numero <= $max))) {
        echo "Debe ingresar un número entre " . $min . " y " . $max . ": ";
        $numero = trim(fgets(STDIN));
        if (is_numeric($numero)) {
            $numero  = $numero * 1;
        }
    }
    return $numero;
}



function menuPrincipal(){
    echo "|------------------------------------------------------------------|\n".
"|             Bienvenido. Qué desea hacer?                         |\n".
"|------------------------------------------------------------------|\n".
"|(1) Acceder a EMPRESA           ||(4) Acceder a RESPONSABLES      |\n".
"|(2) Acceder a VIAJES            ||(5) Salir                       |\n".
"|(3) Acceder a PASAJEROS                                           |\n".
"|__________________________________________________________________|\n".
" Respuesta: ";
    $opcion = solicitarNumeroEntre(1, 5);
    return $opcion;
}

function menuEmpresa(){
    echo "\n|------------------------------------------------------------------|\n".
"|                       MENÚ DE EMPRESA                            |\n".
"|------------------------------------------------------------------|\n".
"|(1) Ingresar una empresa           ||(4) Ver datos de la empresa  |\n".
"|(2) Modificar empresa              ||(5) Volver atrás             |\n".
"|(3) Eliminar empresa                                              |\n".
"|__________________________________________________________________|\n".
" Respuesta: ";
    $opcion = solicitarNumeroEntre(1, 5);
    return $opcion;
}

function menuViajes(){
    echo "\n|------------------------------------------------------------------|\n".
"|                        MENÚ DE VIAJES                            |\n".
"|------------------------------------------------------------------|\n".
"|(1) Ingresar un viaje           ||(4) Ver viajes                  |\n".
"|(2) Modificar un viaje          ||(5) Buscar un viaje             |\n".
"|(3) Eliminar un viaje           ||(6) Volver atrás                |\n".
"|__________________________________________________________________|\n".
" Respuesta: ";
    $opcion = solicitarNumeroEntre(1, 6);
    return $opcion;
}

function menuModificarViaje()
{
    echo "\n|---------------------------------------------------------------------------------|\n" .
    "|                           MENU MODIFICAR VIAJE                                  |\n" .
    "|---------------------------------------------------------------------------------|\n" .
    "|(1) Modificar destino                       ||(4) Modificar responsable          |\n" .
    "|(2) Modificar cantidad máxima de pasajeros  ||(5) Modificar importe              |\n" .
    "|(3) Modificar fecha                         ||(6) Volver atrás                   |\n" .
    "|_________________________________________________________________________________|\n" .
    " Respuesta: ";
    $opcion = solicitarNumeroEntre(1, 6);
    return $opcion;
}

function menuPasajeros(){
    echo "\n|------------------------------------------------------------------|\n".
"|                        MENÚ DE PASAJEROS                         |\n".
"|------------------------------------------------------------------|\n".
"|(1) Ingresar un pasajero           ||(4) Ver pasajeros            |\n".
"|(2) Modificar un pasajero          ||(5) Buscar un pasajero       |\n".
"|(3) Eliminar un pasajero           ||(6) Volver atrás             |\n".
"|__________________________________________________________________|\n".
" Respuesta: ";
    $opcion = solicitarNumeroEntre(1, 6);
    return $opcion;
}

function menuModificarPasajeros()
{
    echo "\n|------------------------------------------------------------------|\n" .
    "|                      MENU MODIFICAR PASAJERO                     |\n" .
    "|------------------------------------------------------------------|\n" .
    "|(1) Modificar nombre         ||(4) Modificar id de viaje          |\n" .
    "|(2) Modificar apellido       ||(5) Modificar número de pasaporte  |\n" .
    "|(3) Modificar teléfono       ||(6) Volver atrás                   |\n" .
    "|__________________________________________________________________|\n" .
    " Respuesta: ";
    $opcion = solicitarNumeroEntre(1, 6);
    return $opcion;
}

function menuResponsables(){
    echo "\n|------------------------------------------------------------------|\n".
"|                      MENÚ DE RESPONSABLES                        |\n".
"|------------------------------------------------------------------|\n".
"|(1) Ingresar un responsable        ||(4) Ver responsables         |\n".
"|(2) Modificar un responsable       ||(5) Buscar un responsable    |\n".
"|(3) Eliminar un responsable        ||(6) Volver atrás             |\n".
"|__________________________________________________________________|\n".
" Respuesta: ";
    $opcion = solicitarNumeroEntre(1, 6);
    return $opcion;
}

function menuModificarResponsable()
{
    echo "\n|------------------------------------------------------------------|\n" .
    "|                      MENÚ MODIFICAR RESPONSABLE                        |\n".
    "|------------------------------------------------------------------|\n".
    "|(1) Modificar nombre         ||(4) Modificar número de empleado   |\n" .
    "|(2) Modificar apellido       ||(5) Modificar número de licencia   |\n" .
    "|(3) Modificar teléfono       ||(6) Volver atrás                   |\n" .
    "|__________________________________________________________________|\n" .
    " Respuesta: ";
    $opcion = solicitarNumeroEntre(1, 6);
    return $opcion;
}

function leer($mensaje){
    echo $mensaje;
    $rta = trim(fgets(STDIN));
    return $rta;
}

$objViaje = new Viaje();
$objPersona = new Persona();
$objResponsable = new ResponsableV();
$objPasajero = new Pasajero();
$empresaViajes = new Empresa();

$resps = $objResponsable->listar('rnumeroempleado = 226');
foreach($resps as $responsable){
    echo $responsable->getNumEmpleado()."\n---";
} 
do{
    $respuesta = menuPrincipal();
    switch($respuesta){
        case 1:
            do{
                $opcionEmpresa = menuEmpresa();
                switch ($opcionEmpresa){
                    case 1:
                        // Acceder a LA empresa
                        // necesitamos sí o sí una empresa creada para acceder a sus métodos (o nos van a dar todos error),
                            //  por lo que siempre nos mostrará el mensaje de "Empresa existente".
                        if(count($empresaViajes->listar()) == 0){
                            $nombre = leer("ingrese el nombre de la empresa: ");
                            $direccion = leer("ingrese la direccion de la empresa: ");
                            $empresaViajes->cargar(null, $nombre,$direccion); #cargo los datos en la clase
                            $resultado = $empresaViajes->insertar();
                            if($resultado){
                                echo "datos cargados correctamente.\n";
                                $arrDatosEmpresa = $empresaViajes->listar(); /* con la condicion vacía listaba todas las empresas. Como tenemos una sola da lo mismo. */
                                foreach($arrDatosEmpresa as $dato){
                                    echo $dato;
                                    echo "\n-------------------------------------------------------";
                                }
                            }
                        }else $respuesta = leer("ya hay una empresa existente. Desea modificar sus datos? si/no: ");
                            if(strcasecmp($respuesta, "si") == 0){
                                goto modificar; /* El operador goto puede ser usado para saltar a otra sección en el programa (https://www.php.net/manual/es/control-structures.goto.php)*/
                            }
                        
                        break;
                    case 2:
                        // modificar una empresa
                        
                        modificar: /* punto de destino especificado */
                        if(count($empresaViajes->listar()) <> 0){
                            $rta1 = leer("desea modificar el nombre ? si/no: ");
                            if (strcasecmp($rta1, "si") == 0) {
                                $newNombre = leer("ingrese el nuevo nombre: ");
                                $empresaViajes->setNombre($newNombre);
                                // $empresaViajes->modificar();
                            }
                            $rta2 = leer("desea modificar la direccion ? si/no: ");
                            if (strcasecmp($rta2, "si") == 0) {
                                $newDireccion = leer("ingrese la nueva dirección: ");
                                $empresaViajes->setDireccion($newDireccion);
                            }
                            $empresaViajes->modificar();
                            if ((strcasecmp($rta1, "si") != 0) && (strcasecmp($rta2, "si") != 0)) {
                                echo "No se modificó ningún dato.";
                            }
                        }else echo "no se pueden modificar datos porque no existe ninguna empresa. ";
                        
                        break;
                    case 3:
                        // eliminar LA empresa
                        if(count($empresaViajes->listar()) <> 0){
                            $rta = leer("ADVERTENCIA. Si elimina la empresa, se eliminarán los viajes asociados. Desea continuar ? si/no: ");
                            if(strcasecmp($rta, "si") == 0){
                                if($empresaViajes->eliminar()){ #con ponerlo acá ya se ejecuta
                                    echo "empresa eliminada.";
                                }else echo "no se ha podido eliminar.";
                            }
                        }else echo "no se puede eliminar la empresa sin antes crearla.";

                        break;
                    case 4:
                        // ver datos de empresa
                        if(count($empresaViajes->listar()) <> 0){

                            $idEmpresa = leer("como método de seguridad, ingrese el id de empresa: ");
                            if($empresaViajes->Buscar($idEmpresa)){
                                $coleccion = $empresaViajes->listar();
                                    foreach($coleccion as $dato){
                                        echo $dato;
                                    }
                            }else echo "id incorrecto. ";
                            
                        }else echo "no hay datos para ver, porque no existe ninguna empresa. ";

                    break;
                }
            } while ($opcionEmpresa <> 5);
            break;

        case 2:
            do{
                $opcionViajes = menuViajes();
                switch($opcionViajes){
                    case 1:
                        // ingresar un viaje
                        if(count($empresaViajes->listar()) <> 0){
                            /* NOT NULL destino, cantMaxPasajeros, responsable, fecha*/
                            $destino = leer("ingrese un destino: ");
                            $cantMaxPasajeros = leer("ingrese una cantidad máxima de pasajeros para el viaje: ");
                            $fechaViaje = leer("ingrese la fecha del viaje (Formato YYYY-MM-DD): ");
                            $colViajes = $objViaje->listar();
                            $colResponsables = $objResponsable->listar(); 
                            if(count($colResponsables) > 0){

                                echo "seleccione un numero de empleado del responsable del viaje. Los que se encuentran disponibles son: \n";
                                if(count($objViaje->listar()) <> 0){
                                    // procedimiento para insertar un responsable que no esté asociado a un viaje:
                                    $numsResponsables = [];
                                    foreach($colViajes as $viaje){
                                        
                                        $numEmpleado = $viaje->getObjResponsable()->getNumEmpleado();
                                        $numsResponsables[] = $numEmpleado;
                                          
                                    }
                                    $contador = 0;                            
                                    foreach ($colResponsables as $responsable) {
        
                                        if (!(in_array($responsable->getNumEmpleado(), $numsResponsables))) {
                                            $contador++;
                                            $numEmpleado = $responsable->getNumEmpleado();
                                            $empleado = $responsable->listar('rnumeroempleado = ' . $numEmpleado . ";")[0];
                                            echo $empleado."\n------------------------------------------------------------";
                                        }
                                    }
                                    if($contador == 0){
                                        echo "no hay responsables disponibles para asignar.";
                                    }
                                    # si no hay viajes creados, directamente listamos todos los responsables.                            
                                } else {
                                    $colResponsables = $objResponsable->listar();
                                    foreach ($colResponsables as $responsable) {
                                        echo $responsable . "\n------------------------------------------------------------";
                                    }
                                }
                                $numDoc = leer("\n ingrese el numero de documento del responsable seleccionado: ");
                                $objResp = new ResponsableV();
                                    while(!$objResp->Buscar($numDoc)){
                                        $numDoc2 = leer("\n numero de documento incorrecto. Ingréselo nuevamente: ");
                                        $numDoc = $numDoc2;
                                    }
                                $idEmpresa = leer("ingrese el id de la empresa: ");
                                    while(!$empresaViajes->Buscar($idEmpresa)){
                                        $idEmpresa2 = leer("\n id de empresa incorrecto. Ingréselo nuevamente: ");
                                        $idEmpresa = $idEmpresa2;
                                    }
                                $importeViaje = leer("Ingrese el importe del viaje. '0' si aún no desea ingresarlo. ");
                                $viajeIngresado = new Viaje();
                                $viajeIngresado->cargar(null,$fechaViaje,$destino,$cantMaxPasajeros,$empresaViajes,[],$objResp,$importeViaje);
                                $confirmacion = $viajeIngresado->insertar();
                                if($confirmacion){
                                    echo "viaje insertado exitosamente.";
                                }else echo "el viaje no pudo ser insertado. ";
                            }else echo "no hay responsables creados";
                            
                        }else echo "no pueden crear viajes sin antes crear la empresa.";
                        
                        break;
                    case 2:
                        // modificar un viaje
                        if(count($objViaje->listar()) <> 0){
                            $idViaje = leer("ingrese el id del viaje a modificar: ");
                            if($objViaje->Buscar($idViaje)){
                                do{
                                    $objViaje->Buscar($idViaje);
                                    $respuesta = menuModificarViaje(); 
                                    switch($respuesta){
                                        case 1:
                                            // destino
                                            $newDestino = leer("ingrese el nuevo destino: ");
                                            $objViaje->setDestino($newDestino);
                                            
                                            break;
                                        case 2: 
                                            // cantidad maxima de pasajeros
                                            $newCantMax = leer("ingrese la nueva cantidad maxima de pasajeros: ");
                                            $cantPasajeros = count($objPasajero->listar('idviaje = '.$objViaje->getIdViaje()));
                                            if($newCantMax < $cantPasajeros){
                                                echo "la cantidad actual de pasajeros ($cantPasajeros) excede la cantidad maxima ingresada. ";
                                            }else $objViaje->setCantMaxPasajeros($newCantMax);
                                            break;
                                        case 3: 
                                            // fecha
                                            $newFecha = leer("ingrese una nueva fecha (formato YYYY-MM-DD): ");
                                            
                                            $fechaValida = "/^202[4-9]-(0[1-9]|1[0-2])-(0[1-9]|1[0-9]|2[0-9]|3[0-1])$/";
                                            if(preg_match($fechaValida, $newFecha) == 0){
                                                echo "fecha invalida. ";
                                            }else $objViaje->setFecha($newFecha);   

                                            break;
                                        case 4:
                                            // responsable
                                            echo "seleccione un numero de empleado del responsable del viaje. Los que se encuentran disponibles son: \n";
                                            $colViajes = $objViaje->listar();
                                            $colResponsables = $objResponsable->listar();
                                            $numsResponsables = [];

                                            foreach($colViajes as $viaje){
                                                
                                                $numEmpleado = $viaje->getObjResponsable()->getNumEmpleado();
                                                $numsResponsables[] = $numEmpleado;
                                                
                                            }
                                            foreach($colResponsables as $responsable) {
                                                # si no se encuentra en el arreglo el numero de responsable
                                                if (!(in_array($responsable->getNumEmpleado(), $numsResponsables))) {
                                                    $numEmpleado = $responsable->getNumEmpleado();
                                                    $empleado = $responsable->listar('rnumeroempleado = ' . $numEmpleado . ";")[0];
                                                    echo $empleado."\n------------------------------------------------------------";
                                                }
                                            }
                                            $dniResponsable = leer("\ningrese el dni de un responsable: ");
                                            if($objResponsable->Buscar($dniResponsable)){
                                                $objViaje->setObjResponsable($objResponsable);
                                            }else echo "el dni no está asociado a un responsable. ";
                                            break;
                                        case 5:
                                            // importe
                                            $newImporte = leer("ingrese el nuevo importe: ");
                                            $objViaje->setImporte($newImporte);
                                            break;
                                    }
                                    if($objViaje->modificar()){
                                        echo "el dato se ha modificado correctamente. ";
                                    }else echo "el dato no se ha podido modificar. ";
                                }while($respuesta <> 6);
                            }else echo "error. Id de viaje no encontrado";
                            
                        }else echo "no pueden modificar datos porque no hay viajes creados. ";
                        
                        break;
                    case 3:
                        // eliminar un viaje
                        if(count($objViaje->listar()) <> 0){
                            $idViaje = leer("ingrese el id del viaje a eliminar: ");
                            if($objViaje->Buscar($idViaje)){
                                $cantPasajeros = count($objPasajero->listar('idviaje = '.$idViaje));
                                if($cantPasajeros > 0){
                                    #CARGAR pasajeros en un viaje para verificar si este condicional se cumple
                                    echo "No se puede eliminar el viaje porque cuenta con pasajeros.";
                                }else{
                                    if($objViaje->eliminar($idViaje)){
                                        echo "viaje eliminado exitosamente. ";
                                    }else echo "no se pudo ejecutar la consulta. Error al eliminar el viaje. ";
                                    
                                }
                            }else echo "el id no existe. ";
                            
                        }else echo "no pueden eliminar viajes porque no hay viajes creados. ";
                        
                        break;
                    case 4:
                        // ver viajes    
                        if(count($objViaje->listar()) <> 0){

                            $datosViajes = $objViaje->listar();
                            
                            foreach($datosViajes as $viaje){
                                $viaje->setColObjPasajeros($objPasajero->listar(" idviaje = ".$viaje->getIdViaje()));
                                echo $viaje."\n------------------------------------------------------------\n";
                            }
                        }else echo "debe crear al menos un viaje para poder ver sus datos. ";
                        
                        
                        break;
                    case 5:
                        // buscar viajes (verifica la existencia de un id viaje)
                        if(count($objViaje->listar()) <> 0){

                            $idViajeBuscado = leer("ingrese el id del viaje para comprobar su existencia: ");
                            if($objViaje->Buscar($idViajeBuscado)){
                                echo "el id existe y está asociado a un viaje.";
                            }else echo "el id no existe. ";
                            
                        }else echo "no hay ningún viaje creado. ";
                        
                        break;
                }
            } while ($opcionViajes <> 6);
            break;
        
        case 3:
            do{
                $opcionPasajero = menuPasajeros();
                switch ($opcionPasajero){
                    case 1:
                        // agregarPasajero;
                        
                        // ingresar
                        if (count($objViaje->listar()) <> 0) {
                            echo "-------------- lista de viajes con lugares disponibles --------------\n";

                            $hayDisponibles = 0;
                            for ($i = 0; $i < count($objViaje->listar()); $i++) {
                                // $cantPasajeros = count($objViaje->listar()[$i]->getColObjPasajeros());
                                
                                $cantPasajeros = count($objPasajero->listar(' idviaje = '.$objViaje->listar()[$i]->getIdViaje())); # ?

                                $cantMaxPasajeros = $objViaje->listar()[$i]->getCantMaxPasajeros();
                                if($cantMaxPasajeros > $cantPasajeros){
                                    $hayDisponibles++;
                                    echo "Viaje ID N°" . $objViaje->listar()[$i]->getIdViaje() . ", destino: " . $objViaje->listar()[$i]->getDestino() . ", importe: $" . $objViaje->listar()[$i]->getImporte() . 
                                    " con ".$cantMaxPasajeros ." de capacidad y ".$cantPasajeros." lugares ocupados. \n";

                                }
                            }

                            if ($hayDisponibles > 0) {
                                $idViaje = leer("ingrese el id del viaje del pasajero: ");

                                if ($objViaje->Buscar($idViaje)) {
                                    $colPasajeros = $objPasajero->listar(' idviaje = ' . $idViaje);
                                    if ($objViaje->getCantMaxPasajeros() > count($colPasajeros)) {
                                        $nroDoc = leer("ingrese el numero de documento del pasajero: ");
                                        $persona = new Persona();
                                        $pasajero = new Pasajero();
                                        if ($persona->Buscar($nroDoc)) {
                                            if (!$objResponsable->Buscar($nroDoc)) {
                                                if ($pasajero->Buscar($nroDoc)) {
                                                    $rta = leer("este pasajero ya existe. desea modificar sus datos? s/n");
                                                    if ($rta = 's'
                                                    ) {
                                                        goto modificarpasajero;
                                                    }
                                                } else {
                                                    $nroPasaporte = leer("ingrese numero de pasaporte: ");
                                                    $pasajero->cargar($nroDoc, $persona->getNombre(), $persona->getApellido(), $persona->getTelefono(), $objViaje, $nroPasaporte);
                                                    if ($pasajero->insertar()) {
                                                        echo "El pasajero ha sido cargado";
                                                    } else echo "El pasajero no ha podido ser cargado. " . $pasajero->getmensajeoperacion();
                                                }
                                            } else echo "ese numero de documento ya está asociado a un RESPONSABLE";
                                        } else {
                                            // cargar persona
                                            $nombre = leer("Ingrese el nombre del pasajero: ");
                                            $apellido = leer("Ingrese el apellido del pasajero: ");
                                            $telefono = leer("Ingrese el teléfono del pasajero: ");
                                            $nroPasaporte = leer("Ingrese el número de pasaporte: "); #
                                            $persona->cargar($nroDoc, $nombre, $apellido, $telefono);
                                            $persona->insertar();
                                            $pasajero->cargar($nroDoc, $nombre, $apellido, $telefono, $objViaje, $nroPasaporte);
                                            if ($pasajero->insertar()) {
                                                echo "El pasajero ha sido cargado";
                                            }
                                        }
                                    } else echo "No hay espacio disponible en el viaje seleccionado";
                                } else echo "no existe viaje con ese id";
                            } else echo "no hay viajes con lugares disponibles para nuevos pasajeros";
                        } else echo "no hay viajes en los que cargar pasajeros";
                        
                        break;
                    case 2:
                        modificarpasajero:
                        // modificar
                        $colPasajeros = $objPasajero->listar();
                        if (count($colPasajeros)>0){
                            $nroDoc = leer("ingrese el numero de documento del pasajero: ");
                            if ($objPasajero->Buscar($nroDoc) && $objPersona->Buscar($nroDoc)){
                                do{
                                    $objPasajero->Buscar($nroDoc);
                                    echo "\n------------PASAJERO------------\n".$objPasajero;
                                    $respuesta = menuModificarPasajeros();
                                    switch($respuesta){
                                        case 1:
                                            // nombre
                                            $nombre = leer("\ningrese el nuevo nombre:");
                                            $objPersona->setNombre($nombre);
                                            if ($objPersona->modificar()){
                                                echo "El nombre ha sido modificado.";
                                            } else echo "No pudo modificarse. " . $objPasajero->getmensajeoperacion();
                                            break;
                                        case 2:
                                            // apellido
                                            $apellido = leer("\ningrese el nuevo apellido:");
                                            $objPersona->setApellido($apellido);
                                            if ($objPersona->modificar()){
                                                echo "El nombre ha sido modificado.";
                                            } else echo "No pudo modificarse. " . $objPasajero->getmensajeoperacion();
                                            break;
                                        case 3:
                                            // telefono
                                            $telefono = leer("\ningrese el nuevo teléfono:");
                                            $objPersona->setTelefono($telefono);
                                            if ($objPersona->modificar()){
                                                echo "El nombre ha sido modificado.";
                                            } else echo "No pudo modificarse. " . $objPasajero->getmensajeoperacion();
                                            break;
                                        case 4:
                                            // id viaje
                                            $idViaje = leer("\ningrese el nuevo id de viaje: ");
                                            if ($objViaje->Buscar($idViaje)){
                                                $objPasajero->setObjViaje($objViaje);
                                            } else echo "\nno hay un viaje relacionado a esa id";
                                            if ($objPasajero->modificar()){
                                                echo "El nombre ha sido modificado.";
                                            } else echo "No pudo modificarse. " . $objPasajero->getmensajeoperacion();
                                            break;
                                        case 5:
                                            // nro pasaporte
                                            $nroPasaporte = leer("\ningrese el nuevo número de pasaporte: ");
                                            $objPasajero->setNroPasaporte($nroPasaporte);
                                            if ($objPasajero->modificar()){
                                                echo "El nombre ha sido modificado.";
                                            } else echo "No pudo modificarse. " . $objPasajero->getmensajeoperacion();
                                            break;
                                    }
                                } while ($respuesta <> 6);
                                
                            } else "no se halló pasajero con ese número de documento";
                        } else "no hay pasajeros cargados aún";
                        break;
                    case 3:
                        // eliminar
                        $colPasajeros = $objPasajero->listar();
                        $nroDoc = leer("ingrese el número de documento: ");

                        if (count($colPasajeros) > 0){
                            if ($objPasajero->Buscar($nroDoc)){
                                if ($objPasajero->eliminar()){
                                    echo "el pasajero ha sido eliminado.\n";
                                    $rta= leer("Desea además eliminar sus datos de PERSONA? (si/no)");
                                    if (strcasecmp($rta, "si")==0){
                                        $objPersona->Buscar($nroDoc);
                                        if ($objPersona->eliminar()){
                                            echo "sus datos han sido eliminados completamente";
                                        } else echo "no ha podido efectuarse. " . $objPersona->getmensajeoperacion();
                                    }
                                } else echo "no pudo eliminarse. " . $objPasajero->getmensajeoperacion();
                            } else "no se halló pasajero con ese número de documento";
                        } else "no hay pasajeros cargados aún";

                        break;
                    case 4:
                        // ver pasajeros
                        $colPasajeros = $objPasajero->listar();
                        foreach ($colPasajeros as $pasajero){
                            echo "\n$pasajero\n-----------------------------";
                        }
                        break;
                    case 5:
                        // buscar un pasajero x dni
                        $nroDoc = leer("ingrese el número de documento: ");
                        $colPasajeros = $objPasajero->listar();
                        if (count($colPasajeros) > 0){
                            if ($objPasajero->Buscar($nroDoc)){
                                echo "\n-------------------------\n$pasajero\n-------------------------\n";
                            } else "no se ha encontrado un pasajero con ese número";
                        } else "no hay pasajeros cargados aún";
                        break;
                }
            } while ($opcionPasajero <> 6);
            break;

        case 4:
            do{
                $opcionResponsable = menuResponsables();
                switch($opcionResponsable){
                    case 1:
                        // ingresar responsable
                        $nroDoc = leer("ingrese el número de documento: ");
                        if ($objPersona->Buscar($nroDoc)){
                            if (!$objPasajero->Buscar($nroDoc)) {
                                $nroEmpleado = leer("ingrese el número de empleado: ");
                                $nroLicencia = leer("ingrese el número de licencia: ");
                                $objResponsable->cargar($nroDoc, $objPersona->getNombre(), $objPersona->getApellido(), $objPersona->getTelefono(), $nroEmpleado, $nroLicencia);
                                if ($objResponsable->insertar()) {
                                    echo "el responsable ha sido cargado";
                                } else echo "no ha sido posible la operación. " . $objResponsable->getmensajeoperacion();
                            } else echo "ese número de documento está asociado a un PASAJERO";
                        } else{
                            $nombre = leer("ingrese el nombre: ");
                            $apellido = leer("ingrese el apellido: ");
                            $telefono = leer("ingrese el teléfono: ");
                            $nroEmpleado = leer("ingrese el número de empleado: ");
                            $nroLicencia = leer("ingrese el número de licencia: ");
                            $objPersona->cargar($nroDoc, $nombre, $apellido, $telefono);
                            $objResponsable->cargar($nroDoc, $nombre, $apellido, $telefono, $nroEmpleado, $nroLicencia);
                            if ($objPersona->insertar() && $objResponsable->insertar()){
                                echo "el responsable ha sido cargado";
                            } else echo "no ha sido posible la operación. " . $objPersona->getmensajeoperacion() . $objResponsable->getmensajeoperacion();
                        }
                        break;
                    case 2:
                        // modificar responsable
                        $nroDoc = leer("ingrese el número de documento: ");
                        if ($objResponsable->Buscar($nroDoc) && $objPersona->Buscar($nroDoc)){
                            do{
                                $objResponsable->Buscar($nroDoc);
                                echo "\n------------RESPONSABLE------------\n".$objResponsable;
                                $rta = menuModificarResponsable();
                                switch ($rta){
                                    case 1:
                                        // nombre
                                        $nombre = leer("ingrese el nuevo nombre: ");
                                        $objPersona->setNombre($nombre);
                                        if ($objPersona->modificar()){
                                            echo "el responsable ha sido modificado";
                                        } else echo "no ha podido ejecutarse. " . $objPersona->getmensajeoperacion();
                                        break;
                                    case 2:
                                        // apellido
                                        $apellido = leer("ingrese el nuevo apellido: ");
                                        $objPersona->setApellido($apellido);
                                        if ($objPersona->modificar()){
                                            echo "el apellido ha sido modificado";
                                        } else echo "no ha podido ejecutarse. " . $objPersona->getmensajeoperacion();
                                        break;
                                    case 3:
                                        // telefono
                                        $telefono = leer("ingrese el nuevo teléfono: ");
                                        $objPersona->setTelefono($telefono);
                                        if ($objPersona->modificar()){
                                            echo "el teléfono ha sido modificado";
                                        } else echo "no ha podido ejecutarse. " . $objPersona->getmensajeoperacion();                                        break;
                                    case 4:
                                        // nro empleado
                                        $nroEmpleado = leer("ingrese el nuevo número de empleado: ");
                                        $objResponsable->setNumEmpleado($nroEmpleado);
                                        if ($objResponsable->modificar()){
                                            echo "el número de empleado ha sido modificado";
                                        } else echo "no ha podido ejecutarse. " . $objResponsable->getmensajeoperacion();
                                        break;
                                    case 5:
                                        // nro licencia
                                        $nroLicencia = leer("ingrese el nuevo número de licencia: ");
                                        $objResponsable->setNumLicencia($nroLicencia);
                                        if ($objResponsable->modificar()){
                                            echo "el número de licencia ha sido modificado. ";
                                        } else echo "no ha podido ejecutarse. " . $objResponsable->getmensajeoperacion();
                                        break;
                                }
                            } while ($rta <> 6);
                        } else echo "no hay un responsable cargado con ese número de documento";
                        break;
                    case 3:
                        // eliminar responsable
                        $nroDoc = leer("ingrese el número de documento del responsable a eliminar: ");
                        if ($objResponsable->Buscar($nroDoc)){
                            if (count($objViaje->listar("rnumeroempleado = ".$objResponsable->getNumEmpleado()))>0){
                                echo "el responsable está asociado a un viaje. no es posible eliminarlo";
                            } else{
                                if ($objResponsable->eliminar()){
                                    echo "el responsable se ha eliminado";
                                    $rta= leer("\nDesea además eliminar sus datos de PERSONA? (si/no)");
                                    if (strcasecmp($rta, "si")==0){
                                        $objPersona->Buscar($nroDoc);
                                        if ($objPersona->eliminar()){
                                            echo "sus datos han sido eliminados completamente";
                                        } else echo "no ha podido efectuarse. " . $objPersona->getmensajeoperacion();
                                    }
                                } else "no ha podido ejecutarse. " . $objResponsable->getmensajeoperacion();
                            }
                        } else echo "no se ha hallado un responsable con ese documento";
                        break;
                    case 4:
                        // ver responsables
                        $colResponsables = $objResponsable->listar();

                        foreach ($colResponsables as $responsable){
                            echo "\n----------------------------------\n$responsable\n----------------------------------\n";
                        }
                        break;
                    case 5:
                        // buscar un responsable x dni
                        $nroDoc = leer("ingrese el número de documento: ");
                        if ($objResponsable->Buscar($nroDoc)){
                            echo "\n-----------RESPONSABLE-----------\n$objResponsable";
                        } else echo "no existe un responsable asociado a ese número de documento";
                        break;
                }
            } while ($opcionResponsable <> 6);
            break;

    }
} while ($respuesta <> 5);