<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
class commentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function save(Request $request)
    {
        // Validacion
        $validate = $this->validate($request, [
            'image_id' => ['integer', 'required'],
            'content' => ['string', 'required'],
        ]);


        // Recoger datos
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');

        // Asigno los valores al nuevo objeto a guardar
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        $comment->save();

        return redirect()->route('image.detail', ['id' => $image_id])
                            ->with(['message' => '¡Tu comentario ha sido publicado!']);
    }


        public function delete($id){
            //Accedemos a los datos del usuario identificado
            $user = \Auth::user();
            //Buscamos los comentarios de dicho usuario logeado
            $comment = Comment::find($id);

            //Comprobamos si el usuario logeado es el dueño del comentario o de la imagen
            if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
                $comment->delete();
                return redirect()->route('image.detail', ['id' => $comment->image->id])
                            ->with(['message' => '¡Comentario eliminado correctamente!']);
        }else{
            return redirect()->route('image.detail', ['id' => $comment->image->id])
                            ->with(['message' => '¡El comentario no se ha podido eliminar!']);
        }
    }
}
