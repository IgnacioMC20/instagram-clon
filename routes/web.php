<!-- <?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Models\Image;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikeController;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Echo_;
/*
Route::get('/', function () {
    $images = Image::all();
    foreach ($images as $image) {
        echo $image->image_path . '<br>';
        echo $image->description . '<br>';
        echo $image->user->name . ' ' . $image->user->surname . '<br>';
        if (count($image->comments) >= 1) {
            echo 'Comentarios</br>';
            foreach ($image->comments as $comment) {
                echo $comment->user->name . ' ' . $comment->user->surname.': ';
                echo $comment->content . '<br>';
            }
        }
        echo 'Likes: '. count($image->likes);
        echo '<br>';echo '<br>';
    }
    die();
    return view('welcome');
});
*/


Auth::routes();

Route::fallback(function () {
    return redirect('/home');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/configuracion', [UserController::class, 'config'])->name('config');

Route::post('/user/edit', [UserController::class, 'update'])->name('userUpdate');

Route::get('/user/avatar/{filename}', [UserController::class, 'getImage'])->name('userAvatar');

Route::get('/subir-imagen', [ImageController::class, 'create'])->name('imageCreate');

Route::post('/image/save', [ImageController::class, 'save'])->name('imageSave');

Route::get('/image/file/{filename}', [ImageController::class, 'getImagen'])->name('imagenes');

Route::get('/imagen/{id}', [ImageController::class, 'detail'])->name('imageDetalleS');

Route::post('/comment/save', [CommentController::class, 'saveCom'])->name('commentSave');

Route::get('/comment/delete/{id}', [CommentController::class, 'delete'])->name('commentDelete');

Route::get('like/{image_id}', [LikeController::class, 'like'])->name('likeSave');

Route::get('dislike/{image_id}', [LikeController::class, 'dislike'])->name('likeDelete');

Route::get('/likes', [LikeController::class, 'likes'])->name('likes');

Route::get('/perfil/{id}', [UserController::class, 'profile'])->name('usuarioPerfil');

Route::get('image/delete/{id}', [ImageController::class, 'delete'])->name('imageDelete');

Route::get('/image/edit/{id}', [ImageController::class, 'edit'])->name('imageEdit');

Route::post('image/update/',[ImageController::class, 'update'])->name('imageUpdate');

Route::get('user/gente/{search?}', [UserController::class, 'users'])->name('userGente');
