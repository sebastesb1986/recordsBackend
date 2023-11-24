<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = "clients";
    protected $fillable = ['sharedkey', 'businessid', 'email', 'phone', 'created_at', 'start_at', 'end_at'];

    public $timestamps = false;

    // Mutador para crear el campo sharedkey
    public function setBusinessidAttribute($data)
    {
        // Dividir el nombre en palabras
        $name = explode(' ', $data);

        // Verificar si hay dos o mas nombres
        if (count($name) > 1) {
            // Obtener la primera letra del primer nombre
            $firstCharName = substr($name[0], 0, 1);

            // Obtener el segundo nombre completo
            $businessid = implode('', array_slice($name, 1));

            // Concatenamos la inicial del primer nombre con el segundo nombre
            $sharedkey = strtolower($firstCharName . $businessid);
        } else {
            // Si solo hay un nombre, mostrarlo completo
            $sharedkey = $name[0];
        }

        // Nombre para el campo sharedkey
        $this->attributes['businessid'] = $data;
        $this->attributes['sharedkey'] = $sharedkey;
    }

    // Relación con clientelog
    public function clientlog()
    {
        return $this->hasOne(Clientlog::class);
    }

    // Scope para crear log registro y actualización de clientes
    protected static function booted()
    {
        static::saved(function ($client) {

            // Guardar en la tabla client_logs
            $client->clientlog()->create([
                'clientName' => $client->businessid,
                'action' => $client->wasRecentlyCreated ? 'created' : 'updated',
            ]);
        });
    }

}