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

echo 
"|             Bienvenido. Qué desea hacer?                         |\n".
"|------------------------------------------------------------------|\n".
"| informacion de empresa viajes: ||    información de un viaje:    |\n".
"|(1) Ingresar                    ||(4) Ingresar                    |\n".
"|(2) Modificar                   ||(5) Modificar                   |\n".
"|(3) Eliminar                    ||(6) Eliminar                    |\n".
"|__________________________________________________________________|\n";


$viaje = new Viaje();
$empresaViajes = new Empresa();
$respuesta = trim(fgets(STDIN));

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
        # las líneas comentadas sirven de ejemplificación para implementar una estructura de control que busca viajes por idViaje
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
        if($empresaViajes->eliminar($idEmpresa)){ #con ponerlo acá ya se ejecuta o debo guardarlo en una variable y poner esa variable ?
            echo "empresa eliminada.";
        }else{
            echo "no se ha podido eliminar";
        }
        break;
    case 4: 
        /* NOT NULL destino, cantMaxPasajeros, responsable, */
        echo "ingrese el destino: ";
        
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
        $respuesta = $responsable->insertar();
        echo "ingrese un destino: ";
        $destino = trim(fgets(STDIN));
        echo "ingrese una cantidad máxima de pasajeros para el viaje: ";
        $cantMaxPasajeros = trim(fgets(STDIN));
        echo "ingrese el id de la empresa al que hará referencia el viaje: ";
    case 5:
        /* Modificar Viaje */
        break;
    case 6: 
        /* Eliminar Viaje */
        break;
}
