<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Pizza;
use App\Models\Ingredientes;
use App\Models\piz_ing;
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
}

