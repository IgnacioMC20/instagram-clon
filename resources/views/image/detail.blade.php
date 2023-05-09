@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        @include('includes.message')
                        <img src="{{ route('userAvatar', ['filename' => $image->user->image]) }}" class="rounded"
                            width="20px" alt="">
                        {{ $image->user->name . ' ' . $image->user->surname }}
                        <small class=" text-muted"> {{ '@' . $image->user->nick }}</small>
                    </div>
                    <div class="card-body">
                        <img src="{{ route('imagenes', ['filename' => $image->image_path]) }}" class="rounded"
                            width="100%" alt="">
                        <br>
                        <hr>
                        <small class=" text-muted"> {{ '@' . $image->user->nick }} </small>{{ $image->description }}
                        <br><small class=" text-muted"> {{ FormatTime::LongTimeFilter($image->created_at) }}</small>
                        <br>
                        <div class="likes">
                            <label class="text-muted nLikes ">{{ count($image->likes) }}</label>
                            <?php $user_like = false; ?>
                            @foreach ($image->likes as $like)
                                @if ($like->user->id == Auth::user()->id)
                                    <?php $user_like = true; ?>
                                @endif

                            @endforeach
                            @if ($user_like)
                                <img src="{{ asset('img/heart-red.png') }}" data-id="{{ $image->id }}"
                                    class="btn-dislike" width="20px" alt="">
                            @else
                                <img src="{{ asset('img/hearts-black.png') }}" data-id="{{ $image->id }}"
                                    class="btn-like" width="20px" alt="">
                            @endif
                            @if (Auth::user() && Auth::user()->id == $image->user->id)
                                <div>
                                    <a href="{{ route('imageEdit',['id' => $image->id]) }}" class="btn btn-sm btn-outline-info">Actualizar</a>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-toggle="modal"
                                        data-target="#exampleModal">
                                        Eliminar Publicacion
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Estas segurp?</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Si eliminas la publicacion, no podras recuperarla
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Cerrar</button>
                                                    <a href="{{ route('imageDelete', ['id' => $image->id]) }}" class="btn btn-outline-danger">Eliminar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <a href="" class="btn btn-light">Comentarios ( {{ count($image->comments) }}
                                )</a><br><br>
                            <form action="{{ route('commentSave') }}" method="POST">
                                @csrf
                                <input type="hidden" name="image_id" value="{{ $image->id }}">
                                <p>
                                    <textarea name="content" id="" cols="30" rows="1" class="form-control"></textarea>
                                </p>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <button type="submit" class="btn btn-outline-success">Enviar</button>
                            </form>
                        </div>
                        <hr>
                        @foreach ($image->comments as $comment)
                            <div class="">
                                <small class=" text-muted"> {{ '@' . $comment->user->nick }}
                                </small>{{ $comment->content }}
                                <small class=" text-muted">
                                    {{ FormatTime::LongTimeFilter($comment->created_at) }}</small>
                                @if (Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                    <a href="{{ route('commentDelete', ['id' => $comment->id]) }}"
                                        class="btn btn-sm btn-outline-danger">Eliminar</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <br>
                <br>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
@endsection
