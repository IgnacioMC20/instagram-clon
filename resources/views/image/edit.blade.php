@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Subir foto
                    </div>
                    <div class="card-body">
                        <form action="{{ route('imageUpdate',) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="image_id" value="{{ $image->id }}">
                            <div class="form-group row">
                                <img src="{{ route('imagenes', ['filename' => $image->image_path]) }}" class="rounded"
                                        width="400px" alt="">
                                        <br>
                            <!--    <div class="custom-file">                                  
                                    <input type="file" class="custom-file-input" id="inputGroupFile04" required
                                        name="image_path">
                                    <label class="custom-file-label" for="inputGroupFile04">Editar Foto</label>
                                    @error('image_path')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            -->
                            </div>

                            <div class="form-group">
                                <div class="custom-file">
                                    <label for="description">Descripción</label>
                                    <textarea class="form-control" name="description"
                                        rows="3">{{ $image->description }}</textarea>
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar Foto</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
