<?php
#[\AllowDynamicProperties]

class Anuncio extends Model{
    protected static $fillable = ["titulo", "precio", "userid", "imagen"];

    public function validate():array{
        $errores = [];

        if(empty($this->titulo)){
            $errores['titulo'] = "Error en el titulo";
        }

        return $errores;
    }

}