<?php

class Prestamo {

    private $identificacion;
    private $codigoElectrodomestico;
    private $fechaOtorgamiento;
    private $monto;
    private $cantidadDeCuotas;
    private $interes;
    private $coleccionCuotas;
    private $objPersona;

    public function __construct($ide,$monto,/*$coleccionDeCuotas,*/$cantCuotas,$int,$persona) {

        $this->identificacion = $ide;
        $this->codigoElectrodomestico = "";
        $this->monto = $monto;
        $this->cantidadDeCuotas = $cantCuotas;
        $this->interes = $int;
        // $this->coleccionCuotas = $coleccionDeCuotas;
        $this->coleccionCuotas = [];
        $this->objPersona = $persona;

    }

    // Métodos Get

    public function getIdentificacion() {
        return $this->identificacion;
    }

    public function getCodigoElectrodomestico() {
        return $this->codigoElectrodomestico;
    }

    public function getFechaOtorgamiento() {
        return $this->fechaOtorgamiento;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function getCantidadDeCuotas() {
        return $this->cantidadDeCuotas;
    }

    public function getInteres() {
        return $this->interes;
    }

    public function getColeccionCuotas() {
        return $this->coleccionCuotas;
    }

    public function getPersona() {
        return $this->objPersona;
    }

    // Métodos Set

    public function setIdentificacion($ide) {
        $this->identificacion = $ide;
    }

    public function setCodigoElectrodomestico($cod) {
        $this->codigoElectrodomestico = $cod;
    }

    public function setFechaOtorgamiento($fecha) {
        $this->fechaOtorgamiento = $fecha;
    }

    public function setMonto($monto) {
        $this->monto = $monto;
    }

    public function setCantidadDeCuotas($cantCuotas) {
        $this->cantidadDeCuotas = $cantCuotas;
    }

    public function setInteres($int) {
        $this->interes = $int;
    }

    public function setColeccionCuotas($colCuotas) {
        $this->coleccionCuotas = $colCuotas;
    }

    public function setPersona($objPersona) {
        $this->objPersona = $objPersona;
    }

    // Otros Métodos

    public function __toString() { 
        
        return "\nPrestamo N°: ".$this->getIdentificacion()."\n".
            "Monto solicitado: ".$this->getMonto()."\n".
            "En ".$this->getCantidadDeCuotas()." cuotas"."\n".
            "Cuotas: ". $this->stringCuotas()."\n".
            "Datos del solicitante: "."\n".
            $this->getPersona();

        /*return "Identificación: ". $this->getIdentificacion(). "\nMonto: ". $this->getMonto(). "\nCantidad de Cuotas: ". $this->getCantidadDeCuotas(). "\nInteres: ". $this->getInteres(). "\nA nombre de: ". $this->getPersona();*/
    }

    private function stringCuotas() {
        $stringCuotasFelices = "";
        $i=0;
        foreach($this->getColeccionCuotas() as $item){
            $stringCuotasFelices .= $item /*Una cuota*/;
            $i++;
            }
        return $stringCuotasFelices;
    }

    private function calcularInteresPrestamo($numCuota) {
        $monto = $this->getMonto();
        $cantidadDeCuotas = $this->getCantidadDeCuotas();
        $porcentajeDeInteres = $this->getInteres();


        $interes = (($monto-(($monto/$cantidadDeCuotas)*($numCuota - 1)))*$porcentajeDeInteres*0.01);
        return $interes;

    }

    public function otorgarPrestamo() {

        $cuotas = [];
        $this->setFechaOtorgamiento(getdate());
        $valorCuota = $this->getMonto() / $this->getCantidadDeCuotas();

        for ($i=1; $i<=$this->getCantidadDeCuotas(); $i++) {
            $objCuota = new Cuota($i,$valorCuota,$this->calcularInteresPrestamo($i));
            $cuotas[$i-1] = $objCuota;
        }

        $this->setColeccionCuotas($cuotas);

    }



    public function darSiguienteCuotaPagar() {

        $cuotas = $this->getColeccionCuotas();
        $encontrado = false;
        $i = 0;

        /*
        do {
            if ($cuotas[$i]->getCancelada() == false) {
                $encontrado = true;
            }
            $i++;
        } while ($i < count($cuotas) && $encontrado == false);
        */

        while ($i < count($cuotas) && $encontrado == false) {
            if ($cuotas[$i]->getCancelada() == false) {
                $encontrado = true;
            }
            $i++;
        }

        if ($encontrado == false) {
            return null;
        }
        else {
            return $cuotas[$i-1];
        }

    }

}