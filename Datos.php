<?php
include 'BaseDatos.php';
include 'Empresa.php';
include 'Persona.php';
include 'Pasajero.php';
include 'ResponsableV.php';
include 'Viaje.php';

/* EMPRESA DE VIAJES */
$empresaViajes = new Empresa();
/* ------------------------------ */
// variables que generan numeros aleatorios
$numeroDocumento = rand(40000000,45000000);
$numeroEmpleado = rand(100,999);
$numeroLicencia = rand(1000,9999);
$numeroTelefono = intval(rand(297,299) . rand(100000,999999));
/* "el numero de pasaporte argentino... está compuesto por tres letras y seis números" */
$caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
$numeroPasaporte = substr(str_shuffle($caracteres), 0, 3) . rand(100000,999999);

/* ---------------------------------------RESPONSABLES (y personas) PRECARGADOS------------------------------------------- */
$nrodoc1 = rand(40000000,45000000);
$numEmpleado1 = rand(100,999);
/* instancias de responsable para ser seleccionados a un determinado viaje creado. 
Se crean en la tabla Responsable y en la tabla Persona */
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
/* ---------------------------------------------------------------------------------------------------------------------------------------- */



/* -----------------------------------------------------------------VIAJES PRECARGADOS------------------------------------------------------- */
/* viajes */
$pasajeros = new Pasajero();

$viaje1 = new Viaje();
$colPasajeros1 = $pasajeros->listar('idviaje ='.$viaje1->getIdViaje());
$viaje1->cargar(null,'2024-07-20','Jamaica',10,$empresaViajes,$colPasajeros1,$responsable1,14500);

$viaje2 = new Viaje();
$colPasajeros2 = $pasajeros->listar('idviaje ='.$viaje2->getIdViaje());
$viaje2->cargar(null,'2024-08-30','Nueva Zelanda',10,$empresaViajes,$colPasajeros2,$responsable2,15100);

$viaje3 = new Viaje();
$colPasajeros3 = $pasajeros->listar('idviaje ='.$viaje3->getIdViaje());
$viaje3->cargar(null,'2024-12-10','Paris',10,$empresaViajes,$colPasajeros3,$responsable3,25000);


/* primer pasajero */
$nrodoc4 = rand(40000000,45000000);
$persona4 = new Persona();
$persona4->cargar($nrodoc4,"pedro","perez",297465321);
$pasajero4 = new Pasajero();
$numPasaporte4 = substr(str_shuffle($caracteres), 0, 3) . rand(100000,999999);
$pasajero4->cargar($persona4->getNrodoc(),$persona4->getNombre(),$persona4->getApellido(),$persona4->getTelefono(),$viaje1,$numPasaporte4);
$pasajero4->insertar();

/* segundo pasajero */
$nrodoc5 = rand(40000000,45000000);
$persona5 = new Persona();
$persona5->cargar($nrodoc5,"ana","figueroa",298432154);
$pasajero5 = new Pasajero();
$numPasaporte5 = substr(str_shuffle($caracteres), 0, 3) . rand(100000,999999);
$pasajero5->cargar($persona5->getNrodoc(),$persona5->getNombre(),$persona5->getApellido(),$persona5->getTelefono(),$viaje1,$numPasaporte5);
$pasajero5->insertar();

/* tercer pasajero */
$nrodoc6 = rand(40000000,45000000);
$persona6 = new Persona();
$persona6->cargar($nrodoc6,"laura","hernandez",299456382);
$pasajero6 = new Pasajero();
$numPasaporte6 = substr(str_shuffle($caracteres), 0, 3) . rand(100000,999999);
$pasajero6->cargar($persona6->getNrodoc(),$persona6->getNombre(),$persona6->getApellido(),$persona6->getTelefono(),$viaje1,$numPasaporte6);
$pasajero6->insertar();

