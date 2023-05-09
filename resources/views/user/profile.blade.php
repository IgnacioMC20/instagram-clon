@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    @if ($user->image)
                    <img src="{{ route('userAvatar', ['filename' => $user->image]) }}" 
                    class="rounded mx-auto d-block" height="300px" alt="">
                    <br>
                    @endif
                    <div class="col-md-8">
                        <h1>{{'@'. $user->nick }}</h1>
                        <h3>{{ $user->name.' '.$user->surname }}</h3>
                        <small class="text-muted">{{ 'Se unió: '.FormatTime::LongTimeFilter($user->created_at) }}</small>
                    </div>
                    
                </div>
                @foreach ($user->images as $image)
                    @include('includes.image');
                    <br>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
@endsection
