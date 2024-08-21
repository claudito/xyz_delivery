<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'nro_pedido',
        'fecha_pedido',
        'status_id',
        'comentario',
        'user_id'
    ];

    protected $casts = [
        'fecha_pedido' => 'datetime:d/m/Y H:i:s',
        'fecha_recepcion' => 'datetime:d/m/Y H:i:s',
        'fecha_despacho' => 'datetime:d/m/Y H:i:s',
        'fecha_entrega' => 'datetime:d/m/Y H:i:s',
    ];
}
