<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Pedidos;
use App\Models\Pedidos_Pizza;
use App\Models\Pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendEmail;
class pedidosController extends Model
{
    
    public function pedido(Request $request)
    {
  
        if (Auth::check()){

            $pizzas= $request->all();
            $pedido = new Pedidos;
            $pedido->usuario_id = Auth::id();
            $total= 0;
            $pedido->save();
            foreach($pizzas as $pizza){
                $pizzaSQL = Pizza::where('nombre',$pizza["id"])->first();
               
               
                $pedido->pizzas()->attach($pizzaSQL->pizza_id, ['cantidad'=> $pizza["cantidad"]]);
                $total= $total + ( $pizza["cantidad"] * $pizza["precio"] );
                
            }
            
/*
            $pedidos = Pedidos::updateOrCreate(
                ['departure' => 'Oakland', 'destination' => 'San Diego'],
                ['price' => 99, 'discounted' => 1]
            );*/
            $data = array(
                'pizza'=> $pizzas,
                'total' => $total,
                'usuario' => Auth::user()
            );
   
            $email = Mail::to(Auth::user()->email)->send(new sendEmail($data));

            return  $email;
        }else{
            return false;


        }
        
    }
}

