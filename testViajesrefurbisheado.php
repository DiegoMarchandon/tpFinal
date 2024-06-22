<?php

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


/* generador de caracteres random */
$caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';   
$nrodoc = rand(40000000,45000000);
$numEmpleado = rand(100,999);

/* instancias de responsable para ser seleccionados a un determinado viaje creado. 
Se crean en la tabla Responsable y en la tabla Persona */
/* $responsable1 = new ResponsableV();
$responsable1->cargar($nrodoc,"jorge","rodriguez",299432123,$numEmpleado,9009);
$insercion1 = $responsable1->insertar();

$responsable2 = new ResponsableV();
$responsable2->cargar($nrodoc,"luis","ramirez",298456432,$numEmpleado,8888);
$insercion2 = $responsable2->insertar();

$responsable3 = new ResponsableV();
$responsable3->cargar(42999888,"pedro","sanchez",299143543,545,1230);
$insercion3 = $responsable3->insertar(); */


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

function leer($mensaje){
    echo $mensaje;
    $rta = trim(fgets(STDIN));
    return $rta;
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
    echo "|------------------------------------------------------------------|\n".
"|                       MENÚ DE EMPRESA                            |\n".
"|------------------------------------------------------------------|\n".
"|(1) Ingresar una empresa           ||(4) Ver empresas             |\n".
"|(2) Modificar empresa              ||(5) Buscar una empresa       |\n".
"|(3) Eliminar empresa               ||(6) Volver atrás             |\n".
"|__________________________________________________________________|\n".
" Respuesta: ";
    $opcion = solicitarNumeroEntre(1, 6);
    return $opcion;
}

function menuViajes(){
    echo "|------------------------------------------------------------------|\n".
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
    echo "|------------------------------------------------------------------|\n".
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
    echo "|------------------------------------------------------------------|\n".
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


do{
    $respuesta = menuPrincipal();
    switch($respuesta){
        case 1:
            do{
                $opcionEmpresa = menuEmpresa();
                switch ($opcionEmpresa){
                    case 1:
                        // ingresar una empresa
                        if(count($empresaViajes->listar()) == 0){

                            $nombre = leer("ingrese el nombre de la empresa: ");
                            $direccion = leer("ingrese la direccion de la empresa: ");
                            $empresaViajes->cargar(null, $nombre,$direccion); #cargo los datos en la clase
                            $resultado = $empresaViajes->insertar();
                            if($resultado){
                                echo "datos cargados correctamente.\n";
                                $coleccion = $empresaViajes->listar();
                                foreach($coleccion as $dato){
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
                        // eliminar una empresa
                        $idEmpresa = leer("inserte el id de la empresa que desea eliminar: ");
                        if($empresaViajes->eliminar($idEmpresa)){ #con ponerlo acá ya se ejecuta
                            echo "empresa eliminada.";
                        }else{
                            echo "no se ha podido eliminar";
                        }
                        break;
                    case 4:
                        // ver empresas
                        break;
                    case 5:
                        // buscar una empresa x id
                        break;
                }
            } while ($opcionEmpresa <> 6);
            break;

        case 2:
            do{
                $opcionViajes = menuViajes();
                switch($opcionViajes){
                    case 1:
                        // ingresar un viaje
                        /* insertar viaje (INCOMPLETO) */
                        /* NOT NULL destino, cantMaxPasajeros, responsable, fecha*/
                        /* 
                        echo "Antes de crear el viaje, debe crear al responsable del mismo.";
                        echo "ingrese su numero de documento: ";
                        $numDoc = trim(fgets(STDIN));
                        echo "ingrese su nombre: ";
                        $nombreResponsable = trim(fgets(STDIN));
                        echo "ingrese su apellido: ";
                        $apellResponsable = trim(fgets(STDIN));
                        echo "ingrese su teléfono: ";
                        $telefono = trim(fgets(STDIN));
                        echo "Ingrese su numero de empleado: ";
                        $numEmpleado = trim(fgets(STDIN));
                        echo "ingrese su número de licencia:";
                        $numLicencia = trim(fgets(STDIN));
                        $responsable = new ResponsableV();
                        $responsable->cargar($numDoc,$nombreResponsable,$apellResponsable,$telefono,$numEmpleado,$numLicencia);
                        $respuesta = $responsable->insertar(); */

                        $destino = leer("ingrese un destino: ");
                        $cantMaxPasajeros = leer("ingrese una cantidad máxima de pasajeros para el viaje: ");
                        $fechaViaje = leer("ingrese la fecha del viaje (Formato YYYY-MM-DD): ");

                        echo "seleccione al responsable encargado del viaje. Los que se encuentran disponibles son: \n";
                        // de un obj responsable, usamos el método listar() sin parámetro, para que nos devuelva todos los responsables
                        $colResponsables = $responsable1->listar();
                        foreach ($colResponsables as $responsable) {
                            echo $responsable .
                                "\n------------------------------------------------------------";
                        }
                        $respuesta = leer("desea ingresar el importe de viaje ahora ? si/no: ");
                        if (strcasecmp($rta2, "si") == 0) {
                            $importeViaje = leer("ingrese el importe del viaje: ");
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
                        break;
                    case 2:
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