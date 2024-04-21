<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

<div class="card">
    <div class="card-header">
        Objavljeno {{ $post->created_at->format('d.m.Y') }}
        ({{ $post->created_at->diffForHumans() }})
        @if($post->edited == "yes")
        | Uređeno
        @endif
        @if(Auth::user()->likes($post)->exists())
        | LAJKOVANO
        @endif 
    </div>
    <div class="card-body">
        <!--<img src="{{ asset('data/' . $post->image_path) }}" class="profile-image-home">-->
        <a href="/post/{{$post->id}}">
        <h4 class="card-title" id="post-title"> <b> {{ $post->title }}</b></a>
            @if ($post->verified == 'yes')
                <i class="ri-verified-badge-line verified"></i>
            @endif
        </h4>
        <p> {{ $post->content }}</p>
        @if($post ->image_path != null)
        <img src="{{ asset('data/' . $post->image_path) }}" style="max-width:100%">
        @endif
        @if(Auth::user()->id != $post->user->id)
        @if(!Auth::user()->likes($post)->exists())
            <button class="btn btn-primary like-btn" id="likeb" onclick="like({{$post->id}})" action="submit"><i class="ri-heart-fill"></i> : <span id="n-1">{{$post->likes()->count()}}</span></button>
            <button class="d-none btn btn-danger like-btn" onclick="unlike({{$post->id}})" id="unlikeb" action="submit"><i class="ri-dislike-fill"></i> :  <span id="n-2">{{$post->likes()->count()}}</span></button>
        @elseif(Auth::user()->likes($post)->exists())
            <button id="unlikeb" class="btn btn-danger like-btn" onclick="unlike({{$post->id}})" action="submit"><i class="ri-dislike-fill"></i> :  <span id="n-1">{{$post->likes()->count()}}</span></button>
            <button id="likeb" class="d-none btn btn-primary like-btn" onclick="like({{$post->id}})" action="submit"><i class="ri-heart-fill"></i> :  <span id="n-2">{{$post->likes()->count()}}</span></button>
        @endif
        @else
        <a href="/likes/{{$post->id}}"><h5>Lajkova : {{$post->likes()->count()}}</h5></a>
        @endif
    </div>
    @if ((Auth::user()->id == $users->id) || Auth::user()->role == 'admin')
        <div class="card-footer">
            <form style="float:left; margin-right:10px"method="POST"
                action="{{ url('/post/delete/' . $post->id) }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-danger">Obriši <i
                        class="ri-delete-bin-6-fill"></i></button>
            </form>
            <a href="{{ url('/post/' . $post->id) . '/edit' }}">
                <button type="submit" style="float:left; margin-right:10px"
                    class="btn btn-primary">Uredi <i
                        class="ri-edit-2-fill"></i></button></a>
    @endif


    @if (Auth::user()->role == 'admin' && $post->verified == 'no')
        <form method="POST" action="{{ url('/post/verify/' . $post->id) }}">
            {{ method_field('PUT') }}
            @csrf
            <button type="submit" class="btn btn-success">Verifikuj <i
                    class="ri-verified-badge-fill"></i></button>
        </form>
    @elseif(Auth::user()->role == 'admin' && $post->verified == 'yes' && $users->owner != 'yes')
        <form method="POST" action="{{ url('/post/unverify/' . $post->id) }}">
            {{ method_field('PUT') }}
            @csrf
            <button type="submit" class="btn btn-danger">Odverifikuj <i
                    class="ri-close-line"></i></button>
        </form>
    @endif
</div>

</div>