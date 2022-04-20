<?php

// Creamos la clase Viaje
class Viaje
{

    // Atributos privados de cada objeto
    private $codigo;
    private $destino;
    private $maxPasajeros;
    private $pasajeros = [];
    private $responsable;

    public function __construct($code, $dest, $maxPa, $pa, $resp)
    {

        // Construimos un objeto y le asignamos dichos atributos
        $this->codigo = $code;
        $this->destino = $dest;
        $this->maxPasajeros = $maxPa;
        $this->pasajeros = $pa;
        $this->responsable = $resp;
    }

    // Funciones Get para recibir información de los atributos del objeto
    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getDestino()
    {
        return $this->destino;
    }

    public function getMaxPasajeros()
    {
        return $this->maxPasajeros;
    }

    public function getPasajeros()
    {
        return $this->pasajeros;
    }

    public function getResponsable()
    {
        return $this->responsable;
    }

    // Funciones Set para modificar los atributos de dicho objeto
    public function setCodigo($codeN)
    {
        $this->codigo = $codeN;
    }

    public function setDestino($destinoN)
    {
        $this->destino = $destinoN;
    }

    public function setMaxPasajeros($maxPasajerosN)
    {
        $this->maxPasajeros = $maxPasajerosN;
    }

    public function setPasajeros($pasajerosN)
    {
        $this->pasajeros = $pasajerosN;
    }

    public function setResponsable($responsableN)
    {
        $this->responsable = $responsableN;
    }

    // Otras funciones
    public function __toString()
    {
        return "Código de viaje: " . $this->getCodigo() . "\nDestino del viaje: " . $this->getDestino() . "\nCantidad máxima de pasajeros: " . $this->getMaxPasajeros() . "\nCantidad de pasajeros: " . count($this->getPasajeros()) . "\nResponsable: " . $this->getResponsable() . "\nPasajeros:\n" . $this->listaDePasajeros();
    }

    // Función que muestra la lista de pasajeros
    public function listaDePasajeros()
    {

        $stringPasajeros = "";

        for ($i = 0; $i < count($this->getPasajeros()); $i++) {
            $stringPasajeros .= ($i + 1) . ". " . $this->getPasajeros()[$i] . "\n";
        }

        return $stringPasajeros;
    }

    /**
     * Función utilizada para modificar los datos de un pasajero, donde se ingresa el dato a modificar, que es lo que se va a modificar y el pasajero al que se va a modificar
     * @param mixed $dato
     * @param int $valor
     * @param object $pasajero 
     */
    public function modificarDatosDePasajeros($dato, $valor, $pasajero)
    {

        $listaDePasajeros = $this->getPasajeros();

        if ($valor == 1) {
            $listaDePasajeros[$pasajero]->setNombre($dato);
        } elseif ($valor == 2) {
            $listaDePasajeros[$pasajero]->setApellido($dato);
        } elseif ($valor == 3) {
            $listaDePasajeros[$pasajero]->setDocumento($dato);
        } elseif ($valor == 4) {
            $listaDePasajeros[$pasajero]->setTelefono($dato);
        }
        $this->setPasajeros($listaDePasajeros);
    }

    /**
     * Función utilizada para modificar los datos del Responsable, donde se ingresa el dato a modificar y que es lo que se va a modificar
     * @param mixed $dato
     * @param int $valor
     * @param object $pasajero 
     */
    public function modificarDatosReponsable($dato, $valor)
    {

        $responsable = $this->getResponsable();

        if ($valor == 1) {
            $responsable->setNombre($dato);
        } elseif ($valor == 2) {
            $responsable->setApellido($dato);
        } elseif ($valor == 3) {
            $responsable->setNumeroDeEmpleado($dato);
        } elseif ($valor == 4) {
            $responsable->setNumeroDeLicencia($dato);
        }
        $this->setResponsable($responsable);
    }

    /**
     * Función utilizada para agregar un pasajero previamente verificado
     * @param object $pasajero
     */
    public function agregarPasajero($pasajero)
    {

        // Validación ya realizada y aprobada en el test (Pero por si las dudas que solo se agregue el pasajero bajo dicha condición)
        if (count($this->getPasajeros()) < $this->getMaxPasajeros()) {
            // array_push()
            $listaDePasajeros = $this->getPasajeros();
            $listaDePasajeros[count($listaDePasajeros)] = $pasajero;
            $this->setPasajeros($listaDePasajeros);
        }
    }

    /**
     * Función que comprueba si un pasajero está repetido dentro de un viaje
     * @param array $pasajero
     * @return boolean $seRepite
     */

    function pasajeroRepetido($pasajero)
    {

        $listaDePasajeros = $this->getPasajeros();
        $seRepite = false;
        $i = 0;
        // in_array
        // Verifico la igualdad total de los objetos, aunque lógicamente solo con el documento bastaría
        if (count($listaDePasajeros) > 0) {
            do {

                $pasajeroABuscar[0] = $listaDePasajeros[$i]->getNombre(); // Se puede repetir
                $pasajeroABuscar[1] = $listaDePasajeros[$i]->getApellido(); // Se puede repetir
                $pasajeroABuscar[2] = $listaDePasajeros[$i]->getDocumento(); // No se debería repetir
                $pasajeroABuscar[3] = $listaDePasajeros[$i]->getTelefono(); // Se puede repetir

                if ($pasajeroABuscar == $pasajero) {
                    $seRepite = true;
                }
                $i++;
            } while ($seRepite == false && $i < count($listaDePasajeros));
        }

        return $seRepite;
    }
}
