<?php

class ViajeTerrestre extends Viaje
{

    private $comodidadAsientos;

    public function __construct($comAsientos, $code, $dest, $maxPa, $pa, $resp, $imp, $iYV)
    {

        parent::__construct($code, $dest, $maxPa, $pa, $resp, $imp, $iYV);
        $this->comodidadAsientos = $comAsientos;
    }

    // Métodos get
    public function getComodidadAsientos()
    {
        return $this->comodidadAsientos;
    }

    // Métodos set

    public function setComodidadAsientos($comAsientosN)
    {
        $this->comodidadAsientos = $comAsientosN;
    }

    // Otras funciones

    public function __toString()
    {
        $terrestre = parent::__toString();
        $terrestre .= "\nTipo de asientos: " . $this->getComodidadAsientos();
        return $terrestre;
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

            if ($this->getComodidadAsientos() == "Cama") {
                $importe = $importe * 1.25;
            }

            if ($this->getIdaYVuelta() == "Ida y Vuelta") {
                $importe = $importe * 1.5;
            }
            $this->agregarPasajero($pasajero);

            return $importe;
        }
    }
}
