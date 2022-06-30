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
    $objViaje1->cargar(0, "La Pampa", 50, $objEmpresa, $objResponsable1, 2500, "Cama", "Si");
    $objViaje2 = new viaje();
    $objViaje2->cargar(0, "Jujuy", 60, $objEmpresa, $objResponsable1, 2501, "Semi-Cama", "No");
    $objViaje1->insertar();
    $objViaje2->insertar();
    $objPasajero1 = new pasajero();
    $objPasajero1->cargar(41092312, "Jorge", "Rodriguez", 156321989, $objViaje1);
    $objPasajero2 = new pasajero();
    $objPasajero2->cargar(37757712, "Roberto", "Hernandez", 155651329, $objViaje1);
    $objPasajero3 = new pasajero();
    $objPasajero3->cargar(18561648, "Selma", "Hells", 154513544, $objViaje2);
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
        echo "5. Cargar datos de prueba\n";
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
    $viajeValido = false;
    do {
        echo "Ingrese el destino del viaje: ";
        $crearViajeDestinoViaje = trim(fgets(STDIN));
        $bdViajes = $objViaje->listar("");
        if (count($bdViajes) > 0) {
            $i=0;
            $viajeDuplicado = false;
            do {
                if (strtoupper($bdViajes[$i]->getVDestino()) == strtoupper($crearViajeDestinoViaje)) {
                    $viajeDuplicado = true;
                }
                $i++;
            } while ($i<count($bdViajes) && $viajeDuplicado == false);
            if ($viajeDuplicado == true) {
                echo "Ya existe un viaje con dicho destino\n";
            }
            else {
                $viajeValido = true;
            }
        }
        else {
            $viajeValido = true;
        }
    } while ($viajeValido == false);
    $valido = false;
    do {
        echo "Ingrese la cantidad máxima de pasajeros: ";
        $crearViajeVCantMaxPasajeros = trim(fgets(STDIN));
        if ($crearViajeVCantMaxPasajeros > 0 && is_numeric($crearViajeVCantMaxPasajeros)) {
            $valido = true;
        }
        else {
            echo "Por favor ingrese un valor válido, mayor a 0\n";
        }
    } while ($valido == false);
    $valido = false;
    do {
        echo "Seleccione la empresa a cargo del viaje:\n";
        listarEmpresas();
        echo "Opción: ";
        $crearViajeEmpresaViaje = trim(fgets(STDIN));
        if ($crearViajeEmpresaViaje > 0 && $crearViajeEmpresaViaje <= count($bdEmpresas)) {
            $crearViajeIdEmpresaViaje = $bdEmpresas[$crearViajeEmpresaViaje-1];
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
            $crearViajeObjEmpleado = $bdResponsables[$crearViajeResponsableViaje-1];
            $valido = true;
        }
        else {
            echo "La opción ingresada no es correcta\n";
        }
    } while ($valido == false);
    echo "Ingrese el importe del viaje: ";
    $crearViajeVImporteViaje = trim(fgets(STDIN));
    $valido = false;
    do {
        echo "Ingrese el tipo de asiento del viaje:\n1. Cama\n2. Semi-Cama\nOpcion: ";
        $crearViajeTipoAsientoViaje = trim(fgets(STDIN));
        if ($crearViajeTipoAsientoViaje == 1) {
            $valido = true;
            $crearViajeTipoAsientoViaje = "Cama";
        }
        elseif ($crearViajeTipoAsientoViaje == 2) {
            $valido = true;
            $crearViajeTipoAsientoViaje = "Semi-Cama";
        }
        else {
            echo "Opción incorrecta\n";
        }
    } while ($valido == false);
    $valido = false;
    do {
        echo "Ingrese el tipo de viaje:\n1.Ida\n2.Ida y vuelta\nOpcion: ";
        $crearViajeIdaYVueltaViaje = trim(fgets(STDIN));
        if ($crearViajeIdaYVueltaViaje == 1) {
            $valido = true;
            $crearViajeIdaYVueltaViaje = "No";
        }
        elseif ($crearViajeIdaYVueltaViaje == 2) {
            $valido = true;
            $crearViajeIdaYVueltaViaje = "Si";
        }
        else {
            echo "Opción incorrecta\n";
        }
    } while ($valido == false);

    $objViaje->cargar(0,$crearViajeDestinoViaje,$crearViajeVCantMaxPasajeros,$crearViajeIdEmpresaViaje,$crearViajeObjEmpleado,$crearViajeVImporteViaje,$crearViajeTipoAsientoViaje,$crearViajeIdaYVueltaViaje);
    return $objViaje;
}

