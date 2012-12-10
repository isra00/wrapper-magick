<?php

namespace WrapperMagick;

/**
 * Interfaz orientada a objetos sencilla para operar con ImageMagick y 
 * GraphicsMagick a través de su API binaria (comando convert).
 *
 * @todo        Hacer buen manejo de errores con excepciones!
 * @todo        Escapar mejor los nombres de ficheros
 *
 * @package     WrapperMagick
 * @author      Israel Viana <http://israelviana.es>
 * @copyright   2011 © Israel Viana <isra00@gmail.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0.txt GNU Lesser General Public License
 */
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


    /**
     * Guarda la imagen procesando las operaciones realizadas con los otros 
     * métodos
     * 
     * @param   string  $destino    Fichero de destino
     * @return  boolean Si el fichero destino ha sido creado correctamente
     *
     * @todo    Separar en otro método _ejecutarComando() o algo así
     */
    public function guardar($destino)
    {
        $this->execCommand($this->assemble($destino));
        
        //Si el fichero destino existe, todo ha ido bien
        return file_exists($destino);
    }
    
    public function assemble($destino)
    {
        $origen = $this->fichero;
        
        //Si el origen es PDF, agrega [0] al nombre (sí, GraphicsMagick lee PDF :-)
        if ($this->getContentType($this->fichero) == 'application/pdf') {
            $origen .= '[0]'; //Primera página del PDF
        }
        
        $this->comando .= " $origen $destino";
        
        return $this->comando;
    }
    
    protected function execCommand($command)
    {
        exec($command);
    }
    
    protected function getContentType($file)
    {
        return mime_content_type($file);
    }
}
