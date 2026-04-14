<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Verificar que las columnas existan
        $columns = DB::getSchemaBuilder()->getColumnListing('contribuyentes');
        
        $contribuyentes = DB::table('contribuyentes')->get();
        
        foreach ($contribuyentes as $contribuyente) {
            $updateData = [];
            
            if (in_array('rfc', $columns) && $contribuyente->rfc && !$this->isEncrypted($contribuyente->rfc)) {
                $updateData['rfc'] = Crypt::encryptString($contribuyente->rfc);
            }
            if (in_array('curp', $columns) && $contribuyente->curp && !$this->isEncrypted($contribuyente->curp)) {
                $updateData['curp'] = Crypt::encryptString($contribuyente->curp);
            }
            if (in_array('email', $columns) && $contribuyente->email && !$this->isEncrypted($contribuyente->email)) {
                $updateData['email'] = Crypt::encryptString($contribuyente->email);
            }
            if (in_array('telefono', $columns) && $contribuyente->telefono && !$this->isEncrypted($contribuyente->telefono)) {
                $updateData['telefono'] = Crypt::encryptString($contribuyente->telefono);
            }
            if (in_array('direccion', $columns) && $contribuyente->direccion && !$this->isEncrypted($contribuyente->direccion)) {
                $updateData['direccion'] = Crypt::encryptString($contribuyente->direccion);
            }
            
            if (!empty($updateData)) {
                DB::table('contribuyentes')->where('id', $contribuyente->id)->update($updateData);
            }
        }
    }
    
    private function isEncrypted($value)
    {
        // Verificar si el valor ya está cifrado (comienza con "eyJ")
        return str_starts_with($value, 'eyJ');
    }
    
    public function down()
    {
        // No se puede desencriptar fácilmente
    }
};