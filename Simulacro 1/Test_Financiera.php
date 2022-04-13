<?php

include 'Cuota.php';
include 'Financiera.php';
include 'Persona.php';
include 'Prestamo.php';

// Financiera
$objFinanciera = new Financiera("Money", "Av. Arg 1234");

// Personas
$listaDePersonas[0] = new Persona("Pepe","Florez","Bs As 12","dir@mail.com",299444567,40000);
$listaDePersonas[1] = new Persona("Luis","Suarez","Bs As 123","dir@mail.com",2994455,4000);

// Prestamos
$listaDePrestamos[0] = new Prestamo(1,50000,5,0.1,$listaDePersonas[0]);
$listaDePrestamos[1] = new Prestamo(2,10000,4,0.1,$listaDePersonas[1]);
$listaDePrestamos[2] = new Prestamo(3,10000,2,0.1,$listaDePersonas[1]);

// Incorporamos los préstamos a nuestra financiera y los mostramos
$objFinanciera->incorporarPrestamo($listaDePrestamos[0]);
$objFinanciera->incorporarPrestamo($listaDePrestamos[1]);
$objFinanciera->incorporarPrestamo($listaDePrestamos[2]);
echo $objFinanciera;


// Otorgamos los préstamos que cumplan las conidiciones y los mostramos nuevamente
$objFinanciera->otorgarPrestamoSiCalifica();
echo $objFinanciera;

// Solicitamos la cuota a pagar del préstamo con el id 2
$objCuota = $objFinanciera->informarCuotaPagar(1); // Error, no cumple la condición para otorgar el préstamo
echo $objCuota; // Por ende no va a tener contenido que mostrar 

/*$objCuota = $objFinanciera->informarCuotaPagar(1); // Este si va a funcionar
echo $objCuota;*/

if ($objCuota <> null) {
    echo "\nMonto final cuota: $". $objCuota->darMontoFinalCuota(). "\n";
    $objCuota->setCancelada(true);
}
else {
    echo "No se otorgó el préstamo";
}


$objCuota = $objFinanciera->informarCuotaPagar(1); // Mismo error que arriba

// $objCuota = $objFinanciera->informarCuotaPagar(1);

echo $objCuota;