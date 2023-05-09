<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function config()
    {
        return view('user.config');
    }
    public function update(Request $request)
    {
        //Conseguir usuario idntificado
        $user = Auth::user();
        $id = $user->id;


        //Validacion del formulario
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,' . $id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
        ]);


        //Recoger datos del formulario
        $name = $request->input('name');
        $email = $request->input('email');
        $surname = $request->input('surname');
        $nick = $request->input('nick');

        //Subir la imagen
        $image_path = $request->file('image_path');
        if ($image_path) {
            //Poner nombre unico
            $image_path_name = time() . $image_path->getClientOriginalName();
            //Guardar en la carpeta storage/app/users
            Storage::disk('users')->put($image_path_name, File::get($image_path));
            //poner el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }

        //Asignar nuevos valores al objeto del usuario
        $user->name = $name;
        $user->surname = $surname;
        $user->email = $email;
        $user->nick = $nick;

        //Ejecutar consulta y cambios en la base de datos
        $user->save();
        return redirect()->route('config')->with(['message' => 'Usuario actualizado correctamente']);
    }
    public function getImage($filename)
    {
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }
    public function profile($id)
    {
        $user = User::find($id);
        return view('user.profile', ['user' => $user]);
    }
    public function users($search = null)
    {       
        if($search && $search != null){
            $users  = User::where('nick', 'LIKE', '%'.$search.'%')->orWhere('name', 'LIKE', '%'.$search.'%')
            ->orWhere('surname', 'LIKE', '%'.$search.'%')
            ->orderBy('id', 'desc')->paginate(5);
    }else{
        $users  = User::orderBy('id', 'desc')->paginate(5);
    }
        
        return  view('user.users', [
            'users' => $users]);
    }
    
}
