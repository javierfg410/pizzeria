<?php

namespace App\Laravue\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Laravue\Models\Ingredientes;

class Pizza extends Model
{
    protected $table = 'pizzas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $fillable = [
        'pizza_id',
        'nombre',
        'precio',
    ];
    protected $primaryKey = 'pizza_id';
    public function pedidos()
    {
       // dd( $this->belongsToMany(  Ingredientes::class ,  ));
        return $this->belongsToMany(  Pedidos::class, 'pedidos_pizza','pizza_id','pedido_id');
    }
    public function ingredientes()
    {
        return $this->belongsToMany(  Ingredientes::class, 'ingredientes_pizza','pizza_id','ingredientes_id');
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @inheritdoc
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    
}
