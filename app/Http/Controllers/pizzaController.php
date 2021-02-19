<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Laravue\Models\Pizza;
use App\Laravue\Models\Ingredientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pizzaController extends Controller
{
    
    public function index()
    {
		//SELECT a la base de datos pizzas
        $pizza = Pizza::get();
     
        
        return view('pizza', ['pizzas' => $pizza]);
    }
    public function getPizza()
    {
		//SELECT a la base de datos pizzas
    
        $pizza = Pizza::get();
        
        return $pizza;
    }
    public function getIngredientes($id)
    {
		//SELECT a la base de datos pizzas
    
        $pizza = Pizza::where('pizza_id', $id)->first();
        
        return $pizza->ingredientes;
    }
    public function setPizza(Request $request)
    {
		//SELECT a la base de datos pizzas
        $newPizza = $request->all();
        $pizza = new Pizza;
        $pizza->nombre = $newPizza['nombre'];
        $pizza->precio = $newPizza['precio'];
        $pizza->save();
        
        foreach($newPizza['ingredientes'] as $ingrediente){
            $ingredienteSQL = Ingredientes::where('nombre',$ingrediente)->first();
            $pizza->ingredientes()->attach($ingredienteSQL->ingredientes_id);
        }
        
        return $pizza;
    }
    public function delPizza($id)
    {
		//SELECT a la base de datos pizzas
    
        $pizza = Pizza::where('pizza_id', $id)->first();
        
        return $pizza->delete();
    }
}

