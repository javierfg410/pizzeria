<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Laravue\Models\User;
use App\Laravue\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class usuariosController extends Controller
{
    public function getUsuario()
    {
     
        $Users = User::get();
        foreach($Users as $user){
            $user->role;
            dd( $user);
        }
        return $Users;
    }
    public function addUsuario(Request $request)
    {
        $newUser = $request->all();
        $User = new User();
        $User->name     = $newUser['name'];
        $User->email    = $newUser['email'];
        $User->password = Hash::make($newUser['password']);
        $User->save();
        
        
        return $User;
    }
}

