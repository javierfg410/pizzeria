<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pedidos_Pizza extends Model
{
    protected $table = 'pedidos_pizza';

    
    protected $fillable = [
        'pedido_id',
        'pizza_id',
        'cantidad'
    ];
    protected $primaryKey = 'pedido_id , pizza_id';
    public function pedidos()
    {
        return $this->belongsTo(  Pedido::class, 'pedido_id','pedido_id');
    }
    public function pizzas()
    {
        return $this->belongsTo(  Pizza::class, 'pedido_id','pizza_id');
    }
}
