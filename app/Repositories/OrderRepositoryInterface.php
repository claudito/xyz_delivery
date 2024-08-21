<?php
namespace App\Repositories;

use App\Models\Order;

interface OrderRepositoryInterface
{   
    
    public function create(array $data);
    public function show($nro_pedido);
    public function update(array $data);
}