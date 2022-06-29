<?php

//Includes
include_once "BaseDatos.php";
include_once "pasajero.php";
include_once "responsable.php";
include_once "empresa.php";
include_once "viaje.php";

// Funciones
// Eliminación de objetos en la base de datos
// Esto lo uso para prevenir duplicados al iniciar el programa

function vaciarBaseDeDatos() {
    $objPasajero = new pasajero();
    $objViaje = new viaje();
    $objEmpresa = new empresa();
    $objResponsable = new responsable();
    $bdPasajeros = $objPasajero->listar("");
    for ($i=0;$i<count($bdPasajeros);$i++) {
        $bdPasajeros[$i]->eliminar();
    }
    $bdViajes = $objViaje->listar("");
    for ($i=0;$i<count($bdViajes);$i++) {
        $bdViajes[$i]->eliminar();
    }
    $bdEmpresas = $objEmpresa->listar("");
    for ($i=0;$i<count($bdEmpresas);$i++) {
        $bdEmpresas[$i]->eliminar();
    }
    $bdResponsables = $objResponsable->listar("");
    for ($i=0;$i<count($bdResponsables);$i++) {
        $bdResponsables[$i]->eliminar();
    }
}

// Precargar objetos en la base de datos
function precargarDatos() {
    // Objetos precargados
    // Creamos el objeto
    $objEmpresa = new empresa();
    // Cargamos los datos al objeto
    $objEmpresa->cargar(0, "Empresa ejemplo 1", "Ruta 22 km 3000");
    // Insertamos el objeto en la base de datos
    $objEmpresa->insertar();
    $objResponsable1 = new responsable();
    $objResponsable1->cargar(0, 160710, "Bernardo", "Benitez");
    $objResponsable1->insertar();
    $objViaje1 = new viaje();
    $objViaje1->cargar(0, "La Pampa", 50, $objEmpresa->getIdEmpresa(), $objResponsable1->getRNumeroEmpleado(), 2500, "Cama", "Si");
    $objViaje2 = new viaje();
    $objViaje2->cargar(0, "Jujuy", 60, $objEmpresa->getIdEmpresa(), $objResponsable1->getRNumeroEmpleado(), 2501, "Semi-Cama", "No");
    $objViaje1->insertar();
    $objViaje2->insertar();
    $objPasajero1 = new pasajero();
    $objPasajero1->cargar(41092312, "Jorge", "Rodriguez", 156321989, $objViaje1->getIdViaje());
    $objPasajero2 = new pasajero();
    $objPasajero2->cargar(37757712, "Roberto", "Hernandez", 155651329, $objViaje1->getIdViaje());
    $objPasajero3 = new pasajero();
    $objPasajero3->cargar(18561648, "Selma", "Hells", 154513544, $objViaje2->getIdViaje());
    $objPasajero1->insertar();
    $objPasajero2->insertar();
    $objPasajero3->insertar();
}

// Menú principal

function menuPrincipal()
{
    $respuestaValida = false;
    do {
        echo "Bienvenido, por favor ingrese la opción que deséa ralizar:\n";
        echo "1. Agregar datos\n";
        echo "2. Modificar datos\n";
        echo "3. Eliminar datos\n";
        echo "4. Mostrar datos\n";
        echo "5. Cargar datos prefabricados\n";
        echo "0. Salir\n";
        echo "Opción: ";
        $respuesta = trim(fgets(STDIN));
        if (is_numeric($respuesta)) {
            if ($respuesta >= 0 && $respuesta < 6) {
                $respuestaValida = true;
            } 
            else {
                echo "Error. La opción elegida no existe\n";
            }
        } 
        else {
            echo "Error. Por favor ingrese una opción válida\n";
        }
    } while ($respuestaValida == false);
    return $respuesta;
}

// Menús agregar

function menuAgregar() {
    $rtaValida = false;
    do {
        echo "¿Qué deséa agregar?\n";
        echo "1. Una Empresa\n";
        echo "2. Un Viaje\n";
        echo "3. Un Responsable\n";
        echo "4. Un Pasajero\n";
        echo "0. Volver\n";
        echo "Opción: ";
        $valor = trim(fgets(STDIN));
        if (is_numeric($valor)) {
            if ($valor >= 0 && $valor < 5) {
                $rtaValida = true;
            } 
            else {
                echo "Error. La opción elegida no existe\n";
            }
        } 
        else {
            echo "Error. Por favor ingrese una opción válida\n";
        }
    } while ($rtaValida == false);
    return $valor;
}

