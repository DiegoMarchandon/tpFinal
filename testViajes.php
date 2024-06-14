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

/* editar el menú para poner las opciones 4,5,6 a la derecha en lugar de abajo. Y el "Bienvenido..." como primera columna entre medio de ambas */
echo "\n| Bienvenido. Qué desea hacer? |\n|------------------------------|\n".
"|informacion de empresa viajes:|\n".
"|1)Ingresar                    |\n|2)Modificar                   |\n|3)Eliminar                    |\n".
"|------------------------------|\n|información de un viaje:      |\n".
"|4)Ingresar                    |\n|5)Modificar                   |\n|6)Eliminar                    |";


$viaje = new Viaje();
$empresaViajes = new Empresa();

$respuesta = trim(fgets(STDIN));

switch($respuesta){
    case 1:
        echo "ingrese el nombre de la empresa: ";
        $nombre = trim(fgets(STDIN));
        echo "ingrese la direccion de la empresa: ";
        $direccion = trim(fgets(STDIN));
        $empresaViajes->cargar($nombre,$direccion); #cargo los datos en la clase
        $resultado = $empresaViajes->insertar();
        if($resultado){
            echo "datos cargados correctamente.\n";
            $coleccion = $empresaViajes->listar();
            foreach($coleccion as $dato){
                echo $dato;
                echo "-------------------------------------------------------";
            }
        }
        break;
    case 2:

        echo "ingrese el id de la empresa: ";
        $idEmpresa = trim(fgets(STDIN));
        if($empresaViajes->buscar($idEmpresa)){ #devuelve true si el id existe.
            echo "desea modificar el nombre ? si/no";
            $rta1 = trim(fgets(STDIN));
            if($rta1 == "si"){
                echo "ingrese el nuevo nombre: ";
                $newNombre = trim(fgets(STDIN));
                $empresaViajes->setNombre($newNombre);
                $modificarNombre = " enombre= '".$newNombre."' ";
                $empresaViajes->modificar($modificarNombre);
            }
            echo "desea modificar la direccion ? si/no";
            $rta2 = trim(fgets(STDIN));
            if($rta2 == "si"){
                echo "ingrese la nueva dirección: ";
                $newDireccion = trim(fgets(STDIN));
                $empresaViajes->setDireccion($newDireccion);
                $modificarDireccion = " edireccion= '".$newDireccion."' ";
                $empresaViajes->modificar($modificarDireccion);
            }
            if($rta1 != "si" && $rta2 != "si"){
                echo "No se modificó ningún dato.";
            }
        }else{
            echo "Error. id de empresa no encontrado. ";
        }
        break;
    case 3: 
        if($empresaViajes->eliminar()){ #con ponerlo acá ya se ejecuta o debo guardarlo en una variable y poner esa variable ?
            echo "empresa eliminada.";
        }else{
            echo "no se ha podido eliminar";
        }
        break;
    case 4: 
        echo "Antes de crear el viaje, debe crear al responsable del mismo.";
        echo "ingrese su numero de documento: ";
        $numDoc = trim(fgets(STDIN));
        echo "ingrese su nombre: ";
        $nombreResponsable = trim(fgets(STDIN));
        echo "ingrese su apellido: ";
        $apellResponsable = trim(fgets(STDIN));

        echo "Ingrese su numero de empleado: ";
        $numEmpleado = trim(fgets(STDIN));
        echo "ingrese su número de licencia:";
        $numLicencia = trim(fgets(STDIN));
        echo "ingrese un destino: ";
        $destino = trim(fgets(STDIN));
        echo "ingrese una cantidad máxima de pasajeros para el viaje: ";
        $cantMaxPasajeros = trim(fgets(STDIN));
        echo "ingrese el id de la empresa al que hará referencia el viaje: ";
}
