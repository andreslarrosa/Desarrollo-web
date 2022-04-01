<?php

    include 'Viaje.php';

    // Pasajeros de prueba 
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

    // Viaje de prueba
    $viaje1 = new Viaje(645165443651458, "La Pampa", 50, $pasajerosViaje1);

    // El conjunto de viajes
    $viajes[0] = $viaje1;


    /**
     * Función que muestra la lista de pasajeros con sus datos
     * @param object $viaje
     */
    
    function listaDePasajerosInfo($viaje) {

        // En un principio usaba print_r, pero como no me gustaba como lo muestra decidí hacerlo manualmente
        // print_r($this->pasajeros);
    
        for ($i = 0; $i < count($viaje->getPasajeros()); $i++) {
            echo $i + 1 . ". ". $viaje->getPasajeros()[$i]['nombre']. " ". $viaje->getPasajeros()[$i]['apellido']. " - DNI: ". $viaje->getPasajeros()[$i]['documento']. "\n";
        }
    
    }

    /**
     * Función que simula un menú de opciones y verifica su respuesta
     * @return int
     */

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

    /**
     * Función que simula un menú para agregar un pasajero
     * @return array
     */

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


    // Programa Principal

    do {
    
        // Ejecutamos el menú
        $case = menu();

        // Realizamos la acción que se elija con el menú
        switch ($case) {

            // Crear viaje
            case 1: 
    
                echo "Ingrese el código de viaje: ";
                $codViajeIng = trim(fgets(STDIN));
                echo "Ingrese el nombre del destino: ";
                $destinoViajeIng = trim(fgets(STDIN));
                echo "Ingrese la cantidad máxima de pasajeros: ";
                $cantMaxPasajerosIng = trim(fgets(STDIN));

                // Nos aseguramos que la cantidad de pasajeros sea menor o igual a la cantidad máxima y que sea un número positivo o 0
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

                // Creamos un array pasajeros en caso de que se inserte 0 pasajeros para no generar errores
                $pasajeros = [];
    
                // En caso de haber creado pasajeros los guardamos en array que después vamos a asignarlos al viaje
                for ($i = 0;$i < $cantPasajerosIng; $i++) {
                    $pasajeros[$i] = menuPasajero();
                }
                
                // Creamos nuestro viaje con todos los datos recolectados
                $viajes[count($viajes)] = new Viaje($codViajeIng, $destinoViajeIng, $cantMaxPasajerosIng, $pasajeros);
    
                break;
    
            case 2:
    
                // Modificar un viaje
                do {

                    // Menú con el que consultamos que viaje se desea modificar
                    echo "¿Qué viaje desea modificar?\n";

                    // Presentamos todos los viajes
                    for ($i = 0; $i < count($viajes); $i++) {
                        echo $i + 1 . ". Destino: ". $viajes[$i]->getDestino(). " - Código: ". $viajes[$i]->getCodigo(). "\n";
                    }
                    echo "Opción: ";
                    $viajeAModificar = trim(fgets(STDIN));

                    // Mensaje de error
                    if ($viajeAModificar < 1 || $viajeAModificar > count($viajes)) {
                        echo "No existe el viaje ". $viajeAModificar. "\n";
                    }

                } while($viajeAModificar < 1 || $viajeAModificar > count($viajes)); // Para asegurar una respuesta correcta

                do {

                    // Consultamos que desea modificar
                    echo "¿Qué desea modificar del viaje?\n";
                    echo "1) Código: ". $viajes[$viajeAModificar - 1]->getCodigo(). "\n";
                    echo "2) Destino: ". $viajes[$viajeAModificar - 1]->getDestino(). "\n";
                    echo "3) Cantidad máxima de pasajeros: ". $viajes[$viajeAModificar - 1]->getMaxpasajeros(). "\n";
                    echo "4) Pasajeros : ". count($viajes[$viajeAModificar - 1]->getPasajeros()). "\n";
                    echo "0) No modificar nada.\nOpción: ";
                    $rta = trim(fgets(STDIN));

                    // Mensaje de error
                    if ($rta < 0 || $rta > 4) {
                        echo "Opción incorrecta\n";
                    }

                } while($rta < 0 || $rta > 4); // Para asegurar una respuesta correcta

                
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

                            echo "Ingrese la nueva cantidad máxima de pasajeros del viaje\n(No puede ser menor que la cantidad de pasajeros actuales)(". count($viajes[$viajeAModificar - 1]->getPasajeros()). "): ";
                            $nuevaCantMax = trim(fgets(STDIN));
                            $cambiado = false;

                            if ($nuevaCantMax >= count($viajes[$viajeAModificar - 1]->getPasajeros()) && is_numeric($nuevaCantMax)){
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

                                $nuevoPasajero = menuPasajero();
                                array_push($listaDePasajeros, $nuevoPasajero);
                                $viajes[$viajeAModificar - 1]->setPasajeros($listaDePasajeros);
                            
                            }

                            // Borrar un pasajero
                            elseif ($accionPasajero == 2) {

                                do {

                                    echo "¿Qué pasajero deséa borrar?\n";
                                    listaDePasajerosInfo($viajes[$viajeAModificar- 1]);
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

                            // Modificar un pasajero
                            elseif ($accionPasajero == 3) {

                                do {

                                    // Exponemos la lista de pasajeros
                                    echo "¿Qué pasajero deséa modificar?\n";
                                    listaDePasajerosInfo($viajes[$viajeAModificar- 1]);
                                    echo "Opción: ";
                                    $pasajeroAModificar = trim(fgets(STDIN));

                                    if ($pasajeroAModificar > 0 && $pasajeroAModificar <= count($listaDePasajeros)) {

                                        do {

                                            // Menú para chequear que se va a modificar
                                            echo "¿Qué deséa modificar del pasajero: ". $listaDePasajeros[$pasajeroAModificar - 1]['nombre']. " ". $listaDePasajeros[$pasajeroAModificar - 1]['apellido']. "\n";
                                            echo "1) Nombre: ". $listaDePasajeros[$pasajeroAModificar - 1]['nombre']. "\n";
                                            echo "2) Apellido: ". $listaDePasajeros[$pasajeroAModificar - 1]['apellido']. "\n";
                                            echo "3) Documento: ". $listaDePasajeros[$pasajeroAModificar - 1]['documento']. "\n";
                                            echo "0) No modificar nada.\nOpción: ";
                                            $opcionIngresada = trim(fgets(STDIN));

                                            // Cambio de nombre
                                            if ($opcionIngresada == 1) {

                                                echo "Ingrese el nuevo nombre: ";
                                                $nuevoNombre = trim(fgets(STDIN));
                                                $pasajeroNombreCambiado = [$nuevoNombre, $pasajeroAModificar - 1] ;
                                                $viajes[$viajeAModificar -1]->setNombrePasajero($pasajeroNombreCambiado);

                                            }
                                            
                                            // Cambio de apellido
                                            elseif ($opcionIngresada == 2) {

                                                echo "Ingrese el nuevo apellido: ";
                                                $nuevoApellido = trim(fgets(STDIN));
                                                $pasajeroApellidoCambiado = [$nuevoApellido, $pasajeroAModificar - 1] ;
                                                $viajes[$viajeAModificar -1]->setApellidoPasajero($pasajeroApellidoCambiado);

                                            }
    
                                            // Cambio de documento
                                            elseif ($opcionIngresada == 3) {

                                                echo "Ingrese el nuevo documento: ";
                                                $nuevoDocumento = trim(fgets(STDIN));
                                                $pasajeroDocumentoCambiado = [$nuevoDocumento, $pasajeroAModificar - 1] ;
                                                $viajes[$viajeAModificar -1]->setDocumentoPasajero($pasajeroDocumentoCambiado);

                                            }
    
                                            // Salir
                                            elseif ($opcionIngresada == 0) {

                                            }
    
                                            // Opción incorrecta
                                            else {
                                                echo "Opción incorrecta.\n";
                                            }

                                        } while ($opcionIngresada < 0 || $opcionIngresada > 3 && (!is_int($opcionIngresada))); // Para asegurar una respuesta correcta

                                    }

                                    // Mensaje de error
                                    else {

                                        echo "Opción incorrecta\n";
                                    }


                                } while ($pasajeroAModificar < 0 || $pasajeroAModificar > count($listaDePasajeros) && (!is_int($pasajeroAModificar))); // Para asegurar una respuesta correcta

                            }
                            elseif ($accionPasajero == 0) {

                            }

                            // Mensaje de error
                            else {
                                echo "Opción incorrecta";
                            }

                        
                        } while($accionPasajero > 3 || $accionPasajero < 0); //Para asegurar una respuesta correcta

                        break;

                }

                break;

            case 3:
                // Mostrar información de un viaje
                echo "Seleccione el viaje del que quiere ver la información:\n"; 
    
                do {

                    // Mostramos los viajes guardados
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
                    listaDePasajerosInfo($viajes[$viajeABuscar- 1]);
                /*}*/

    
                break;
    
            
            case 0:
                echo "Fin del programa";
    
                break;
    
        }

    } while($case <> 0);