<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Laravue\Models\Pizza;
use App\Laravue\Models\Ingredientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ingredienteController extends Controller
{
    
    public function getIngrediente()
    {
		//SELECT a la base de datos pizzas
        $ingredientes = Ingredientes::get();
     
        
        return $ingredientes;
    }
    public function setIngrediente(Request $request)
    {
		//SELECT a la base de datos pizzas
        $newingrediente = $request->all();
        $ingrediente = new Ingredientes;
        $ingrediente->nombre = $newingrediente['nombre'];
        $ingrediente->save();
     
        
        return $ingrediente;
    }
}

