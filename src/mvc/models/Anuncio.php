<?php
#[\AllowDynamicProperties]

class Anuncio extends Model{
    protected static $fillable = ["titulo", "precio", "iduser", "imagen", "descripcion"];

    public function validate():array{
        $errores = [];

        if(empty($this->titulo)){
            $errores['titulo'] = "Error en el titulo";
        }

        return $errores;
    }
    public function checkOwner(){
        return $this->iduser == Login::user()->id;
    }

}