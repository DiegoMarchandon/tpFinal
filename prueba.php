<?php
$numero = intval(rand(297,299) . rand(100000,999999));

// echo $numero ."\n".gettype($numero)."\n";

$caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 

$nroPasaporte = substr(str_shuffle($caracteres), 0, 3) . rand(100000,999999);
// echo $nroPasaporte;

$numeroDocumento = mt_rand(40000000,45000000);
// echo $numeroDocumento ."\n".$numeroDocumento;

$persona1 = ["nombre"=>"jorge",
            "apellido"=> "lopez",
            "nroDoc" => $numeroDocumento];
$persona2  = ["nombre"=>"agustin",
            "apellido"=> "rodriguez",
            "nroDoc" => $numeroDocumento];

// print_r($persona1);
// print_r($persona2);

// echo rand(10,920)."\n";
// echo rand(10,920);

function generaAleatorio(){
    return rand(100000,999999);
}

echo generaAleatorio();