<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;

trait EncriptacionTrait
{
    /**
     * Encriptar una ruta o string
     */
    protected function enc($path)
    {
        return Crypt::encryptString($path);
    }
    
    /**
     * Desencriptar una ruta o string
     */
    protected function dec($pathEncriptado)
    {
        try {
            return Crypt::decryptString($pathEncriptado);
        } catch (\Exception $e) {
            abort(404, 'Ruta inválida o documento no encontrado');
        }
    }
}