function agregarEmpresa() {
    $objEmpresa = new empresa();
    echo "Ingrese el nombre de la empresa: ";
    $crearEmpresaNombreEmpresa = trim(fgets(STDIN));
    echo "Ingrese la dirección de la empresa: ";
    $crearEmpresaDireccionEmpresa = trim(fgets(STDIN));

    // Creamos la empresa y le seteamos los valores
    $objEmpresaCreada = new empresa();
    $objEmpresaCreada->cargar(0,$crearEmpresaNombreEmpresa,$crearEmpresaDireccionEmpresa);

    return $objEmpresaCreada;
}

function agregarViaje() {
    $objViaje = new viaje();
    $objResponsable = new responsable();
    $bdResponsables = $objResponsable->listar("");
    $objEmpresa = new empresa();
    $bdEmpresas = $objEmpresa->listar("");
    echo "Ingrese el destino del viaje: ";
    $crearViajeDestinoViaje = trim(fgets(STDIN));
    echo "Ingrese la cantidad máxima de pasajeros: ";
    $crearViajeVCantMaxPasajeros = trim(fgets(STDIN));
    $valido = false;
    do {
        echo "Seleccione la empresa a cargo del viaje:\n";
        listarEmpresas();
        echo "Opción: ";
        $crearViajeEmpresaViaje = trim(fgets(STDIN));
        if ($crearViajeEmpresaViaje > 0 && $crearViajeEmpresaViaje <= count($bdEmpresas)) {
            $crearViajeIdEmpresaViaje = $bdEmpresas[$crearViajeEmpresaViaje-1]->getIdEmpresa();
            $valido = true;
        }
        else {
            echo "La opción ingresada no es correcta\n";
        }
    } while ($valido == false);
    $valido = false;
    do {
        echo "Seleccione al Responsable a cargo del viaje:\n";
        listarResponsables();
        echo "Opción: ";
        $crearViajeResponsableViaje = trim(fgets(STDIN));
        if ($crearViajeResponsableViaje > 0 && $crearViajeResponsableViaje <= count($bdResponsables)) {
            $crearViajeRNumeroDeEmpleado = $bdResponsables[$crearViajeResponsableViaje-1]->getRNumeroEmpleado();
            $valido = true;
        }
        else {
            echo "La opción ingresada no es correcta\n";
        }
    } while ($valido == false);
    echo "Ingrese el importe del viaje: ";
    $crearViajeVImporteViaje = trim(fgets(STDIN));
    echo "Ingrese el tipo de asiento del viaje: (Cama/Semi-Cama): ";
    $crearViajeTipoAsientoViaje = trim(fgets(STDIN));
    echo "Ingrese el tipo de viaje (Si = Ida y vuelta || No = Ida): ";
    $crearViajeIdaYVueltaViaje = trim(fgets(STDIN));

    $objViaje->cargar(0,$crearViajeDestinoViaje,$crearViajeVCantMaxPasajeros,$crearViajeIdEmpresaViaje,$crearViajeRNumeroDeEmpleado,$crearViajeVImporteViaje,$crearViajeTipoAsientoViaje,$crearViajeIdaYVueltaViaje);
    return $objViaje;
}

function agregarResponsable() {
    $objResponsable = new responsable();
    $valido = false;
    echo "Ingrese el número de licencia del Responsable: ";
    $crearResponsableRNumeroLicencia = trim(fgets(STDIN));
    echo "Ingrese el nombre del Responsable: ";
    $crearResponsableNombreResponsable = trim(fgets(STDIN));
    echo "Ingrese el apellido del Responsable: ";
    $crearResponsableApellidoResponsable = trim(fgets(STDIN));

    $objResponsable->cargar(0,$crearResponsableRNumeroLicencia,$crearResponsableNombreResponsable,$crearResponsableApellidoResponsable);

    return $objResponsable;
}

function agregarPasajeroElegirViaje() {
    // Creamos los objetos que vamos a utilizar para poder ver los alojados en la base de datos
    $valido = false;
    $objViaje = new viaje();
    $objPasajero = new pasajero();
    $bdViajes = $objViaje->listar("");
    do {
        echo "Seleccione el viaje al que quiere agregar el pasajero:\n===================================================\n";
        listarViajes();
        $crearPasajeroViajeSeleccionado = trim(fgets(STDIN));
        if (is_numeric($crearPasajeroViajeSeleccionado)) {
            if ($crearPasajeroViajeSeleccionado > 0 && $crearPasajeroViajeSeleccionado <= count($bdViajes)) {
                $bdPasajeros = $objPasajero->listar("idviaje=". $bdViajes[$crearPasajeroViajeSeleccionado-1]->getIdViaje());
                if ($bdViajes[$crearPasajeroViajeSeleccionado-1]->getVCantMaxPasajeros() > count($bdPasajeros)) {
                    $valido = true;
                    $viajeElegido = $bdViajes[$crearPasajeroViajeSeleccionado - 1];
                    $pasajeroCreado = crearPasajero($viajeElegido);
                }
                else {
                    echo "El viaje ya superó la cantidad máxima de pasajeros\n";
                }
            }
            else {
                echo "Error. Por favor ingrese una opción correcta de viaje\n";
            }
        }
        else {
            echo "Error. La opción ingresada no es válida\n";
        }
    } while ($valido == false);

    return ($pasajeroCreado);
}