/* cuarto pasajero */
$nrodoc7 = rand(40000000,45000000);
$persona7 = new Persona();
$persona7->cargar($nrodoc7,"maria","martinez",299543321);
$pasajero7 = new Pasajero();
$numPasaporte7 = substr(str_shuffle($caracteres), 0, 3) . rand(100000,999999);
$pasajero7->cargar($persona7->getNrodoc(),$persona7->getNombre(),$persona7->getApellido(),$persona7->getTelefono(),$viaje1,$numPasaporte7);
$pasajero7->insertar();

function leer($mensaje){
    echo $mensaje;
    $rta = trim(fgets(STDIN));
    return $rta;
}

/**
 * crea un nuevo pasajero o responsable, en un determinado viaje,
 * y se asegura de que los datos ingresados no coincidan con 
 * pasajeros o responsables ya creados.
 */
/* function cargaDatoViaje($tipoPersona,$numViaje){
    #los datos generados aleatoriamente en las clases los voy guardando en arreglos 
        # para después validar en los bucles 'while' que no se repitan. 
    $arrDocs = [];
    $arrNumEmpleados = [];
    $arrNumLicencias = [];
    $arrNumTelefonos = [];
    $arrNumPasaportes = [];

// variables que generan numeros aleatorios
$caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 

// $numeroDocumento = rand(40000000,45000000);
// $numeroEmpleado = rand(100,999);
// $numeroLicencia = rand(1000,9999);
// $numeroTelefono = intval(rand(297,299) . rand(100000,999999));
// $numeroPasaporte = substr(str_shuffle($caracteres), 0, 3) . rand(100000,999999);


    $nombre = leer("ingrese el nombre de la persona: ");
    $apellido = leer("ahora ingrese el apellido: ");
    $persona = new Persona();
    $persona->cargar(rand(40000000,45000000),$nombre,$apellido,(intval(rand(297,299) . rand(100000,999999))));
    #mientras sea TRUE que el documento de la persona se encuentre en el arreglo Y en numero de telefono en el arreglo...
    while((in_array($persona->getNrodoc(),$arrDocs)) && (in_array($persona->getTelefono(),$arrNumTelefonos))){
        $persona->setNrodoc(rand(40000000,45000000)); #... seteo su documento a otro.
        $persona->setTelefono((intval(rand(297,299) . rand(100000,999999)))); #y también seteo el número de teléfono.
    }
    #una vez que genero datos únicos, los guardo en sus respectivos arreglos...
    $arrDocs[]= $persona->getNrodoc();
    $arrNumTelefonos[] = $persona->getTelefono();   
    #... E inserto la persona en la base de datos.
    $persona->insertar();

    if(strcasecmp($tipoPersona, "pasajero") == 0){ #si el parametro es "pasajero". Se crea antes la persona.
        $pasajero = new Pasajero();
        $pasajero->cargar($persona->getNrodoc(),$persona->getNombre(),$persona->getApellido(),$persona->getTelefono(),$numViaje,(substr(str_shuffle($caracteres), 0, 3) . rand(100000,999999)));
        #mientras sea TRUE que el pasaporte del pasajero se encuentre en el arreglo...
        while(in_array($pasajero->getNroPasaporte(),$arrNumPasaportes)){
            $pasajero->setNroPasaporte(substr(str_shuffle($caracteres), 0, 3) . rand(100000,999999)); #seteo su numero de pasaporte a otro.
        }
        #después de validar que posee datos unicos, lo inserto en la BD
        $pasajero->insertar();
    }else{ #se trata de un responsable. Se crea antes la persona.
        $responsable = new ResponsableV();
        $responsable->cargar($persona->getNrodoc(),$persona->getNombre(),$persona->getApellido(),$persona->getTelefono(),rand(100,999),rand(1000,9999));
        #mientras sea TRUE que el numero de licencia y el numero de empleado se encuentran en sus arreglos...
        while((in_array($responsable->getNumEmpleado(),$arrNumEmpleados)) && (in_array($responsable->getNumLicencia(),$arrNumLicencias))){
            $responsable->setNumEmpleado(rand(100,999)); #seteo su numero de empleado a otro.
            $responsable->setNumLicencia(rand(1000,9999)); #seteo su numero de licencia a otro.
        }
        #después de validar que posee datos unicos, lo inserto en la BD
        $responsable->insertar();
    }
} */