<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;



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

    public function detail($id)
    {
        $image = Image::find($id);

        return view('image.detail', [
            'image' => $image
        ]);
    }


}
