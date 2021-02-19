<?php

namespace App\Laravue\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Laravue\Models\Pizza;

class Ingredientes extends Model
{
    protected $table = 'ingredientes';
    public $timestamps = false;
    protected $fillable = [
        'ingredientes_id',
        'nombre',
    ];
    protected $primaryKey = 'ingredientes_id';
    public function pizzas()
    {
        return $this->belongsToMany(  Pizza::class, 'ingredientes_pizza' ,'pizza_id','ingredientes_id');
    }
}
