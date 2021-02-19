<?php

namespace App\Laravue\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Laravue\Models\Pizza;

class Ingredientes_pizza extends Model
{
    protected $table = 'ingredientes_pizza';
    public $timestamps = false;
    protected $fillable = [
        'ingredientes_id',
        'pizza_id',
    ];
    protected $primaryKey = ['ingredientes_id' , 'pizza_id'];
}
