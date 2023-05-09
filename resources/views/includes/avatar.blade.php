@if (Auth::user()->image)
    <img src="{{ route('userAvatar', ['filename' => Auth::user()->image]) }}" class="rounded mx-auto d-block" height="30px" alt="">
@else
<img src="./avatar.jpg" alt="avatar" class="rounded mx-auto d-block" height="30px">
    @endif
