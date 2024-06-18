<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposTicket extends Model
{
    use HasFactory;

    protected $table = 'tipos_tickets';

    protected $id = 'tipo_ticket_id';
    protected $fillable = [
        'nombre',
        'precio',
        'turno',
    ];
}
