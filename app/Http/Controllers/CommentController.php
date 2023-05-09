<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function saveCom(Request $request)
    {
        //Validacion
        $validate = $this->validate($request, [
            'image_id' => 'integer|required',
            'content' => 'string|required'
        ]);
        //Recoger datos del formulario
        $user = Auth::user();
        $content = $request->input('content');
        $image_id = $request->input('image_id');

        //Asignar los valores a la nueva variable
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;

        //Guardar en la base de datos
        $comment->save();
        return redirect()->route('imageDetalleS', ['id' => $comment->image_id])
            ->with(['message' => 'Has publicado tu comentario correctamente']);
    }
    public function delete($id)
    {
        //Conseguir datos del usuario identificado
        $user = Auth::user();

        //Conseguir objeto del comentario
        $comment = Comment::find($id);

        //Comprobar si soy el due;o del comentario o de la publicacion
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            $comment->delete();
            return redirect()->route('imageDetalleS', ['id' => $comment->image->id])
            ->with(['message' => 'El comentario se ha eliminado']);
        }else{
            return redirect()->route('imageDetalleS', ['id' => $comment->image->id])
            ->with(['message' => 'El comentario no se ha eliminado']);
        }
    }
}
