<?php
/* NOTAS DE COSAS A IMPLEMENTAR DESPUES
conseguir que se pueda 

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
include_once 'Datos.php';

/* generador de caracteres random */
$caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 

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
"|(1) Ingresar empresa               ||(4) Ver empresa              |\n".
"|(2) Modificar empresa              ||(5) Volver atrás             |\n".
"|(3) Eliminar empresa               ||                             |\n".
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

$objViaje = new Viaje();
$objPersona = new Persona();
$objResponsable = new ResponsableV();
$objPasajero = new Pasajero();

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
                            leer("no hay una empresa existente. Debe crearla primero: \n");
                            $nombre = leer("ingrese el nombre de la empresa: ");
                            $direccion = leer("ingrese la direccion de la empresa: ");
                            $empresaViajes->cargar(null, $nombre,$direccion); #cargo los datos en la clase
                            $resultado = $empresaViajes->insertar();
                            if($resultado){
                                echo "datos cargados correctamente.\n";
                                $empresaDatos = $empresaViajes->listar();
                                foreach($empresaDatos as $dato){
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
                        # las líneas comentadas sirven de ejemplificación para implementar una estructura de control que busca (para eliminar o modificar) viajes por idViaje
                        // echo "ingrese el id de la empresa: ";
                        // $idEmpresa = trim(fgets(STDIN));
                        // if($empresaViajes->buscar($idEmpresa)){ #devuelve true si el id existe. 
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
                        // }else{
                        //     echo "Error. id de empresa no encontrado. ";
                        // }
                        break;
                    case 3:
                        // eliminar LA empresa
                        $idEmpresa = leer("como método de seguridad, inserte el id de la empresa: ");
                        if($empresaViajes->eliminar($idEmpresa)){ #con ponerlo acá ya se ejecuta
                            leer("empresa eliminada.\n");
                        }else{
                            leer("no se ha podido eliminar.\n");
                        }
                        break;
                    case 4:
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

                        echo "seleccione al responsable encargado del viaje. Los que se encuentran disponibles son: \n";
                        // procedimiento para insertar un responsable que no esté asociado a un viaje:
                        $responsables = new ResponsableV();
                        $colResponsables = $responsables->listar(); 
                        $viajes = new Viaje();
                        $colViajes = $viajes->listar('');
                        foreach ($colResponsables as $responsable) {
                            foreach($colViajes as $viaje){
                                if($responsable->getNumEmpleado() == ){

                                }
                            }
                            echo $responsable .
                                "\n------------------------------------------------------------";
                        }

                        $respuesta = leer("desea ingresar el importe de viaje ahora ? si/no: ");
                        if (strcasecmp($rta2, "si") == 0) {
                            $importeViaje = leer("ingrese el importe del viaje: ");
                        }else{
                            $importeViaje = null;
                        }
                        break;
                    case 2:
                        // modificar un viaje
                        /* Modificar Viaje 
                        En Empresa le puse un parámetro al método modificar() 
                        para que el usuario pudiera ingresar de a uno los atributos que quisiera modificar (case 2).
                        Te encargo si querés hacer lo mismo ocn el método modificar de Viaje :))) 
                        */
                        break;
                    case 3:
                        // eliminar un viaje
                        break;
                    case 4:
                        // ver viajes
                        break;
                    case 5:
                        // buscar viajes
                        break;
                }
            } while ($opcionViajes <> 6);
            break;
        
        case 3:
            do{
                $opcionPasajero = menuPasajeros();
                switch ($opcionPasajero){
                    case 1:
                        // ingresar
                        if (count($objViaje->listar()) <> 0) {
                            echo "-------------- lista de viajes --------------\n";
                            for ($i = 0; $i < count($objViaje->listar()); $i++) {
                                echo "Viaje ID N°" . $objViaje->listar()[$i]->getIdViaje() . ", destino: " . $objViaje->listar()[$i]->getDestino() . ", importe: $" . $objViaje->listar()[$i]->getImporte() . "\n";
                            }
                            $idViaje = leer("ingrese la id del viaje del pasajero: ");
                            if ($objViaje->Buscar($idViaje)) {
                                $colPasajeros = $objPasajero->listar($idViaje);
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

                        break;
                    case 3:
                        // eliminar
                        break;
                    case 4:
                        // ver pasajeros
                        break;
                    case 5:
                        // buscar un pasajero x dni
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