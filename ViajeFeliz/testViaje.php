<?php

include 'Viaje.php';
include 'Pasajero.php';
include 'ResponsableV.php';
include 'ViajeAereo.php';
include 'ViajeTerrestre.php';

// Pasajeros de prueba 
$pasajeroD1 = new Pasajero("Carmen", "Reinike", 8, 6);
$pasajeroD2 = new Pasajero("Juan", "Lopez", 25643215, 19841651989);
$pasajeroD3 = new Pasajero("Maria", "Ave", 34659825, 10051645894);
$pasajeroD4 = new Pasajero("Fernando", "Perez", 15135647, 87465119849);
$pasajerosViaje1 = [$pasajeroD1, $pasajeroD2, $pasajeroD3, $pasajeroD4];
$pasajerosViaje2 = [$pasajeroD2];

// Responsable de Prueba
$responsableDePrueba = new ResponsableV("Carlos", "Benitez", 15, 160710);

// Viaje de prueba
//$viaje1 = new Viaje(645165443651458, "La Pampa", 4, $pasajerosViaje1, $responsableDePrueba);
//$viaje2 = new Viaje(635212316546546, "Jujuy", 40, $pasajerosViaje2, $responsableDePrueba);

// Viaje aereo de prueba
$objViajeAereo1 = new ViajeAereo(1315, "Primera Clase", "Aerolineas Argentina", 1, 648132184654813, "Cordoba", 250, $pasajerosViaje1, $responsableDePrueba, 2000, "Ida y Vuelta");
$objViajeAereo2 = new ViajeAereo(1316, "Estandar", "Aerolineas Argentina", 2, 454556658498189, "Tierra del Fuego", 300, $pasajerosViaje1, $responsableDePrueba, 3500, "Ida");

// Viaje terrestre de prueba
$objViajeTerrestre1 = new ViajeTerrestre("Cama", 6516813518465181651, "Santiago del Estero", 130, $pasajerosViaje2, $responsableDePrueba, 500, "Ida");
$objViajeTerrestre2 = new ViajeTerrestre("Semicama", 6518163215196818994, "San Juan", 110, $pasajerosViaje1, $responsableDePrueba, 350, "Ida y Vuelta");

// El conjunto de viajes
$viajes = [$objViajeAereo1, $objViajeAereo2, $objViajeTerrestre1, $objViajeTerrestre2];

/**
 * Función que simula un menú de opciones y verifica su respuesta
 * @return int
 */

function menu()
{

    do {
        echo "\n---------------------\nIngrese una opción:\n\n1) Cargar viaje\n2) Modificar un viaje\n3) Ver datos de un viaje\n4) Vender un pasaje\n0) Salir\nOpción: ";
        $respuesta = trim(fgets(STDIN));
        if (!(is_int($respuesta)) && ($respuesta < 0 || $respuesta > 4)) {
            echo "Opcion incorrecta.\n";
        }
    } while (!(is_int($respuesta)) && ($respuesta < 0 || $respuesta > 4));

    return ($respuesta);
}


/**
 * Función que simula un menú para crear un Responsable
 * @return object
 */
function menuReponsable()
{

    echo "Ingrese el nombre del responsable del viaje: ";
    $nombreResponsable = trim(fgets(STDIN));
    echo "Ingrese el apellido del responsable del viaje: ";
    $apellidoResponsable = trim(fgets(STDIN));
    echo "Ingrese el número de empleado del responsable del viaje: ";
    $numEmpleadoResponsable = trim(fgets(STDIN));
    echo "Ingrese el número de licencia del responsable del viaje: ";
    $numLicenciaResponsable = trim(fgets(STDIN));
    $responsable = new ResponsableV($nombreResponsable, $apellidoResponsable, $numEmpleadoResponsable, $numLicenciaResponsable);
    echo "Responsable: " . $responsable . "\n";

    return $responsable;
}

/**
 * Función que simula un menú para agregar un pasajero
 * @return object
 */

function menuPasajero()
{

    echo "Ingrese el nombre del pasajero: ";
    $nomPasajeroIng = trim(fgets(STDIN));
    echo "Ingrese el apellido del pasajero: ";
    $apePasajeroIng = trim(fgets(STDIN));
    echo "Ingrese el número de documento del pasajero: ";
    $docPasajeroIng = trim(fgets(STDIN));
    echo "Ingrese el número de teléfono del pasajero: ";
    $telPasajeroIng = trim(fgets(STDIN));
    $pasajeroTemporal = [$nomPasajeroIng, $apePasajeroIng, $docPasajeroIng, $telPasajeroIng];

    return $pasajeroTemporal;
}

