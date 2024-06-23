<?php
$numero = intval(rand(297,299) . rand(100000,999999));

echo $numero ."\n".gettype($numero)."\n";

$caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 

$nroPasaporte = substr(str_shuffle($caracteres), 0, 3) . rand(100000,999999);
echo $nroPasaporte;