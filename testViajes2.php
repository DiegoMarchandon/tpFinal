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
$nrodoc1 = rand(40000000,45000000);
$numEmpleado1 = rand(100,999);
$persona1 = new Persona();
$persona1->cargar($nrodoc1,"jorge","rodriguez",299432123);
$persona1->insertar();
$responsable1 = new ResponsableV();
$responsable1->cargar($persona1->getNrodoc(),$persona1->getNombre(),$persona1->getApellido(),$persona1->getTelefono(),$numEmpleado1,7070);
$insercion1 = $responsable1->insertar();

$nrodoc2 = rand(40000000,45000000);
$numEmpleado2 = rand(100,999);
$persona2 = new Persona();
$persona2->cargar($nrodoc2,"luis","ramirez",298456432);
$persona2->insertar();
$responsable2 = new ResponsableV();
$responsable2->cargar($persona2->getNrodoc(),$persona2->getNombre(),$persona2->getApellido(),$persona2->getTelefono(),$numEmpleado2,8888);
$insercion2 = $responsable2->insertar();

$nrodoc3 = rand(40000000,45000000);
$numEmpleado3 = rand(100,999);
$persona3 = new Persona();
$persona3->cargar($nrodoc3,"pedro","sanchez",299143543);
$persona3->insertar();
$responsable3 = new ResponsableV();
$responsable3->cargar($persona3->getNrodoc(),$persona3->getNombre(),$persona3->getApellido(),$persona3->getTelefono(),$numEmpleado3,1230);
$insercion3 = $responsable3->insertar();

