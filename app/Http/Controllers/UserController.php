<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;


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

                /* subir la image */
                $image_path = $request->file('image_path');
                if($image_path){
                    /* Poner nombre unico */
                    $image_path_name = time().$image_path->getClientOriginalName();

                    /* Guardar en la carpeta storage (storage/app/users) */
                    Storage::disk('users')->put($image_path_name, File::get($image_path));

                    /* Seteo el nombre de la imagen en el objeto */
                    $user->image = $image_path_name;

                    $image = Storage::disk('users')->get($image_path_name);
                    $image = base64_encode($image);
                    $user->image = $image;
                }
        /* Ejecutar consulta y cambios en la base de datos */
        $user->update();

        /* convertir en base 64 */


        return redirect()->route('config')->with(['message' => 'Usuario actualizado correctamente']);
    }
    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }
}
