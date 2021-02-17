<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pedidosController extends Controller
{
    
    public function pedido(Request $request)
    {
       
        
        if (Auth::check()){
            $pizzas= $request->all();
        }else{
            $pizza = false;
        }
        
        return  $pizza;
    }
}

