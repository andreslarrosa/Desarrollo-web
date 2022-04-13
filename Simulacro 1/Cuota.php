<?php

class Cuota {

    private $numero;
    private $montoCuota;
    private $montoInteres;
    private $cancelada;

    public function __construct($num,$monCuo,$monInt){

        $this->numero = $num;
        $this->montoCuota = $monCuo;
        $this->montoInteres = $monInt;
        $this->cancelada = false;

    }

    // Métodos Get

    public function getNumero() {
        return $this->numero;
    }

    public function getMontoCuota() {
        return $this->montoCuota;
    }

    public function getMontoInteres() {
        return $this->montoInteres;
    }

    public function getCancelada() {
        return $this->cancelada;
    }

    // Métodos Set
    
    public function setNumero($num) {
        $this->numero = $num;
    }

    public function setMontoCuota($monCuo) {
        $this->montoCuota = $monCuo;
    }

    public function setMontoInteres($monInt) {
        $this->montoInteres = $monInt;
    }

    public function setCancelada($can) {
        $this->cancelada = $can;
    }


    // Otros Métodos

    public function __toString() {

        return "Número de cuota: ". $this->getNumero(). "\nMonto: ". $this->getMontoCuota(). "\nInterés: ". $this->getMontoInteres(). "\nCancelada: ". $this->getCancelada(). "\n";

        //return "Número de cuota: ". $this->getNumero(). "\nMonto: ". $this->getMontoCuota(). "\nInterés: ". $this->getMontoInteres(). "\nCancelada: ". $this->getCancelada();
    }

    /**
     * Función que retorna el monto final de la cuota + su interes
     * @return int
     */

    public function darMontoFinalCuota() {
        return $this->getMontoCuota() + $this->getMontoInteres();
    }

}