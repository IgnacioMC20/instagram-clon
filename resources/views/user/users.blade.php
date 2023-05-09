@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Usuarios</h1>
                <div class="form-group">
                    <form action="{{ route('userGente') }}" method="GET" id="buscador">
                        <input type="text" id="search" class="form-control">
                        <input type="submit" value="Buscar" class="btn btn-success">
                    </form>
                </div>
                @foreach ($users as $user)
                    <div>
                        @if ($user->image)
                            <img src="{{ route('userAvatar', ['filename' => $user->image]) }}"
                                class="rounded mx-auto d-block" height="300px" alt="">
                            <br>
                        @endif
                        <div class="col-md-8">
                            <h1>{{ '@' . $user->nick }}</h1>
                            <h3>{{ $user->name . ' ' . $user->surname }}</h3>
                            <small
                                class="text-muted">{{ 'Se unió: ' . FormatTime::LongTimeFilter($user->created_at) }}</small>
                            <a href="{{ route('usuarioPerfil', ['id' => $user->id]) }}" class="btn btn-outline-success">Ver
                                Perfil</a>
                        </div>
                        <hr>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="pagination">
        {{ $users->links() }}
    </div>
@endsection
