<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function config()
    {
        return view('user.config');
    }

    public function update(Request $request){
        /* Conseguir el usuario identificado */
        $user = \Auth::user();
        $id = $user->id;

        /* validacion del formulario  */
        $validate = $this->validate($request, [
/*             'name' => 'requiredstring|max:255',
            'surname' => 'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,'.\Auth::user()->id,
            'email' => 'required|string|email|max:255|unique:users,email' . \Auth::user()->id */
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'.\Auth::user()->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.\Auth::user()->id],
        ]);

        /* Recoger datos del formulario */
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');

        /* Asignar nuevo valores al objeto del usuario */
        $user->name = $name;
        $user->surname = $surname;
        $user->nick = $nick;
        $user->email = $email;

        /* Ejecutar consulta y cambios en la base de datos */
        $user->update();

        return redirect()->route('config')->with(['message' => 'Usuario actualizado correctamente']);








    }
}
