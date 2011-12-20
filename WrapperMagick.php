<?php

/** @todo Hacer buen manejo de errores con excepciones! */

class WrapperMagick 
{

    protected $comando = "convert ";
    protected $fichero;

    public function __construct($fichero)
    {
        $this->fichero = $fichero;
    }
    
    public function redimensionar($ancho, $alto=null)
    {
        $this->comando .= " -resize " . $ancho . "x";
        if (!empty($alto)) $this->comando .= $alto;
        return $this;
    }
    
    public function cortar($x, $y, $ancho, $alto) {
        $this->comando .= " -crop ...";
        return $this;
    }

    public function guardar($destino)
    {
        $this->comando .= " " . $this->fichero . " $destino";
        system($this->comando);
        
        //Si el fichero destino existe, todo ha ido bien
        return file_exists($destino);
    }
}