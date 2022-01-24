<?php

include "CalculadoraCientifica.php";

$cal = new CalculadoraCientifica();

$suma = $cal->suma(3,5);
echo 'La suma es: '.$suma;

$potencia = $cal->potenciaCuadrado(5);

echo '<br>La potencia es: '.$potencia;