$nrodoc4 = rand(40000000,45000000);
$numEmpleado4 = rand(100,999);
$persona4 = new Persona();
$persona4->cargar($nrodoc4,"blas","parera",299694362);
$persona4->insertar();
$responsable4 = new ResponsableV();
$responsable4->cargar($persona4->getNrodoc(),$persona4->getNombre(),$persona4->getApellido(),$persona4->getTelefono(),$numEmpleado4,5531);
$insercion4 = $responsable4->insertar();

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
                                    echo "-------------------------------------------------------";
                                }
                            }
                        }else{
                            $respuesta = leer("ya hay una empresa existente. Desea modificar sus datos? si/no: ");
                            if(strcasecmp($respuesta, "si") == 0){
                                goto modificar; /* El operador goto puede ser usado para saltar a otra sección en el programa (https://www.php.net/manual/es/control-structures.goto.php)*/
                            }
                        }
                        break;
                    case 2:
                        // modificar una empresa
                        
                        modificar: /* punto de destino especificado */
                        $rta1 = leer("desea modificar el nombre ? si/no: ");
                        if (strcasecmp($rta1, "si") == 0) {
                            $newNombre = leer("ingrese el nuevo nombre: ");
                            $empresaViajes->setNombre($newNombre);
                            $modificarNombre = " enombre= '" . $newNombre . "' ";
                            $empresaViajes->modificar($modificarNombre);
                        }
                        $rta2 = leer("desea modificar la direccion ? si/no: ");
                        if (strcasecmp($rta2, "si") == 0) {
                            $newDireccion = leer("ingrese la nueva dirección: ");
                            $empresaViajes->setDireccion($newDireccion);
                            $modificarDireccion = " edireccion= '" . $newDireccion . "' ";
                            $empresaViajes->modificar($modificarDireccion);
                        }
                        if ((strcasecmp($rta1, "si") != 0) && (strcasecmp($rta2, "si") != 0)) {
                            echo "No se modificó ningún dato.";
                        }
                        
                        break;
                    case 3:
                        // eliminar LA empresa
                        $idEmpresa = leer("como método de seguridad, inserte el id de la empresa: ");
                        if($empresaViajes->eliminar($idEmpresa)){ #con ponerlo acá ya se ejecuta
                            echo "empresa eliminada.";
                        }else{
                            echo "no se ha podido eliminar.";
                        }
                        break;
                    case 4:
                        // ver datos de empresa
                        $idEmpresa = leer("como método de seguridad, ingrese el id de empresa: ");
                        if($empresaViajes->Buscar($idEmpresa)){
                            $coleccion = $empresaViajes->listar();
                                foreach($coleccion as $dato){
                                    echo $dato;
                                }
                        }
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
                        /* insertar viaje */
                        /* NOT NULL destino, cantMaxPasajeros, responsable, fecha*/
                        $destino = leer("ingrese un destino: ");
                        $cantMaxPasajeros = leer("ingrese una cantidad máxima de pasajeros para el viaje: ");
                        $fechaViaje = leer("ingrese la fecha del viaje (Formato YYYY-MM-DD): ");

                        echo "seleccione un numero de empleado del responsable del viaje. Los que se encuentran disponibles son: \n";
                        $colViajes = $objViaje->listar();
                        $colResponsables = $objResponsable->listar(); 
                        if(count($objViaje->listar()) <> 0){
                            // procedimiento para insertar un responsable que no esté asociado a un viaje:
                            $numsResponsables = [];
                            foreach($colViajes as $viaje){
                                
                                $numEmpleado = $viaje->getObjResponsable()->getNumEmpleado();
                                $numsResponsables[] = $numEmpleado;
                                  
                            }
                            
                            foreach ($colResponsables as $responsable) {

                                

                                if (!(in_array($responsable->getNumEmpleado(), $numsResponsables))) {
                                    $numEmpleado = $responsable->getNumEmpleado();
                                    $empleado = $responsable->listar('rnumeroempleado = ' . $numEmpleado . ";")[0];
                                    echo $empleado;
                                    "\n------------------------------------------------------------";
                                }
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
                                $idEmpresa2 = leer("\n numero de documento incorrecto. Ingréselo nuevamente: ");
                                $idEmpresa = $idEmpresa2;
                            }
                        $importeViaje = leer("Ingrese el importe del viaje. '0' si aún no desea ingresarlo. ");
                        $viajeIngresado = new Viaje();
                        $viajeIngresado->cargar(null,$fechaViaje,$destino,$cantMaxPasajeros,$empresaViajes,[],$objResp,$importeViaje);
                        $confirmacion = $viajeIngresado->insertar();
                        if($confirmacion){
                            echo "viaje insertado exitosamente.";
                        }else{
                            echo "el viaje no pudo ser insertado. ";
                        }
                        break;
                    case 2:
                        // modificar un viaje
                        $idViaje = leer("ingrese el id del viaje a modificar: ");
                        if($objViaje->Buscar($idViaje)){
                            // preguntar a pau si personalizo la función modificar() para que se aplique a cada atributo modificado
                            // atributos propios de viaje:
                            $newFecha = leer("ingrese una nueva fecha (formato YYYY-MM-DD): ");
                            $objViaje->setFecha($newFecha);
                            $newDestino = leer("ingrese un nuevo destino: ");
                            $objViaje->setDestino($newDestino);
                            $newCantMax = leer("ingrese una nueva cantidad maxima de pasajeros: ");
                            $objViaje->setCantMaxPasajeros($newCantMax);
                            /* $rta = leer("desea ingresar un pasajero al viaje ? si/no");
                            if(strcasecmp($rta1, "si") != 0){
                                goto agregarPasajero; 
                            }
                            $rta2 = leer("desea cambiar al responsable del viaje ? si/no: ");
                            if(strcasecmp($rta2, "si") != 0){
                                goto cambiarResp; 
                            } */
                            $newImporte = leer("ingrese un nuevo importe: ");
                            $objViaje->setImporte($newImporte);
                            $objViaje->modificar($idViaje);
                        }else{
                            echo "error. Id de viaje no encontrado";
                        }
                        break;
                    case 3:
                        // eliminar un viaje
                        $idViaje = leer("ingrese el id del viaje a eliminar: ");
                        if($objViaje->Buscar($idViaje)){
                            $arrViaje = $objViaje->listar(' idviaje = '.$idViaje);
                            if($arrViaje['vcantmaxpasajeros'] > 0){
                                echo "No se puede eliminar el viaje porque cuenta con pasajeros.";
                            }else{
                                $objViaje->eliminar($idViaje);
                            }
                        }else{
                            echo "el id no existe. ";
                        }
                        break;
                    case 4:
                        // ver viajes    
                            $datosViajes = $objViaje->listar();
                            
                                foreach($datosViajes as $viaje){
                                    echo $viaje."\n------------------------------------------------------------";
                                }
                        
                        break;
                    case 5:
                        // buscar viajes (verifica la existencia de un id viaje)
                        $idViajeBuscado = leer("ingrese el id del viaje para comprobar su existencia: ");
                        if($objViaje->Buscar($idViajeBuscado)){
                            echo "el id existe y está asociado a un viaje.";
                        }else{
                            echo "el id no existe. ";
                        }
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
                            echo "-------------- lista de viajes --------------\n";
                            for ($i = 0; $i < count($objViaje->listar()); $i++) {
                                echo "Viaje ID N°" . $objViaje->listar()[$i]->getIdViaje() . ", destino: " . $objViaje->listar()[$i]->getDestino() . ", importe: $" . $objViaje->listar()[$i]->getImporte() . "\n";
                            }
                            $idViaje = leer("ingrese la id del viaje del pasajero: ");
                            if ($objViaje->Buscar($idViaje)) {
                                $colPasajeros = $objPasajero->listar('where idviaje = '.$idViaje);
                                if ($objViaje->getCantidadMaximaPasajeros() > count($colPasajeros)) {
                                    $nroDoc = leer("ingrese el numero de documento del pasajero: ");
                                    $persona = new Persona();
                                    $pasajero = new Pasajero();
                                    if ($persona->Buscar($nroDoc)) {
                                        if (!$objResponsable->Buscar($nroDoc)) {
                                            if ($pasajero->Buscar($nroDoc)) {
                                                $rta = leer("este pasajero ya existe. desea modificar sus datos? s/n");
                                                if ($rta = 's') {
                                                    goto modificarpasajero;
                                                }
                                            } else {
                                                $nroPasaporte = leer("ingrese numero de pasaporte: ");
                                                $pasajero->cargar($nroDoc, $persona->getNombre(), $persona->getApellido(), $persona->getTelefono(), $objViaje, $nroPasaporte);
                                                if ($pasajero->insertar()){
                                                    echo "El pasajero ha sido cargado";
                                                } else echo "El pasajero no ha podido ser cargado. ". $pasajero->getmensajeoperacion();
                                            }
                                        } else echo "ese numero de documento ya está asociado a un RESPONSABLE";
                                    } else{
                                        // cargar persona
                                        $nombre = leer("Ingrese el nombre del pasajero: ");
                                        $apellido = leer("Ingrese el apellido del pasajero: ");
                                        $telefono = leer("Ingrese el teléfono del pasajero: ");
                                        $nroPasaporte = leer("Ingrese el número de pasaporte: ");
                                        $persona->cargar($nroDoc, $nombre, $apellido, $telefono);
                                        $persona->insertar();
                                        $pasajero->cargar($nroDoc, $nombre, $apellido, $telefono, $objViaje, $nroPasaporte);
                                        if ($pasajero->insertar()){
                                            echo "El pasajero ha sido cargado";
                                        };
                                    }
                                } else echo "No hay espacio disponible en el viaje seleccionado";
                            } else echo "no existe viaje con ese id";
                        } else echo "no hay viajes en los que cargar pasajeros";
                        
                        break;
                    case 2:
                        modificarpasajero:
                        // modificar
                        $colPasajeros = $objPasajero->listar();
                        if (count($colPasajeros)>0){
                            $nroDoc = leer("ingrese el numero de documento del pasajero: ");
                            if ($objPasajero->Buscar($nroDoc)){
                                do{
                                    echo "\n------------PASAJERO------------\n".$objPasajero;
                                    $respuesta = menuModificarPasajeros();
                                    switch($respuesta){
                                        case 1:
                                            // nombre
                                            $nombre = leer("\ningrese el nuevo nombre:");
                                            $objPasajero->setNombre($nombre);
                                            if ($objPasajero->modificar()){
                                                echo "El nombre ha sido modificado.";
                                            } else echo "No pudo modificarse. " . $objPasajero->getmensajeoperacion();
                                            break;
                                        case 2:
                                            // apellido
                                            $apellido = leer("\ningrese el nuevo apellido:");
                                            $objPasajero->setApellido($apellido);
                                            if ($objPasajero->modificar()){
                                                echo "El nombre ha sido modificado.";
                                            } else echo "No pudo modificarse. " . $objPasajero->getmensajeoperacion();
                                            break;
                                        case 3:
                                            // telefono
                                            $telefono = leer("\ningrese el nuevo teléfono:");
                                            $objPasajero->setTelefono($telefono);
                                            if ($objPasajero->modificar()){
                                                echo "El nombre ha sido modificado.";
                                            } else echo "No pudo modificarse. " . $objPasajero->getmensajeoperacion();
                                            break;
                                        case 4:
                                            // id viaje
                                            $idViaje = leer("\ningrese el nuevo id de viaje:");
                                            $objPasajero->setobjViaje($objViaje->Buscar($idViaje));
                                            if ($objPasajero->modificar()){
                                                echo "El nombre ha sido modificado.";
                                            } else echo "No pudo modificarse. " . $objPasajero->getmensajeoperacion();
                                            break;
                                        case 5:
                                            // nro pasaporte
                                            $nroPasaporte = leer("\ningrese el nuevo número de pasaporte:");
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
                                    echo "el pasajero ha sido eliminado";
                                    $rta= leer("desea además eliminar sus datos de PERSONA? (si/no)");
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
                        break;
                    case 2:
                        // modificar responsable
                        break;
                    case 3:
                        // eliminar responsable
                        break;
                    case 4:
                        // ver responsables
                        break;
                    case 5:
                        // buscar un responsable x dni
                        break;
                }
            } while ($opcionResponsable <> 6);
            break;

    }
} while ($respuesta <> 5);