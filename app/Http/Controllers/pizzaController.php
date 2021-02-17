<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pizzaController extends Controller
{
    
    public function index()
    {
		//SELECT a la base de datos pizzas
        $sql = 'SELECT * FROM pizzas';
        $pizzaSQL = DB::select($sql);

        $pizza =  array();

        foreach ($pizzaSQL as  $pizzaData){
            $sql = 'SELECT ing.nombre, ing.tipo 
                    FROM pizzeria.ingredientes ing
                    inner join 	pizzeria.piz_ing pi ON (ing.id_ingredientes = pi.id_ingredientes)
                    inner join 	pizzeria.pizzas piz ON (piz.id_pizza = pi.id_pizza)
                    where piz.id_pizza = '. $pizzaData->id_pizza;
            $ingredientesSQL = DB::select($sql);
            $ingredientes =  array();
            foreach ($ingredientesSQL as $valor => $ingData){
                $ingredientes[$valor] = array(
                    "nombre" => $ingData->nombre,
                    "tipo" => $ingData->tipo
                );

            }
			
            $pizza[$pizzaData->id_pizza] = array(
                "nombre" => $pizzaData->nombre,
                "precio" => $pizzaData->precio,
                "ingredientes" => $ingredientes
            );
            
            
            
        }
   
        
        return view('pizza', ['pizzas' => $pizza]);
    }
}

