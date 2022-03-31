<?php

    include 'Viaje.php';

    $pasajeroD1 = [ 'nombre' => "Juan",
                    'apellido' => "Lopez",
                    'documento' => 25643215];
                    
    $pasajeroD2 = [ 'nombre' => "Maria",
                    'apellido' => "Ave",
                    'documento' => 34659825];

    $pasajeroD3 = [ 'nombre' => "Fernando",
                    'apellido' => "Perez",
                    'documento' => 15135647];

    $pasajeroD4 = [ 'nombre' => "Carmen",
                    'apellido' => "Reinike",
                    'documento' => 8431659];

    $pasajerosViaje1 = [$pasajeroD1, $pasajeroD2, $pasajeroD3, $pasajeroD4];

    $viaje1 = new Viaje(645165443651458, "La Pampa", 50, $pasajerosViaje1);
    $viajes[0] = $viaje1;

    function menu() {

        do {
            echo "---------------------\nIngrese una opción:\n\n1) Cargar viaje\n2) Modificar un viaje\n3) Ver datos de un viaje\n0) Salir\nOpción: ";
            $respuesta = trim(fgets(STDIN));
            if (!(is_int($respuesta)) && ($respuesta < 0 || $respuesta > 3)) {
                echo "Opcion incorrecta.\n";
            }
        } while (!(is_int($respuesta)) && ($respuesta < 0 || $respuesta > 3));

        return ($respuesta);
    }

    function menuPasajero() {

        echo "Ingrese el nombre del pasajero: ";
        $nomPasajeroIng = trim(fgets(STDIN));
        echo "Ingrese el apellido del pasajero: ";
        $apePasajeroIng = trim(fgets(STDIN));
        echo "Ingrese el número de documento del pasajero: ";
        $docPasajeroIng = trim(fgets(STDIN));

        $pasajero = ['nombre' => $nomPasajeroIng,
                     'apellido' => $apePasajeroIng,
                     'documento' => $docPasajeroIng];

        return $pasajero;

    }

    $pasajeros = [];



    do {
    
        $case = menu();

        switch ($case) {

            case 1: 
    
                echo "Ingrese el código de viaje: ";
                $codViajeIng = trim(fgets(STDIN));
                echo "Ingrese el nombre del destino: ";
                $destinoViajeIng = trim(fgets(STDIN));
                echo "Ingrese la cantidad máxima de pasajeros: ";
                $cantMaxPasajerosIng = trim(fgets(STDIN));
                do {
    
                    echo "Ingrese la cantidad de pasajeros: ";
                    $cantPasajerosIng = trim(fgets(STDIN));
    
                    if ($cantPasajerosIng > $cantMaxPasajerosIng) {
                        echo "La cantidad de pasajeros no puede ser mayor que la cantidad máxima de pasajeros (". $cantMaxPasajerosIng. ").\n";
                    }
                    elseif ($cantPasajerosIng < 0) {
                        echo "La cantidad de pasajeros no puede ser negativa.\n";
                    }
                    elseif ((is_int(!$cantPasajerosIng))) {
                        echo "La cantidad de pasajeros debe ser un número\n";
                    }
    
                } while ($cantPasajerosIng > $cantMaxPasajerosIng || $cantPasajerosIng < 0);

                $pasajeros = [];
    
                for ($i = 0;$i < $cantPasajerosIng; $i++) {
                    $pasajeros[$i] = menuPasajero();
                }
                
                $viajes[count($viajes)] = new Viaje($codViajeIng, $destinoViajeIng, $cantMaxPasajerosIng, $pasajeros);
    
                break;
    
            case 2:
    
                do {

                    echo "¿Qué viaje desea modificar?\n";
                    for ($i = 0; $i < count($viajes); $i++) {
                        echo $i + 1 . ". Destino: ". $viajes[$i]->getDestino(). " - Código: ". $viajes[$i]->getCodigo(). "\n";
                    }
                    echo "Opción: ";
                    $viajeAModificar = trim(fgets(STDIN));

                    if ($viajeAModificar < 1 || $viajeAModificar > count($viajes)) {
                        echo "No existe el viaje ". $viajeAModificar. "\n";
                    }

                } while($viajeAModificar < 1 || $viajeAModificar > count($viajes));

                do {
                    echo "¿Qué desea modificar del viaje?\n";
                    echo "1) Código: ". $viajes[$viajeAModificar - 1]->getCodigo(). "\n";
                    echo "2) Destino: ". $viajes[$viajeAModificar - 1]->getDestino(). "\n";
                    echo "3) Cantidad máxima de pasajeros: ". $viajes[$viajeAModificar - 1]->getMaxpasajeros(). "\n";
                    echo "4) Pasajeros : ". count($viajes[$viajeAModificar - 1]->getPasajeros()). "\n";
                    echo "0) No modificar nada.\nOpción: ";
                    $rta = trim(fgets(STDIN));

                    if ($rta < 0 || $rta > 4) {
                        echo "Opción incorrecta\n";
                    }

                } while($rta < 0 || $rta > 4);

                
                switch ($rta) {

                    case 1:

                        echo "Ingrese el nuevo código de viaje: ";
                        $nuevoCodigo = trim(fgets(STDIN));
                        $viajes[$viajeAModificar - 1]->setCodigo($nuevoCodigo);

                        break;

                    case 2:

                        echo "Ingrese el nuevo destino de viaje: ";
                        $nuevoDestino = trim(fgets(STDIN));
                        $viajes[$viajeAModificar - 1]->setDestino($nuevoDestino);

                        break;

                    case 3:

                        do {

                            echo "Ingrese la nueva cantidad máxima de pasajeros del viaje\n(No puede ser menor que la cantidad de pasajeros actuales): ";
                            $nuevaCantMax = trim(fgets(STDIN));
                            $cambiado = false;

                            if ($nuevaCantMax >= count($viajes[$viajeAModificar - 1]->getPasajeros()) && is_numeric($nuevaCantMax)){
                                $viajes[$viajeAModificar - 1]->setMaxpasajeros($nuevaCantMax);
                                $cambiado = true;
                            }

                            else {
                                echo "No se cumple la condición\n";
                            }

                        } while ($cambiado == false);
                        
                        break;
                
                    case 4: 
                        
                        do {

                            echo "¿Qué deséa hacer con los pasajeros?\n1. Agregar un pasajero\n2. Borrar un pasajero\n3. Modificar un pasajero\n0. No hacer nada\nOpción: ";
                            $accionPasajero = trim(fgets(STDIN));
                        
                            $listaDePasajeros = $viajes[$viajeAModificar - 1]->getPasajeros();

                            if ($accionPasajero == 1) {

                                $nuevoPasajero = menuPasajero();
                                array_push($listaDePasajeros, $nuevoPasajero);
                                $viajes[$viajeAModificar - 1]->setPasajeros($listaDePasajeros);
                            
                            }
                            elseif ($accionPasajero == 2) {

                                do {

                                    echo "¿Qué pasajero deséa borrar?\n";
                                    $viajes[$viajeAModificar - 1]->listaDePasajeros();
                                    echo "Opción: ";
                                    $pasajeroABorrar = trim(fgets(STDIN));

                                    if ($pasajeroABorrar > 0 && $pasajeroABorrar <= count($listaDePasajeros)) {

                                        array_splice($listaDePasajeros, ($pasajeroABorrar - 1), 1);
                                        $viajes[$viajeAModificar - 1]->setPasajeros($listaDePasajeros);

                                    }
                                    else {
                                        echo "Opción incorrecta\n";
                                    }

                                } while ($pasajeroABorrar < 0 || $pasajeroABorrar > count($listaDePasajeros) && (!is_int($pasajeroABorrar)));

                            }
                            elseif ($accionPasajero == 3) {

                                do {

                                    echo "¿Qué pasajero deséa modificar?\n";
                                    $viajes[$viajeAModificar - 1]->listaDePasajeros();
                                    echo "Opción: ";
                                    $pasajeroAModificar = trim(fgets(STDIN));

                                    if ($pasajeroAModificar > 0 && $pasajeroAModificar <= count($listaDePasajeros)) {

                                        do {

                                            echo "¿Qué deséa modificar del pasajero: ". $listaDePasajeros[$pasajeroAModificar - 1]['nombre']. " ". $listaDePasajeros[$pasajeroAModificar - 1]['apellido']. "\n";
                                            echo "1) Nombre: ". $listaDePasajeros[$pasajeroAModificar - 1]['nombre']. "\n";
                                            echo "2) Apellido: ". $listaDePasajeros[$pasajeroAModificar - 1]['apellido']. "\n";
                                            echo "3) Documento: ". $listaDePasajeros[$pasajeroAModificar - 1]['documento']. "\n";
                                            echo "0) No modificar nada.\nOpción: ";
                                            $opcionIngresada = trim(fgets(STDIN));

                                            if ($opcionIngresada == 1) {

                                                echo "Ingrese el nuevo nombre: ";
                                                $nuevoNombre = trim(fgets(STDIN));
                                                $viajes[$viajeAModificar -1]->setNombrePasajero($nuevoNombre,$pasajeroAModificar - 1);

                                            }
                                            
                                            elseif ($opcionIngresada == 2) {

                                                echo "Ingrese el nuevo apellido: ";
                                                $nuevoApellido = trim(fgets(STDIN));
                                                $viajes[$viajeAModificar -1]->setApellidoPasajero($nuevoApellido,$pasajeroAModificar - 1);

                                            }
    
                                            elseif ($opcionIngresada == 3) {

                                                echo "Ingrese el nuevo documento: ";
                                                $nuevoDocumento = trim(fgets(STDIN));
                                                $viajes[$viajeAModificar -1]->setDocumentoPasajero($nuevoDocumento,$pasajeroAModificar - 1);

                                            }
    
                                            elseif ($opcionIngresada == 0) {

                                            }
    
                                            else {
                                                echo "Opción incorrecta.\n";
                                            }

                                        } while ($opcionIngresada < 0 || $opcionIngresada > 3 && (!is_int($opcionIngresada)));

                                    }

                                    else {

                                        echo "Opción incorrecta\n";
                                    }


                                } while ($pasajeroAModificar < 0 || $pasajeroAModificar > count($listaDePasajeros) && (!is_int($pasajeroAModificar)));

                            }
                            elseif ($accionPasajero == 0) {

                            }

                            else {
                                echo "Opción incorrecta";
                            }

                        
                        } while($accionPasajero > 3 || $accionPasajero < 0);

                        break;

                }

                break;

            case 3:
    
                echo "Seleccione el viaje del que quiere ver la información:\n"; 
    
                do {

                    for ($i = 0; $i < count($viajes); $i++) {
                        echo $i + 1 . ". Destino: ". $viajes[$i]->getDestino(). " - Código: ". $viajes[$i]->getCodigo(). "\n";
                    }
                    echo "Opción: ";
                    $viajeABuscar = trim(fgets(STDIN));

                    if ($viajeABuscar > count($viajes) || $viajeABuscar < 1){
                        echo "Opción incorrecta\n";
                    }

                } while($viajeABuscar > count($viajes) || $viajeABuscar < 1);
                    
                /*echo "¿Deséa ver los datos de los pasajeros? (s): ";
                $mostrarPasajeros = trim(fgets(STDIN));
    
                if ($mostrarPasajeros == "s") {*/
                    echo $viajes[$viajeABuscar - 1]. "\nLista de pasajeros:\n";
                    $viajes[$viajeABuscar - 1]->listaDePasajeros();
                /*}*/

    
                break;
    
            
            case 0:
                echo "Fin del programa";
    
                break;
    
        }
    } while($case <> 0);

    /*Implementar un script testViaje.php que cree una instancia de la clase Viaje y presente un menú que permita cargar 
    la información del viaje, modificar y ver sus datos.*/