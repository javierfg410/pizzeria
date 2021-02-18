<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Ingredientes extends Model
{
    protected $table = 'ingredientes';

    protected $fillable = [
        'ingredientes_id',
        'nombre',
        'tipo',
    ];
    protected $primaryKey = 'ingredientes_id';
    public function pizzas()
    {
        return $this->belongsToMany(  Pizza::class, 'ingredientes_pizza' ,'pizza_id','ingredientes_id');
    }
}