function crearPasajero($viaje) {
    $valido = false;
    $objPasajero = new pasajero();
    // Pedimos y verificamos que el Documento del pasajero no exista
    do {
        echo "Ingrese el número de documento del pasajero: ";
        $dniPasajeroACrear = trim(fgets(STDIN));
        $verificarDuplicado = $objPasajero->Buscar($dniPasajeroACrear);
        if ($verificarDuplicado == false) {
            $valido = true;
        }
        else {
            echo "El número de documento ya se encuentra en la base de datos\n";
        }
    } while ($valido == false);

    echo "Ingrese el nombre del pasajero: ";
    $nombrePasajeroACrear = trim(fgets(STDIN));
    echo "Ingrese el apellido del pasajero: ";
    $apellidoPasajeroACrear = trim(fgets(STDIN));
    echo "Ingrese el teléfono del pasajero: ";
    $telefonoPasajeroACrear = trim(fgets(STDIN));
    $idViajePasajeroACrear = $viaje->getIdViaje();
    
    $objPasajero->cargar($dniPasajeroACrear,$nombrePasajeroACrear,$apellidoPasajeroACrear,$telefonoPasajeroACrear,$idViajePasajeroACrear);

    return $objPasajero;
}

// Modificaciones

function menuModificar() {
    $rtaValida = false;
    do {
        echo "¿Qué deséa modificar?\n";
        echo "1. Una Empresa\n";
        echo "2. Un Viaje\n";
        echo "3. Un Responsable\n";
        echo "4. Un Pasajero\n";
        echo "0. Volver\n";
        echo "Opción: ";
        $valor = trim(fgets(STDIN));
        if (is_numeric($valor)) {
            if ($valor >= 0 && $valor < 5) {
                $rtaValida = true;
            } 
            else {
                echo "Error. La opción elegida no existe\n";
            }
        } 
        else {
            echo "Error. Por favor ingrese una opción válida\n";
        }
    } while ($rtaValida == false);
    return $valor;
}

function modificarEmpresa() {
    $objEmpresa = new empresa();
    $bdEmpresas = $objEmpresa->listar("");
    $valido = false;
    do {
        echo "Seleccione la empresa que deséa modificar:\n===================================================\n";
        listarEmpresas();
        $empresaAModificar = trim(fgets(STDIN));
        if (is_numeric($empresaAModificar)) {
            if ($empresaAModificar > 0 && $empresaAModificar <= count($bdEmpresas)) {
                $valido = true;
                $empresaElegida = $bdEmpresas[$empresaAModificar - 1];
            }
            else {
                echo "Error. Por favor ingrese una opción correcta\n";
            }
        }
        else {
            echo "Error. La opción ingresada no es válida\n";
        }
    } while ($valido == false);
    $valido = false;
    do {
        echo "¿Qué deséa modificar de la empresa?\n";
        echo "1. Nombre\n";
        echo "2. Dirección\n";
        echo "Opción: ";
        $respuestaModificarEmpresa = trim(fgets(STDIN));
        if ($respuestaModificarEmpresa == 1) {
            echo "Ingrese el nuevo nombre de la empresa: ";
            $nuevoNombreEmpresa = trim(fgets(STDIN));
            $empresaElegida->setEmpNombre($nuevoNombreEmpresa);
            $empresaElegida->modificar();
            $valido = true;
        }
        elseif ($respuestaModificarEmpresa == 2) {
            echo "Ingrese la nueva dirección de la empresa: ";
            $nuevaDireccionEmpresa = trim(fgets(STDIN));
            $empresaElegida->setEmpDireccion($nuevaDireccionEmpresa);
            $empresaElegida->modificar();
            $valido = true;
        }
        else {
            echo "Opción incorrecta\n";
        }
    } while ($valido == false);
}

