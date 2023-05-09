<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function create()
    {
        # code... 
        return view('image.create');
    }
    public function save(Request $request)
    {
        //Validacion 
        $validate = $this->validate($request, [
            'description' => 'required',
            'image_path' => 'required|image|'
        ]);
        //Recogiendo los datos
        $description = $request->input('description');
        $image_path = $request->file('image_path');

        //Asignar valores al objeto
        $image = new Image();
        $user = Auth::user();
        $image->user_id = $user->id;
        $image->description = $description;

        //Subir fichero
        $image_path_name = time().$image_path->getClientOriginalName();
        if($image_path){
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        $image->save();
        return redirect()->route('home')->with([
            'message' => 'La foto ha sido subida correctamente']);
    }
    public function getImagen($filename){
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }
    public function detail($id){
        $image = Image::find($id);
        return view('image.detail', [
            'image' => $image
        ]);
    }
    public function delete($id){
        $user = Auth::user();
        $image = Image::find($id);
        $comments = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if($user && $image && $image->user->id == $user->id){
            //Eliminar los comentarios
            if($comments && count($comments) >= 1){
                foreach($comments as $comment){
                    $comment->delete();
                }
            }
            //Eliminar los likes
            if($likes && count($likes) >= 1){
                foreach($likes as $like){
                    $like->delete();
                }
            }
            //Eliminar fichero de imagen
            Storage::disk('images')->delete($image->image_path);

            //Eliinar registro de la imagen
            $image->delete();
            $message = array('mensaje' => 'La imagen se ha borrado completamente');
        }else{
            $message = array('mensaje' => 'La imagen no se ha borrado completamente');
        }
        return redirect()->route('home')->with($message);
    }

    public function edit($id){
        $user = Auth::user();
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
            'description' => 'required'
        ]);
        $image_id = $request->input('image_id');
        $description = $request->input('description');

        $image = Image::find($image_id);
        $image->description = $description;
        $image->update();
        
        return redirect()->route('imageDetalleS',['id' => $image->id]);
    }
}
