<?php

    include 'Viaje.php';
    include 'Pasajero.php';
    include 'ResponsableV.php';

    // Pasajeros de prueba 
    $pasajeroD1 = new Pasajero("Carmen","Reinike",8,6);
    $pasajeroD2 = new Pasajero("Juan","Lopez",25643215,19841651989);
    $pasajeroD3 = new Pasajero("Maria","Ave",34659825,10051645894);
    $pasajeroD4 = new Pasajero("Fernando","Perez",15135647,87465119849);
    $pasajerosViaje1 = [$pasajeroD1, $pasajeroD2, $pasajeroD3, $pasajeroD4];
    $pasajerosViaje2 = [$pasajeroD2];

    // Responsable de Prueba
    $responsableDePrueba = new ResponsableV("Carlos","Benitez",15,160710);
    $responsables[0] = $responsableDePrueba;

    // Viaje de prueba
    $viaje1 = new Viaje(645165443651458, "La Pampa", 50, $pasajerosViaje1, $responsables[0]);
    $viaje2 = new Viaje(635212316546546, "Jujuy", 40, $pasajerosViaje2, $responsables[0]);

    // El conjunto de viajes
    $viajes = [$viaje1, $viaje2];

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
     * Función que simula un menú para crear un Responsable
     * @return object
     */
    function menuReponsable() {

        echo "Ingrese el nombre del responsable del viaje: ";
        $nombreResponsable = trim(fgets(STDIN));
        echo "Ingrese el apellido del responsable del viaje: ";
        $apellidoResponsable = trim(fgets(STDIN));
        echo "Ingrese el número de empleado del responsable del viaje: ";
        $numEmpleadoResponsable = trim(fgets(STDIN));
        echo "Ingrese el número de licencia del responsable del viaje: ";
        $numLicenciaResponsable = trim(fgets(STDIN));
        $reponsable = new ResponsableV($nombreResponsable,$apellidoResponsable,$numEmpleadoResponsable,$numLicenciaResponsable);

        return $reponsable;
    }

    /**
     * Función que simula un menú para agregar un pasajero
     * @return object
     */

    function menuPasajero() {

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

    function crearViaje() {

        echo "Ingrese el código de viaje: ";
        $codViajeIng = trim(fgets(STDIN));
        echo "Ingrese el nombre del destino: ";
        $destinoViajeIng = trim(fgets(STDIN));
        $responsable = menuReponsable();
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
        $viajeCreado = new Viaje($codViajeIng, $destinoViajeIng, $cantMaxPasajerosIng, $pasajeros, $responsable);

        return $viajeCreado;
    }

    /**
     * Función que comprueba si un pasajero está repetido dentro de un viaje
     * @param array $pasajero
     * @param object $viaje
     * @return boolean $seRepite
     */

    function pasajeroRepetido($pasajero, $viaje) {

        $listaDePasajeros = $viaje->getPasajeros();
        $seRepite = false;
        $i=0;
        if (count($listaDePasajeros) > 0) {
            do {

                $pasajeroABuscar[0] = $listaDePasajeros[$i]->getNombre();
                $pasajeroABuscar[1] = $listaDePasajeros[$i]->getApellido();
                $pasajeroABuscar[2] = $listaDePasajeros[$i]->getDocumento();
                $pasajeroABuscar[3] = $listaDePasajeros[$i]->getTelefono();

                if ($pasajeroABuscar == $pasajero) {
                    $seRepite = true;
                }
                $i++;
            } while ($seRepite == false && $i < count($listaDePasajeros));
        }

        return $seRepite;
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
    
                $viajeNuevo = crearViaje();
                $viajes[count($viajes)] = $viajeNuevo;
    
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
                    echo "5) Responsable\n";
                    echo "0) No modificar nada.\nOpción: ";
                    $rta = trim(fgets(STDIN));

                    // Mensaje de error
                    if ($rta < 0 || $rta > 5) {
                        echo "Opción incorrecta\n";
                    }

                } while($rta < 0 || $rta > 5); // Para asegurar una respuesta correcta

                
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

                    case 5:

                        do {
    
                            // Menú para chequear que se va a modificar
                            echo "¿Qué deséa modificar del responsable: ". $viajes[$viajeAModificar - 1]->getResponsable()->getNombre(). " ". $viajes[$viajeAModificar - 1]->getResponsable()->getApellido(). "\n";
                            echo "1) Nombre: ". $viajes[$viajeAModificar - 1]->getResponsable()->getNombre(). "\n";
                            echo "2) Apellido: ". $viajes[$viajeAModificar - 1]->getResponsable()->getApellido(). "\n";
                            echo "3) Número de Empleado: ". $viajes[$viajeAModificar - 1]->getResponsable()->getNumeroDeEmpleado(). "\n";
                            echo "4) Número de Licencia: ". $viajes[$viajeAModificar - 1]->getResponsable()->getNumeroDeLicencia(). "\n";
                            echo "0) No modificar nada.\nOpción: ";
                            $opcionIngresada = trim(fgets(STDIN));

                            // Cambio de nombre
                            if ($opcionIngresada == 1) {

                                echo "Ingrese el nuevo nombre: ";
                                $nuevoNombre = trim(fgets(STDIN));
                                $viajes[$viajeAModificar - 1]->getResponsable()->setNombre($nuevoNombre);

                            }
                            
                            // Cambio de apellido
                            elseif ($opcionIngresada == 2) {

                                echo "Ingrese el nuevo apellido: ";
                                $nuevoApellido = trim(fgets(STDIN));
                                $viajes[$viajeAModificar - 1]->getResponsable()->setApellido($nuevoApellido);

                            }

                            // Cambio de documento
                            elseif ($opcionIngresada == 3) {

                                echo "Ingrese el nuevo número de Empleado: ";
                                $nuevoNumeroDeEmpleado = trim(fgets(STDIN));
                                $viajes[$viajeAModificar - 1]->getResponsable()->setNumeroDeEmpleado($nuevoNumeroDeEmpleado);

                            }

                            // Cambio de Teléfono
                            elseif ($opcionIngresada == 4) {

                                echo "Ingrese el nuevo número de licencia: ";
                                $nuevoNumeroDeLicencia = trim(fgets(STDIN));
                                $viajes[$viajeAModificar - 1]->getResponsable()->setNumeroDeLicencia($nuevoNumeroDeLicencia);

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
                
                    case 4: 
                        
                        do {

                            // Consultamos que se desea hacer con los pasajeros
                            echo "¿Qué deséa hacer con los pasajeros?\n1. Agregar un pasajero\n2. Borrar un pasajero\n3. Modificar un pasajero\n0. No hacer nada\nOpción: ";
                            $accionPasajero = trim(fgets(STDIN));
                        
                            $listaDePasajeros = $viajes[$viajeAModificar - 1]->getPasajeros();

                            // Agregar un pasajero
                            if ($accionPasajero == 1) {

                                do {
                                    $nuevoPasajero = menuPasajero();
                                    $comprobarNuevoPasajero = pasajeroRepetido($nuevoPasajero, $viajes[$viajeAModificar - 1]);
                        
                                    if ($comprobarNuevoPasajero == true) {
                                        echo "El pasajero ya se encuentra en el viaje\n";
                                    }
                        
                                } while ($comprobarNuevoPasajero == true);
                        
                                $pasajero = new Pasajero($nuevoPasajero[0],$nuevoPasajero[1],$nuevoPasajero[2],$nuevoPasajero[3]);

                                array_push($listaDePasajeros, $pasajero);
                                $viajes[$viajeAModificar - 1]->setPasajeros($listaDePasajeros);
                            
                            }

                            // Borrar un pasajero
                            elseif ($accionPasajero == 2) {

                                if (count($viajes[$viajeAModificar - 1]->getPasajeros()) > 0) {
                                 
                                    do {

                                        echo "¿Qué pasajero deséa borrar? (0 para volver al menú principal)\n";
                                        echo $viajes[$viajeAModificar- 1]->listaDePasajeros();
                                        echo "Opción: ";
                                        $pasajeroABorrar = trim(fgets(STDIN));
    
                                        if ($pasajeroABorrar > 0 && $pasajeroABorrar <= count($listaDePasajeros)) {
    
                                            array_splice($listaDePasajeros, ($pasajeroABorrar - 1), 1);
                                            $viajes[$viajeAModificar - 1]->setPasajeros($listaDePasajeros);
                                            $pasajeroABorrar = $pasajeroABorrar - 1;
    
                                        }
                                        elseif ($pasajeroABorrar == 0) {
                                            echo "\n";
                                        }
                                        else {
                                            echo "Opción incorrecta\n";
                                        }
    
                                    } while ($pasajeroABorrar < 0 || $pasajeroABorrar > count($listaDePasajeros) && (!is_int($pasajeroABorrar)));

                                }
                                else {
                                    echo "Este viaje no tiene pasajeros\n";
                                }

                            }

                            // Modificar un pasajero
                            elseif ($accionPasajero == 3) {

                                if (count($viajes[$viajeAModificar - 1]->getPasajeros()) > 0) {

                                    do {

                                        // Exponemos la lista de pasajeros
                                        echo "¿Qué pasajero deséa modificar?\n";
                                        echo $viajes[$viajeAModificar- 1]->listaDePasajeros();
                                        echo "Opción: ";
                                        $pasajeroAModificar = trim(fgets(STDIN));
    
                                        if ($pasajeroAModificar > 0 && $pasajeroAModificar <= count($listaDePasajeros)) {
    
                                            do {
    
                                                // Menú para chequear que se va a modificar
                                                echo "¿Qué deséa modificar del pasajero: ". $listaDePasajeros[$pasajeroAModificar - 1]->getNombre(). " ". $listaDePasajeros[$pasajeroAModificar - 1]->getApellido(). "\n";
                                                echo "1) Nombre: ". $listaDePasajeros[$pasajeroAModificar - 1]->getNombre(). "\n";
                                                echo "2) Apellido: ". $listaDePasajeros[$pasajeroAModificar - 1]->getApellido(). "\n";
                                                echo "3) Documento: ". $listaDePasajeros[$pasajeroAModificar - 1]->getDocumento(). "\n";
                                                echo "4) Teléfono: ". $listaDePasajeros[$pasajeroAModificar - 1]->getTelefono(). "\n";
                                                echo "0) No modificar nada.\nOpción: ";
                                                $opcionIngresada = trim(fgets(STDIN));
    
                                                // Cambio de nombre
                                                if ($opcionIngresada == 1) {
    
                                                    echo "Ingrese el nuevo nombre: ";
                                                    $nuevoNombre = trim(fgets(STDIN));
                                                    $listaDePasajeros[$pasajeroAModificar - 1]->setNombre($nuevoNombre);
    
                                                }
                                                
                                                // Cambio de apellido
                                                elseif ($opcionIngresada == 2) {
    
                                                    echo "Ingrese el nuevo apellido: ";
                                                    $nuevoApellido = trim(fgets(STDIN));
                                                    $listaDePasajeros[$pasajeroAModificar - 1]->setApellido($nuevoApellido);
    
                                                }
        
                                                // Cambio de documento
                                                elseif ($opcionIngresada == 3) {
    
                                                    echo "Ingrese el nuevo documento: ";
                                                    $nuevoDocumento = trim(fgets(STDIN));
                                                    $listaDePasajeros[$pasajeroAModificar - 1]->setDocumento($nuevoDocumento);
    
                                                }
    
                                                // Cambio de Teléfono
                                                elseif ($opcionIngresada == 4) {
    
                                                    echo "Ingrese el nuevo teléfono: ";
                                                    $nuevoTelefono = trim(fgets(STDIN));
                                                    $listaDePasajeros[$pasajeroAModificar - 1]->setTelefono($nuevoTelefono);
    
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

                                }
                                else {
                                    echo "Este viaje no tiene pasajeros\n";
                                }

                            }
                            elseif ($accionPasajero == 0) {
                                echo "\n";
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

                echo $viajes[$viajeABuscar - 1];

                break;

            case 0:
                echo "Fin del programa";
    
                break;
    
        }

    } while($case <> 0);