function agregarResponsable() {
    $objResponsable = new responsable();
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
        echo "O ingrese 0 para cancelar\nOpción: ";
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
            elseif($crearPasajeroViajeSeleccionado == 0) {
                $pasajeroCreado = null;
                break;
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
    } while ($valido == false && $dniPasajeroACrear != "0");
    if ($valido == true) {
        echo "Ingrese el nombre del pasajero: ";
        $nombrePasajeroACrear = trim(fgets(STDIN));
        echo "Ingrese el apellido del pasajero: ";
        $apellidoPasajeroACrear = trim(fgets(STDIN));
        echo "Ingrese el teléfono del pasajero: ";
        $telefonoPasajeroACrear = trim(fgets(STDIN));
        
        $objPasajero->cargar($dniPasajeroACrear,$nombrePasajeroACrear,$apellidoPasajeroACrear,$telefonoPasajeroACrear,$viaje);
    }

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
            $viajeValido = false;
            do {
                echo "Ingrese el destino del viaje: ";
                $crearViajeDestinoViaje = trim(fgets(STDIN));
                $bdViajes = $objViaje->listar("");
                if (count($bdViajes) > 0) {
                    $i=0;
                    $viajeDuplicado = false;
                    do {
                        if (strtoupper($bdViajes[$i]->getVDestino()) == strtoupper($crearViajeDestinoViaje)) {
                            $viajeDuplicado = true;
                        }
                        $i++;
                    } while ($i<count($bdViajes) && $viajeDuplicado == false);
                    if ($viajeDuplicado == true) {
                        echo "Ya existe un viaje con dicho destino\n";
                    }
                    else {
                        $viajeValido = true;
                    }
                }
                else {
                    $viajeValido = true;
                }
            } while ($viajeValido == false);
            $viajeElegido->setVDestino($crearViajeDestinoViaje);
            $viajeElegido->modificar();
            $valido = true;

        }
        elseif ($respuestaModificarViaje == 2) {
            $respuestaValida = false;
            do {
                $objPasajero = new pasajero();
                $bdPasajerosDelViaje = $objPasajero->listar("idviaje=". $viajeElegido->getIdViaje());
                echo "Ingrese la nueva cantidad máxima de pasajeros\nNo puede ser menor a la cantidad actual (". count($bdPasajerosDelViaje) . ") ni tampoco menor a 0: ";
                $nuevaCantidadMaxima = trim(fgets(STDIN));
                if ($nuevaCantidadMaxima > 0 && $nuevaCantidadMaxima >= count($bdPasajerosDelViaje)) {
                    $viajeElegido->setVCantMaxPasajeros($nuevaCantidadMaxima);
                    $viajeElegido->modificar();
                    $valido = true;
                    $respuestaValida = true;
                }
            } while ($respuestaValida == false);
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
                    $viajeElegido->setObjEmpresa($empresaElegida);
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
                    $viajeElegido->setObjEmpleado($responsableElegido);
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
                    $pasajeroElegido->setObjViaje($viajeElegido);
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
    if (count($bdEmpresas) == 0) {
        echo "No hay empresas para eliminar\n";
    }
    else {
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

}

function eliminarViaje() {
    $objViaje = new viaje();
    $bdViajes = $objViaje->listar("");
    $valido = false;

    if (count($bdViajes) == 0) {
        echo "No hay viajes para eliminar\n";
    }
    else {
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

}

function eliminarResponsable() {
    $objResponsable = new responsable();
    $bdResponsables = $objResponsable->listar("");
    $valido = false;

    if (count($bdResponsables) == 0) {
        echo "No hay responsables para eliminar\n";
    }
    else {
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

}

function eliminarPasajero() {
    $objPasajero = new pasajero();
    $bdPasajeros = $objPasajero->listar("");
    $valido = false;

    if (count($bdPasajeros) == 0) {
        echo "No hay pasajeros para eliminar\n";
    }
    else {
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
        echo "5. Mostrar Todo\n";
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

function mostrarTodo() {
    $objEmpresa = new empresa();
    $bdEmpresas = $objEmpresa->listar("");
    $objResponsable = new responsable();
    $bdResponsables = $objResponsable->listar("");
    $stringMostrarTodo = "";

    for ($i=0;$i<count($bdEmpresas);$i++) {
        $stringMostrarTodo .= "\n===================================================". $bdEmpresas[$i] . "\n===================================================\n";
        $objViaje = new viaje();
        $bdViajes = $objViaje->listar("idempresa=". $bdEmpresas[$i]->getIdEmpresa());
        if (count($bdViajes) > 0) {
            $stringMostrarTodo .= "Viajes de " . $bdEmpresas[$i]->getEmpNombre() . ":\n\n";
            for ($j=0;$j<count($bdViajes);$j++) {
                $stringMostrarTodo .= "Viaje Numero ". ($j+1). ":\n\n". $bdViajes[$j]. "\n\n";
                $objPasajero = new pasajero();
                $bdPasajeros = $objPasajero->listar("idviaje=". $bdViajes[$j]->getIdViaje());
                if (count($bdPasajeros) > 0) {
                    $stringMostrarTodo .= "Pasajeros del viaje:\n\n";
                    for ($k=0;$k<count($bdPasajeros);$k++) {
                        $stringMostrarTodo .= ($k+1). ". ". $bdPasajeros[$k]. "\n\n";
                    }
                }
            }
        }
    }
    $stringMostrarTodo .= "\n===================================================\n\nLista de responsables:\n\n";
    for ($h=0;$h<count($bdResponsables);$h++) {
        $stringMostrarTodo .= ($h+1). ". ". $bdResponsables[$h] . "\n\n";
    }
    $stringMostrarTodo .= "===================================================\n\n";
    echo $stringMostrarTodo;
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
                        if ($objPasajeroCreado == null) {
                            echo "No se agregó ningún pasajero\n";
                        }
                        else {
                            $objPasajeroCreado->insertar();
                        }
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
                    $objEmpresaTemp = new empresa();
                    $bdEmpresasTemp = $objEmpresaTemp->listar("");
                    if (count($bdEmpresasTemp) > 0) {
                        modificarEmpresa();
                    }
                    else {
                        echo "No hay empresas para modificar\n";
                    }
                    break;
                case 2:
                    $objViajeTemp = new viaje();
                    $bdViajeTemp = $objViajeTemp->listar("");
                    if (count($bdViajeTemp) > 0) {
                        modificarViaje();
                    }
                    else {
                        echo "No hay viajes para modificar\n";
                    }
                    break;
                case 3:
                    $objResponsableTemp = new responsable();
                    $bdResponsablesTemp = $objResponsableTemp->listar("");
                    if (count($bdResponsablesTemp) > 0) {
                        modificarResponsable();
                    }
                    else {
                        echo "No hay responsables para modificar\n";
                    }
                    break;
                case 4:
                    $objPasajeroTemp = new pasajero();
                    $bdPasajerosTemp = $objPasajeroTemp->listar("");
                    if (count($bdPasajerosTemp) > 0) {
                        modificarPasajero();
                    }
                    else {
                        echo "No hay pasajeros para modificar\n";
                    }
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
                case 5:
                    mostrarTodo();
                    break;
            }
            break;
        case 5:
            $objEmpresaTemp = new empresa();
            $dbEmpresaTemp = $objEmpresaTemp->listar("");
            $objResponsableTemp = new responsable();
            $dbResponsableTemp = $objResponsableTemp->listar("");
            if ( count($dbEmpresaTemp) > 0 || count($dbResponsableTemp) > 0) {
                echo "Ya hay datos cargados, si quiere cargar los de prueba borre los previos\n";
            }
            else {
                precargarDatos();
                echo "Datos de prueba cargados con éxitos\n";
            }
            break;
        case 0:
            echo "Fin del programa";
            break;
    }
} while ($respuestaMenuPrincipal <> 0);