function modificarViaje() {
    $objViaje = new viaje();
    $bdViajes = $objViaje->listar("");
    $valido = false;
    do {
        echo "Seleccione el viaje que deséa modificar:\n===================================================\n";
        listarViajes();
        $viajeAModificar = trim(fgets(STDIN));
        if (is_numeric($viajeAModificar)) {
            if ($viajeAModificar > 0 && $viajeAModificar <= count($bdViajes)) {
                $valido = true;
                $viajeElegido = $bdViajes[$viajeAModificar - 1];
            }
            else {
                echo "Error. Por favor ingrese una opción correcta\n";
            }
        }
        else {
            echo "Error. La opción ingresada no es válida\n";
        }
    } while ($valido == false);
    $valido = false;
    do {
        echo "¿Qué deséa modificar del viaje?\n";
        echo "1. Destino\n";
        echo "2. Cantidad Máxima de Pasajeros\n";
        echo "3. Empresa encargada\n";
        echo "4. Responsable a Cargo\n";
        echo "5. Importe\n";
        echo "6. Tipo de Asiento\n";
        echo "7. Ida y Vuelta\n";
        echo "Opción: ";
        $respuestaModificarViaje = trim(fgets(STDIN));
        if ($respuestaModificarViaje == 1) {
            echo "Ingrese el nuevo destino del viaje: ";
            $nuevoDestinoViaje = trim(fgets(STDIN));
            $viajeElegido->setEmpNombre($nuevoDestinoViaje);
            $viajeElegido->modificar();
            $valido = true;
        }
        elseif ($respuestaModificarViaje == 2) {
            $objPasajero = new pasajero();
            $bdPasajerosDelViaje = $objPasajero->listar("idviaje=". $viajeElegido->getIdViaje());
            echo "Ingrese la nueva cantidad máxima de pasajeros\nNo puede ser menor a la cantidad actual (". count($bdPasajerosDelViaje) . ")\nNi tampoco menor a 0: ";
            $nuevaCantidadMaxima = trim(fgets(STDIN));
            if ($nuevaCantidadMaxima > 0 && $nuevaCantidadMaxima >= count($bdPasajerosDelViaje)) {
                $viajeElegido->setVCantMaxPasajeros($nuevaCantidadMaxima);
                $viajeElegido->modificar();
                $valido = true;
            }
        }
        elseif ($respuestaModificarViaje == 3) {
            $objEmpresa = new empresa();
            $bdEmpresas = $objEmpresa->listar();
            $respuestaValida = false;
            do {
                echo "Elija la nueva empresa a cargo del viaje:\n";
                listarEmpresas();
                $respuestaEmpresaElegida = trim(fgets(STDIN));
                if ($respuestaEmpresaElegida > 0 && $respuestaEmpresaElegida <= count($bdEmpresas)) {
                    $empresaElegida = $bdEmpresas[$respuestaEmpresaElegida - 1];
                    $viajeElegido->setIdEmpresa($empresaElegida->getIdEmpresa());
                    $viajeElegido->modificar();
                    $respuestaValida = true;
                }
            } while ($respuestaValida == false);
            $valido = true;
        }
        elseif ($respuestaModificarViaje == 4) {
            $objResponsable = new responsable();
            $bdResponsables = $objResponsable->listar("");
            $respuestaValida = false;
            do {
                echo "Elija el nuevo responsable a cargo del viaje:\n";
                listarResponsables();
                $respuestaResponsableElegido = trim(fgets(STDIN));
                if ($respuestaResponsableElegido > 0 && $respuestaResponsableElegido <= count($bdResponsables)) {
                    $responsableElegido = $bdResponsables[$respuestaResponsableElegido - 1];
                    $viajeElegido->setRNumeroEmpleado($responsableElegido->getRNumeroEmpleado());
                    $viajeElegido->modificar();
                    $respuestaValida = true;
                }
            } while ($respuestaValida == false);
            $valido = true;
        }
        elseif ($respuestaModificarViaje == 5) {
            echo "Ingrese el nuevo importe del viaje: ";
            $nuevoImporteViaje = trim(fgets(STDIN));
            $viajeElegido->setVImporte($nuevoImporteViaje);
            $viajeElegido->modificar();
            $valido = true;
        }
        elseif ($respuestaModificarViaje == 6) {
            do {
                echo "Ingrese el nuevo tipo de asiento del viaje:\n";
                echo "1. Cama\n";
                echo "2. Semi-Cama\n";
                echo "Opción: ";
                $nuevoImporteViaje = trim(fgets(STDIN));
                if ($nuevoImporteViaje != 1 && $nuevoImporteViaje != 2) {
                    echo "Opción incorrecta\n";
                }
            } while ($nuevoImporteViaje != 1 && $nuevoImporteViaje != 2);
            if ($nuevoImporteViaje == 1) {
                $viajeElegido->setTipoAsiento("Cama");       
            }
            else {
                $viajeElegido->setTipoAsiento("Semi-Cama");    
            }
            $viajeElegido->modificar();
            $valido = true;
        }
        elseif ($respuestaModificarViaje == 7) {
            do {
                echo "Ingrese el nuevo tipo de viaje:\n";
                echo "1. Ida\n";
                echo "2. Ida y Vuelta\n";
                $nuevoTipoViaje = trim(fgets(STDIN));
                if ($nuevoTipoViaje != 1 && $nuevoTipoViaje != 2) {
                    echo "Opción incorrecta\n";
                }
            } while ($nuevoTipoViaje != 1 && $nuevoTipoViaje != 2);

            if ($nuevoTipoViaje == 1) {
                $viajeElegido->setIdaYVuelta("No"); 
            }
            else {
                $viajeElegido->setIdaYVuelta("Si");
            }
            $viajeElegido->modificar();
            $valido = true;
        }
        else {
            echo "Opción incorrecta\n";
        }

    } while ($valido == false);
}

