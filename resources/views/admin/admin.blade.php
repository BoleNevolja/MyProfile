@extends('layouts.app')
<title>MyProfile ┃ Admin</title>
@section('content')
    <div id="admin-panels" class="row">
        <div class="container col-6" id="left-admin-panel">
            <div class="row">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card col-12">
                            <div class="card-header">BROJ KORISNIKA: <b>{{ $TotalUsers }}</b><br>
                                BROJ ADMINISTRATORA: <b>{{ $TotalAdmins }}</b><br>
                                BROJ NOVIH KORISNIKA U ZADNJIH 24h: <b>{{ $NewUsers }}</b></div>
                            <div class="card-body">
                                @foreach ($users as $user)
                                    <div class="card cardic">
                                        <div class="card-header">
                                            {{ $user->created_at->diffForHumans() }}
                                        </div>
                                        <div class="card-body">
                                            <img src="{{ asset('images/' . $user->image_path) }}"
                                                class="profile-image-home">
                                            <a href="/user/{{ $user->id }}">
                                                <h3 class="card-title"> <b> {{ $user->name }}</b>
                                            </a>
                                            @if ($user->owner == 'yes')
                                                <i class="ri-verified-badge-fill owner-badge"></i>
                                            @elseif($user->role == 'admin')
                                                <i class="ri-verified-badge-fill admin"></i>
                                            @endif
                                            </h3>
                                            <p> {{ $user->bio }}</p>

                                        </div>
                                        <div class="card-footer">
                                            @if ($user->owner == 'yes')
                                                VLASNIK
                                            @else
                                                <a href="{{ url('/user/' . $user->id . '/edit') }}"><button
                                                        class="btn btn-primary buttones">Uredi profil</button></a>
                                                @if ($user->role != 'admin' && Auth::user()->owner == 'yes')
                                                    <form method="POST" action="{{ url('/addadmin/' . $user->id) }}">
                                                        {{ method_field('PUT') }}
                                                        @csrf
                                                        <button type="submit" class="btn btn-success buttones">Dodaj admina
                                                            <i class="ri-admin-fill"></i></button>
                                                    </form>
                                                @elseif($user->role == 'admin' && Auth::user()->owner == 'yes')
                                                    <form method="POST" action="{{ url('/removeadmin/' . $user->id) }}">
                                                        {{ method_field('PUT') }}
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger buttones">Ukloni admina
                                                            <i class="ri-user-unfollow-fill"></i></button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                <a href="admin/users">
                                    <button class="btn btn-primary" style="width:100%">Vidi sve</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="container col-12">
                <div class="row justify-content-center">
                    <div class="col-md-8" style="padding:0px; padding-right:23px">
                        <div class="card">
                            <div class="card-header">OGLASNA TABLA</div>
                            <div class="card-body">
                                @if(Auth::user()->owner == "yes")
                                <form action="/addmsg" method="POST">
                                    <div class="form-group">
                                        @csrf
                                      <input type="text" class="form-control" name="content" id="content" placeholder="Nešto novo?">
                                    </div>
                                    <button class="btn btn-primary" style="width:20%; margin-top:2px;"type="submit"><i class="ri-user-search-fill"></i></button>
                                  </form>
                                  @endif <br>
                                  @foreach($msgs as $msg)
                                  <div class="card">
                                    <div class="card-header">{{ $msg->created_at->diffForHumans() }}</div>
                                  <div class="card-body"><b>{{$msg->content}}</b></div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SREDNJA -->
        <div class="container col-6" id="center-admin-panel">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">BROJ NOVIH OBJAVA U ZADNJIH 24h: <b>{{ $NewPosts }}</b></div>
                        <div class="card-body">
                            @foreach ($posts as $post)
                                <div class="card cardic">
                                    <div class="card-header">
                                        {{ $post->created_at->diffForHumans() }}
                                        | {{ $post->user->name }}
                                        @if ($post->edited == 'yes')
                                            | Uređeno
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <a href="/post/{{ $post->id }}">
                                            <h4 class="card-title" id="post-title"> <b> {{ $post->title }}</b>
                                        </a>
                                        @if ($post->verified == 'yes')
                                            <i class="ri-verified-badge-line verified"></i>
                                        @endif
                                        </h4>
                                        @if ($post->image_path != null)
                                            <img src="{{ asset('data/' . $post->image_path) }}" style="max-width:100%">
                                        @endif
                                    </div>
                                    <div class="card-footer">
                                        @if ($post->user->owner != 'yes')
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


                                            @if ($post->verified == 'no')
                                                <form method="POST" style="float:left; margin-right:10px"
                                                    action="{{ url('/post/verify/' . $post->id) }}">
                                                    {{ method_field('PUT') }}
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Verifikuj <i
                                                            class="ri-verified-badge-fill"></i></button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ url('/post/unverify/' . $post->id) }}">
                                                    {{ method_field('PUT') }}
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Odverifikuj <i
                                                            class="ri-close-line"></i></button>
                                                </form>
                                            @endif
                                        @else
                                            VLASNIK
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
