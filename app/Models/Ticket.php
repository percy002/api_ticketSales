<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';

    protected $fillable = [
        'venta_id',
        'tipo_ticket_id',
        'turno',
        'cantidad',
        'precio',
        'QR_ticket',
    ];

    function venta(){
        return $this->belongsTo(Venta::class, 'venta_id', 'venta_id');
    }
}
