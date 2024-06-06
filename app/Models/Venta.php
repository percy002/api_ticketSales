<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'ventas';
    protected $primaryKey = 'venta_id';
    protected $fillable = [
        'cliente_id',
        'usuario_id',
        'monto_total',
        'tipo_pago',
        'fecha',
        'token_culqi'
    ];

}
