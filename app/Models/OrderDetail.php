<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'sku',
        'nombre',
        'tipo',
        'etiquetas',
        'precio',
        'unidad_medida'
    ];

}