function modificarResponsable() {
    
    $objResponsable = new responsable();
    $bdResponsables = $objResponsable->listar("");
    $valido = false;
    do {
        echo "Seleccione el responsable que deséa modificar:\n===================================================\n";
        listarResponsables();
        $responsableAModificar = trim(fgets(STDIN));
        if (is_numeric($responsableAModificar)) {
            if ($responsableAModificar > 0 && $responsableAModificar <= count($bdResponsables)) {
                $valido = true;
                $responsableElegido = $bdResponsables[$responsableAModificar - 1];
            }
            else {
                echo "Error. Por favor ingrese una opción correcta\n";
            }
        }
        else {
            echo "Error. La opción ingresada no es válida\n";
        }
    } while ($valido == false);
    $valido = false;
    do {
        echo "¿Qué deséa modificar del Responsable?\n";
        echo "1. Nombre\n";
        echo "2. Apellido\n";
        echo "3. Número de licencia\n";
        echo "Opción: ";
        $respuestaModificarResponsable = trim(fgets(STDIN));
        if ($respuestaModificarResponsable == 1) {
            echo "Ingrese el nuevo nombre del responsable: ";
            $nuevoNombreResponsable = trim(fgets(STDIN));
            $responsableElegido->setRNombre($nuevoNombreResponsable);
            $responsableElegido->modificar();
            $valido = true;
        }
        elseif ($respuestaModificarResponsable == 2) {
            echo "Ingrese el nuevo apellido del responsable: ";
            $nuevoApellidoResponsable = trim(fgets(STDIN));
            $responsableElegido->setRApellido($nuevoApellidoResponsable);
            $responsableElegido->modificar();
            $valido = true;
        }
        elseif ($respuestaModificarResponsable == 3) {
            echo "Ingrese el nuevo número de licencia del responsable: ";
            $nuevoNumeroLicenciaResponsable = trim(fgets(STDIN));
            $responsableElegido->setRNumeroLicencia($nuevoNumeroLicenciaResponsable);
            $responsableElegido->modificar();
            $valido = true;
        }
        else {
            echo "Opción incorrecta\n";
        }
    } while ($valido == false);
}

function modificarPasajero() {
    $objPasajero = new pasajero();
    $bdPasajeros = $objPasajero->listar("");
    $valido = false;
    do {
        echo "Seleccione el pasajero que deséa modificar:\n===================================================\n";
        listarPasajeros();
        $pasajeroAModificar = trim(fgets(STDIN));
        if (is_numeric($pasajeroAModificar)) {
            if ($pasajeroAModificar > 0 && $pasajeroAModificar <= count($bdPasajeros)) {
                $valido = true;
                $pasajeroElegido = $bdPasajeros[$pasajeroAModificar - 1];
            }
            else {
                echo "Error. Por favor ingrese una opción correcta\n";
            }
        }
        else {
            echo "Error. La opción ingresada no es válida\n";
        }
    } while ($valido == false);

    $valido = false;
    do {
        echo "¿Qué deséa modificar del Pasajero?\n";
        echo "1. Nombre\n";
        echo "2. Apellido\n";
        echo "3. Número de teléfono\n";
        echo "4. Cambiar de Viaje\n";
        echo "Opción: ";
        $respuestaModificarPasajero = trim(fgets(STDIN));
        if ($respuestaModificarPasajero == 1) {
            echo "Ingrese el nuevo nombre del pasajero: ";
            $nuevoNombreResponsable = trim(fgets(STDIN));
            $pasajeroElegido->setPNombre($nuevoNombreResponsable);
            $pasajeroElegido->modificar();
            $valido = true;
        }
        elseif ($respuestaModificarPasajero == 2) {
            echo "Ingrese el nuevo apellido del responsable: ";
            $nuevoApellidoResponsable = trim(fgets(STDIN));
            $pasajeroElegido->setPApellido($nuevoApellidoResponsable);
            $pasajeroElegido->modificar();
            $valido = true;
        }
        elseif ($respuestaModificarPasajero == 3) {
            echo "Ingrese el nuevo número de teléfono del pasajero: ";
            $nuevoNumeroLicenciaResponsable = trim(fgets(STDIN));
            $pasajeroElegido->setPTelefono($nuevoNumeroLicenciaResponsable);
            $pasajeroElegido->modificar();
            $valido = true;
        }
        elseif ($respuestaModificarPasajero == 4) {
            $objViaje = new viaje();
            $bdViajes = $objViaje->listar("");
            $respuestaValida = false;
            do {
                echo "Elija el nuevo viaje:\n";
                listarViajes();
                $respuestaViajeElegido = trim(fgets(STDIN));
                if ($respuestaViajeElegido > 0 && $respuestaViajeElegido <= count($bdViajes)) {
                    $viajeElegido = $bdViajes[$respuestaViajeElegido - 1];
                    $pasajeroElegido->setIDViaje($viajeElegido->getIdViaje());
                    $pasajeroElegido->modificar();
                    $respuestaValida = true;
                }
                else {
                    echo "Opción incorrecta\n";
                }
            } while ($respuestaValida == false);
            $valido = true;
        }
        else {
            echo "Opción incorrecta\n";
        }
    } while ($valido == false);

    /*
		$this->setPNombre($pNomN);
		$this->setPApellido($pApeN);
		$this->setPTelefono($pTelN);
		$this->setIDViaje($idViaN);
    */
}

