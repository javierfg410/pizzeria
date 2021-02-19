<?php

namespace App\Laravue\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Pedidos extends Model
{
    protected $table = 'pedidos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = true;
    protected $fillable = [
        'pedido_id',
        'usuario_id',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'pedido_id';
    public function usuarios()
    {
       // dd( $this->belongsToMany(  Ingredientes::class ,  ));
        return $this->belongsTo(  User::class, 'usuario_id','id');
    }
    public function pizzas()
    {
       // dd( $this->belongsToMany(  Ingredientes::class ,  ));
        return $this->belongsToMany(  Pizza::class, 'pedidos_pizza','pedido_id','pizza_id')->withPivot('cantidad');
    }
}
