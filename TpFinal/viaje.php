<?php

include_once "BaseDatos.php";

class viaje
{

    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $idempresa;
    private $rnumeroempleado;
    private $vimporte;
    private $tipoAsiento;
    private $idayvuelta;
    private $mensajeoperacion;

    public function __construct()
    {

        $this->idviaje = 0;
        $this->vdestino = "";
        $this->vcantmaxpasajeros = "";
        $this->idempresa = "";
        $this->rnumeroempleado = "";
        $this->vimporte = "";
        $this->tipoAsiento = "";
        $this->idayvuelta = "";
    }

    public function cargar($idViajeN,$vDestN, $vCantMaxPsjN, $idEmpN, $rNumEmpN, $vImpN, $tipoAsiN, $idaYVN)
    {
        $this->setIdViaje($idViajeN);
        $this->setVDestino($vDestN);
        $this->setVCantMaxPasajeros($vCantMaxPsjN);
        $this->setIdEmpresa($idEmpN);
        $this->setRNumeroEmpleado($rNumEmpN);
        $this->setVImporte($vImpN);
        $this->setTipoAsiento($tipoAsiN);
        $this->setIdaYVuelta($idaYVN);
    }

    public function getIdViaje()
    {
        return $this->idviaje;
    }

    public function getVDestino()
    {
        return $this->vdestino;
    }

    public function getVCantMaxPasajeros()
    {
        return $this->vcantmaxpasajeros;
    }

    public function getIdEmpresa()
    {
        return $this->idempresa;
    }

    public function getRNumeroEmpleado()
    {
        return $this->rnumeroempleado;
    }

    public function getVImporte()
    {
        return $this->vimporte;
    }

    public function getTipoAsiento()
    {
        return $this->tipoAsiento;
    }

    public function getIdaYVuelta()
    {
        return $this->idayvuelta;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setIdViaje($idViaN)
    {
        $this->idviaje = $idViaN;
    }

    public function setVDestino($vDestN)
    {
        $this->vdestino = $vDestN;
    }

    public function setVCantMaxPasajeros($vCantMaxPsjN)
    {
        $this->vcantmaxpasajeros = $vCantMaxPsjN;
    }

    public function setIdEmpresa($idEmpN)
    {
        $this->idempresa = $idEmpN;
    }

    public function setRNumeroEmpleado($rNumEmpN)
    {
        $this->rnumeroempleado = $rNumEmpN;
    }

    public function setVImporte($vImpN)
    {
        $this->vimporte = $vImpN;
    }

    public function setTipoAsiento($tipoAsiN)
    {
        $this->tipoAsiento = $tipoAsiN;
    }

    public function setIdaYVuelta($idaYVN)
    {
        $this->idayvuelta = $idaYVN;
    }

    public function setmensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function __toString()
    {
        return "Id del viaje: " . $this->getIdViaje() . "\nDestino: " . $this->getVDestino() . "\nPasajeros máximos: " . $this->getVCantMaxPasajeros() . "\nId Empresa: ". $this->getIdEmpresa(). 
            "\nNúmero de empleado: " . $this->getRNumeroEmpleado() . "\nImporte: " . $this->getVImporte() . "\nAsientos: " . $this->getTipoAsiento() . "\nIda y Vuelta: " . $this->getIdaYVuelta();
    }

    public function Buscar($idViaje)
    {
        $base = new BaseDatos();
        $consultaViaje = "Select * from viaje where idviaje=" . $idViaje;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViaje)) {
                if ($row2 = $base->Registro()) {
                    $this->setIdViaje($idViaje);
                    $this->setVDestino($row2['vdestino']);
                    $this->setVCantMaxPasajeros($row2['vcantmaxpasajeros']);
                    $this->setIdEmpresa($row2['idempresa']);
                    $this->setRNumeroEmpleado($row2['rnumeroempleado']);
                    $this->setVImporte($row2['vimporte']);
                    $this->setTipoAsiento($row2['tipoAsiento']);
                    $this->setIdaYVuelta($row2['idayvuelta']);
                    $resp = true;
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    public static function listar($condicion = "")
    {
        $arregloViaje = null;
        $base = new BaseDatos();
        $consultaViajes = "Select * from viaje ";
        if ($condicion != "") {
            $consultaViajes = $consultaViajes . ' where ' . $condicion;
        }
        $consultaViajes .= " order by idviaje ";
        //echo $consultaViajes;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViajes)) {
                $arregloViaje = array();
                while($row2=$base->Registro()) {
                    $IdVia=$row2['idviaje'];
                    $VDest=$row2['vdestino'];
                    $VCantMaxPsj=$row2['vcantmaxpasajeros'];
                    $IdEmp=$row2['idempresa'];
                    $RNumEmp=$row2['rnumeroempleado'];
                    $VImp=$row2['vimporte'];
                    $TipoAsi=$row2['tipoAsiento'];
                    $IdaYV=$row2['idayvuelta'];

                    $viaj = new viaje();
                    $viaj->cargar($IdVia, $VDest, $VCantMaxPsj, $IdEmp, $RNumEmp, $VImp, $TipoAsi, $IdaYV);
                    array_push($arregloViaje, $viaj);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloViaje;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar="INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte, tipoAsiento,  idayvuelta) 
				VALUES ('".$this->getVDestino()."','".$this->getVCantMaxPasajeros()."','".$this->getIdEmpresa()."','".$this->getRNumeroEmpleado()."','".$this->getVImporte()."','".$this->getTipoAsiento()."','".$this->getIdaYVuelta()."')";

        if ($base->Iniciar()) {

            if ($base->Ejecutar($consultaInsertar)) {
                $this->setIdViaje($base->DevolverID());;
                $resp =  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE viaje SET vdestino='" . $this->getVDestino() . "',vcantmaxpasajeros='" . $this->getVCantMaxPasajeros() . "'
                           ,idempresa='" . $this->getIdEmpresa() . "',rnumeroempleado='" . $this->getRNumeroEmpleado() . "'
                           ,vimporte='" . $this->getVImporte() . "',tipoAsiento='" . $this->getTipoAsiento() . "',idayvuelta='" . $this->getIdaYVuelta() . "' WHERE idviaje=" . $this->getIdViaje();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $base = new BaseDatos();
        $resp = false;
        if ($base->Iniciar()) {
            $consultaBorra = "DELETE FROM viaje WHERE idviaje=" . $this->getIdViaje();
            if ($base->Ejecutar($consultaBorra)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $resp;
    }
}