// Eliminaciones

function menuEliminar() {
    $rtaValida = false;
    do {
        echo "¿Qué deséa eliminar?\n";
        echo "1. Una Empresa\n";
        echo "2. Un Viaje\n";
        echo "3. Un Responsable\n";
        echo "4. Un Pasajero\n";
        echo "5. Eliminar Todo\n";
        echo "0. Volver\n";
        echo "Opción: ";
        $valor = trim(fgets(STDIN));
        if (is_numeric($valor)) {
            if ($valor >= 0 && $valor < 6) {
                $rtaValida = true;
            } 
            else {
                echo "Error. La opción elegida no existe\n";
            }
        } 
        else {
            echo "Error. Por favor ingrese una opción válida\n";
        }
    } while ($rtaValida == false);
    return $valor;
}

function eliminarEmpresa() {
    $objEmpresa = new empresa();
    $bdEmpresas = $objEmpresa->listar("");
    $valido = false;

    do {
        echo "Seleccione la empresa que deséa eliminar:\n===================================================\n";
        listarEmpresas();
        $empresaAEliminar = trim(fgets(STDIN));
        if (is_numeric($empresaAEliminar)) {
            if ($empresaAEliminar > 0 && $empresaAEliminar <= count($bdEmpresas)) {
                $valido = true;
                $EmpresaElegida = $bdEmpresas[$empresaAEliminar - 1];
            }
            else {
                echo "Error. Por favor ingrese una opción correcta\n";
            }
        }
        else {
            echo "Error. La opción ingresada no es válida\n";
        }
    } while ($valido == false);

    do {
        echo "Eliminar la empresa también eliminará los viajes relacionados a ella\ny por consecuencia los pasajeros asignados al mismo\nDeséa continuar? (S/N): ";
        $respuestaEliminarEmpresa = trim(fgets(STDIN));
        if (strtoupper($respuestaEliminarEmpresa) == "S") {
            $objViaje = new viaje();
            $bdViajesABorrar = $objViaje->listar("idempresa=". $EmpresaElegida->getIdEmpresa());
            $objPasajero = new pasajero();
            for ($i=0;$i<count($bdViajesABorrar);$i++) {
                $bdPasajerosABorrar = $objPasajero->listar("idviaje=". $bdViajesABorrar[$i]->getIdViaje());
                for ($j=0;$j<count($bdPasajerosABorrar);$j++) {
                    $bdPasajerosABorrar[$j]->eliminar();
                    echo "Pasajero Eliminado\n";
                }
                $bdViajesABorrar[$i]->eliminar();
                echo "Viaje Eliminado\n";
            }
            $EmpresaElegida->eliminar();
            echo "Empresa eliminada\n";
        }
        elseif (strtoupper($respuestaEliminarEmpresa) == "N") {
            echo "Operación cancelada, no se eliminó nada\n";
        }
        else {
            echo "Opción incorrecta\n";
        }
    } while (strtoupper($respuestaEliminarEmpresa) != "S" && strtoupper($respuestaEliminarEmpresa) != "N");
}

