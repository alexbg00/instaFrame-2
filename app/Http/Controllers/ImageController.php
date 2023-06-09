<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use App\Models\Comment;
use App\Models\Like;



class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
        return view('image.create');
    }

    public function save(Request $request)
    {
        // Validación
        $validate = $this->validate($request,[
            'description' => 'required',
            'image_path' => 'required|image'
        ]);

        // Recoger los datos del formulario
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        // Asignar valores nuevo objeto
        $user = \Auth::user();
        $image = new Image();
        $image->user_id = $user->id;
        $image->image_path = null;
        $image->description = $description;

        // Subir la imagen en base64
        if ($image_path) {
            $image_base64 = base64_encode(File::get($image_path));
            $image->image_path = $image_base64;
        }

        // Insertar en la base de datos
        $image->save();

        return redirect()->route('home')->with([
            'message' => 'La foto se ha subido correctamente'
        ]);
    }

    public function getImage($filename)
    {
        $file = Storage::disk('images')->get($filename);

        return new Response($file, 200);
    }



    public function delete($id){
        $user = \Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if($user && $image->user->id == $user->id){
            // Eliminar comentarios
            if($comments && count($comments) >= 1){
                foreach($comments as $comment){
                    $comment->delete();
                }
            }

            // Eliminar likes
            if($likes && count($likes) >= 1){
                foreach($likes as $like){
                    $like->delete();
                }
            }


            // Eliminar una imagen en base64 de la base de dato cuyo campo se llama image_path
            Storage::disk('images')->delete($image->image_path);

            // Eliminar registro de imagen
            $image->delete();

            $message = array('message' => 'La imagen se ha borrado correctamente');
        }else{
            $message = array('message' => 'La imagen no se ha borrado');
        }

        return redirect()->route('home')->with($message);

    }

    public function detail($id)
    {
        $image = Image::find($id);

        return view('image.detail', [
            'image' => $image
        ]);
    }

    public function edit($id)
    {
        $user = \Auth::user();
        $image = Image::find($id);

        if($user && $image && $image->user->id == $user->id){
            return view('image.edit', [
                'image' => $image
            ]);
        }else{
            return redirect()->route('home');
        }
    }

    public function update(Request $request){

        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'image'
        ]);

        $image_id = $request->input('image_id');
        $image_path = $request->file('image_path');
        $description = $request->input('description');

        // Conseguir objeto image
        $image = Image::find($image_id);
        $image->description = $description;

        if($image_id){
            $image = Image::find($image_id);
            $image->description = $description;

            // Subir la imagen en base64
            $image_path = $request->file('image_path');
            if ($image_path) {
                $image_base64 = base64_encode(File::get($image_path));
                $image->image_path = $image_base64;
            }

            $image->update();

            return redirect()->route('image.detail', ['id' => $image_id])
                             ->with(['message' => 'Imagen actualizada con éxito']);



    }

}




}
