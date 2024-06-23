<?php
/* EMPRESA DE VIAJES */
$empresaViajes = new Empresa();
/* ------------------------------ */

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
/* ---------------------------------------------------------------------------------------------------------------------------------------- */



/* -----------------------------------------------------------------VIAJES PRECARGADOS------------------------------------------------------- */
$pasajero = new Pasajero();

$viaje1 = new Viaje();
$colPasajeros1 = $pasajero->listar('idviaje ='.$viaje1->getIdViaje());
$viaje1->cargar(null,'2024-07-20','Jamaica',30,$empresaViajes,$colPasajeros1,$responsable1,14500);

$viaje2 = new Viaje();
$colPasajeros2 = $pasajero->listar('idviaje ='.$viaje2->getIdViaje());
$viaje2->cargar(null,'2024-08-30','Nueva Zelanda',30,$empresaViajes,$colPasajeros2,$responsable2,15100);

$viaje3 = new Viaje();
$colPasajeros3 = $pasajero->listar('idviaje ='.$viaje3->getIdViaje());
$viaje3->cargar(null,'2024-12-10','Paris',30,$empresaViajes,$colPasajeros3,$responsable3,25000);