/**
 * Función que crea un viaje pidiendo todos sus datos
 * @return object $viajeCreado
 */

function crearViaje()
{

    do {
        echo "Tipo de viaje:\nAereo = 1\nTerrestre = 2\n";
        $tipoDeViaje = trim(fgets(STDIN));
        if ($tipoDeViaje > 2 || $tipoDeViaje < 1) {
            echo "Por favor ingrese una opción correcta.\n";
        }
    } while ($tipoDeViaje > 2 || $tipoDeViaje < 1);
    echo "Ingrese el código de viaje: ";
    $codViajeIng = trim(fgets(STDIN));
    echo "Ingrese el nombre del destino: ";
    $destinoViajeIng = trim(fgets(STDIN));
    $responsable = menuReponsable();
    echo "Ingrese la cantidad máxima de pasajeros: ";
    $cantMaxPasajerosIng = trim(fgets(STDIN));
    $pasajeros = [];
    echo "Ingrese el importe del viaje: ";
    $importeViaje = trim(fgets(STDIN));
    do {
        echo "Ingrese el comportamiento de viaje:\nIda = 1\nIda y Vuelta = 2\n";
        $compViaje = trim(fgets(STDIN));
        if ($compViaje > 2 || $compViaje < 1) {
            echo "Ingrese una opción correcta.\n";
        }
    } while ($compViaje > 2 || $compViaje < 1);

    if ($compViaje == 2) {
        $compViaje = "Ida y Vuelta";
    } else {
        $compViaje = "Ida";
    }

    if ($tipoDeViaje == 1) {
        echo "Ingrese el número de vuelo: ";
        $numVuelo = trim(fgets(STDIN));
        do {
            echo "Ingrese la categoría de Asientos:\nPrimera Clase = 1\nEstandar = 2\n";
            $catAsientos = trim(fgets(STDIN));
            if ($catAsientos > 2 || $catAsientos < 1) {
                echo "Ingrese una opción correcta\n";
            }
        } while ($catAsientos > 2 || $catAsientos < 1);
        if ($catAsientos == 2) {
            $catAsientos = "Estandar";
        } else {
            $catAsientos = "Primera Clase";
        }
        echo "Ingrese el nombre de la Aerolinea: ";
        $nomAero = trim(fgets(STDIN));
        echo "Ingrese la cantidad de Escalas: ";
        $cantEscalas = trim(fgets(STDIN));

        $viajeCreado = new ViajeAereo($numVuelo, $catAsientos, $nomAero, $cantEscalas, $codViajeIng, $destinoViajeIng, $cantMaxPasajerosIng, $pasajeros, $responsable, $importeViaje, $compViaje);
    } else {
        do {
            echo "Ingrese el tipo de asiento:\nCama = 1\nSemicama = 2";
            $asientosViaje = trim(fgets(STDIN));
            if ($asientosViaje > 2 || $asientosViaje < 1) {
                echo "Ingrese una opción correcta\n";
            }
        } while ($asientosViaje > 2 || $asientosViaje < 1);
        if ($asientosViaje == 2) {
            $asientosViaje = "Semicama";
        } else {
            $asientosViaje = "Cama";
        }

        $viajeCreado = new ViajeTerrestre($asientosViaje, $codViajeIng, $destinoViajeIng, $cantMaxPasajerosIng, $pasajeros, $responsable, $importeViaje, $compViaje);
    }

    // Nos aseguramos que la cantidad de pasajeros sea menor o igual a la cantidad máxima y que sea un número positivo o 0
    do {

        echo "Ingrese la cantidad de pasajeros: ";
        $cantPasajerosIng = trim(fgets(STDIN));

        if ($cantPasajerosIng > $cantMaxPasajerosIng) {
            echo "La cantidad de pasajeros no puede ser mayor que la cantidad máxima de pasajeros (" . $cantMaxPasajerosIng . ").\n";
        } elseif ($cantPasajerosIng < 0) {
            echo "La cantidad de pasajeros no puede ser negativa.\n";
        } elseif ((is_int(!$cantPasajerosIng))) {
            echo "La cantidad de pasajeros debe ser un número\n";
        }
    } while ($cantPasajerosIng > $cantMaxPasajerosIng || $cantPasajerosIng < 0);

    // Si se crean pasajeros se ejecuta este menú para ingresarlos después de verificar que no se repitan
    for ($i = 0; $i < $cantPasajerosIng; $i++) {
        $nuevoPasajero = menuPasajero();
        $seRepite = $viajeCreado->pasajeroRepetido($nuevoPasajero);
        if ($seRepite == true) {
            echo "El pasajero ya se encuentra en el viaje\n";
            $i--;
        } else {
            $pasajero = new Pasajero($nuevoPasajero[0], $nuevoPasajero[1], $nuevoPasajero[2], $nuevoPasajero[3]);
            $viajeCreado->venderPasaje($pasajero);
            echo "Pasajero agregado: " . $pasajero . "\n";
        }
    }

    return $viajeCreado;
}

