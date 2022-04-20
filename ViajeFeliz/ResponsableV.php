<?php

    class ResponsableV {

        private $nombre;
        private $apellido;
        private $numeroDeEmpleado;
        private $numeroDeLicencia;

        public function __construct($nom,$ape,$numEmpleado,$numLicencia) {
            
            $this->nombre = $nom;
            $this->apellido = $ape;
            $this->numeroDeEmpleado = $numEmpleado;
            $this->numeroDeLicencia = $numLicencia;

        }

        // Métodos Get

        public function getNombre() {
            return $this->nombre;
        }

        public function getApellido() {
            return $this->apellido;
        }

        public function getNumeroDeEmpleado() {
            return $this->numeroDeEmpleado;
        }

        public function getNumeroDeLicencia() {
            return $this->numeroDeLicencia;
        }

        // Métodos Set

        public function setNombre($nombreN) {
            $this->nombre = $nombreN;
        }

        public function setApellido($apellidoN) {
            $this->apellido = $apellidoN;
        }

        public function setNumeroDeEmpleado($numEmpN) {
            $this->numeroDeEmpleado = $numEmpN;
        }

        public function setNumeroDeLicencia($numLicN) {
            $this->numeroDeLicencia = $numLicN;
        }


        // Otros Métodos

        public function __toString() {
            
            return $this->getNombre(). " ". $this->getApellido(). " - Empleado Número: ". $this->getNumeroDeEmpleado(). " - Licencia: ". $this->getNumeroDeLicencia();  

        }

    }