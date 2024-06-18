<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\User;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $primaryKey = 'venta_id';
    protected $fillable = [
        'usuario_id',
        'monto_total',
        'tipo_pago',
        'fecha',
        'token_pago'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'token_pago'
    ];

    function tickets(){
        return $this->hasMany(Ticket::class, 'venta_id', 'venta_id');
    }

    function usuario(){
        return $this->belongsTo(User::class, 'usuario_id', 'usuario_id');
    }

}
