<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderHistory;
use App\Models\Product;
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

    private function correlativo()
    {
        return Order::count();
    }

    private function validate($user_id)
    {
        $user = User::where('id', $user_id)->first();
        if (!$user) {
            return 'El Vendedor No existe';
        }

        if( !$user->hasRole(2) ){
            return 'El Id de Usuario debe ser del tipo Vendedor';
        }

        return false;
    }

    private function store($data)
    {
        $nro_pedido =  Carbon::now()->format('Ym-') . $this->correlativo() + 1;
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

        return $this->info($order->id);
    }


    private function info($id)
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
            ->where('orders.id', $id)
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
