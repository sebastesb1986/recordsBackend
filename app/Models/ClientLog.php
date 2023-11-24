<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLog extends Model
{
    use HasFactory;

    protected $table = "clientlog";
    protected $fillable = ['clientName', 'action', 'client_id', 'created_at', 'updated_at'];

    // Relación con cliente
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