function eliminarViaje() {
    $objViaje = new viaje();
    $bdViajes = $objViaje->listar("");
    $valido = false;

    do {
        echo "Seleccione el viaje que deséa eliminar:\n===================================================\n";
        listarViajes();
        $viajeAEliminar = trim(fgets(STDIN));
        if (is_numeric($viajeAEliminar)) {
            if ($viajeAEliminar > 0 && $viajeAEliminar <= count($bdViajes)) {
                $valido = true;
                $viajeElegido = $bdViajes[$viajeAEliminar - 1];
            }
            else {
                echo "Error. Por favor ingrese una opción correcta\n";
            }
        }
        else {
            echo "Error. La opción ingresada no es válida\n";
        }
    } while ($valido == false);

    do {
        echo "Eliminar el viaje también eliminará los pasajeros asignados al mismo\nDeséa continuar? (S/N): ";
        $respuestaEliminarViaje = trim(fgets(STDIN));
        if (strtoupper($respuestaEliminarViaje) == "S") {
            $objPasajero = new pasajero();
            $bdPasajerosABorrar = $objPasajero->listar("idviaje=". $viajeElegido->getIdViaje());
            for ($i=0;$i<count($bdPasajerosABorrar);$i++) {
                $bdPasajerosABorrar[$i]->eliminar();
                echo "Pasajero Eliminado\n";
            }
            $viajeElegido->eliminar();
            echo "Viaje Eliminado\n";
        }
        elseif (strtoupper($respuestaEliminarViaje) == "N") {
            echo "Operación cancelada, no se eliminó nada\n";
        }
        else {
            echo "Opción incorrecta\n";
        }
    } while (strtoupper($respuestaEliminarViaje) != "S" && strtoupper($respuestaEliminarViaje) != "N");
}

function eliminarResponsable() {
    $objResponsable = new responsable();
    $bdResponsables = $objResponsable->listar("");
    $valido = false;

    do {
        echo "Seleccione el responsable que deséa eliminar:\n===================================================\n";
        listarResponsables();
        $responsableAEliminar = trim(fgets(STDIN));
        if (is_numeric($responsableAEliminar)) {
            if ($responsableAEliminar > 0 && $responsableAEliminar <= count($bdResponsables)) {
                $valido = true;
                $responsableElegido = $bdResponsables[$responsableAEliminar - 1];
            }
            else {
                echo "Error. Por favor ingrese una opción correcta\n";
            }
        }
        else {
            echo "Error. La opción ingresada no es válida\n";
        }
    } while ($valido == false);

    do {
        echo "Eliminar el responsable también eliminará los viajes relacionados a ella\ny por consecuencia los pasajeros asignados al mismo\nDeséa continuar? (S/N): ";
        $respuestaEliminarResponsable = trim(fgets(STDIN));
        if (strtoupper($respuestaEliminarResponsable) == "S") {
            $objViaje = new viaje();
            $bdViajesABorrar = $objViaje->listar("rnumeroempleado=". $responsableElegido->getRNumeroEmpleado());
            $objPasajero = new pasajero();
            for ($i=0;$i<count($bdViajesABorrar);$i++) {
                $bdPasajerosABorrar = $objPasajero->listar("idviaje=". $bdViajesABorrar[$i]->getIdViaje());
                for ($j=0;$j<count($bdPasajerosABorrar);$j++) {
                    $bdPasajerosABorrar[$j]->eliminar();
                    echo "Pasajero Eliminado\n";
                }
                $bdViajesABorrar[$i]->eliminar();
                echo "Viaje Eliminado\n";
            }
            $responsableElegido->eliminar();
            echo "Responsable Eliminado\n";
        }
        elseif (strtoupper($respuestaEliminarResponsable) == "N") {
            echo "Operación cancelada, no se eliminó nada\n";
        }
        else {
            echo "Opción incorrecta\n";
        }
    } while (strtoupper($respuestaEliminarResponsable) != "S" && strtoupper($respuestaEliminarResponsable) != "N");
}

function eliminarPasajero() {
    $objPasajero = new pasajero();
    $bdPasajeros = $objPasajero->listar("");
    $valido = false;

    do {
        echo "Seleccione el pasajero que deséa eliminar:\n===================================================\n";
        listarPasajeros();
        $pasajeroAEliminar = trim(fgets(STDIN));
        if (is_numeric($pasajeroAEliminar)) {
            if ($pasajeroAEliminar > 0 && $pasajeroAEliminar <= count($bdPasajeros)) {
                $valido = true;
                $pasajeroElegido = $bdPasajeros[$pasajeroAEliminar - 1];
            }
            else {
                echo "Error. Por favor ingrese una opción correcta\n";
            }
        }
        else {
            echo "Error. La opción ingresada no es válida\n";
        }
    } while ($valido == false);

    $pasajeroElegido->eliminar();
    echo "Pasajero Eliminado\n";
}

// Menus Mostrar

function menuMostrar() {
    $rtaValida = false;
    do {
        echo "¿Qué deséa mostrar?\n";
        echo "1. Empresas\n";
        echo "2. Viajes\n";
        echo "3. Responsables\n";
        echo "4. Pasajeros\n";
        echo "0. Volver\n";
        echo "Opción: ";
        $valor = trim(fgets(STDIN));
        if (is_numeric($valor)) {
            if ($valor >= 0 && $valor < 5) {
                $rtaValida = true;
            } 
            else {
                echo "Error. La opción elegida no existe\n";
            }
        } 
        else {
            echo "Error. Por favor ingrese una opción válida\n";
        }
    } while ($rtaValida == false);
    return $valor;
}

