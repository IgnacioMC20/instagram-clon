@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('includes.message')
                @foreach ($images as $image)
                    @include('includes.image')
                    <br>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="pagination">
        {{ $images->links() }}
    </div>
@endsection
