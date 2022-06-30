<?php

include_once "BaseDatos.php";

class empresa
{

    private $idempresa;
    private $enombre;
    private $edireccion;
    private $mensajeoperacion;

    public function __construct()
    {
        $this->idempresa = 0;
        $this->enombre = "";
        $this->edireccion = "";
    }

    public function cargar($idEmp, $empNom, $empDir)
    {
        $this->setIdEmpresa($idEmp);
        $this->setEmpNombre($empNom);
        $this->setEmpDireccion($empDir);
    }

    public function getIdEmpresa()
    {
        return $this->idempresa;
    }

    public function getEmpNombre()
    {
        return $this->enombre;
    }

    public function getEmpDireccion()
    {
        return $this->edireccion;
    }

    public function getmensajeoperacion()
    {
        return $this->mensajeoperacion;
    }

    public function setIdEmpresa($idEmpN)
    {
        $this->idempresa = $idEmpN;
    }

    public function setEmpNombre($empNomN)
    {
        $this->enombre = $empNomN;
    }

    public function setEmpDireccion($empDirN)
    {
        $this->edireccion = $empDirN;
    }

    public function setmensajeoperacion($mensajeoperacion)
    {
        $this->mensajeoperacion = $mensajeoperacion;
    }

    public function __toString()
    {
        return "\nNombre de la Empresa: " . $this->getEmpNombre() . "\nId: " . $this->getIdEmpresa() . "\nDirección: " . $this->getEmpDireccion();
    }

    public function Buscar($idEmpresa)
    {
        $base = new BaseDatos();
        $consultaEmpresa = "Select * from empresa where idempresa=" . $idEmpresa;
        $resp = false;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEmpresa)) {
                if ($row2 = $base->Registro()) {
                    $this->setIdEmpresa($idEmpresa);
                    $this->setEmpNombre($row2['enombre']);
                    $this->setEmpDireccion($row2['edireccion']);
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
        $arregloEmpresa = null;
        $base = new BaseDatos();
        $consultaEmpresas = "Select * from empresa ";
        if ($condicion != "") {
            $consultaEmpresas = $consultaEmpresas . ' where ' . $condicion;
        }
        $consultaEmpresas .= " order by idempresa ";
        //echo $consultaPersonas;
        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaEmpresas)) {
                $arregloEmpresa = array();
                while ($row2 = $base->Registro()) {

                    $empr = new empresa();
                    $empr->Buscar($row2['idempresa']);
                    array_push($arregloEmpresa, $empr);
                }
            } else {
                $this->setmensajeoperacion($base->getError());
            }
        } else {
            $this->setmensajeoperacion($base->getError());
        }
        return $arregloEmpresa;
    }

    public function insertar()
    {
        $base = new BaseDatos();
        $resp = false;
        $consultaInsertar = "INSERT INTO empresa(enombre, edireccion) 
				VALUES ('" . $this->getEmpNombre() . "','" . $this->getEmpDireccion() . "')";

        if ($base->Iniciar()) {

            if ($base->Ejecutar($consultaInsertar)) {
                $this->setIdEmpresa($base->DevolverID());;
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
        $consultaModifica = "UPDATE empresa SET enombre='" . $this->getEmpNombre() . "',edireccion='" . $this->getEmpDireccion() . "' WHERE idempresa=" . $this->getIdEmpresa();
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
            $consultaBorra = "DELETE FROM empresa WHERE idempresa=" . $this->getIdEmpresa();
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