function listarViajes() {
    // Mostramos los viajes
    $objViaje = new viaje();
    $bdViajes = $objViaje->listar("");
    $viajes = "";
    for ($i=0;$i < count($bdViajes);$i++) {
        $viajes .= ($i+1) . ". ". $bdViajes[$i]. "\n===================================================\n";
    }
    echo $viajes;
}

function listarPasajeros() {
    //Mostramos los pasajeros
    $objPasajero = new pasajero();
    $bdPasajeros = $objPasajero->listar("");
    $pasajeros = "";
    for ($i=0;$i < count($bdPasajeros);$i++) {
        $pasajeros .= ($i+1) . ". ". $bdPasajeros[$i]. "\n===================================================\n";
    }
    echo $pasajeros;
}

function listarEmpresas() {
    //Mostramos las empresas
    $objEmpresa = new empresa();
    $bdEmpresas = $objEmpresa->listar("");
    $empresas = "";
    for ($i=0;$i < count($bdEmpresas);$i++) {
        $empresas .= ($i+1) . ". ". $bdEmpresas[$i]. "\n===================================================\n";
    }
    echo $empresas;
}

function listarResponsables() {
    //Mostramos las empresas
    $objResponsable = new responsable();
    $bdResponsables = $objResponsable->listar("");
    $responsables = "";
    for ($i=0;$i < count($bdResponsables);$i++) {
        $responsables .= ($i+1) . ". ". $bdResponsables[$i]. "\n===================================================\n";
    }
    echo $responsables;
}

// Programa Principal

do {
    $respuestaMenuPrincipal = menuPrincipal();
    switch($respuestaMenuPrincipal) {
        case 1:
            //Agregar
            $respuestaMenuAgregar = menuAgregar();
            switch($respuestaMenuAgregar) {
                case 1:
                    $objEmpresaCreada = agregarEmpresa();
                    $objEmpresaCreada->insertar();
                    break;
                case 2:
                    $objEmpresaTemporal = new empresa();
                    $objResponsableTemporal = new responsable();
                    $bdEmpresasTemporal = $objEmpresaTemporal->listar("");
                    $bdResponsablesTemporal = $objResponsableTemporal->listar("");
                    if (count($bdEmpresasTemporal) > 0 && count($bdResponsablesTemporal) > 0) {
                        $objViajeCreado = agregarViaje();
                        $objViajeCreado->insertar();
                    }
                    else {
                        if (count($bdEmpresasTemporal) < 1) {
                            echo "No hay ninguna empresa que pueda almacenar viajes, por favor cree una.\n";
                        }
                        if (count($bdResponsablesTemporal) < 1) {
                            echo "No hay ningún responsable para poner a cargo de viajes, por favor cree uno.\n";
                        }
                    }
                    break;
                case 3:
                    $objResponsableCreado = agregarResponsable();
                    $objResponsableCreado->insertar();
                    break;
                case 4:
                    $objViajeTemporal = new viaje();
                    $bdViajesTemporales = $objViajeTemporal->listar("");
                    if (count($bdViajesTemporales) > 0) {
                        $objPasajeroCreado = agregarPasajeroElegirViaje();
                        $objPasajeroCreado->insertar();
                    }
                    else {
                        echo "No hay viajes disponibles, por favor cree uno\n";
                    }

                    break;
                case 0:
                    break;
            }
            break;
        case 2:
            //Modificar
            $respuestaMenuModificar = menuModificar();
            switch($respuestaMenuModificar) {
                case 1:
                    modificarEmpresa();
                    break;
                case 2:
                    modificarViaje();
                    break;
                case 3:
                    modificarResponsable();
                    break;
                case 4:
                    modificarPasajero();
                    break;
                case 0:
                    break;
            }
            break;
        case 3:
            //Eliminar
            $respuestaMenuEliminar = menuEliminar();
            switch ($respuestaMenuEliminar) {
                case 1:
                    eliminarEmpresa();
                    break;
                case 2:
                    eliminarViaje();
                    break;
                case 3:
                    eliminarResponsable();
                    break;
                case 4:
                    eliminarPasajero();
                    break;
                case 5:
                    vaciarBaseDeDatos();
                    echo "Base de datos vaciada con éxito\n";
                    break;
                case 0:
                    break;
            }
            break;
        case 4:
            //Mostrar
            $menuMostrarOpcionElegida = menuMostrar();
            switch($menuMostrarOpcionElegida) {
                case 1:
                    listarEmpresas();
                    break;
                case 2:
                    listarViajes();
                    break;
                case 3:
                    listarResponsables();
                    break;
                case 4:
                    listarPasajeros();
                    break;
            }
            break;
        case 5:
            precargarDatos();
            break;
        case 0:
            echo "Fin del programa";
            break;
    }
} while ($respuestaMenuPrincipal <> 0);