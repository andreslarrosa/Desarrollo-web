<?php

class ViajeAereo extends Viaje
{

    //De los viajes aéreos se conoce el número del vuelo, 
    //la categoría del asiento (primera clase o no), nombre de la aerolínea, y la cantidad de escalas del vuelo en caso de tenerlas.

    private $numeroDeVuelo;
    private $categoriaAsientos;
    private $nombreAerolinea;
    private $cantidadDeEscalas;

    public function __construct($numVuelo, $catAsientos, $nomAero, $cantEsc, $code, $dest, $maxPa, $pa, $resp, $imp, $iYV)
    {

        parent::__construct($code, $dest, $maxPa, $pa, $resp, $imp, $iYV);
        $this->numeroDeVuelo = $numVuelo;
        $this->categoriaAsientos = $catAsientos;
        $this->nombreAerolinea = $nomAero;
        $this->cantidadDeEscalas = $cantEsc;
    }

    // Métodos Get

    public function getNumeroDeVuelo()
    {
        return $this->numeroDeVuelo;
    }

    public function getCategoriaDeAsientos()
    {
        return $this->categoriaAsientos;
    }

    public function getNombreAerolinea()
    {
        return $this->nombreAerolinea;
    }

    public function getCantidadDeEscalas()
    {
        return $this->cantidadDeEscalas;
    }

    // Métodos Set

    public function setNumeroDeVuelo($numVueloN)
    {
        $this->numeroDeVuelo = $numVueloN;
    }

    public function setCategoriaDeAsientos($catAsientosN)
    {
        $this->categoriaAsientos = $catAsientosN;
    }

    public function setNombreAerolinea($nomAeroN)
    {
        $this->nombreAerolinea = $nomAeroN;
    }

    public function setCantidadDeEscalas($cantEscN)
    {
        $this->cantidadDeEscalas = $cantEscN;
    }

    // Otras funciones

    public function __toString()
    {
        $aereo = parent::__toString();
        $aereo .= "\nNombre De Aerolinea: " . $this->getNombreAerolinea() . "\nNúmero de vuelo:" . $this->getNumeroDeVuelo() . "\nAsientos: " . $this->getCategoriaDeAsientos() . "\nCantidad de Escalas: " . $this->getCantidadDeEscalas();
        return $aereo;
    }

    /**
     * Función que vende un pasaje
     * @param object $pasajero
     * @return int $importe
     */
    function venderPasaje($pasajero)
    {

        if ($this->hayPasajesDisponibles() == true) {

            $importe = $this->getImporte();

            if ($this->getCategoriaDeAsientos() == "Primera Clase" && $this->getCantidadDeEscalas() == 0) {
                $importe = $importe * 1.4;
            } elseif ($this->getCategoriaDeAsientos() == "Primera Clase" && $this->getCantidadDeEscalas() > 0) {
                $importe = $importe * 1.6;
            }

            if ($this->getIdaYVuelta() == "Ida y Vuelta") {
                $importe = $importe * 1.5;
            }
            $this->agregarPasajero($pasajero);

            return $importe;
        }
    }
}