// ************************
// ** Programa Principal **
// ************************

do {

    // Ejecutamos el menú
    $case = menu();

    // Realizamos la acción que se elija con el menú
    switch ($case) {

            // Crear viaje
        case 1:

            $objViaje = crearViaje();
            $viajes[count($viajes)] = $objViaje;

            break;

        case 2:

            // Modificar un viaje
            do {

                // Menú con el que consultamos que viaje se desea modificar
                echo "¿Qué viaje desea modificar?\n";

                // Presentamos todos los viajes
                for ($i = 0; $i < count($viajes); $i++) {
                    $tipoDeViaje = get_class($viajes[$i]);
                    if ($tipoDeViaje == "ViajeAereo") {
                        $tipoDeViaje = "Aereo";
                    } else {
                        $tipoDeViaje = "Terrestre";
                    }
                    echo $i + 1 . ". " . $tipoDeViaje . " - Destino: " . $viajes[$i]->getDestino() . " - Código: " . $viajes[$i]->getCodigo() . "\n";
                }
                echo "Opción: ";
                $viajeAModificar = trim(fgets(STDIN));

                // Mensaje de error
                if ($viajeAModificar < 1 || $viajeAModificar > count($viajes)) {
                    echo "No existe el viaje " . $viajeAModificar . "\n";
                }
            } while ($viajeAModificar < 1 || $viajeAModificar > count($viajes)); // Para asegurar una respuesta correcta

            do {

                $respuestaCorrecta = false;
                // Consultamos que desea modificar
                echo "¿Qué desea modificar del viaje?\n";
                echo "1) Código: " . $viajes[$viajeAModificar - 1]->getCodigo() . "\n";
                echo "2) Destino: " . $viajes[$viajeAModificar - 1]->getDestino() . "\n";
                echo "3) Cantidad máxima de pasajeros: " . $viajes[$viajeAModificar - 1]->getMaxpasajeros() . "\n";
                echo "4) Pasajeros : " . count($viajes[$viajeAModificar - 1]->getPasajeros()) . "\n";
                echo "5) Responsable\n";
                $tipoDeViaje = get_class($viajes[$viajeAModificar - 1]);
                if ($tipoDeViaje == "ViajeAereo") {
                    echo "6) Número de vuelo: " . $viajes[$viajeAModificar - 1]->getNumeroDeVuelo() . "\n";
                    echo "7) Categoría de asientos: " . $viajes[$viajeAModificar - 1]->getCategoriaDeAsientos() . "\n";
                    echo "8) Nombre de la Aerolinea: " . $viajes[$viajeAModificar - 1]->getNombreAerolinea() . "\n";
                    echo "9) Cantidad de Escalas: " . $viajes[$viajeAModificar - 1]->getCantidadDeEscalas() . "\n";
                } else {
                    echo "6) Comodidad de Asientos: " . $viajes[$viajeAModificar - 1]->getComodidadAsientos() . "\n";
                }
                echo "0) No modificar nada.\nOpción: ";
                $rta = trim(fgets(STDIN));

                // Mensaje de error
                if ($tipoDeViaje == "ViajeAereo") {
                    if ($rta < 0 || $rta > 9) {
                        echo "Opción incorrecta\n";
                    } else {
                        $respuestaCorrecta = true;
                    }
                } else {
                    if ($rta < 0 || $rta > 6) {
                        echo "Opción incorrecta\n";
                    } else {
                        $respuestaCorrecta = true;
                    }
                }
            } while ($respuestaCorrecta == false); // Para asegurar una respuesta correcta


            switch ($rta) {

                    // Cambiar el código
                case 1:

                    echo "Ingrese el nuevo código de viaje: ";
                    $nuevoCodigo = trim(fgets(STDIN));
                    $viajes[$viajeAModificar - 1]->setCodigo($nuevoCodigo);

                    break;

                    // Cambiar el destino
                case 2:

                    echo "Ingrese el nuevo destino de viaje: ";
                    $nuevoDestino = trim(fgets(STDIN));
                    $viajes[$viajeAModificar - 1]->setDestino($nuevoDestino);

                    break;

                    // Cambiar la cantidad máxima de pasajeros
                case 3:

                    // Para asegurar que la cantidad máxima de pasajeros no pase a ser menor que la cantidad de pasajeros actuales
                    do {

                        echo "Ingrese la nueva cantidad máxima de pasajeros del viaje\n(No puede ser menor que la cantidad de pasajeros actuales)(" . count($viajes[$viajeAModificar - 1]->getPasajeros()) . "): ";
                        $nuevaCantMax = trim(fgets(STDIN));
                        $cambiado = false;

                        if ($nuevaCantMax >= count($viajes[$viajeAModificar - 1]->getPasajeros()) && is_numeric($nuevaCantMax)) {
                            $viajes[$viajeAModificar - 1]->setMaxpasajeros($nuevaCantMax);
                            $cambiado = true;
                        }

                        // Mensaje de error
                        else {
                            echo "No se cumple la condición\n";
                        }
                    } while ($cambiado == false); // Para asegurar una respuesta correcta

                    break;

                case 4:

                    do {

                        // Consultamos que se desea hacer con los pasajeros
                        echo "¿Qué deséa hacer con los pasajeros?\n1. Agregar un pasajero\n2. Borrar un pasajero\n3. Modificar un pasajero\n0. No hacer nada\nOpción: ";
                        $accionPasajero = trim(fgets(STDIN));

                        $listaDePasajeros = $viajes[$viajeAModificar - 1]->getPasajeros();

                        // Agregar un pasajero
                        if ($accionPasajero == 1) {

                            if ($viajes[$viajeAModificar - 1]->hayPasajesDisponibles()) {
                                do {
                                    $nuevoPasajero = menuPasajero();
                                    $comprobarNuevoPasajero = $viajes[$viajeAModificar - 1]->pasajeroRepetido($nuevoPasajero);

                                    if ($comprobarNuevoPasajero == true) {
                                        echo "El pasajero ya se encuentra en el viaje\n";
                                    }
                                } while ($comprobarNuevoPasajero == true);

                                $pasajero = new Pasajero($nuevoPasajero[0], $nuevoPasajero[1], $nuevoPasajero[2], $nuevoPasajero[3]);
                                $viajes[$viajeAModificar - 1]->venderPasaje($pasajero);
                            } else {
                                echo "El viaje ya alcanzó su cupo máximo de pasajeros\n";
                            }
                        }

                        // Borrar un pasajero
                        elseif ($accionPasajero == 2) {

                            if (count($viajes[$viajeAModificar - 1]->getPasajeros()) > 0) {

                                do {

                                    echo "¿Qué pasajero deséa borrar? (0 para volver al menú principal)\n";
                                    echo $viajes[$viajeAModificar - 1]->listaDePasajeros();
                                    echo "Opción: ";
                                    $pasajeroABorrar = trim(fgets(STDIN));

                                    if ($pasajeroABorrar > 0 && $pasajeroABorrar <= count($listaDePasajeros)) {

                                        //array_splice($listaDePasajeros, ($pasajeroABorrar - 1), 1);
                                        $nuevaLista = [];
                                        for ($i = 0; $i < (count($listaDePasajeros)); $i++) {
                                            $j = $i;
                                            if ($i >= $pasajeroABorrar - 1) {
                                                $j = $i - 1;
                                            }
                                            if ($i <> ($pasajeroABorrar - 1)) {
                                                $nuevaLista[$j] = $listaDePasajeros[$i];
                                            }
                                        }

                                        $viajes[$viajeAModificar - 1]->setPasajeros($nuevaLista);
                                        $pasajeroABorrar = $pasajeroABorrar - 1;
                                    } elseif ($pasajeroABorrar == 0) {
                                        echo "\n";
                                    } else {
                                        echo "Opción incorrecta\n";
                                    }
                                } while ($pasajeroABorrar < 0 || $pasajeroABorrar > count($listaDePasajeros) && (!is_int($pasajeroABorrar)));
                            } else {
                                echo "Este viaje no tiene pasajeros\n";
                            }
                        }

                        // Modificar un pasajero
                        elseif ($accionPasajero == 3) {

                            if (count($viajes[$viajeAModificar - 1]->getPasajeros()) > 0) {

                                do {

                                    // Exponemos la lista de pasajeros
                                    echo "¿Qué pasajero deséa modificar?\n";
                                    echo $viajes[$viajeAModificar - 1]->listaDePasajeros();
                                    echo "Opción: ";
                                    $pasajeroAModificar = trim(fgets(STDIN));

                                    if ($pasajeroAModificar > 0 && $pasajeroAModificar <= count($listaDePasajeros)) {

                                        do {

                                            // Menú para chequear que se va a modificar
                                            echo "¿Qué deséa modificar del pasajero: " . $listaDePasajeros[$pasajeroAModificar - 1]->getNombre() . " " . $listaDePasajeros[$pasajeroAModificar - 1]->getApellido() . "\n";
                                            echo "1) Nombre: " . $listaDePasajeros[$pasajeroAModificar - 1]->getNombre() . "\n";
                                            echo "2) Apellido: " . $listaDePasajeros[$pasajeroAModificar - 1]->getApellido() . "\n";
                                            echo "3) Documento: " . $listaDePasajeros[$pasajeroAModificar - 1]->getDocumento() . "\n";
                                            echo "4) Teléfono: " . $listaDePasajeros[$pasajeroAModificar - 1]->getTelefono() . "\n";
                                            echo "0) No modificar nada.\nOpción: ";
                                            $opcionIngresada = trim(fgets(STDIN));

                                            // Cambio de nombre
                                            if ($opcionIngresada == 1) {

                                                echo "Ingrese el nuevo nombre: ";
                                                $nuevoNombre = trim(fgets(STDIN));
                                                $viajes[$viajeAModificar - 1]->modificarDatosDePasajeros($nuevoNombre, 1, $pasajeroAModificar - 1);
                                            }

                                            // Cambio de apellido
                                            elseif ($opcionIngresada == 2) {

                                                echo "Ingrese el nuevo apellido: ";
                                                $nuevoApellido = trim(fgets(STDIN));
                                                $viajes[$viajeAModificar - 1]->modificarDatosDePasajeros($nuevoApellido, 2, $pasajeroAModificar - 1);
                                            }

                                            // Cambio de documento
                                            elseif ($opcionIngresada == 3) {

                                                echo "Ingrese el nuevo documento: ";
                                                $nuevoDocumento = trim(fgets(STDIN));
                                                $viajes[$viajeAModificar - 1]->modificarDatosDePasajeros($nuevoDocumento, 3, $pasajeroAModificar - 1);
                                            }

                                            // Cambio de Teléfono
                                            elseif ($opcionIngresada == 4) {

                                                echo "Ingrese el nuevo teléfono: ";
                                                $nuevoTelefono = trim(fgets(STDIN));
                                                $viajes[$viajeAModificar - 1]->modificarDatosDePasajeros($nuevoTelefono, 4, $pasajeroAModificar - 1);
                                            }

                                            // Salir
                                            elseif ($opcionIngresada == 0) {
                                                echo "\n";
                                            }

                                            // Opción incorrecta
                                            else {
                                                echo "Opción incorrecta.\n";
                                            }
                                        } while ($opcionIngresada < 0 || $opcionIngresada > 4 && (!is_int($opcionIngresada))); // Para asegurar una respuesta correcta

                                    }
                                    // Mensaje de error
                                    else {
                                        echo "Opción incorrecta\n";
                                    }
                                } while ($pasajeroAModificar < 0 || $pasajeroAModificar > count($listaDePasajeros) && (!is_int($pasajeroAModificar))); // Para asegurar una respuesta correcta

                            } else {
                                echo "Este viaje no tiene pasajeros\n";
                            }
                        } elseif ($accionPasajero == 0) {
                            echo "\n";
                        }

                        // Mensaje de error
                        else {
                            echo "Opción incorrecta";
                        }
                    } while ($accionPasajero > 3 || $accionPasajero < 0); //Para asegurar una respuesta correcta

                    break;

                case 5:

                    do {

                        // Menú para chequear que se va a modificar
                        echo "¿Qué deséa modificar del responsable: " . $viajes[$viajeAModificar - 1]->getResponsable()->getNombre() . " " . $viajes[$viajeAModificar - 1]->getResponsable()->getApellido() . "\n";
                        echo "1) Nombre: " . $viajes[$viajeAModificar - 1]->getResponsable()->getNombre() . "\n";
                        echo "2) Apellido: " . $viajes[$viajeAModificar - 1]->getResponsable()->getApellido() . "\n";
                        echo "3) Número de Empleado: " . $viajes[$viajeAModificar - 1]->getResponsable()->getNumeroDeEmpleado() . "\n";
                        echo "4) Número de Licencia: " . $viajes[$viajeAModificar - 1]->getResponsable()->getNumeroDeLicencia() . "\n";
                        echo "0) No modificar nada.\nOpción: ";
                        $opcionIngresada = trim(fgets(STDIN));

                        // Cambio de nombre
                        if ($opcionIngresada == 1) {
                            echo "Ingrese el nuevo nombre: ";
                            $nuevoNombre = trim(fgets(STDIN));
                            $viajes[$viajeAModificar - 1]->modificarDatosReponsable($nuevoNombre, 1);
                        }

                        // Cambio de apellido
                        elseif ($opcionIngresada == 2) {
                            echo "Ingrese el nuevo apellido: ";
                            $nuevoApellido = trim(fgets(STDIN));
                            $viajes[$viajeAModificar - 1]->modificarDatosReponsable($nuevoApellido, 2);
                        }

                        // Cambio de número de empleado
                        elseif ($opcionIngresada == 3) {
                            echo "Ingrese el nuevo número de Empleado: ";
                            $nuevoNumeroDeEmpleado = trim(fgets(STDIN));
                            $viajes[$viajeAModificar - 1]->modificarDatosReponsable($nuevoNumeroDeEmpleado, 3);
                        }

                        // Cambio de número de licencia
                        elseif ($opcionIngresada == 4) {
                            echo "Ingrese el nuevo número de licencia: ";
                            $nuevoNumeroDeLicencia = trim(fgets(STDIN));
                            $viajes[$viajeAModificar - 1]->modificarDatosReponsable($nuevoNumeroDeLicencia, 4);
                        }

                        // Salir
                        elseif ($opcionIngresada == 0) {
                            echo "\n";
                        }

                        // Opción incorrecta
                        else {
                            echo "Opción incorrecta.\n";
                        }
                    } while ($opcionIngresada < 0 || $opcionIngresada > 4 && (!is_int($opcionIngresada))); // Para asegurar una respuesta correcta

                    break;

                case 6:

                    // 2 opciones porque la opción 6 va a variar dependiendo del tipo de viaje
                    // Opción 1 si el viaje es Aereo
                    // Vamos a cambiar el número de vuelo
                    $tipoDeViaje = get_class($viajes[$viajeAModificar - 1]);
                    if ($tipoDeViaje == "ViajeAereo") {

                        echo "Ingrese el nuevo número de vuelo: ";
                        $numVueloN = trim(fgets(STDIN));
                        $viajes[$viajeAModificar - 1]->setNumeroDeVuelo($numVueloN);
                    }
                    // Opción 2 si el viaje es Terrestre
                    // En caso de que el viaje sea Terrestre se va a cambiar el tipo de asiento, no dejando escribir, ya que al ser 2 opciones las alterna entre si
                    else {
                        if ($viajes[$viajeAModificar - 1]->getComodidadAsientos() == "Cama") {
                            $viajes[$viajeAModificar - 1]->setComodidadAsientos("Semicama");
                        } else {
                            $viajes[$viajeAModificar - 1]->setComodidadAsientos("Cama");
                        }
                        echo "La comodidad de los asientos se cambió a: " . $viajes[$viajeAModificar - 1]->getComodidadAsientos();
                    }

                    break;

                case 7:

                    // Opción 7 solo caso Aereo
                    // Cambia la categoria de asientos entre si, sin dejar escribir, alternando entre las 2 opciones que hay
                    if ($viajes[$viajeAModificar - 1]->getCategoriaDeAsientos() == "Primera Clase") {
                        $viajes[$viajeAModificar - 1]->setCategoriaDeAsientos("Estandar");
                    } else {
                        $viajes[$viajeAModificar - 1]->setCategoriaDeAsientos("Primera Clase");
                    }
                    echo "La categoría de asientos se modificó a: " . $viajes[$viajeAModificar - 1]->getCategoriaDeAsientos();
                    break;

                case 8:

                    // Cambiar el nombre de la Aerolinea
                    echo "Ingrese el nuevo nombre de la aerolinea: ";
                    $nuevoNombreAerolinea = trim(fgets(STDIN));
                    $viajes[$viajeAModificar - 1]->setNombreAerolinea($nuevoNombreAerolinea);
                    break;

                case 9:

                    // Cambiar la cantidad de escalas
                    echo "Ingrese la nueva cantidad de Escalas: ";
                    $nuevaCantEscalas = trim(fgets(STDIN));
                    $viajes[$viajeAModificar - 1]->setCantidadDeEscalas($nuevaCantEscalas);
                    break;
            }

            break;

        case 3:
            // Mostrar información de un viaje
            echo "Seleccione el viaje del que quiere ver la información:\n";

            do {

                // Mostramos los viajes guardados
                for ($i = 0; $i < count($viajes); $i++) {
                    $tipoDeViaje = get_class($viajes[$i]);
                    if ($tipoDeViaje == "ViajeAereo") {
                        $tipoDeViaje = "Aereo";
                    } else {
                        $tipoDeViaje = "Terrestre";
                    }
                    echo $i + 1 . ". " . $tipoDeViaje . " - Destino: " . $viajes[$i]->getDestino() . " - Código: " . $viajes[$i]->getCodigo() . "\n";
                }
                echo "Opción: ";
                $viajeABuscar = trim(fgets(STDIN));

                if ($viajeABuscar > count($viajes) || $viajeABuscar < 1) {
                    echo "Opción incorrecta\n";
                }
            } while ($viajeABuscar > count($viajes) || $viajeABuscar < 1);

            echo $viajes[$viajeABuscar - 1];

            break;
        case 4:

            // Vender un pasaje
            do {
                echo "De que viaje deséa vender un pasaje?\n";
                // Presentamos todos los viajes
                for ($i = 0; $i < count($viajes); $i++) {
                    $tipoDeViaje = get_class($viajes[$i]);
                    if ($tipoDeViaje == "ViajeAereo") {
                        $tipoDeViaje = "Aereo";
                    } else {
                        $tipoDeViaje = "Terrestre";
                    }
                    echo $i + 1 . ". " . $tipoDeViaje . " - Destino: " . $viajes[$i]->getDestino() . " - Código: " . $viajes[$i]->getCodigo() . "\n";
                }

                echo "Opción: ";
                $viajeAVenderPasaje = trim(fgets(STDIN));

                if ($viajeAVenderPasaje < 1 && $viajeAVenderPasaje > count($viajes)) {
                    echo "Opción incorrecta\n";
                }
            } while ($viajeAVenderPasaje < 1 && $viajeAVenderPasaje > count($viajes));

            if ($viajes[$viajeAVenderPasaje - 1]->hayPasajesDisponibles()) {
                do {
                    $nuevoPasajero = menuPasajero();
                    $comprobarNuevoPasajero = $viajes[$viajeAVenderPasaje - 1]->pasajeroRepetido($nuevoPasajero);

                    if ($comprobarNuevoPasajero == true) {
                        echo "El pasajero ya se encuentra en el viaje\n";
                    }
                } while ($comprobarNuevoPasajero == true);

                $pasajero = new Pasajero($nuevoPasajero[0], $nuevoPasajero[1], $nuevoPasajero[2], $nuevoPasajero[3]);
                $viajes[$viajeAVenderPasaje - 1]->venderPasaje($pasajero);
            } else {
                echo "El viaje ya alcanzó su cupo máximo de pasajeros\n";
            }

            break;
        case 0:
            echo "Fin del programa";

            break;
    }
} while ($case <> 0);
