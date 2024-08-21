<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderHistory;
use App\Models\Product;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Testing\Fakes\Fake;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class OrderRepository implements OrderRepositoryInterface
{


    public function create(array $data)
    {
        $data = (object) $data;
        $validate =  $this->validate($data->vendedor_id);
        if ($validate) {

            return $validate;
        } else {

            return $this->store($data);
        }
    }

    public function show($nro_pedido)
    {
        return $this->info($nro_pedido);
    }

    public function update(array $data)
    {
        $data = (object) $data;

        $now = Carbon::now();

        $order = Order::where('nro_pedido', $data->nro_pedido)->first();
        if (!$order) {
            return 'Nro de Pedido no Valido';
        }

        $estado = Status::where('id', $data->estado_id)->first();

        if (!$estado) {
            return 'Estado No Valido';
        }

        if ($this->maxStatus()  == $order->status_id) {
            return 'El Pedido se Encuentra Cerrado';
        }


        if ($order->status_id ==  $data->estado_id) {
            return 'El Estado Tiene que ser diferente al inicial.';
        }

        if ( !($data->estado_id > $order->status_id)) {
            return 'EL Pedido no puede ser actualizado a un nivel anterior';
        }

        $user = User::where('id', $data->user_id)->first();
        if (!$user) {
            return 'El Usuario NO existe';
        }

        if (!$user->hasRole([2,3,4])) {
            return 'El Id de Usuario debe ser del tipo Vendedor, Delivery o Repartidor';
        }


        switch ($data->estado_id) {
            case 2:
                $order->update([
                    'fecha_recepcion' =>$now,
                    'status_id' => 2
                ]);

                break;
            case 3:
                $order->update([
                    'fecha_despacho' =>$now,
                    'status_id' => 3
                ]);
                break;
            case 4:
                $order->update([
                    'fecha_entrega' =>$now,
                    'status_id' => 4
                ]);
                break;
            default:
                # code...
                break;
        }

        OrderHistory::create([
            'status_id' => $data->estado_id,
            'order_id' => $order->id,
            'user_id' => $data->user_id,
            'fecha_registro' => $now
        ]);

        return $this->info($data->nro_pedido);
    }

    private function correlativo()
    {
        return Carbon::now()->format('Ym-') . Order::count() + 1;
    }


    private function maxStatus()
    {
        return Status::max('id');
    }

    private function validate($user_id)
    {
        $user = User::where('id', $user_id)->first();
        if (!$user) {
            return 'El Vendedor No existe';
        }

        if (!$user->hasRole(2)) {
            return 'El Id de Usuario debe ser del tipo Vendedor';
        }

        return false;
    }

    private function store($data)
    {
        $nro_pedido =  $this->correlativo();
        $details =  $data->details;

        $now = Carbon::now();

        //Cabecera
        $order = Order::create([
            'nro_pedido' => $nro_pedido,
            'comentario' => $data->comentario,
            'fecha_pedido' => $now,
            'user_id' => $data->vendedor_id
        ]);

        //Detalle
        foreach ($details as $detail) {
            $detail = (object) $detail;
            $product = Product::where('sku', $detail->sku)->first();

            if ($product) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'sku' => $product->sku,
                    'nombre' =>  $product->nombre,
                    'tipo' =>  $product->tipo,
                    'etiquetas' =>  $product->etiquetas,
                    'precio' => $detail->precio,
                    'unidad_medida' => $product->unidad_medida
                ]);
            }
        }

        //Historial
        OrderHistory::create([
            'order_id' => $order->id,
            'user_id' => $data->vendedor_id,
            'fecha_registro' => $now
        ]);

        return $this->info($order->nro_pedido);
    }


    private function info($nro_pedido)
    {

        $order = Order::selectRaw("
                orders.id,
                orders.nro_pedido,
                orders.fecha_pedido,
                orders.fecha_recepcion,
                orders.fecha_despacho,
                orders.fecha_entrega,
                orders.comentario,
                statuses.name estado,
                users.name vendedor
            ")
            ->join('statuses', function ($join) {
                $join->on('orders.status_id', '=', 'statuses.id');
            })
            ->join('users', function ($join) {
                $join->on('orders.user_id', '=', 'users.id');
            })
            ->where('orders.nro_pedido', $nro_pedido)
            ->get()
            ->map(function ($item) {

                $historial = OrderHistory::selectRaw("
                    statuses.name estado,
                    users.name,
                    users.position puesto,
                    order_histories.fecha_registro
                ")
                    ->join('users', function ($join) {
                        $join->on('order_histories.user_id', '=', 'users.id');
                    })
                    ->join('statuses', function ($join) {
                        $join->on('order_histories.status_id', '=', 'statuses.id');
                    })
                    ->where('order_histories.order_id', $item->id)->get();
                $item->historial = $historial;

                $details = OrderDetail::selectRaw("
                    sku,
                    nombre,
                    tipo,
                    etiquetas,
                    precio,
                    unidad_medida
                ")->where('order_id', $item->id)->get();
                $item->details = $details;
                return $item;
            });

        return $order;
    }
}
