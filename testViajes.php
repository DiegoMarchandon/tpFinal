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

function menuPrincipal(){
    echo "|------------------------------------------------------------------|\n".
"|             Bienvenido. Qué desea hacer?                         |\n".
"|------------------------------------------------------------------|\n".
"| informacion de empresa viajes: ||    información de un viaje:    |\n".
"|(1) Ingresar                    ||(4) Ingresar                    |\n".
"|(2) Modificar                   ||(5) Modificar                   |\n".
"|(3) Eliminar                    ||(6) Eliminar                    |\n".
"|__________________________________________________________________|\n".
" Respuesta: ";
    $opcion = solicitarNumeroEntre(1, 6);
    return $opcion;
}
// salir?


$viaje = new Viaje();
$empresaViajes = new Empresa();

do{
    $respuesta = menuPrincipal();
    switch($respuesta){
    case 1:
        if(count($empresaViajes->listar()) == 0){

            echo "ingrese el nombre de la empresa: ";
            $nombre = trim(fgets(STDIN));
            echo "ingrese la direccion de la empresa: ";
            $direccion = trim(fgets(STDIN));
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
            echo "ya hay una empresa existente. Desea modificar sus datos? si/no: ";
            $respuesta = trim(fgets(STDIN));
            if(strcasecmp($respuesta, "si") == 0){
                goto modificar; /* El operador goto puede ser usado para saltar a otra sección en el programa (https://www.php.net/manual/es/control-structures.goto.php)*/
            }
        }
        break;
    case 2:
        # las líneas comentadas sirven de ejemplificación para implementar una estructura de control que busca (para eliminar o modificar) viajes por idViaje
        // echo "ingrese el id de la empresa: ";
        // $idEmpresa = trim(fgets(STDIN));
        // if($empresaViajes->buscar($idEmpresa)){ #devuelve true si el id existe. 
            modificar: /* punto de destino especificado */
            echo "desea modificar el nombre ? si/no: ";
            $rta1 = trim(fgets(STDIN));
            if(strcasecmp($rta1, "si") == 0){
                echo "ingrese el nuevo nombre: ";
                $newNombre = trim(fgets(STDIN));
                $empresaViajes->setNombre($newNombre);
                $modificarNombre = " enombre= '".$newNombre."' ";
                $empresaViajes->modificar($modificarNombre);
            }
            echo "desea modificar la direccion ? si/no: ";
            $rta2 = trim(fgets(STDIN));
            if(strcasecmp($rta2, "si") == 0){
                echo "ingrese la nueva dirección: ";
                $newDireccion = trim(fgets(STDIN));
                $empresaViajes->setDireccion($newDireccion);
                $modificarDireccion = " edireccion= '".$newDireccion."' ";
                $empresaViajes->modificar($modificarDireccion);
            }
            if((strcasecmp($rta1, "si") != 0) && (strcasecmp($rta2, "si") != 0)){
                echo "No se modificó ningún dato.";
            }
        // }else{
        //     echo "Error. id de empresa no encontrado. ";
        // }
        break;
    case 3: 
        echo "inserte el id de la empresa que desea eliminar: ";
        $idEmpresa = trim(fgets(STDIN));
        if($empresaViajes->eliminar($idEmpresa)){ #con ponerlo acá ya se ejecuta
            echo "empresa eliminada.";
        }else{
            echo "no se ha podido eliminar";
        }
        break;
    case 4:
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
        
        echo "ingrese un destino: ";
        $destino = trim(fgets(STDIN));
        echo "ingrese una cantidad máxima de pasajeros para el viaje: ";
        $cantMaxPasajeros = trim(fgets(STDIN));
        echo "ingrese la fecha del viaje (Formato YYYY-MM-DD): ";
        $fechaViaje = trim(fgets(STDIN));

        echo "seleccione al responsable encargado del viaje. Los que se encuentran disponibles son: \n";
        // de un obj responsable, usamos el método listar() sin parámetro, para que nos devuelva todos los responsables
        $colResponsables = $responsable1->listar();
        foreach($colResponsables as $responsable){
            echo $responsable.
            "\n------------------------------------------------------------";
        }
        echo "desea ingresar el importe de viaje ahora ? si/no: ";
        $respuesta = trim(fgets(STDIN));
        if(strcasecmp($rta2, "si") == 0){
            echo "ingrese el importe del viaje: ";
            $importeViaje = trim(fgets(STDIN));
        }
    case 5:
        /* Modificar Viaje 
        En Empresa le puse un parámetro al método modificar() 
        para que el usuario pudiera ingresar de a uno los atributos que quisiera modificar (case 2).
        Te encargo si querés hacer lo mismo ocn el método modificar de Viaje :))) 
        */
        break;
    case 6: 
        /* Eliminar Viaje */

                
        
            
        break;
}} while ($opcion != 7);
