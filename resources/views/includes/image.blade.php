<div class="card">
    <div class="card-header">
        <img src="{{ route('userAvatar', ['filename' => $image->user->image]) }}" class="rounded" width="20px" alt="">
        {{ $image->user->name . ' ' . $image->user->surname }}
        <a href="{{ route('usuarioPerfil', ['id' => $image->user->id]) }}"><small class=" text-muted">
                {{ '@' . $image->user->nick }}</small></a>
    </div>
    <div class="card-body">
        <img src="{{ route('imagenes', ['filename' => $image->image_path]) }}" class="rounded" width="100%" alt="">
        <br>
        <hr>
        <a href="{{ route('imageDetalleS', ['id' => $image->id]) }}"> <small class=" text-muted">
                {{ '@' . $image->user->nick }} </small>{{ $image->description }}</a>
        <br><small class="text-muted">
            {{ FormatTime::LongTimeFilter($image->created_at) }}</small><br>
        <div class="likes">
            <small class=" text-muted">{{ count($image->likes) }}</small>
            <?php $user_like = false; ?>
            @foreach ($image->likes as $like)
                @if ($like->user->id == Auth::user()->id)
                    <?php $user_like = true; ?>
                @endif

            @endforeach
            @if ($user_like)
                <img src="{{ asset('img/heart-red.png') }}" data-id="{{ $image->id }}" class="btn-dislike"
                    width="20px" alt="">
            @else
                <img src="{{ asset('img/hearts-black.png') }}" data-id="{{ $image->id }}" class="btn-like"
                    width="20px" alt="">
            @endif
            <a href="{{ route('imageDetalleS', ['id' => $image->id]) }}" class="btn btn-light">Comentarios (
                {{ count($image->comments) }}
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
                <a href="{{ route('usuarioPerfil', ['id' => $comment->user->id]) }}"> <small class=" text-muted"> {{ '@' . $comment->user->nick }}</a>
                </small>{{ $comment->content }}
                <small class=" text-muted">
                    {{ FormatTime::LongTimeFilter($comment->created_at) }}</small>
            </div>
        @endforeach

    </div>
</div>
