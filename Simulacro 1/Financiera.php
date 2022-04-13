<?php

class Financiera {

    private $denominacion;
    private $direccion;
    private $coleccionDePrestamos;

    public function __construct($den, $dir/*,$coleccionDePrestamos*/) {

        $this->denominacion = $den;
        $this->direccion = $dir;
        $this->coleccionDePrestamos = []/* $coleccionDePrestamos */;

    }

    // Métodos Get

    public function getDenominacion() {
        return $this->denominacion;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function getColeccionDePrestamos() {
        return $this->coleccionDePrestamos;
    }

    // Métodos Set

    public function setDenominacion($den) {
        $this->denominacion = $den;
    }

    public function setDireccion($dir) {
        $this->direccion = $dir;
    }

    public function setColeccionDePrestamos($col) {
        $this->coleccionDePrestamos = $col;
    }

    // Otros Métodos

    public function __toString() {

        return "Denominación: ". $this->getDenominacion(). "\nDirección: ". $this->getDireccion(). "\nPréstamos otorgados: ". $this->stringPrestamos(). "\n";

        /*return "Denominación: ". $this->getDenominacion(). "\nDirección: ". $this->getDireccion(). "\nPréstamos otorgados: ". print_r($this->getColeccionDePrestamos()). "\n";*/
    }

    private function stringPrestamos() {
        $stringPrestamosFelices = "";
        $i=0;
        foreach($this->getColeccionDePrestamos() as $item){
            $stringPrestamosFelices .= $item /*Un préstamo*/;
            $i++;
            }
        return $stringPrestamosFelices;
    }

    public function incorporarPrestamo($prestamo) {

        $coleccionPrestamos = $this->getColeccionDePrestamos();
        $coleccionPrestamos[count($coleccionPrestamos)] = $prestamo;
        $this->setColeccionDePrestamos($coleccionPrestamos);

    }

    public function otorgarPrestamoSiCalifica() {

        for ($i=0; $i < count($this->getColeccionDePrestamos());$i++) {
            if (count($this->getColeccionDePrestamos()[$i]->getColeccionCuotas()) == 0) {
                $objPersona = $this->getColeccionDePrestamos()[$i]->getPersona();
                if($this->getColeccionDePrestamos()[$i]->getMonto() / $this->getColeccionDePrestamos()[$i]->getCantidadDeCuotas() <= $objPersona->getNeto() * 0.4) {
                    $this->getColeccionDePrestamos()[$i]->otorgarPrestamo();
                }
            }
        }
    }

    public function informarCuotaPagar($idPrestamo) {

        $encontrado = false;
        $siguienteCuota = null;
        $i=0;

        do {
            if ($idPrestamo == $this->getColeccionDePrestamos()[$i]->getIdentificacion()) {
                $siguienteCuota = $this->getColeccionDePrestamos()[$i]->darSiguienteCuotaPagar();
                $encontrado = true;
            }
            $i++;
        } while ($i < count($this->getColeccionDePrestamos()) && $encontrado == false);

        return $siguienteCuota;

    }

}