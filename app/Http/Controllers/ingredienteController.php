<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Laravue\Models\Pizza;
use App\Laravue\Models\Ingredientes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        Schema::disableForeignKeyConstraints();
		//SELECT a la base de datos pizzas
        $newingrediente = $request->all();
        $ingrediente = new Ingredientes;
        $ingrediente->nombre = $newingrediente['nombre'];
        $ingrediente->save();
        Schema::enableForeignKeyConstraints();
        
        return $ingrediente;
    }
    public function delIngrediente($id)
    {
		//SELECT a la base de datos pizzas
        Schema::disableForeignKeyConstraints();
        $pizza = Ingredientes::where('ingredientes_id', $id)->first();
        
        $pizza->delete();
        Schema::enableForeignKeyConstraints();
        return $pizza;
    }
}

